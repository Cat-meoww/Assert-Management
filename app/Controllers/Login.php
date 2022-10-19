<?php

namespace App\Controllers;

use App\Models\UserModel;
use Config\Services;
use CodeIgniter\Cookie\Cookie;


class Login extends BaseController
{
    public function __construct()
    {
        helper('cookie');
        $this->session = session();
        $this->usermodel = new UserModel();
    }

    public function index()
    {
        return view('auth-sign-in');
    }
    public function auth_check()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[5]|max_length[225]|validate_user[email,password]',
        ];
        $error = [
            'password' => ['validate_user' => "Email or Password doesn't match"],
            'email' => ['valid_email' => "Require valid mail id"]
        ];
        if (!$this->validate($rules, $error)) {

            return view('auth-sign-in', ['validation' => $this->validator]);
        } else {
            $email = $this->request->getGetPost('email');
            $this->usermodel = new UserModel();
            $data = $this->usermodel->where('email', $email)->first();
            $this->set_userdata($data);
            setcookie("controller", "12345", time() + 3600);
            return $this->user_dashboard();
        }
    }

    private function set_userdata($data)
    {
        $usertoken = md5(uniqid("auth", true));
        $update = ['is_logged' => 1, 'token' => $usertoken];
        $this->usermodel->where('id', $data['id'])->set($update)->update();
        $userdata = array(
            'username' => $data['username'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'user_role' => $data['user_role'],
            'user_id' => $data['id'],
            'login' => true,
            'token' => $usertoken,
        );
        $this->session->set($userdata);
    }
    public function user_dashboard()
    {
        $userrole = $this->session->user_role;

        //1 -> admin
        //2 -> workers
        //3 -> maintainer
        //4 -> sales
        if ($userrole == 1) {
            return redirect()->to('admin/dashboard');
        } else if ($userrole == 2) {
            return redirect()->to('maintainer/dashboard');
        } else if ($userrole == 3) {
            return redirect()->to('staff/dashboard');
        } else {
            return redirect()->to('global/chat');
        }
    }
    public function dashboard()
    {
        return view('dashboard/dashboard');
    }
    public function logout()
    {

        $update = ['is_logged' => 0, 'token' => ''];
        $this->usermodel->where('id', $this->session->user_id)->set($update)->update();
        $this->session->destroy();
        return redirect('auth/login');
    }
}

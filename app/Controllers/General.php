<?php

namespace App\Controllers;

use App\Models\Product_type;
use App\Models\Product_category;
use App\Models\Product_sub_category;
use App\Models\Product;
use App\Models\UserModel;
use Config\Security;
use Config\Services;

class General extends BaseController
{
    public function __construct()
    {
        $this->session = session();
        $this->usermodel = new UserModel();
        $this->data['session'] = $this->session;
        $this->data['uri']  = service('uri');
        helper(['url', 'session', 'custom']);
        $this->date = date("Y-m-d h:i:s");
        $this->session = session();
        if (!$this->session->has('login') || !$this->session->login) {
            redirect('auth/login', 'refresh');
        }
        $this->db = db_connect();
    }


    public function index()
    {
    }
    public function shared_worker()
    {

        $this->response->setContentType('application/javascript', 'utf-8');
        return view('global/shared_worker.js', $this->data);
    }
    public function setpageroute()
    {
        echo '<pre>';
        return redirect('auth/login', 'refresh');
    }
    public function global_chat()
    {
        $this->data['title'] = "Chat";
        $this->data['user_list'] = $this->usermodel->where('id !=', $this->session->user_id)->get()->getResult();
        //print_r($this->data['user_list']);
        return view('global/chat', $this->data);
    }
    public function admin_inventory()
    {
        $this->data['title'] = "Inventory";
        $product = new \App\Models\Product();
        $this->load_product_property();

        $this->data['product_list'] = $product->select("id,name,default_price")->get()->getResult();
        $where_maintainer = ['in_active' => 0, 'user_role' => 2];
        $this->data['maintainer_list'] = $this->usermodel->select("id,username,firstname")->where($where_maintainer)->get()->getResult();
        return view('admin/admin_inventory', $this->data);
    }
    private function load_product_property()
    {
        $this->product_type_model = new Product_type();
        $this->product_category_model = new Product_category();
        $this->Product_sub_category = new Product_sub_category();
        $this->data['pro_type'] = $this->product_type_model->select('id,type')->get()->getResult();
        $this->data['pro_category'] = $this->product_category_model->select("id,type,category")->get()->getResult();
        $this->data['pro_sub_category'] = $this->Product_sub_category->select('id,type_id,category_id,sub_category_name')->get()->getResult();
        $this->data['invent_status'] = $this->db->table('inventory_status')->select('id,status_name')->get()->getResult();
    }
}

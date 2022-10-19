<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Product_type;
use App\Models\Product_category;
use App\Models\Product_sub_category;



class All_master extends ResourceController
{

    use ResponseTrait;
    public function __construct()
    {
        $this->db = db_connect();
        $this->session = session();
        $this->date = date("Y-m-d H:i:s");
    }
    public function user_creation()
    {
        $rules = [
            'Username'    => 'required|alpha_numeric|is_unique[users.username]',
            'Firstname' => 'required|trim|alpha_numeric_space',
            'Lastname' => 'required|trim|alpha_numeric_space',
            'Mailid' => 'required|valid_email|is_unique[users.email]',
            'Userrole' => 'required|in_list[employee,maintainer]',
            'Password' => 'required|min_length[5]'
        ];
        if ($this->validate($rules)) {
            $username = $this->request->getPost('Username');
            $firstname = $this->request->getPost('Firstname');
            $lastname = $this->request->getPost('Lastname');
            $mailid = $this->request->getPost('Mailid');
            $userrole = $this->request->getPost('Userrole');
            $password = $this->request->getPost('Password');
            if ($userrole === 'maintainer') {
                $role = 2;
            } elseif ($userrole === 'employee') {
                $role = 3;
            }

            $data = [
                'username' => $username,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $mailid,
                'password' => $password,
                'user_role' => $role,
                'created_on' => $this->date,
                'updated_on' => $this->date,
            ];
            if ($res = $this->db->table('users')->insert($data)) {
                return $this->respond('success');
            }
        }
        return $this->respond($this->validator->getErrors());
    }
    public function post_create_product_type()
    {

        $rules = [
            'product_type'    => 'required',
        ];
        if ($this->validate($rules)) {
            $this->product_type_model = new Product_type();
            $pro_type = $this->request->getPost('product_type');
            $data = [
                'type' => $pro_type,
                'created_by'  => $this->session->user_id,
            ];
            if ($this->product_type_model->insert($data)) {
                return $this->respond('success');
            }
        }
        return $this->respond('fail');
        //return redirect()->back();
    }
    public function post_create_product_category()
    {
        $rules = [
            'product_type'    => 'required|is_natural_no_zero',
            'product_category' => 'required|trim|alpha_numeric_space'
        ];
        if ($this->validate($rules)) {
            $pro_type = trim($this->request->getPost('product_type'));
            $pro_category = trim($this->request->getPost('product_category'));
            $this->product_category_model = new Product_category();
            $data = [
                'category' => $pro_category,
                'type' => $pro_type,
                'created_by'  => $this->session->user_id,
            ];
            if ($this->product_category_model->insert($data)) {

                return $this->respond('success');
            }
        }
        return $this->respond('fail');
        //return redirect()->back();
    }
    public function post_create_product_sub_category()
    {
        $rules = [
            'product_type'    => 'required|is_natural_no_zero',
            'product_category' => 'required|is_natural_no_zero',
            'product_sub_category' => 'required|trim|alpha_numeric_space'
        ];
        if ($this->validate($rules)) {
            $pro_type = $this->request->getPost('product_type');
            $pro_category = $this->request->getPost('product_category');
            $product_sub_category = trim($this->request->getPost('product_sub_category'));

            $this->product_category_model = new Product_category();

            $where =  ['id' => $pro_category, 'type' => $pro_type];
            $row = $this->product_category_model->where($where)->get()->getRow();

            if (isset($row)) {

                $this->product_sub_category_model = new Product_sub_category();
                $data = [
                    'type_id' => $pro_type,
                    'category_id' => $pro_category,
                    'sub_category_name' => $product_sub_category,
                    'created_by'  => $this->session->user_id,
                ];
                if ($this->product_sub_category_model->insert($data)) {
                    return $this->respond('success');
                }
            }
        }
        return $this->respond('fail');
    }
    public function post_create_product()
    {
        $rules = [
            'product_type'    => 'required|is_natural_no_zero',
            'product_category' => 'required|is_natural_no_zero',
            'product_sub_category' => 'required|is_natural_no_zero',
            'product_name' => 'required|trim|htmlspecialchars|alpha_numeric_punct',
            'product_price' => 'required|trim|htmlspecialchars|is_natural_no_zero',
            'product_tags' => 'required|trim|htmlspecialchars',
        ];
        if ($this->validate($rules)) {
            $product_type   = $this->request->getPost('product_type');
            $product_category = $this->request->getPost('product_category');
            $product_sub_category = $this->request->getPost('product_sub_category');
            $product_name = $this->request->getPost('product_name');
            $product_price = $this->request->getPost('product_price');
            $product_tags =  $this->request->getPost('product_tags');
            $is_upgrade = (int) $this->request->getPost('is_upgrade');
            $is_repairable = (int) $this->request->getPost('is_repairable');
            $where =  ['id' => $product_sub_category, 'type_id' => $product_type, 'category_id' => $product_category];
            $this->product_sub_category_model = new Product_sub_category();
            $row = $this->product_sub_category_model->where($where)->get()->getRow();
            if (isset($row)) {
                // $this->product_model = new Product();
                $this->product_model = new \App\Models\Product();
                $data = [
                    'name' => $product_name,
                    'type' => $product_type,
                    'category' => $product_category,
                    'sub_category' => $product_sub_category,
                    'default_price' => $product_price,
                    'tags' => $product_tags,
                    'created_by' => $this->session->user_id,
                    'is_upgrable' => "$is_upgrade",
                    'is_repairable' => "$is_repairable",
                ];

                if ($this->product_model->insert($data)) {
                    return $this->respond('success');
                }
            }
        }
        return $this->respond('fail');
    }
    public function post_add_product()
    {
        $rules = [
            'product_id'    => 'required|is_array',
            'actual_price' => 'required|is_array',
            'quantity' => 'required|is_array',
            'maintainer_id' => 'required|is_array',
            'buyed_on' => 'required|is_array',
            'expired_on' => 'required|is_array',
            'product_sake' => 'required|is_array',
        ];
        if ($this->validate($rules)) {
            $product_id = $this->request->getPost("product_id");
            $actual_price = $this->request->getPost("actual_price");
            $quantity =  $this->request->getPost("quantity");
            $maintainer_id = $this->request->getPost("maintainer_id");
            $buyed_on = $this->request->getPost("buyed_on");
            $expired_on = $this->request->getPost("expired_on");
            $product_sake = $this->request->getPost("product_sake");
            $this->field_count = count($product_id);
            if ($this->match_count($product_id) && $this->match_count($actual_price) && $this->match_count($quantity) && $this->match_count($maintainer_id) && $this->match_count($buyed_on) && $this->match_count($expired_on) && $this->match_count($product_sake)) {
                $data = [];
                $INSERT_COUNT = 0;
                $TOTAL_ITEMS = 0;
                for ($i = 0; $i < $this->field_count; $i++) {

                    $temp_quanity = (int)$quantity[$i];
                    $temp = [];
                    $temp['product_id'] = (int)$product_id[$i];
                    $temp['actual_price'] = (int)$actual_price[$i];
                    $temp['is_for_sale'] = ($product_sake[$i] == 'sale') ? 1 : 0;
                    $temp['maintainer'] = (int)$maintainer_id[$i];
                    $temp['created_on'] = $this->date;
                    $temp['bought_on'] = date("Y-m-d h:i:s", strtotime($buyed_on[$i]));
                    $temp['expired_on'] = date("Y-m-d h:i:s", strtotime($expired_on[$i]));
                    $temp['status'] = 1;
                    $temp['created_by'] = $this->session->user_id;
                    for ($q = 1; $q <= $temp_quanity; $q++) {
                        $TOTAL_ITEMS++;
                        if ($this->db->table('inventory')->insert($temp)) {
                            $INSERT_COUNT++;
                        }
                        $data[] = $temp;
                    }
                    unset($temp);
                }
                if ($TOTAL_ITEMS === $INSERT_COUNT) {
                    return $this->respond('success');
                }
                //echo $this->db->table('inventory')->insertID();
                // if ($this->db->table('inventory')->insertBatch($data)) {
                //     return $this->respond('success');
                // }
                return $this->respond('fail');
            }
            return 0;
        } else {
            return $this->respond($this->validator->listErrors('alert-info-list'));
        }
    }
    private function match_count(array $arr)
    {
        if (count($arr) == $this->field_count) {
            return TRUE;
        }
        return FALSE;
    }
    public function post_update_assigner()
    {
        $rules = [
            'instanceid'    => 'required|is_natural_no_zero',
            'assignitemto' => 'required|is_natural',
        ];
        if ($this->validate($rules)) {
            $invent_id = (int) $this->request->getPost("instanceid");
            $staff_id = (int) $this->request->getPost("assignitemto");

            $data = [
                'assigned_to' => $staff_id,
                'assigned_on' => $this->date,
            ];
            $where = [
                'id' => $invent_id,
                'maintainer' => $this->session->user_id,
            ];


            if ($this->db->table('inventory')->where($where)->update($data)) {
                $status = $this->db->table('inventory')->select('status')->where($where)->get()->getRow()->status;
                $timedata = [
                    'assert_id' => $invent_id,
                    'status' => $status,
                    'action' => '',
                    'cost' => 0,
                    'comment' => '',
                    'created_on' => $this->date,
                    'created_by' => $this->session->user_id,
                ];
                $timedata['action'] = "Unassigned-SM";
                if ($staff_id) {
                    $timedata['action'] = "Assigned-SM";
                }
                $this->db->table('timeline')->insert($timedata);
                return $this->respond('success');
            }
        }
        return $this->respond('fail');
    }
    /**
     * ALL MASTER API - Inserts Ticket Titles
     * @param titles varchar input post
     * @return response success or fail
     */
    public function post_create_tickets_titles()
    {
        $rules = [
            'ticket-title'    => 'required|alpha_numeric_punct|max_length[200]|is_unique[ticket_title.title]'
        ];
        if ($this->validate($rules)) {
            $data = [
                'title' => $this->request->getPost('ticket-title'),
                'created_by' => $this->session->user_id,
                'created_on' => $this->date,
                'status' => 1
            ];
            if ($this->db->table('ticket_title')->insert($data)) {
                return $this->respond('success');
            }
        }

        return $this->respond('fail');
    }
}

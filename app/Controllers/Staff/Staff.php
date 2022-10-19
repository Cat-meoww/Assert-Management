<?php

namespace App\Controllers\Staff;

use App\Controllers\General;

class Staff extends General
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        return $this->dashboard();
    }
    public function dashboard()
    {
        $this->data['title'] = "Dashboard";
        return view('admin/dashboard', $this->data);
    }
    public function assigned_assert()
    {
        $this->data['title'] = "Assigned Assert";
        $product = new \App\Models\Product();
        $this->load_product_property();
        $this->data['product_list'] = $product->select("id,name,default_price")->get()->getResult();
        $this->data['ticket_titles'] = $this->db->table('ticket_title')->select("*")->get()->getResult();
        $where_maintainer = ['in_active' => 0, 'user_role' => 2];
        $where_workers = ['in_active' => 0, 'user_role' => 3];
        $this->data['maintainer_list'] = $this->usermodel->select("id,username,firstname")->where($where_maintainer)->get()->getResult();
        return view('staff/staff_assert', $this->data);
    }
    private function load_product_property()
    {
        $this->product_type_model = new \App\Models\Product_type();
        $this->product_category_model = new \App\Models\Product_category();
        $this->Product_sub_category = new \App\Models\Product_sub_category();
        $this->data['pro_type'] = $this->product_type_model->select('id,type')->get()->getResult();
        $this->data['pro_category'] = $this->product_category_model->select("id,type,category")->get()->getResult();
        $this->data['pro_sub_category'] = $this->Product_sub_category->select('id,type_id,category_id,sub_category_name')->get()->getResult();
        $this->data['invent_status'] = $this->db->table('inventory_status')->select('id,status_name')->get()->getResult();
    }
    /**
     * @param maintainer tickets for viewing
     */
    public function ticket_view()
    {
        $this->data['title'] = "Tickets";
        return view('maintainer/tickets', $this->data);
    }
}

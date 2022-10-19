<?php

namespace App\Controllers\admin;

use App\Controllers\General;
use App\Models\Product_type;
use App\Models\Product_category;
use App\Models\Product_sub_category;
use Config\App;

class Admin extends General
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
    public function user_creation()
    {
        $this->data['title'] = "User Creation";
        return view('admin/user_creation', $this->data);
    }
    public function create_product_type()
    {
        $this->product_type_model = new Product_type();
        $this->data['title'] = "Product type";
        $this->data['pro_type'] = $this->product_type_model->get()->getResult();
        return view('admin/create_product_type', $this->data);
    }
    public function create_product_category()
    {
        $this->product_type_model = new Product_type();
        $this->product_category_model = new Product_category();
        $this->data['title'] = "Product Category";
        $this->data['pro_type'] = $this->product_type_model->get()->getResult();
        $this->data['pro_category'] = $this->product_category_model->get()->getResult();
        return view('admin/create_product_category', $this->data);
    }
    public function create_product_sub_category()
    {
        $this->product_type_model = new Product_type();
        $this->product_category_model = new Product_category();
        $this->Product_sub_category = new Product_sub_category();
        $this->data['title'] = "Product Sub Category";
        $this->data['pro_type'] = $this->product_type_model->get()->getResult();
        $this->data['pro_category'] = $this->product_category_model->get()->getResult();
        $this->data['pro_sub_category'] = $this->Product_sub_category->get()->getResult();
        return view('admin/create_product_sub_category', $this->data);
    }
    public function create_product()
    {
        $this->data['title'] = "Product";
        $this->product_type_model = new Product_type();
        $this->product_category_model = new Product_category();
        $this->Product_sub_category = new Product_sub_category();
        $this->data['title'] = "Product Sub Category";
        $this->data['pro_type'] = $this->product_type_model->select('id,type')->get()->getResult();
        $this->data['pro_category'] = $this->product_category_model->select("id,type,category")->get()->getResult();
        $this->data['pro_sub_category'] = $this->Product_sub_category->select('id,type_id,category_id,sub_category_name')->get()->getResult();
        //need to add serverside data table
        //search with tags, name, Category
        return view('admin/create_product', $this->data);
    }
    public function add_product()
    {
    }
    public function alpha_numeric_punct($str)
    {
        if ($str === null) {
            return false;
        }

        return preg_match('/\A[A-Z0-9 ~!#$%\&\*\-_+=|:.]+\z/i', $str) === 1;
    }
    private function remove_other_character(array &$array)
    {
        helper('text');
        helper('inflector');
        foreach ($array as $key => $value) {

            if ($this->alpha_numeric_punct($value)) {
                //echo " $value ";
            } else {
                unset($array[$key]);
            }
        }
    }
    private function remixicons_json()
    {
        $jsondata = json_decode(file_get_contents(FCPATH . 'assets\vendor\remixicon\tags.json'));
        //print_r($jsondata);
        $insertbatch = [];
        foreach ($jsondata as $categoryname => $category) {
            // echo "$categoryname->";
            //print_r($category);
            foreach ($category as $catlist => $catval) {
                // echo $catlist . "@";
                $this->remove_other_character($catval);
                $hints = implode(',', $catval);
                // echo "<br>";
                $insertbatch[] = [
                    'category' => $categoryname,
                    'icon_class' => $catlist,
                    'hints' => $hints,

                ];
            }
            // echo "<br>";
        }
        //print_r($insertbatch);

        $remix_icon = new \App\Models\Remix_icons_model();
        //$remix_icon->insertBatch($insertbatch);
        // $table = new \CodeIgniter\View\Table();
        // echo $table->generate($insertbatch);
    }
    public function create_ticket_titles()
    {
        $this->data['title'] = "Ticket Titles";
        $this->data['ticket_titles'] = $this->db->table('ticket_title')->select('*')->get()->getResult();
        return view('admin/create_ticket_titles', $this->data);
    }
}

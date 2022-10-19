<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;


class Admin extends ResourceController
{

    use ResponseTrait;
    public function __construct()
    {
        $this->db = db_connect();
        $this->session = session();
        $this->date = date("Y-m-d H:i:s");
    }
    public function UsersDataTable()
    {
        $sql = "SELECT * FROM users  WHERE id !=0 ";
        $recordsTotal = $this->db->query($sql)->getNumRows();
        $search_value = $this->request->getPost('search[value]');
        if (!empty($search_value)) {
            $search_value = $this->db->escapeLikeString($search_value);
            $sql .= "AND(username LIKE '%{$search_value}%' 
            OR firstname LIKE '%{$search_value}%' 
            OR lastname LIKE '%{$search_value}%' 
            OR email LIKE '%{$search_value}%' 
             ) ";
        }
        $recordsFiltered = $this->db->query($sql)->getNumRows();
        $sql .= " ORDER BY id DESC";
        if ($_POST["length"] != -1) {
            $sql .= " LIMIT " . $_POST["start"] . ", " . $_POST["length"];
        }
        $query = $this->db->query($sql);
        $data=[];
        foreach ($query->getResult() as $row) {
            $subarray = [];
            $subarray[] = $row->username;
            $subarray[] = $row->firstname;
            $subarray[] = $row->lastname;
            $subarray[] = $row->email;
            $data[] = $subarray;
        }
        $output = [
            "draw"                 => $this->request->getPost('draw'),
            "recordsTotal"         => $recordsTotal,
            "recordsFiltered"    => $recordsFiltered,
            "data"                 => $data,
        ];
        return $this->respond($output);
    }
}

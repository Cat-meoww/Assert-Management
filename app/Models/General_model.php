<?php

namespace App\Models;

use CodeIgniter\Model;

class General_model extends Model
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function save_product_type(string $type)
    {
        $this->db->table('')->insert();
    }
}

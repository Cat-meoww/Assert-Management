<?php

namespace App\Models;

use CodeIgniter\Model;

class Product_sub_category extends Model
{
    protected $table      = 'product_sub_category';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';


    protected $allowedFields = ['type_id',  'category_id', 'sub_category_name', 'status', 'created_by'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_on';
    protected $updatedField  = 'updated_on';
    protected $dateFormat = 'datetime';
}

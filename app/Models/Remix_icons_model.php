<?php

namespace App\Models;

use CodeIgniter\Model;

class Remix_icons_model extends Model
{
    protected $table      = 'remix_icons';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';


    protected $allowedFields = ['category',  'icon_class', 'hints', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_on';
    protected $updatedField  = 'updated_on';
    protected $dateFormat = 'datetime';
}

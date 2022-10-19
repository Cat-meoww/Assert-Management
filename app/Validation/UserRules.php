<?php

namespace App\Validation;

use App\Models\usermodel;

class UserRules
{
    public function validate_user(string $str, string $fields, array $data)
    {
        $model = new usermodel();
        $user = $model->where('email', $data['email'])->first();


        if (!$user)
            return false;
        if ($data['password'] != $user['password'])
            return false;
        else
            return true;
    }
}

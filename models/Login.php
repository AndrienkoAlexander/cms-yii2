<?php

namespace app\models;

use yii\base\Model;

class Login extends Model
{
    public $password;
    public $email;

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
        ];
    }
}
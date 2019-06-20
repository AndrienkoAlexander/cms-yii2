<?php

namespace app\models;

use yii\base\Model;

class Signup extends Model
{
    public $name;
    public $password1;
    public $password2;
    public $email;
    public $IP;

    public function rules()
    {
        return [
            [['name', 'password1', 'password2', 'email', 'IP'], 'required'],
            ['email', 'email'],
            [['email', 'name'], 'unique', 'targetClass'=>'app\models\User'],
            [['password1', 'password2'], 'string', 'min'=>2, 'max'=>256],
        ];
    }
}
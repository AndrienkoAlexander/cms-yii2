<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use PHPUnit\Framework\MockObject\Stub\ReturnStub;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $IP
 * @property bool $admin
 */

/**
 * User is the model behind the user.
 *
 * @property User|null $user.
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['id', 'name', 'email', 'password', 'IP', 'admin'], 'safe'],
        ];
    }

    /**
     * Устанавливаем свойств с помощью значений формы редактирования записи в заданном массиве
     *
     * @param assoc Значения записи формы
     */
    public function storeFormValues($params)
    {
        // Сохраняем все параметры
        print_r($params);
        $this->attributes = $params;
        $this->IP = $_SERVER['REMOTE_ADDR'];
        $this->admin = 0;
        $this->password = sha1($params['password1']);
    }

    /**
     * Возвращаем объект пользователя соответствующий заданному ID пользователя
     *
     * @param int ID пользователя
     * @return User|null Объект пользователя или null, если запись не найдена или возникли проблемы
     */
    public static function getById($id)
    {
        $user = User::find()
            ->where(['id' => $id])
            ->one();
        return $user;
    }

    /**
     * Возвращает все (или диапазон) объектов пользователей в базе данных
     *
     * @param int Optional Количество строк (по умолчанию все)
     * @param string Optional Столбец по которому производится сортировка  пользователей (по умолчанию "name")
     * @return Array|null Двух элементный массив: results => массив, список объектов пользователей; totalRows => общее количество пользователей
     */
    public static function getList($numRows = 1000000, $order = "name")
    {
        $list = array();
        $list = User::find()
            ->orderBy($order)
            ->limit($numRows)
            ->all();
        $totalRows = count($list);

        return (array("results" => $list, "totalRows" => $totalRows));
    }

    /**
     * Возвращаем объект пользователя соответствующий заданному name пользователя
     *
     * @param int name пользователя
     * @return User|null Объект пользователя или null, если запись не найдена или возникли проблемы
     */
    public static function getByName($name)
    {
        $user = User::find()
            ->where(['name' => $name])
            ->one();
        return $user;
    }

    /**
     * Возвращаем объект пользователя соответствующий заданному email пользователя
     *
     * @param int email пользователя
     * @return User|null Объект пользователя или null, если запись не найдена или возникли проблемы
     */
    public static function getByEmail($email)
    {
        $user = User::find()
            ->where(['email' => $email])
            ->one();
        return $user;
    }

    public function isAdmin()
    {
        if($this->admin)
            return true;
        else
            return false;
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        
    }

    public function getAuthKey()
    {
        
    }

    public function validateAuthKey($authKey)
    {
        
    }
}

<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "cars".
 *
 * @property int $id
 * @property string $name
 * @property int $price
 * @property int $serial_num
 * @property int $year
 * @property string $gear_box
 * @property int $power
 * @property int $categoryId
 */

/**
 * Car is the model behind the car.
 *
 * @property Car|null $car.
 *
 */
class Car extends ActiveRecord
{
    public static function tableName()
    {
        return 'cars';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['id', 'name', 'price', 'serial_num', 'year', 'gear_box', 'power', 'categoryId'], 'safe'],
        ];
    }

    /**
     * Устанавливаем свойств с помощью значений формы редактирования машины в заданном массиве
     *
     * @param assoc Значения машины формы
     */
    public function storeFormValues($params)
    {
        // Сохраняем все параметры
        $this->attributes = $params;
    }

        /**
     * Возвращаем объект машины соответствующий заданному ID машины
     *
     * @param int ID машины
     * @return Car|null Объект машины или null, если запись не найдена или возникли проблемы
     */
    public static function getById($id)
    {
        $car = Car::find()
        ->where(['id' => $id])
        ->one();
        return $car;
    }

    /**
     * Возвращает все (или диапазон) объектов машин в базе данных
     *
     * @param int Optional Количество строк (по умолчанию все)
     * @param string Optional Столбец по которому производится сортировка  машин (по умолчанию "name")
     * @return Array|null Двух элементный массив: results => массив, список объектов машин; totalRows => общее количество машин
     */
    public static function getList($categoryId = null, $numRows = 1000000, $order = "name")
    {
        $list = array();
        if($categoryId)
        {
            $list = Car::find()
            ->where(['categoryId' => $categoryId])
            ->orderBy($order)
            ->limit($numRows)
            ->all();
        }
        else{
            $list = Car::find()
            ->orderBy($order)
            ->limit($numRows)
            ->all();
        }
        $totalRows = count($list);

        return (array("results" => $list, "totalRows" => $totalRows));
    }
}

<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property string $name
 * @property int $car_id
 */

/**
 * Image is the model behind the image.
 *
 * @property Image|null $image.
 *
 */
class Image extends ActiveRecord
{
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['id', 'name', 'car_id'], 'safe'],
        ];
    }

    /**
     * Устанавливаем свойств с помощью значений формы редактирования изображения в заданном массиве
     *
     * @param assoc Значения изображения формы
     */
    public function storeFormValues($params)
    {
        // Сохраняем все параметры
        $this->attributes = $params;
    }
    
    /**
     * Возвращает все (или диапазон) объектов изображений в базе данных
     *
     * @param int Id автомобиля
     * @return Image|null Двух элементный массив: results => массив, список объектов категорий; totalRows => общее количество категорий
     */
    public static function getByCarId($car_id)
    {
        $list = array();
        $list = Image::find()
        ->where(['car_id' => $car_id])
        ->all();
        $totalRows = count($list);

        return (array("results" => $list, "totalRows" => $totalRows));
    }
}

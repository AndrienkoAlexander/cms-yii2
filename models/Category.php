<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property int $parent
 */

/**
 * Category is the model behind the category.
 *
 * @property Category|null $category.
 *
 */
class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['id', 'name', 'parent'], 'safe'],
        ];
    }

    /**
     * Устанавливаем свойств с помощью значений формы редактирования категории в заданном массиве
     *
     * @param assoc Значения категории формы
     */
    public function storeFormValues($params)
    {
        // Сохраняем все параметры
        $this->attributes = $params;
    }

    /**
     * Возвращаем объект категории соответствующий заданному ID категории
     *
     * @param int ID категории
     * @return Category|null Объект категории или null, если запись не найдена или возникли проблемы
     */
    public static function getById($id)
    {
        $category = Category::find()
            ->where(['id' => $id])
            ->one();
        return $category;
    }

    /**
     * Возвращает все (или диапазон) объектов категорий в базе данных
     *
     * @param int Optional Количество строк (по умолчанию все)
     * @param string Optional Столбец по которому производится сортировка  категорий (по умолчанию "id")
     * @return Category|null Двух элементный массив: results => массив, список объектов категорий; totalRows => общее количество категорий
     */
    public static function getList($numRows = 1000000, $order = "id")
    {
        $list = array();
        $list = Category::find()
            ->orderBy($order)
            ->limit($numRows)
            ->all();
        $totalRows = count($list);

        return (array("results" => $list, "totalRows" => $totalRows));
    }

    public static function getListArray($numRows = 1000000, $order = "id")
    {
        $list = array();
        $list = Category::find()
            ->asArray()
            ->orderBy($order)
            ->limit($numRows)
            ->all();
        $totalRows = count($list);

        return (array("results" => $list, "totalRows" => $totalRows));
    }

    /**
     * Printing array
     **/
    public function print_arr($array)
    {
        echo "<pre>" . print_r($array, true) . "</pre>";
    }

    /**
     * Categories Tree
     * Tommy Lacroix function
     **/
    public function map_tree($dataset)
    {
        $tree = array();

        $t = array();
        foreach ($dataset as $cat) {
            $t[$cat['id']] = array();
            $t[$cat['id']] = (array)$cat;
        }

        foreach ($t as $id => &$node) {
            if (!$node['parent']) {
                $tree[$id] = &$node;
            } 
            else 
            {
                $t[$node['parent']]['childs'][$id] = &$node;
            }
        }

        return $tree;
    }
}

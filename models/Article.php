<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property string $publicationDate
 * @property string $title
 * @property string $summary
 * @property string $content
 */

 /**
 * Article is the model behind the article.
 *
 * @property Article|null $article.
 *
 */
class Article extends ActiveRecord
{
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['id', 'publicationDate', 'title', 'summary', 'content'], 'safe'],
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
        $this->attributes = $params;

        // Разбираем и сохраняем дату публикации
        if (isset($params['publicationDate'])) {
            $publicationDate = explode('-', $params['publicationDate']);

            if (count($publicationDate) == 3) {
                list($y, $m, $d) = $publicationDate;
                $this->publicationDate = mktime(0, 0, 0, $m, $d, $y);
            }
        }
    }

    /**
     * Возвращаем объект статьи соответствующий заданному ID статьи
     *
     * @param int ID статьи
     * @return Article|null Объект статьи или false, если запись не найдена или возникли проблемы
     */
    public static function getById($id)
    {
        $article = Article::find()
        ->where(['id' => $id])
        ->one();
        return $article;
    }

    /**
     * Возвращает все (или диапазон) объектов статей в базе данных
     *
     * @param int Optional Количество строк (по умолчанию все)
     * @param string Optional Столбец по которому производится сортировка  статей (по умолчанию "publicationDate DESC")
     * @return Array|null Двух элементный массив: results => массив, список объектов статей; totalRows => общее количество статей
     */
    public static function getList($numRows = 1000000, $order = "publicationDate DESC")
    {
        $list = array();
        $list = Article::find()
        ->orderBy($order)
        ->limit($numRows)
        ->all();
        $totalRows = count($list);

        return (array("results" => $list, "totalRows" => $totalRows));
    }
}

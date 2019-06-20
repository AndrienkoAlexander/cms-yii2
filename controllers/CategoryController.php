<?php

namespace app\controllers;

use yii\base\Controller;
use app\models\Car;
use app\models\Category;


class CategoryController extends Controller
{
    public function actionIndex()
    {
        $this->actionCarsCategories();
    }

    public function actionCarsCategories()
    {
        $data = Category::getListArray();
        $results['pageTitle'] = "Cars Categories";
        $categories_tree = Category::map_tree($data['results']);

        return $this->render('carsCategories', compact('categories_tree', 'results'));
    }
}

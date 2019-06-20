<?php

namespace app\controllers;

use yii\base\Controller;
use app\models\Car;
use app\models\Image;
use app\models\Category;


class CarController extends Controller
{
    public function actionIndex()
    {
        $this->actionViewCategory();
    }

    public function actionViewCategory()
    {
        $results = array();
        $categoryId = (isset($_GET['categoryId']) && $_GET['categoryId']) ? (int)$_GET['categoryId'] : 2;
        $results['category'] = Category::getById($categoryId);
        $data = Car::getList($categoryId);
        $results['cars'] = $data['results'];
        $results['totalRows'] = $data['totalRows'];
        $results['pageHeading'] = $results['category'] ?  $results['category']['name'] : "Car Category";
        $results['pageTitle'] = $results['pageHeading'] . " | Cars News";
        $results['images'] = array();

        foreach ($results['cars'] as $car) {
            $temp = Image::getByCarId($car['id']);
            if ($temp['totalRows'] > 0) {
                $results['images'][$car['id']] = $temp['results'][0];
            }
        }

        return $this->render('viewCar', compact('results'));
    }

    public function actionViewCar()
    {
        if (!isset($_GET["carId"]) || !$_GET["carId"]) {
            $this->viewCategory();
            return;
        }

        $results = array();
        $results['cars'] = array();
        $results['cars'][0] = Car::getById((int)$_GET["carId"]);
        $results['images'] = Image::getByCarId((int)$_GET["carId"]);
        $results['category'] = Category::getById($results['cars'][0]['categoryId']);
        $results['pageTitle'] = $results['cars'][0]['name'] . " | Cars News";

        return $this->render('viewCar', compact('results'));
    }
}

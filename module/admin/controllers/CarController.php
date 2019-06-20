<?php

namespace app\module\admin\controllers;

use yii\base\Controller;
use app\models\Car;
use app\models\Image;
use app\models\Category;


class CarController extends Controller
{
    public function actionIndex()
    {
        $this->actionListCars();
    }

    public function actionNewCar()
    {
        $results = array();
        $results['pageTitle'] = "New Car";
        $results['formAction'] = "new-car";

        if (isset($_POST['saveChanges'])) {
            // User has posted the car edit form: save the new car
            $car = new Car();
            $car->storeFormValues($_POST);
            $car->save();
            \Yii::$app->response->redirect('/admin/car/list-cars?status=changesSaved');
        } elseif (isset($_POST['cancel'])) {
            // User has cancelled their edits: return to the car list
            \Yii::$app->response->redirect("/admin/car/list-cars");
        } else {
            // User has not posted the car edit form yet: display the form
            $results['car'] = new Car;
            $data = Category::getList();
            $results['categories'] = $data['results'];

            return $this->render('editCar', compact('results'));
        }
    }

    public function actionEditCar()
    {
        $results = array();
        $results['pageTitle'] = "Edit Car";
        $results['formAction'] = "edit-car";

        if (isset($_POST['saveChanges'])) {
            // User has posted the car edit form: save the car changes
            if (!$car = Car::getById((int)$_POST['carId'])) {
                \Yii::$app->response->redirect("/admin/car/list-cars?error=carNotFound");
                return;
            }
            $car->storeFormValues($_POST);
            $car->update();
            \Yii::$app->response->redirect("/admin/car/list-cars?status=changesSaved");
        } elseif (isset($_POST['cancel'])) {
            // User has cancelled their edits: return to the car list
            \Yii::$app->response->redirect("/admin/car/list-cars");
        } else {
            // User has not posted the car edit form yet: display the form
            $results['car'] = Car::getById((int)$_GET['carId']);
            $data = Category::getList();
            $results['categories'] = $data['results'];

            return $this->render('editCar', compact('results'));
        }
    }

    public function actionDeleteCar()
    {
        if (!$car = Car::getById((int)$_GET['carId'])) {
            \Yii::$app->response->redirect("/admin/car/list-cars?error=carNotFound");
            return;
        }
        $car->delete();
        \Yii::$app->response->redirect("/admin/car/list-cars?status=carDeleted");
    }

    public function actionListCars()
    {
        $results = array();
        $data = Car::getList();
        $results['cars'] = $data['results'];
        $results['totalRows'] = $data['totalRows'];
        $results['images'] = array();
        foreach ($results['cars'] as $car) {
            $temp = Image::getByCarId($car['id']);
            if ($temp['totalRows'] > 0)
                $results['images'][$car['id']] = $temp['results'][0];
        }

        $results['pageTitle'] = "All Cars";

        if (isset($_GET['error'])) {
            if ($_GET['error'] == "carNotFound") $results['errorMessage'] = "Error: Car not found.";
        }

        if (isset($_GET['status'])) {
            if ($_GET['status'] == "changesSaved") $results['statusMessage'] = "Your changes have been saved.";
            if ($_GET['status'] == "carDeleted") $results['statusMessage'] = "Car deleted.";
        }

        return $this->render('listCars', compact('results'));
    }
}

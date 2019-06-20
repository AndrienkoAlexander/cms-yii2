<?php

namespace app\module\admin\controllers;

use yii\base\Controller;
use app\models\Car;
use app\models\Category;


class CategoryController extends Controller
{
    public function actionIndex()
    {
        $this->actionListCategories();
    }

    public function actionListCategories()
    {
        $results = array();
        $data = Category::getList();
        $results['categories'] = $data['results'];
        $results['totalRows'] = $data['totalRows'];
        $results['pageTitle'] = "Cars Categories | Cars News";

        if (isset($_GET['error'])) {
            if ($_GET['error'] == "categoryNotFound") $results['errorMessage'] = "Error: Category not found.";
            if ($_GET['error'] == "categoryContainsCars") $results['errorMessage'] = "Error: Category contains carss. Delete the cars, or assign them to another category, before deleting this category.";
        }

        if (isset($_GET['status'])) {
            if ($_GET['status'] == "changesSaved") $results['statusMessage'] = "Your changes have been saved.";
            if ($_GET['status'] == "categoryDeleted") $results['statusMessage'] = "Category deleted.";
        }

        return $this->render('listCategories', compact('results'));
    }

    public function actionNewCategory()
    {
        $results = array();
        $results['pageTitle'] = "New Car Category";
        $results['formAction'] = "new-category";

        if (isset($_POST['saveChanges'])) {
            // User has posted the category edit form: save the new category
            $category = new Category;
            $category->storeFormValues($_POST);
            $category->save();
            \Yii::$app->response->redirect("/admin/category/list-categories?status=changesSaved");
        } elseif (isset($_POST['cancel'])) {
            // User has cancelled their edits: return to the category list
            \Yii::$app->response->redirect("/admin/category/list-categories");
        } else {
            // User has not posted the category edit form yet: display the form
            $results['category'] = new Category;

            return $this->render('editCategory', compact('results'));
        }
    }

    public function actionEditCategory()
    { 
        $results = array();
		$results['pageTitle'] = "Edit Car Category";
		$results['formAction'] = "edit-category";

		if ( isset( $_POST['saveChanges'] ) ) {
			// User has posted the category edit form: save the category changes
			if ( !$category = Category::getById( (int)$_POST['categoryId'] ) ) {
                \Yii::$app->response->redirect("/admin/category/list-categories?error=categoryNotFound");
				return;
            }
            
			$category->storeFormValues( $_POST );
            $category->update();
            \Yii::$app->response->redirect("/admin/category/list-categories?status=changesSaved");
            
		} elseif ( isset( $_POST['cancel'] ) ) {
            // User has cancelled their edits: return to the category list
            \Yii::$app->response->redirect("/admin/category/list-categories");
		} else {
			// User has not posted the category edit form yet: display the form
			$results['category'] = Category::getById( (int)$_GET['categoryId'] );
            return $this->render('editCategory', compact('results'));
		}
    }

    public function actionDeleteCategory()
    { 
		if ( !$category = Category::getById( (int)$_GET['categoryId'] ) ) {
            \Yii::$app->response->redirect("/admin/category/list-categories?error=categoryNotFound");
			return;
		}

		$cars = Car::getList( 1000000, $category->id );

		if ( $cars['totalRows'] > 0 ) {
            \Yii::$app->response->redirect("/admin/category/list-categories?error=categoryContainsCars");
			return;
        }
        
        $category->delete();
        \Yii::$app->response->redirect("/admin/category/list-categories?status=categoryDeleted");
    }
}

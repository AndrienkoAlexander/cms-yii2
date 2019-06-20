<?php

namespace app\module\admin\controllers;

use yii\base\Controller;
use app\models\User;


class UserController extends Controller
{
    public function actionIndex()
    {
        $this->actionListUsers();
    }

    public function actionListUsers() {
		$results = array();
		$data = User::getList();
		$results['users'] = $data['results'];
		$results['totalRows'] = $data['totalRows'];
		$results['pageTitle'] = "Users";

		if ( isset( $_GET['error'] ) ) {
			if ( $_GET['error'] == "userNotFound" ) $results['errorMessage'] = "Error: User not found.";
		}

		if ( isset( $_GET['status'] ) ) {
			if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
			if ( $_GET['status'] == "userDeleted" ) $results['statusMessage'] = "User deleted.";
		}
        return $this->render('listUsers', compact('results'));
	}

	public function actionDeleteUser() {
        if(isset($_GET['userId'])) {
            if ( !$user = User::getById( (int)$_GET['userId'] ) ) {
                \Yii::$app->response->redirect("/admin/user/list-users?error=userNotFound");
            }
            $user->delete();
            \Yii::$app->response->redirect("/admin/user/list-users?status=userDeleted");
        }
        else
        {
            \Yii::$app->response->redirect("/admin/user/list-users?error=userNotFound");
        }

	}
}
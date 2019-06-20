<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Article;
use app\models\User;

class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $results = array();

        if ( isset( $_GET['status'] ) ) {
			if ( $_GET['status'] == "newUser" ) $results['statusMessage'] = "You have been successfully registered! Log in.";
        }

        $data = Article::getList();
        $results['articles'] = $data['results'];
        $results['totalRows'] = $data['totalRows'];
        $results['pageTitle'] = "Cars News";
        return $this->render('index', compact('results'));
    }

    public function actionSignup()
    {
        $results = array();
        $results['pageTitle'] = "Signup | Cars News";

        if (isset($_POST['signup'])) {
            // Пользователь получает форму регистрации
            if (User::getByName($_POST['name'])) {
                $results['errorMessage'] = "This name is already registered. Please try again.";
                return $this->render('signup', compact('results'));
                return;
            }

            if (User::getByEmail($_POST['email'])) {
                $results['errorMessage'] = "This email is already registered. Please try again.";
                return $this->render('signup', compact('results'));
                return;
            }

            if ($_POST['password1'] != $_POST['password2']) {
                $results['errorMessage'] = "Passwords do not match. Please try again.";
                return $this->render('signup', compact('results'));
                return;
            }
            $user = new User;
            $user->storeFormValues($_POST);
            $user->save();

            \Yii::$app->response->redirect("/site/index?status=newUser");
        } elseif (isset($_POST['cancel'])) {
            // Пользователь сбросид результаты: возвращаемся к списку статей
            \Yii::$app->response->redirect("/site");
        } else {
            // Пользователь еще не получил форму: выводим форму
            $results['user'] = new User;
            return $this->render('signup', compact('results'));
        }
    }
    
    public function actionLogin()
    {
        $results = array();
		$results['pageTitle'] = "Login | Cars News";

		if ( isset( $_POST['login'] ) ) {

			$email = $_POST['email'];
			$user = User::getByEmail($email);
			// Пользователь получает форму входа: попытка авторизировать пользователя
			if ( sha1($_POST['password']) == $user->password ) {
				// Вход прошел успешно: создаем сессию и перенаправляем на страницу администратора
                \Yii::$app->user->login($user);
                \Yii::$app->response->redirect("/");
			} else {
      			// Ошибка входа: выводим сообщение об ошибке для пользователя
				$results['errorMessage'] = "Incorrect email or password. Please try again.";
                return $this->render('login', compact('results'));
			}
		} else {
			// Пользователь еще не получил форму: выводим форму
            return $this->render('login', compact('results'));
		}
    }

    public function actionLogout()
    {
        if(!Yii::$app->user->isGuest)
        {
            Yii::$app->user->logout();
            \Yii::$app->response->redirect("/site/index");
        }
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }
}

<?php

namespace app\module\admin\controllers;

use yii\base\Controller;
use app\models\Article;


class ArticleController extends Controller
{
    public function actionIndex()
    {
        $this->actionListArticlesAdmin();
    }

    public function actionNewArticle()
    {
        $results = array();
        $results['pageTitle'] = "New Article | Cars News";
        $results['formAction'] = "new-article";

        if (isset($_POST['saveChanges'])) {
            // Пользователь получает форму редактирования статьи: сохраняем новую статью
            $article = new Article;
            $article->storeFormValues($_POST);
            $article->save();
            \Yii::$app->response->redirect("/admin/article/list-articles-admin?status=changesSaved");
        } elseif (isset($_POST['cancel'])) {
            // Пользователь сбросид результаты редактирования: возвращаемся к списку статей
            \Yii::$app->response->redirect("/admin/article/list-articles-admin");
        } else {
            // Пользователь еще не получил форму редактирования: выводим форму
            $results['article'] = new Article;
            return $this->render('editArticle', compact('results'));
        }
    }

    public function actionEditArticle()
    {
        $results = array();
        $results['pageTitle'] = "Edit Article";
        $results['formAction'] = "edit-article";

        if (isset($_POST['saveChanges'])) {
            // Пользователь получил форму редактирования статьи: сохраняем изменения
            if (!$article = Article::getById((int)$_POST['articleId'])) {
                \Yii::$app->response->redirect("/admin/article/list-articles-admin?error=articleNotFound");
                return;
            }

            $article->storeFormValues($_POST);
            $article->update();
            \Yii::$app->response->redirect("/admin/article/list-articles-admin?status=changesSaved");
        } elseif (isset($_POST['cancel'])) {
            // Пользователь отказался от результатов редактирования: возвращаемся к списку статей
            \Yii::$app->response->redirect("/admin/article/list-articles-admin");
        } else {
            // Пользвоатель еще не получил форму редактирования: выводим форму
            $results['article'] = Article::getById((int)$_GET['articleId']);
            return $this->render('editArticle', compact('results'));
        }
    }

    public function actionListArticlesAdmin() {
		$results = array();
		$data = Article::getList();
		$results['articles'] = $data['results'];
		$results['totalRows'] = $data['totalRows'];
		$results['pageTitle'] = "All Articles | Car News";

		if ( isset( $_GET['error'] ) ) {
			if ( $_GET['error'] == "articleNotFound" ) $results['errorMessage'] = "Error: Article not found.";
		}

		if ( isset( $_GET['status'] ) ) {
			if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
			if ( $_GET['status'] == "articleDeleted" ) $results['statusMessage'] = "Article deleted.";
		}

        return $this->render('listArticlesAdmin', compact('results'));
	}

	public function actionDeleteArticle() {

		if ( !$article = Article::getById( (int)$_GET['articleId'] ) ) {
            \Yii::$app->response->redirect("/admin/article/list-articles-admin?error=articleNotFound");
			return;
		}

        $article->delete();
        \Yii::$app->response->redirect("/admin/article/list-articles-admin?status=articleDeleted");
	}
}

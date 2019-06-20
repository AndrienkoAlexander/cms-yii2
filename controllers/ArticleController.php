<?php

namespace app\controllers;

use yii\base\Controller;
use app\models\Article;


class ArticleController extends Controller
{
    public function actionIndex()
    {
        $this->actionListArticles();
    }

    public function actionArchive()
    {
        $results = array();
        $data = Article::getList();
        $results['articles'] = $data['results'];
        $results['totalRows'] = $data['totalRows'];
        $results['pageTitle'] = "Article Archive | Cars News";
        return $this->render('archive', compact('results'));
    }

    public function actionListArticles()
    {
        $results = array();
        if (isset($_GET['status'])) {
            if ($_GET['status'] == "newUser") $results['statusMessage'] = "You have been successfully registered! Log in.";
        }

        $data = Article::getList();
        $results['articles'] = $data['results'];
        $results['totalRows'] = $data['totalRows'];
        $results['pageTitle'] = "List Articles | Cars News";
        return $this->render('listArticles', compact('results'));
    }

    public function actionViewArticle()
    {
        if (!isset($_GET["articleId"]) || !$_GET["articleId"]) {
            $this->listArticles();
            return;
        }

        $results = array();
        $results['article'] = Article::getById((int)$_GET["articleId"]);
        $results['pageTitle'] = $results['article']['title'] . " | Cars News";
        return $this->render('viewArticle', compact('results'));
    }

}

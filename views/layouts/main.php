<?php
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru">
  <head>    
    <title><?= Html::encode($this->title) ?></title>
    <?= $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>
  </head>
  <body>
    <?php $this->beginBody() ?>
    <input type="checkbox" id="nav-toggle" hidden>
    <nav class="nav">
        <label for="nav-toggle" class="nav-toggle" onclick></label>
        <h2 class="logo"> 
            <a href="/">Car News</a> 
        </h2>
        <ul>
            <li><a href="/">Главная</a>
            <li><a href="/site/signup">Регистрация</a>
            <li><a href="/site/login">Вход</a>
            <li><a href="/category/cars-categories">Каталог машин</a>
            <?php if(!\Yii::$app->user->isGuest) { if(\Yii::$app->user->identity->admin) {?>
            <li><a href="/admin/default">Админ панель</a>
            <li><a href="/admin/article/list-articles-admin">Edit Articles</a>
            <li><a href="/admin/category/list-categories">Edit Categories</a> 
            <li><a href="/admin/car/list-cars">Edit Cars</a>
            <li><a href="/admin/user/list-users">Users</a>
            <?php }} ?>
        </ul>
    </nav>
    <div id="container">

		<a href="/"><?=Html::img('@web/images/logo.jpg', ['alt' => 'Cars News', 'class' => 'logo']);?></a>
		
		<?php
			if(!\Yii::$app->user->isGuest)
			{
        if(\Yii::$app->user->identity->admin)
        {
		?>
			<div id="adminHeader">
		        <h2>Cars News Admin</h2>
		        <p>You are logged in as <b><?php echo htmlspecialchars( \Yii::$app->user->identity->name) ?></b>. <a href="/site/logout"?>Log Out</a></p>
		    </div>
    <?php
      }
      else{
    ?>
		    <div id="userHeader">
		        <p>You are logged in as <b><?php echo htmlspecialchars( \Yii::$app->user->identity->name) ?></b>. <a href="/site/logout"?>Log Out</a></p>
		    </div>
		<?php
			}
      }
		?>

    <?=$content?>
		
		<div id="footer">
			Cars News &copy; 2019. All rights reserved.
		</div>
    </div>
    <?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>

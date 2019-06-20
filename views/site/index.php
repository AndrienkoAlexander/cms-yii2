<?php 
    /**
     * @var $this yii\web\View
     * @var $article app\models\Article
     */

    $this->title = $results['pageTitle'];
    if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } 

    if ( isset( $results['statusMessage'] ) ) { ?>
        <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>

      <ul id="headlines">

<?php foreach ( $results['articles'] as $article ) { ?>
    <li>
        <h2>
            <span class="pubDate"><?php echo $article['publicationDate']?></span><a href="/article/view-article?articleId=<?php echo $article['id']?>"><?php echo htmlspecialchars( $article['title'] )?></a>
        </h2>
        <p class="summary"><?php echo htmlspecialchars( $article['summary'] )?></p>
    </li>

<?php } ?>

    </ul>

    <p><a href="/article/archive">Article Archive</a></p>
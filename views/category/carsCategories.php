<?php 
	/* @var $this yii\web\View */

	$this->title = $results['pageTitle'];
	/*$this->registerJsFile('@web/js/jquery.accordion.js', ['position' => \yii\web\View::POS_READY]);
	$this->registerJsFile('@web/js/jquery.cookie.js', ['position' => \yii\web\View::POS_READY]);
	$this->registerJsFile('@web/js/categories.js', ['position' => \yii\web\View::POS_READY]);*/
	$categories_menu = categories_to_string($categories_tree); 

	/**
	* Tree to HTML string
	**/
  	function categories_to_string($data) {
	    $string = "";
	    foreach($data as $item) {
	      $string .= categories_to_template($item);
	    }
	    return $string;
  	}

	function categories_to_template($category) {
    	$string = "";
		$string .= '<li>';
		$string .= '<a href="/car/view-category?categoryId='. $category['id']. '">' . $category['name'] . '</a>';
		if(isset($category['childs'])) {
			if($category['childs']){
				$string .= '<ul>';
				$string .= categories_to_string($category['childs']);
				$string .= '</ul>';
			}
		}
		$string .= '</li>';
		return $string;
	}
	$this->title = $results['pageTitle'];
?>

<div class="catalog">
	<ul class="category"> 
		<?php  echo $categories_menu; ?>
	</ul>
</div>
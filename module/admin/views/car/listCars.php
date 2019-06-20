<?php 
  use yii\helpers\Html;
  $this->title = $results['pageTitle'];
?> 
     <h1>All Cars</h1>

<?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>


<?php if ( isset( $results['statusMessage'] ) ) { ?>
        <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>

<?php
  echo '<div class="products">'; 
  foreach ($results['cars'] as $car) {
    echo '<div class="cars">';
    echo '<p class="car_name"><a href="/admin/car/edit-car?carId=' . $car->id . '">'. $car->name .'</a></p>';

    if(isset($results['images'][$car->id]))
      echo Html::img('@web/images/' . $results['images'][$car->id]->name, ['alt' => $car->name]);

    echo '<ul>';
    echo '<li>Цена: $'. $car->price .'</li>';
    echo '<li>Год: '. $car->year .'</li>';
    echo '<li>Серийный номер: '. $car->serial_num .'</li>';
    echo '<li>Коробка передач: '. $car->gear_box .'</li>';
    echo '<li>Мощность: '. $car->power .' л.с.</li>';
    echo '</ul>';
    echo '</div>';
  }
  echo '</div>';
?>

      <p><a href="/admin/car/new-car">Add a New Car</a></p>


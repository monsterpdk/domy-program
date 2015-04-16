<?php
/* @var $this AdatforrasokController */
/* @var $model Adatforrasok */

$this->breadcrumbs=array(
	'Adatforrások'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1><?php echo $model->adatforras; ?> adatforrás szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
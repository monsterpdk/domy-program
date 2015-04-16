<?php
/* @var $this BesorolasokController */
/* @var $model Besorolasok */

$this->breadcrumbs=array(
	'Besorolások'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1><?php echo $model->besorolas; ?> besorolás szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
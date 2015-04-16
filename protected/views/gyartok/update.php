<?php
/* @var $this GyartokController */
/* @var $model Gyartok */

$this->breadcrumbs=array(
	'Gyártók'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>'<?php echo $model->cegnev; ?>' gyártó szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
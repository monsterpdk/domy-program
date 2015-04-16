<?php
/* @var $this UgyfelekController */
/* @var $model Ugyfelek */

$this->breadcrumbs=array(
	'Ügyfelek'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1><?php echo $model->cegnev; ?> ügyfél szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
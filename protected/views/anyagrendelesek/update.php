<?php
/* @var $this AnyagrendelesekController */
/* @var $model Anyagrendelesek */

$this->breadcrumbs=array(
	'Anyagrendelések'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1><?php echo $model->id; ?> anyagrendelés adatai</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this OrszagokController */
/* @var $model Orszagok */

$this->breadcrumbs=array(
	'Országok'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1><?php echo $model->nev; ?> ország szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this ArkategoriakController */
/* @var $model Arkategoriak */

$this->breadcrumbs=array(
	'Árkategóriák'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1><?php echo $model->nev; ?> árkategória szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
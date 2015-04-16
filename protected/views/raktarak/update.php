<?php
/* @var $this RaktarakController */
/* @var $model Raktarak */

$this->breadcrumbs=array(
	'Raktárak'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1><?php echo $model->nev; ?> raktár szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
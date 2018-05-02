<?php
/* @var $this SzallitoCegekController */
/* @var $model SzallitoCegek */

$this->breadcrumbs=array(
	'Szállító cégek'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1><?php echo $model->nev; ?> szállító cég szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
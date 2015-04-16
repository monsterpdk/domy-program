<?php
/* @var $this AnyagbeszallitasokController */
/* @var $model Anyagbeszallitasok */

$this->breadcrumbs=array(
	'Anyagbeszallitasoks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Anyagbeszallitasok', 'url'=>array('index')),
	array('label'=>'Manage Anyagbeszallitasok', 'url'=>array('admin')),
);
?>

<h1>Create Anyagbeszallitasok</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this AnyagbeszallitasTermekekIrodaController */
/* @var $model AnyagbeszallitasTermekekIroda */

$this->breadcrumbs=array(
	'Anyagbeszallitas Termekek Irodas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AnyagbeszallitasTermekekIroda', 'url'=>array('index')),
	array('label'=>'Manage AnyagbeszallitasTermekekIroda', 'url'=>array('admin')),
);
?>

<h1>Create AnyagbeszallitasTermekekIroda</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
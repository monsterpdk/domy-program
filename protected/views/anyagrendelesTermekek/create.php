<?php
/* @var $this AnyagrendelesTermekekController */
/* @var $model AnyagrendelesTermekek */

$this->breadcrumbs=array(
	'Anyagrendeles Termekeks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AnyagrendelesTermekek', 'url'=>array('index')),
	array('label'=>'Manage AnyagrendelesTermekek', 'url'=>array('admin')),
);
?>

<h1>Create AnyagrendelesTermekek</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'termek' => $termek,)); ?>
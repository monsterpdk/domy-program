<?php
/* @var $this ArajanlatTetelekController */
/* @var $model ArajanlatTetelek */

$this->breadcrumbs=array(
	'Arajanlat Teteleks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ArajanlatTetelek', 'url'=>array('index')),
	array('label'=>'Manage ArajanlatTetelek', 'url'=>array('admin')),
);
?>

<h1>Create ArajanlatTetelek</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
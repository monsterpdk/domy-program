<?php
/* @var $this SzallitoFutarlevelekController */
/* @var $model SzallitoFutarlevelek */

$this->breadcrumbs=array(
	'szallitoFutarlevelek'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Futarlevelek', 'url'=>array('index')),
	array('label'=>'Manage Futarlevelek', 'url'=>array('admin')),
);
?>

<h1>Új futárlevél</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'aruk'=>$aruk)); ?>
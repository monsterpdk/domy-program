<?php
/* @var $this SzallitoCegFutarokController */
/* @var $model SzallitoCegFutarok */

$this->breadcrumbs=array(
	'Szállító cég futárok'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SzallitoCegFutarok', 'url'=>array('index')),
	array('label'=>'Manage SzallitoCegFutarok', 'url'=>array('admin')),
);
?>

<h1>Új futár létrehozása</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
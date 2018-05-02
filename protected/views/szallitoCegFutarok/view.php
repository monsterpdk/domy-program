<?php
/* @var $this SzallitoCegFutarokController */
/* @var $model SzallitoCegFutarok */

$this->breadcrumbs=array(
	'Futárok'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SzallitoCegFutarok', 'url'=>array('index')),
	array('label'=>'Create SzallitoCegFutarok', 'url'=>array('create')),
	array('label'=>'Update SzallitoCegFutarok', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SzallitoCegFutarok', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SzallitoCegFutarok', 'url'=>array('admin')),
);
?>

<h1>View SzallitoCegFutarok #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'szallito_ceg_id',
		'nev',
		'telefon',
		'rendszam',
		'torolt',
	),
)); ?>

<?php
/* @var $this AnyagrendelesTermekekController */
/* @var $model AnyagrendelesTermekek */

$this->breadcrumbs=array(
	'Anyagrendeles Termekeks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AnyagrendelesTermekek', 'url'=>array('index')),
	array('label'=>'Create AnyagrendelesTermekek', 'url'=>array('create')),
	array('label'=>'Update AnyagrendelesTermekek', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AnyagrendelesTermekek', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AnyagrendelesTermekek', 'url'=>array('admin')),
);
?>

<h1>View AnyagrendelesTermekek #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'anyagrendeles_id',
		'termek_id',
		'rendelt_darabszam',
		'rendeleskor_netto_darabar',
	),
)); ?>

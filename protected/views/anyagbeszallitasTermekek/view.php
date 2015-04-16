<?php
/* @var $this AnyagbeszallitasTermekekController */
/* @var $model AnyagbeszallitasTermekek */

$this->breadcrumbs=array(
	'Anyagbeszallitas Termekeks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AnyagbeszallitasTermekek', 'url'=>array('index')),
	array('label'=>'Create AnyagbeszallitasTermekek', 'url'=>array('create')),
	array('label'=>'Update AnyagbeszallitasTermekek', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AnyagbeszallitasTermekek', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AnyagbeszallitasTermekek', 'url'=>array('admin')),
);
?>

<h1>View AnyagbeszallitasTermekek #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'anyagbeszallitas_id',
		'termek_id',
		'darabszam',
		'netto_darabar',
	),
)); ?>

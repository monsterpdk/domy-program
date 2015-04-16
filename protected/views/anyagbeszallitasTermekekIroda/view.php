<?php
/* @var $this AnyagbeszallitasTermekekIrodaController */
/* @var $model AnyagbeszallitasTermekekIroda */

$this->breadcrumbs=array(
	'Anyagbeszallitas Termekek Irodas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AnyagbeszallitasTermekekIroda', 'url'=>array('index')),
	array('label'=>'Create AnyagbeszallitasTermekekIroda', 'url'=>array('create')),
	array('label'=>'Update AnyagbeszallitasTermekekIroda', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AnyagbeszallitasTermekekIroda', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AnyagbeszallitasTermekekIroda', 'url'=>array('admin')),
);
?>

<h1>View AnyagbeszallitasTermekekIroda #<?php echo $model->id; ?></h1>

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

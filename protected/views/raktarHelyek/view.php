<?php
/* @var $this RaktarHelyekController */
/* @var $model RaktarHelyek */

$this->breadcrumbs=array(
	'Raktar Helyeks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RaktarHelyek', 'url'=>array('index')),
	array('label'=>'Create RaktarHelyek', 'url'=>array('create')),
	array('label'=>'Update RaktarHelyek', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RaktarHelyek', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RaktarHelyek', 'url'=>array('admin')),
);
?>

<h1>View RaktarHelyek #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'raktar_id',
		'nev',
		'torolt',
	),
)); ?>

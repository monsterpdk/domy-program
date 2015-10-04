<?php
/* @var $this ArajanlatVisszahivasokController */
/* @var $model ArajanlatVisszahivasok */

$this->breadcrumbs=array(
	'Arajanlat Visszahivasok'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ArajanlatVisszahivasok', 'url'=>array('index')),
	array('label'=>'Create ArajanlatVisszahivasok', 'url'=>array('create')),
	array('label'=>'Update ArajanlatVisszahivasok', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ArajanlatVisszahivasok', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ArajanlatVisszahivasok', 'url'=>array('admin')),
);
?>

<h1>#<?php echo $model->id; ?> árajánlat visszahívásainak megtekintése</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'arajanlat_id',
		'user_id',
		'jegyzet',
		'idopont',
		'torolt',
	),
)); ?>

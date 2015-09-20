<?php
/* @var $this ArajanlatTetelekController */
/* @var $model ArajanlatTetelek */

$this->breadcrumbs=array(
	'Arajanlat Teteleks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ArajanlatTetelek', 'url'=>array('index')),
	array('label'=>'Create ArajanlatTetelek', 'url'=>array('create')),
	array('label'=>'Update ArajanlatTetelek', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ArajanlatTetelek', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ArajanlatTetelek', 'url'=>array('admin')),
);
?>

<h1>View ArajanlatTetelek #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'arajanlat_id',
		'termek_id',
		'szinek_szama1',
		'szinek_szama2',
		'darabszam',
		'netto_darabar',
		'megjegyzes',
		'mutacio',
		'torolt',
	),
)); ?>

<?php
/* @var $this NyomdakonyvLejelentesController */
/* @var $model NyomdakonyvLejelentes */

$this->breadcrumbs=array(
	'Nyomdakönyv lejelentett teljesítmények'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List NyomdakonyvLejelentes', 'url'=>array('index')),
	array('label'=>'Create NyomdakonyvLejelentes', 'url'=>array('create')),
	array('label'=>'Update NyomdakonyvLejelentes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NyomdakonyvLejelentes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NyomdakonyvLejelentes', 'url'=>array('admin')),
);
?>

<h1>View Nyomdakonyv lejelentes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nyomdakonyv_id',
		'user_id',
		'teljesitmeny_szazalek',
		'torolt',
	),
)); ?>

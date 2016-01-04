<?php
/* @var $this NyomdakonyvLejelentesController */
/* @var $model NyomdakonyvLejelentes */

$this->breadcrumbs=array(
	'Nyomdakönyv lejelentett teljesítmények'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List NyomdakonyvLejelentes', 'url'=>array('index')),
	array('label'=>'Create NyomdakonyvLejelentes', 'url'=>array('create')),
	array('label'=>'View NyomdakonyvLejelentes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NyomdakonyvLejelentes', 'url'=>array('admin')),
);
?>

<h1>Update NyomdakonyvLejelentes <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'nyomdakonyv_model'=>$nyomdakonyv_model)); ?>
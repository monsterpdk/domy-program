<?php
/* @var $this NyomdakonyvController */
/* @var $model Nyomdakonyv */

$this->breadcrumbs=array(
	'Nyomdakonyvs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Nyomdakonyv', 'url'=>array('index')),
	array('label'=>'Create Nyomdakonyv', 'url'=>array('create')),
	array('label'=>'View Nyomdakonyv', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Nyomdakonyv', 'url'=>array('admin')),
);
?>

<h1>Update Nyomdakonyv <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
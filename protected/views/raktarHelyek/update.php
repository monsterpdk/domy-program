<?php
/* @var $this RaktarHelyekController */
/* @var $model RaktarHelyek */

$this->breadcrumbs=array(
	'Raktar Helyeks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RaktarHelyek', 'url'=>array('index')),
	array('label'=>'Create RaktarHelyek', 'url'=>array('create')),
	array('label'=>'View RaktarHelyek', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RaktarHelyek', 'url'=>array('admin')),
);
?>

<h1>Update RaktarHelyek <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
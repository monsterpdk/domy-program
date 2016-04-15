<?php
/* @var $this RaktarHelyekController */
/* @var $model RaktarHelyek */

$this->breadcrumbs=array(
	'Raktar Helyeks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RaktarHelyek', 'url'=>array('index')),
	array('label'=>'Manage RaktarHelyek', 'url'=>array('admin')),
);
?>

<h1>Create RaktarHelyek</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this NyomdakonyvController */
/* @var $model Nyomdakonyv */

$this->breadcrumbs=array(
	'Nyomdakonyvs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Nyomdakonyv', 'url'=>array('index')),
	array('label'=>'Manage Nyomdakonyv', 'url'=>array('admin')),
);
?>

<h1>Create Nyomdakonyv</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
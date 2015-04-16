<?php
/* @var $this AnyagrendelesTermekekController */
/* @var $model AnyagrendelesTermekek */

$this->breadcrumbs=array(
	'Anyagrendeles Termekeks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AnyagrendelesTermekek', 'url'=>array('index')),
	array('label'=>'Create AnyagrendelesTermekek', 'url'=>array('create')),
	array('label'=>'View AnyagrendelesTermekek', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AnyagrendelesTermekek', 'url'=>array('admin')),
);
?>

<h1>Update AnyagrendelesTermekek <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'termek' => $termek,)); ?>
<?php
/* @var $this ArajanlatTetelekController */
/* @var $model ArajanlatTetelek */

$this->breadcrumbs=array(
	'Arajanlat Teteleks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ArajanlatTetelek', 'url'=>array('index')),
	array('label'=>'Create ArajanlatTetelek', 'url'=>array('create')),
	array('label'=>'View ArajanlatTetelek', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ArajanlatTetelek', 'url'=>array('admin')),
);
?>

<h1>Update ArajanlatTetelek <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
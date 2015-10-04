<?php
/* @var $this ArajanlatVisszahivasokController */
/* @var $model ArajanlatVisszahivasok */

$this->breadcrumbs=array(
	'Arajanlat Visszahivasok'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ArajanlatVisszahivasok', 'url'=>array('index')),
	array('label'=>'Create ArajanlatVisszahivasok', 'url'=>array('create')),
	array('label'=>'View ArajanlatVisszahivasok', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ArajanlatVisszahivasok', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->id; ?> árajánlat visszahívásának módosítása</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
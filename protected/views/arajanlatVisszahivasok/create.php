<?php
/* @var $this ArajanlatVisszahivasokController */
/* @var $model ArajanlatVisszahivasok */

$this->breadcrumbs=array(
	'Arajanlat Visszahivasok'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ArajanlatVisszahivasok', 'url'=>array('index')),
	array('label'=>'Manage ArajanlatVisszahivasok', 'url'=>array('admin')),
);
?>

<h1>Árajánlat visszahívás létrehozása</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
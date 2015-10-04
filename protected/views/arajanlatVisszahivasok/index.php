<?php
/* @var $this ArajanlatVisszahivasokController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Arajanlat Visszahivasok',
);

$this->menu=array(
	array('label'=>'Create ArajanlatVisszahivasok', 'url'=>array('create')),
	array('label'=>'Manage ArajanlatVisszahivasok', 'url'=>array('admin')),
);
?>

<h1>Árajánlat visszahívások</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

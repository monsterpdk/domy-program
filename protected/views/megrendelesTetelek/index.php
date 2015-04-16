<?php
/* @var $this ArajanlatTetelekController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Arajanlat Teteleks',
);

$this->menu=array(
	array('label'=>'Create ArajanlatTetelek', 'url'=>array('create')),
	array('label'=>'Manage ArajanlatTetelek', 'url'=>array('admin')),
);
?>

<h1>Arajanlat Teteleks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

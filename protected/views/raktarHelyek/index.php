<?php
/* @var $this RaktarHelyekController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Raktar Helyeks',
);

$this->menu=array(
	array('label'=>'Create RaktarHelyek', 'url'=>array('create')),
	array('label'=>'Manage RaktarHelyek', 'url'=>array('admin')),
);
?>

<h1>Raktar Helyeks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php
/* @var $this AnyagbeszallitasTermekekController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Anyagbeszallitas Termekeks',
);

$this->menu=array(
	array('label'=>'Create AnyagbeszallitasTermekek', 'url'=>array('create')),
	array('label'=>'Manage AnyagbeszallitasTermekek', 'url'=>array('admin')),
);
?>

<h1>Anyagbeszallitas Termekeks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

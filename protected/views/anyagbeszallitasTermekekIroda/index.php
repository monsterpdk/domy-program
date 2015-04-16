<?php
/* @var $this AnyagbeszallitasTermekekIrodaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Anyagbeszallitas Termekek Irodas',
);

$this->menu=array(
	array('label'=>'Create AnyagbeszallitasTermekekIroda', 'url'=>array('create')),
	array('label'=>'Manage AnyagbeszallitasTermekekIroda', 'url'=>array('admin')),
);
?>

<h1>Anyagbeszallitas Termekek Irodas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

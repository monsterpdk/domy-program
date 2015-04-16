<?php
/* @var $this AnyagrendelesTermekekController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Anyagrendeles Termekeks',
);

$this->menu=array(
	array('label'=>'Create AnyagrendelesTermekek', 'url'=>array('create')),
	array('label'=>'Manage AnyagrendelesTermekek', 'url'=>array('admin')),
);
?>

<h1>Anyagrendeles Termekeks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php
/* @var $this SzallitoCegFutarokController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Szállító cég futárok',
);

$this->menu=array(
	array('label'=>'Create SzallitoCegFutarok', 'url'=>array('create')),
	array('label'=>'Manage SzallitoCegFutarok', 'url'=>array('admin')),
);
?>

<h1>Raktar Helyeks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

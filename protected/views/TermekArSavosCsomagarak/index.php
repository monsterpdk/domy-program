<?php
/* @var $this TermekSavosCsomagarakController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Termék sávos csomagárak',
);

$this->menu=array(
	array('label'=>'Create TermekSavosCsomagarak', 'url'=>array('create')),
	array('label'=>'Manage TermekSavosCsomagarak', 'url'=>array('admin')),
);
?>

<h1>Árajánlat visszahívások</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

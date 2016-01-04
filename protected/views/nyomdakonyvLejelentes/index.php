<?php
/* @var $this NyomdakonyvLejelentesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Nyomdakönyv lejelentett teljesítmények',
);

$this->menu=array(
	array('label'=>'Create NyomdakonyvLejelentes', 'url'=>array('create')),
	array('label'=>'Manage NyomdakonyvLejelentes', 'url'=>array('admin')),
);
?>

<h1>Nyomdakönyv lejelentett teljesítmények</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

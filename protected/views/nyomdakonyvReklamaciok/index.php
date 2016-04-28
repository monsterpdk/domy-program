<?php
/* @var $this NyomdakonyvReklamaciokController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Nyomdakonyv Reklamacioks',
);

$this->menu=array(
	array('label'=>'Create NyomdakonyvReklamaciok', 'url'=>array('create')),
	array('label'=>'Manage NyomdakonyvReklamaciok', 'url'=>array('admin')),
);
?>

<h1>Nyomdakonyv Reklamacioks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

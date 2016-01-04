<?php
/* @var $this NyomdakonyvLejelentesController */
/* @var $model NyomdakonyvLejelentes */

$this->breadcrumbs=array(
	'Nyomdakönyv lejelentett teljesítmények'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List NyomdakonyvLejelentes', 'url'=>array('index')),
	array('label'=>'Manage NyomdakonyvLejelentes', 'url'=>array('admin')),
);
?>

<h1>Nyomdakönyv kézi lejelentés</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'nyomdakonyv_model'=>$nyomdakonyv_model)); ?>
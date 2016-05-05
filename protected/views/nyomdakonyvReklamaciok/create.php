<?php
/* @var $this NyomdakonyvReklamaciokController */
/* @var $model NyomdakonyvReklamaciok */

$this->breadcrumbs=array(
	'Nyomdakonyv Reklamacioks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List NyomdakonyvReklamaciok', 'url'=>array('index')),
	array('label'=>'Manage NyomdakonyvReklamaciok', 'url'=>array('admin')),
);
?>

<h1>Create NyomdakonyvReklamaciok</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
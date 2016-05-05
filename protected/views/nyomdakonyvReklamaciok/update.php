<?php
/* @var $this NyomdakonyvReklamaciokController */
/* @var $model NyomdakonyvReklamaciok */

$this->breadcrumbs=array(
	'Nyomdakonyv Reklamacioks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List NyomdakonyvReklamaciok', 'url'=>array('index')),
	array('label'=>'Create NyomdakonyvReklamaciok', 'url'=>array('create')),
	array('label'=>'View NyomdakonyvReklamaciok', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NyomdakonyvReklamaciok', 'url'=>array('admin')),
);
?>

<h1>Update NyomdakonyvReklamaciok <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
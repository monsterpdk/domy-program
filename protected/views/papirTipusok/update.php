<?php
/* @var $this PapirTipusokController */
/* @var $model PapirTipusok */

$this->breadcrumbs=array(
	'Papírítpusok'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
?>

<h1>'<?php echo $model->nev; ?>' papírtípus szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
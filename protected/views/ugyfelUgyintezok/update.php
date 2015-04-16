<?php
/* @var $this UgyfelUgyintezokController */
/* @var $model UgyfelUgyintezok */

$this->breadcrumbs=array(
	'Ügyfélügyintézők'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1><?php echo $model->nev; ?> ügyfélügyintéző szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
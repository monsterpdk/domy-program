<?php
/* @var $this AruhazakController */
/* @var $model Aruhazak */

$this->breadcrumbs=array(
	'Áruházak'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>'<?php echo $model->aruhaz_nev; ?>' áruház szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
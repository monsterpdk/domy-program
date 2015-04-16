<?php
/* @var $this CegformakController */
/* @var $model Cegformak */

$this->breadcrumbs=array(
	'Cégformák'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1><?php echo $model->cegforma; ?> cégforma szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
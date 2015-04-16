<?php
/* @var $this VarosokController */
/* @var $model Varosok */

$this->breadcrumbs=array(
	'Városok'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1><?php echo $model->varosnev; ?> város szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
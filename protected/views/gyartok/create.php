<?php
/* @var $this GyartokController */
/* @var $model Gyartok */

$this->breadcrumbs=array(
	'Gyártók'=>array('index'),
	'Create',
);

?>

<h1>Új gyártó</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
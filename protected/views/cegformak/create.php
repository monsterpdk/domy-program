<?php
/* @var $this CegformakController */
/* @var $model Cegformak */

$this->breadcrumbs=array(
	'Cégformák'=>array('index'),
	'Létrehozás',
);

?>

<h1>Új cégforma</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
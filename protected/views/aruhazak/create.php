<?php
/* @var $this AruhazakController */
/* @var $model Aruhazak */

$this->breadcrumbs=array(
	'Áruházak'=>array('index'),
	'Create',
);

?>

<h1>Új áruház</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this UgyfelekController */
/* @var $model Ugyfelek */

$this->breadcrumbs=array(
	'Ügyfelek'=>array('index'),
	'Create',
);

?>

<h1>Új ügyfél</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
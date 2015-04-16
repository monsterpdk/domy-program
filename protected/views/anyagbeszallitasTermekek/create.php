<?php
/* @var $this AnyagbeszallitasTermekekController */
/* @var $model AnyagbeszallitasTermekek */

$this->breadcrumbs=array(
	'Anyagbeszallitas Termekeks'=>array('index'),
	'Create',
);

?>

<h1>Create AnyagbeszallitasTermekek</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'termek' => $termek)); ?>
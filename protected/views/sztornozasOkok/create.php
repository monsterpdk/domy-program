<?php
/* @var $this SztornozasOkokController */
/* @var $model SztornozasOkok */

$this->breadcrumbs=array(
	'Sztornózás okok'=>array('index'),
	'Létrehozás',
);

?>

<h1>Új sztornózási ok</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this BesorolasokController */
/* @var $model Besorolasok */

$this->breadcrumbs=array(
	'Besorolások'=>array('index'),
	'Létrehozás',
);

?>

<h1>Új besorolás</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
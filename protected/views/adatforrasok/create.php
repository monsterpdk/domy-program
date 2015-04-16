<?php
/* @var $this AdatforrasokController */
/* @var $model Adatforrasok */

$this->breadcrumbs=array(
	'Adatforrások'=>array('index'),
	'Létrehozás',
);

?>

<h1>Új adatforrás</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
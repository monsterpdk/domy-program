<?php
/* @var $this OrszagokController */
/* @var $model Orszagok */

$this->breadcrumbs=array(
	'Országok'=>array('index'),
	'Létrehozás',
);

?>

<h1>Új ország</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this AnyagrendelesekController */
/* @var $model Anyagrendelesek */

$this->breadcrumbs=array(
	'Anyagrendelések'=>array('index'),
	'Létrehozás',
);

?>

<h1>Új anyagrendelés</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
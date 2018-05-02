<?php
/* @var $this SzallitoCegekController */
/* @var $model SzallitoCegek */

$this->breadcrumbs=array(
	'Szállító cégek'=>array('index'),
	'Létrehozás',
);

?>

<h1>Új szállító cég</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
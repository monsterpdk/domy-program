<?php
/* @var $this VarosokController */
/* @var $model Varosok */

$this->breadcrumbs=array(
	'Városok'=>array('index'),
	'Létrehozás',
);

?>

<h1>Új város</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
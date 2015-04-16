<?php
/* @var $this ArkategoriakController */
/* @var $model Arkategoriak */

$this->breadcrumbs=array(
	'Árkategóriák'=>array('index'),
	'Létrehozás',
);

?>

<h1>Új árkategória</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this NyomasiArakSzazalekController */
/* @var $model NyomasiArakSzazalek */

$this->breadcrumbs=array(
	'Nyomási árak %'=>array('index'),
	'Create',
);

?>

<h1>Elemzéshez</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
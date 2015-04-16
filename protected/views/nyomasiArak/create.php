<?php
/* @var $this NyomasiArakController */
/* @var $model NyomasiArak */

$this->breadcrumbs=array(
	'Nyomási árak'=>array('index'),
	'Create',
);

?>

<h1>Új nyomási ár</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
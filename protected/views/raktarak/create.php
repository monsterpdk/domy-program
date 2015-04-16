<?php
/* @var $this RaktarakController */
/* @var $model Raktarak */

$this->breadcrumbs=array(
	'Raktárak'=>array('index'),
	'Létrehozás',
);

?>

<h1>Új raktár</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this TermekMeretekController */
/* @var $model TermekMeretek */

$this->breadcrumbs=array(
	'Termékméretek'=>array('index'),
	'Create',
);

?>

<h1>Új termékméret</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
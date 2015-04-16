<?php
/* @var $this TermekAblakMeretekController */
/* @var $model TermekAblakMeretek */

$this->breadcrumbs=array(
	'Ablakméretek'=>array('index'),
	'Create',
);

?>

<h1>Új ablakméret</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
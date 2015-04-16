<?php
/* @var $this TermekMeretekController */
/* @var $model TermekMeretek */

$this->breadcrumbs=array(
	'Termekméretek'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>'<?php echo $model->nev; ?>' termekméretek szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
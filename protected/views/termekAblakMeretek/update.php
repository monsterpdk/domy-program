<?php
/* @var $this TermekAblakMeretekController */
/* @var $model TermekAblakMeretek */

$this->breadcrumbs=array(
	'Termek Ablak Mereteks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>'<?php echo $model->nev; ?>' ablakméret szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
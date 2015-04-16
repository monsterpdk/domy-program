<?php
/* @var $this TermekAblakHelyekController */
/* @var $model TermekAblakHelyek */

$this->breadcrumbs=array(
	'Ablakhelyek'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>'<?php echo $model->nev; ?>' ablakhely szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
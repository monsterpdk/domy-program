<?php
/* @var $this TermekAblakHelyekController */
/* @var $model TermekAblakHelyek */

$this->breadcrumbs=array(
	'Ablakhelyek'=>array('index'),
	'Create',
);

?>

<h1>Új ablakhely</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
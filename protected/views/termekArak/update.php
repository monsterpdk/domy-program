<?php
/* @var $this TermekArakController */
/* @var $model TermekArak */

$this->breadcrumbs=array(
	'Termékárak'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>'<?php echo $model->id; ?>' termékár szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this TermekekController */
/* @var $model Termekek */

$this->breadcrumbs=array(
	'Termékek'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>'<?php echo $model->nev; ?>' termék szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
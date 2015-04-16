<?php
/* @var $this NyomasiArakController */
/* @var $model NyomasiArak */

$this->breadcrumbs=array(
	'Nyomási árak'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>'<?php echo $model->id; ?>' nyomási ár szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
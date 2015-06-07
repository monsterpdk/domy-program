<?php
/* @var $this NyomasiArakSzazalekController */
/* @var $model NyomasiArakSzazalek */

$this->breadcrumbs=array(
	'Nyomási árak %'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>'<?php echo $model->id; ?>' nyomási termékár szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
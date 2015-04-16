<?php
/* @var $this AnyagbeszallitasTermekekController */
/* @var $model AnyagbeszallitasTermekek */

$this->breadcrumbs=array(
	'Anyagbeszallitas Termekeks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>Update AnyagbeszallitasTermekek <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'termek' => $termek)); ?>
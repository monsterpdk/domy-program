<?php
/* @var $this AnyagbeszallitasokController */
/* @var $model Anyagbeszallitasok */

$this->breadcrumbs=array(
	'Anyagbeszallítások'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1><?php echo $model->id; ?> anyagbeszállítás adatai</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
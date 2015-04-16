<?php
/* @var $this AnyagbeszallitasTermekekIrodaController */
/* @var $model AnyagbeszallitasTermekekIroda */

$this->breadcrumbs=array(
	'Anyagbeszallitas Termekek Irodas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AnyagbeszallitasTermekekIroda', 'url'=>array('index')),
	array('label'=>'Create AnyagbeszallitasTermekekIroda', 'url'=>array('create')),
	array('label'=>'View AnyagbeszallitasTermekekIroda', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AnyagbeszallitasTermekekIroda', 'url'=>array('admin')),
);
?>

<h1>Update AnyagbeszallitasTermekekIroda <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
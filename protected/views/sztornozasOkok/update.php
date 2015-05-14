<?php
/* @var $this SztornozasOkokController */
/* @var $model SztornozasOkok */

$this->breadcrumbs=array(
	'Sztornózás okok'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>'<?php echo $model->ok; ?>' sztornózási ok szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this FizetesiMoralokController */
/* @var $model FizetesiMoralok */

$this->breadcrumbs=array(
	'Fizetési morálok'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>'<?php echo $model->moral_szam; ?>' fizetési morál szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
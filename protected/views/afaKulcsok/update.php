<?php
/* @var $this AfaKulcsokController */
/* @var $model AfaKulcsok */

$this->breadcrumbs=array(
	'ÁFA kulcsok'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1><?php echo $model->nev; ?> ÁFA kulcs szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
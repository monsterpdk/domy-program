<?php
/* @var $this SzallitoCegFutarokController */
/* @var $model SzallitoCegFutarok */

$this->breadcrumbs=array(
	'Futárok'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SzallitoCegFutarok', 'url'=>array('index')),
	array('label'=>'Create SzallitoCegFutarok', 'url'=>array('create')),
	array('label'=>'View SzallitoCegFutarok', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SzallitoCegFutarok', 'url'=>array('admin')),
);
?>

<h1>Update SzallitoCegFutarok <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this TermekSavosCsomagarakController */
/* @var $model TermekSavosCsomagarak */

$this->breadcrumbs=array(
	'Termékek sávos csomag árak'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TermekSavosCsomagarak', 'url'=>array('index')),
	array('label'=>'Create TermekSavosCsomagarak', 'url'=>array('create')),
	array('label'=>'View TermekSavosCsomagarak', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TermekSavosCsomagarak', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->id; ?> csomag ár sáv módosítása</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
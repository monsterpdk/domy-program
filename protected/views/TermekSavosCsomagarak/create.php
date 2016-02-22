<?php
/* @var $this TermekSavosCsomagarakController */
/* @var $model TermekSavosCsomagarak */

$this->breadcrumbs=array(
	'Termék sávos csomag árak'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TermekSavosCsomagarak', 'url'=>array('index')),
	array('label'=>'Manage TermekSavosCsomagarak', 'url'=>array('admin')),
);
?>

<h1>Termék csomag ár sáv létrehozása</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
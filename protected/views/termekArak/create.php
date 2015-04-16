<?php
/* @var $this TermekArakController */
/* @var $model TermekArak */

$this->breadcrumbs=array(
	'Termékárak'=>array('index'),
	'Create',
);

?>

<h1>Új termékár</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
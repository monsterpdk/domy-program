<?php
/* @var $this TermekekController */
/* @var $model Termekek */

$this->breadcrumbs=array(
	'Termékek'=>array('index'),
	'Create',
);

?>

<h1>Új termék</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this FizetesiMoralokController */
/* @var $model FizetesiMoralok */

$this->breadcrumbs=array(
	'Fizetési morálok'=>array('index'),
	'Létrehozás',
);

?>

<h1>Új fizetési morál</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
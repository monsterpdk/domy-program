<?php
/* @var $this PapirTipusokController */
/* @var $model PapirTipusok */

$this->breadcrumbs=array(
	'Papírtípusok'=>array('index'),
	'Létrehozás',
);

?>

<h1>Új papírtípus</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
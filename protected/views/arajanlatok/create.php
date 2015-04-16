<?php
/* @var $this ArajanlatokController */
/* @var $model Arajanlatok */

$this->breadcrumbs=array(
	'Árajánlatok'=>array('index'),
	'Létrehozás',
);

?>

<h1>Új árajánlat</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
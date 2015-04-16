<?php
/* @var $this UgyfelUgyintezokController */
/* @var $model UgyfelUgyintezok */

$this->breadcrumbs=array(
	'ÜgyfélÜgyintézők'=>array('index'),
	'Létrehozás',
);

?>

<h1>Új ügyfélügyintéző</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
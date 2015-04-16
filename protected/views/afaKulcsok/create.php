<?php
/* @var $this AfaKulcsokController */
/* @var $model AfaKulcsok */

$this->breadcrumbs=array(
	'ÁFA kulcsok'=>array('index'),
	'Létrehozás',
);

?>

<h1>Új ÁFA kulcs</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this SzallitolevelekController */
/* @var $model Megrendelesek */
?>

<h1>Új szállítólevél</h1>

<?php $this->renderPartial('_form', array('dataProvider'=>$dataProvider, 'model'=>$model,)); ?>
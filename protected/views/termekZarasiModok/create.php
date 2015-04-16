<?php
/* @var $this TermekZarasiModokController */
/* @var $model TermekZarasiModok */

$this->breadcrumbs=array(
	'Zárásmódok'=>array('index'),
	'Create',
);

?>

<h1>Új zárásmód</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
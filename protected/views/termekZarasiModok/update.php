<?php
/* @var $this TermekZarasiModokController */
/* @var $model TermekZarasiModok */

$this->breadcrumbs=array(
	'Zárásmódok'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>'<?php echo $model->nev; ?>' zárásmód szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
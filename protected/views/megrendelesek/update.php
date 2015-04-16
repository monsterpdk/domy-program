<?php
/* @var $this MegrendelesekController */
/* @var $model Megrendelesek */
?>

<h1> '<?php echo $model->sorszam; ?>' megrendelés szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this TermekCsoportokController */
/* @var $model Termekcsoportok */
?>

<h1>'<?php echo $model->nev; ?>' termékcsoport szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
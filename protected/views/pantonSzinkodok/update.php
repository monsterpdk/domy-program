<?php
/* @var $this PantonSzinkodokController */
/* @var $model PantonSzinkodok */
?>

<h1>'<?php echo $model->nev; ?>' panton színkód szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
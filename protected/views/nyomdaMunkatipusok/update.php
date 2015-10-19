<?php
/* @var $this NyomdaMunkatipusokController */
/* @var $model NyomdaMunkatipusok */
?>

<h1> '<?php echo $model->munkatipus_nev; ?>' munkatípus szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model,)); ?>
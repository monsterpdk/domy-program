<?php
/* @var $this NyomdagepTipusokController */
/* @var $model NyomdagepTipusok */
?>

<h1>'<?php echo $model->tipusnev; ?>' nyomdagép típus szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this ZuhController */
/* @var $model Zuh */
?>

<h1>'<?php echo $model->id; ?>' zuh szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
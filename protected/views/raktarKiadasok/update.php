<?php
/* @var $this RaktarKiadasokController */
/* @var $model RaktarKiadasok */
?>

<h1>'<?php echo $model->id; ?>' raktár kiadás szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
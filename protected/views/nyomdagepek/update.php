<?php
/* @var $this NyomdagepekController */
/* @var $model Nyomdagepek */

?>

<h1>'<?php echo $model->gepnev; ?>' nyomdagép szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
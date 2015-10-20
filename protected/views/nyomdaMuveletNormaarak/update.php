<?php
/* @var $this NyomdaMuveletNormaarakController */
/* @var $model NyomdaMuveletNormaarak */
?>

<h1> '<?php echo $model->id; ?> művelet ár szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
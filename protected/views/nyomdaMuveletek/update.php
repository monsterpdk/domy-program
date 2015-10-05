<?php
/* @var $this NyomdaMuveletekController */
/* @var $model NyomdaMuveletek */

?>

<h1> '<?php echo $model->muvelet_nev; ?>' művelet szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
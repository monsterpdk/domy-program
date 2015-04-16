<?php
/* @var $this ArajanlatokController */
/* @var $model Arajanlatok */
?>

<h1> '<?php echo $model->sorszam; ?>' árajánlat szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
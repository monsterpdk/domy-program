<?php
/* @var $this FizetesiModokController */
/* @var $model FizetesiModok */
?>

<h1>'<?php echo $model->nev; ?>' fizetési mód szerkesztése</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
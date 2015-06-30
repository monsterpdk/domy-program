<?php
/* @var $this Szallitolevelek */
/* @var $model Szallitolevel */
?>

<h1> '<?php echo $model->sorszam; ?>' szállítólevél szerkesztése</h1>

<?php $this->renderPartial('_form', array('dataProvider'=>$dataProvider, 'model'=>$model,)); ?>
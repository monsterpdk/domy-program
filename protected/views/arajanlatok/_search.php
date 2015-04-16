<?php
/* @var $this ArajanlatokController */
/* @var $model Arajanlatok */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sorszam'); ?>
		<?php echo $form->textField($model,'sorszam',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ugyfel_id'); ?>
		<?php echo $form->textField($model,'ugyfel_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'arkategoria_id'); ?>
		<?php echo $form->textField($model,'arkategoria_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ajanlat_datum'); ?>
		<?php echo $form->textField($model,'ajanlat_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ervenyesseg_datum'); ?>
		<?php echo $form->textField($model,'ervenyesseg_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hatarido'); ?>
		<?php echo $form->textField($model,'hatarido',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'afakulcs_id'); ?>
		<?php echo $form->textField($model,'afakulcs_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kovetkezo_hivas_ideje'); ?>
		<?php echo $form->textField($model,'kovetkezo_hivas_ideje'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'visszahivas_lezarva'); ?>
		<?php echo $form->textField($model,'visszahivas_lezarva'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ugyfel_tel'); ?>
		<?php echo $form->textField($model,'ugyfel_tel',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ugyfel_fax'); ?>
		<?php echo $form->textField($model,'ugyfel_fax',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'visszahivas_jegyzet'); ?>
		<?php echo $form->textField($model,'visszahivas_jegyzet',array('size'=>60,'maxlength'=>127)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'jegyzet'); ?>
		<?php echo $form->textField($model,'jegyzet',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reklamszoveg'); ?>
		<?php echo $form->textField($model,'reklamszoveg',array('size'=>60,'maxlength'=>127)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'egyeb_megjegyzes'); ?>
		<?php echo $form->textField($model,'egyeb_megjegyzes',array('size'=>60,'maxlength'=>127)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'torolt'); ?>
		<?php echo $form->textField($model,'torolt'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
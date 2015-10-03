<?php
/* @var $this NyomdagepTipusokController */
/* @var $model NyomdagepTipusok */
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
		<?php echo $form->label($model,'gep_id'); ?>
		<?php echo $form->textField($model,'gep_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipusnev'); ?>
		<?php echo $form->textField($model,'tipusnev',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fordulat_kis_boritek'); ?>
		<?php echo $form->textField($model,'fordulat_kis_boritek',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fordulat_nagy_boritek'); ?>
		<?php echo $form->textField($model,'fordulat_nagy_boritek',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fordulat_egyeb'); ?>
		<?php echo $form->textField($model,'fordulat_egyeb',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'aktiv'); ?>
		<?php echo $form->textField($model,'aktiv'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szinszam_tol'); ?>
		<?php echo $form->textField($model,'szinszam_tol'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szinszam_ig'); ?>
		<?php echo $form->textField($model,'szinszam_ig'); ?>
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
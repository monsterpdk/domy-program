<?php
/* @var $this NyomdaMunkatipusokController */
/* @var $model NyomdaMunkatipusok */
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
		<?php echo $form->label($model,'munkatipus_nev'); ?>
		<?php echo $form->textField($model,'munkatipus_nev',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'darabszam_tol'); ?>
		<?php echo $form->textField($model,'darabszam_tol',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'darabszam_ig'); ?>
		<?php echo $form->textField($model,'darabszam_ig',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szinszam_tol'); ?>
		<?php echo $form->textField($model,'szinszam_tol',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szinszam_ig'); ?>
		<?php echo $form->textField($model,'szinszam_ig',array('size'=>10,'maxlength'=>10)); ?>
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
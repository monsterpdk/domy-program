<?php
/* @var $this NyomdaMuveletekController */
/* @var $model NyomdaMuveletek */
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
		<?php echo $form->label($model,'muvelet_nev'); ?>
		<?php echo $form->textField($model,'muvelet_nev',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'elokeszites_ido'); ?>
		<?php echo $form->textField($model,'elokeszites_ido'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'muvelet_ido'); ?>
		<?php echo $form->textField($model,'muvelet_ido'); ?>
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
		<?php echo $form->label($model,'megjegyzes'); ?>
		<?php echo $form->textField($model,'megjegyzes',array('size'=>60,'maxlength'=>127)); ?>
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
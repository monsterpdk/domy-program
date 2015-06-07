<?php
/* @var $this NyomasiArakSzazalekController */
/* @var $model NyomasiArakSzazalek */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'peldanyszam_tol'); ?>
		<?php echo $form->textField($model,'peldanyszam_tol'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'peldanyszam_ig'); ?>
		<?php echo $form->textField($model,'peldanyszam_ig'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'alap'); ?>
		<?php echo $form->textField($model,'alap'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kp'); ?>
		<?php echo $form->textField($model,'kp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'utal'); ?>
		<?php echo $form->textField($model,'utal'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kis_tetel'); ?>
		<?php echo $form->textField($model,'kis_tetel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nagy_tetel'); ?>
		<?php echo $form->textField($model,'nagy_tetel'); ?>
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
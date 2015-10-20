<?php
/* @var $this NyomdaMuveletNormaarakController */
/* @var $model NyomdaMuveletNormaarak */
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
		<?php echo $form->label($model,'muvelet_id'); ?>
		<?php echo $form->textField($model,'muvelet_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gep_id'); ?>
		<?php echo $form->textField($model,'gep_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oradij'); ?>
		<?php echo $form->textField($model,'oradij',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szazalek_tol'); ?>
		<?php echo $form->textField($model,'szazalek_tol'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szazalek_ig'); ?>
		<?php echo $form->textField($model,'szazalek_ig'); ?>
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
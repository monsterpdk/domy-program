<?php
/* @var $this FizetesiMoralokController */
/* @var $model FizetesiMoralok */
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
		<?php echo $form->label($model,'moral_szam'); ?>
		<?php echo $form->textField($model,'moral_szam'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'keses_tol'); ?>
		<?php echo $form->textField($model,'keses_tol'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'keses_ig'); ?>
		<?php echo $form->textField($model,'keses_ig'); ?>
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
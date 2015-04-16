<?php
/* @var $this TermekMeretekController */
/* @var $model TermekMeretek */
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
		<?php echo $form->label($model,'nev'); ?>
		<?php echo $form->textField($model,'nev',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'magassag'); ?>
		<?php echo $form->textField($model,'magassag'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szelesseg'); ?>
		<?php echo $form->textField($model,'szelesseg'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vastagsag'); ?>
		<?php echo $form->textField($model,'vastagsag'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'aktiv'); ?>
		<?php echo $form->textField($model,'aktiv'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
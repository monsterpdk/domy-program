<?php
/* @var $this AnyagrendelesTermekekController */
/* @var $model AnyagrendelesTermekek */
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
		<?php echo $form->label($model,'anyagrendeles_id'); ?>
		<?php echo $form->textField($model,'anyagrendeles_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'termek_id'); ?>
		<?php echo $form->textField($model,'termek_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rendelt_darabszam'); ?>
		<?php echo $form->textField($model,'rendelt_darabszam',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rendeleskor_netto_darabar'); ?>
		<?php echo $form->textField($model,'rendeleskor_netto_darabar'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
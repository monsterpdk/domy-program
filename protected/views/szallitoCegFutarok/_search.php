<?php
/* @var $this SzallitoCegFutarokController */
/* @var $model SzallitoCegFutarok */
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
		<?php echo $form->label($model,'szallito_ceg_id'); ?>
		<?php echo $form->textField($model,'szallito_ceg_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nev'); ?>
		<?php echo $form->textField($model,'nev',array('size'=>50,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rendszam'); ?>
		<?php echo $form->textField($model,'rendszam',array('size'=>10,'maxlength'=>10)); ?>
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
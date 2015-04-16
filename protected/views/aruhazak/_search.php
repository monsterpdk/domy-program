<?php
/* @var $this AruhazakController */
/* @var $model Aruhazak */
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
		<?php echo $form->label($model,'kod'); ?>
		<?php echo $form->textField($model,'kod',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'aruhaz_nev'); ?>
		<?php echo $form->textField($model,'aruhaz_nev',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'aruhaz_url'); ?>
		<?php echo $form->textField($model,'aruhaz_url',array('size'=>60,'maxlength'=>127)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'arkategoria_id'); ?>
		<?php echo $form->textField($model,'arkategoria_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ingyen_szallitas'); ?>
		<?php echo $form->textField($model,'ingyen_szallitas'); ?>
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
<?php
/* @var $this FizetesiModokController */
/* @var $model FizetesiModok */
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
		<?php echo $form->label($model,'szamlazo_azonosito'); ?>
		<?php echo $form->textField($model,'szamlazo_azonosito',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fizetesi_hatarido'); ?>
		<?php echo $form->textField($model,'fizetesi_hatarido'); ?>
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
<?php
/* @var $this TermekAblakHelyekController */
/* @var $model TermekAblakHelyek */
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
		<?php echo $form->label($model,'nev'); ?>
		<?php echo $form->textField($model,'nev',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hely'); ?>
		<?php echo $form->textField($model,'hely',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'x_pozicio_honnan'); ?>
		<?php echo $form->textField($model,'x_pozicio_honnan',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'x_pozicio_mm'); ?>
		<?php echo $form->textField($model,'x_pozicio_mm'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'y_pozicio_honnan'); ?>
		<?php echo $form->textField($model,'y_pozicio_honnan',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'y_pozicio_mm'); ?>
		<?php echo $form->textField($model,'y_pozicio_mm'); ?>
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
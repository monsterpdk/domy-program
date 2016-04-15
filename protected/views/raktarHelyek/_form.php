<?php
/* @var $this RaktarHelyekController */
/* @var $model RaktarHelyek */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'raktar-helyek-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'raktar_id'); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'nev'); ?>
		<?php echo $form->textField($model,'nev',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'nev'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'leiras'); ?>
		<?php echo $form->textField($model,'leiras',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'leiras'); ?>
	</div>
	
	<div class="row buttons">
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'submitForm',
						'caption'=>'Mentés',
						'htmlOptions' => array ('class' => 'btn btn-primary btn-lg',),
					 )); ?>
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'cancelForm',
						'caption'=>'Mégse',
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'onclick'=>'js: $("#dialogRaktarHelyek").dialog("close"); return false;'),
					 )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
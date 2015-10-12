<?php
/* @var $this ArajanlatVisszahivasokController */
/* @var $model ArajanlatVisszahivasok */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'arajanlat-visszahivasok-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'focus'=>array($model,'jegyzet')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'arajanlat_id'); ?>
	<?php echo $form->hiddenField($model, 'user_id'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'visszahivas_datum'); ?>
			
			<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'visszahivas_datum',
						'options'=>array('dateFormat'=>'yy-mm-dd',),
						'htmlOptions'=>array('value'=>$model->visszahivas_datum),
					));
			?>
			
		<?php echo $form->error($model,'visszahivas_datum'); ?>
		<?php echo $form->labelEx($model,'visszahivas_idopont'); ?>
		<?php
			$this->widget('CMaskedTextField', array(
			'model' => $model,
			'attribute' => 'visszahivas_idopont',
			'mask' => '99:99',
			'htmlOptions' => array('size' => 15, 'value'=>$model->visszahivas_idopont)
			));
		?>
		<?php echo $form->error($model,'visszahivas_idopont'); ?>
		
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'jegyzet'); ?>
		<?php echo $form->textArea($model,'jegyzet',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'jegyzet'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Mentés'); ?>
		<?php echo CHtml::button('Mégse', array('title'=>'Mégse', 'onclick'=>'js: $("#dialogArajanlatVisszahivas").dialog("close"); return false;')); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->
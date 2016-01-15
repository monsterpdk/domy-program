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
		<div class="row">
			<?php echo $form->labelEx($model,'visszahivas_datum'); ?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'visszahivas_datum',
						'options'=>array('dateFormat'=>'yy-mm-dd',),
						'htmlOptions'=>array('style' => 'width:123px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_visszahivas_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#ArajanlatVisszahivasok_visszahivas_datum").datepicker("setDate", new Date());
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'margin-left:10px; height:32px', 'target' => '_blank'),
					));
				?>
			
			<?php echo $form->error($model,'visszahivas_datum'); ?>
		</div>
		
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
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'onclick'=>'js: $("#dialogArajanlatVisszahivas").dialog("close"); return false;'),
					 )); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->
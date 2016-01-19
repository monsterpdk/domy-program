<?php
/* @var $this EmailBeallitasokController */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Számlázó program e-mail beállítások</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'email-beallitasok-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<fieldset>
		<legend>Árajánlatküldés e-mail beállítások</legend>	

		<div class="row active">
			<?php echo $form->labelEx($model,'ArajanlatKuldoEmail'); ?>
			<?php echo $form->textField($model,'ArajanlatKuldoEmail', array('size'=>100,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'ArajanlatKuldoEmail'); ?>
		</div>

		<div class="row active">
			<?php echo $form->labelEx($model,'ArajanlatKuldoHost'); ?>
			<?php echo $form->textField($model,'ArajanlatKuldoHost', array('size'=>100,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'ArajanlatKuldoHost'); ?>
		</div>

		<div class="row active">
			<?php echo $form->labelEx($model,'ArajanlatKuldoPort'); ?>
			<?php echo $form->textField($model,'ArajanlatKuldoPort', array('size'=>10,'maxlength'=>5)); ?>
			<?php echo $form->error($model,'ArajanlatKuldoPort'); ?>
		</div>
		
		<div class="row active" style="margin-bottom: 10px;">
			<?php echo $form->labelEx($model,'ArajanlatKuldoSMTP'); ?>
			
				<?php echo CHtml::activeRadioButtonList($model, 'ArajanlatKuldoSMTP', array("1" => "Igen", "0" => "Nem"), array( 'separator' => "  ", 'template' => '{label} {input}', 'labelOptions' => array('style'=>"display:inline;"))) ; ?>
				
			<?php echo $form->error($model,'ArajanlatKuldoSMTP'); ?>
		</div>
		
		<div class="row active">
			<?php echo $form->labelEx($model,'ArajanlatKuldoTitkositas'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'ArajanlatKuldoTitkositas', array("" => "Nincs", "ssl" => "SSL", "tls" => "TLS")) ; ?>
				
			<?php echo $form->error($model,'ArajanlatKuldoTitkositas'); ?>
		</div>

		<div class="row active">
			<?php echo $form->labelEx($model,'ArajanlatKuldoSMTPUser'); ?>
			<?php echo $form->textField($model,'ArajanlatKuldoSMTPUser', array('size'=>100,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'ArajanlatKuldoSMTPUser'); ?>
		</div>

		<div class="row active">
			<?php echo $form->labelEx($model,'ArajanlatKuldoSMTPPassword'); ?>
			<?php echo $form->textField($model,'ArajanlatKuldoSMTPPassword', array('size'=>100,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'ArajanlatKuldoSMTPPassword'); ?>
		</div>

		<div class="row active">
			<?php echo $form->labelEx($model,'ArajanlatKuldoFromName'); ?>
			<?php echo $form->textField($model,'ArajanlatKuldoFromName', array('size'=>100,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'ArajanlatKuldoFromName'); ?>
		</div>

		<div class="row active">
			<?php echo $form->labelEx($model,'ArajanlatKuldoAlapertelmezettSubject'); ?>
			<?php echo $form->textField($model,'ArajanlatKuldoAlapertelmezettSubject', array('size'=>100,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'ArajanlatKuldoAlapertelmezettSubject'); ?>
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
							'name'=>'back',
							'caption'=>'Vissza',
							'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => Yii::app()->request->urlReferrer),
						 )); ?>
		</div>
	</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->endWidget();?>
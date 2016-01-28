<?php
/* @var $this EmailBeallitasokController */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Nyomtató beállítások</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nyomtato-beallitasok-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<fieldset>
		<legend>Nyomtató beállítások</legend>	

		<div class="row active">
			<?php echo $form->labelEx($model,'PdfBoxUrl'); ?>
			<?php echo $form->textField($model,'PdfBoxUrl', array('size'=>100,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'PdfBoxUrl'); ?>
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
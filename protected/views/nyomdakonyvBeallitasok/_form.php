<?php
/* @var $this NyomdakonyvBeallitasokController */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Nyomdakönyv modul beállítások</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'Nyomdakonyv-beallitasok-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'NyomDbfPath'); ?>
		<?php echo $form->textField($model,'NyomDbfPath', array('size'=>100,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'NyomDbfPath'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'WorkflowDbfPath'); ?>
		<?php echo $form->textField($model,'WorkflowDbfPath', array('size'=>100,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'WorkflowDbfPath'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'MunkataskaXmlExportPath'); ?>
		<?php echo $form->textField($model,'MunkataskaXmlExportPath', array('size'=>100,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'MunkataskaXmlExportPath'); ?>
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

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->endWidget();?>
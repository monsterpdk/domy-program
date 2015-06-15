<?php
/* @var $this UgyfelekEgyebBeallitasokController */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Ügyfelekkel kapcsolatos egyéb beállítások</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ugyfelek-egyeb-beallitasok-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'alapertelmezettRendelesTartozasLimit'); ?>
		<?php echo $form->textField($model,'alapertelmezettRendelesTartozasLimit', array('size'=>60,'maxlength'=>127)); ?>
		<?php echo $form->error($model,'alapertelmezettRendelesTartozasLimit'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Mentés'); ?>
		<?php echo CHtml::button('Vissza', array('submit' => Yii::app()->request->urlReferrer)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->endWidget();?>
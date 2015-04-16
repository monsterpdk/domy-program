<?php
/* @var $this AfaKulcsokController */
/* @var $model AfaKulcsok */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Áfa kulcs adatai</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'afa-kulcsok-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nev'); ?>
		<?php echo $form->textField($model,'nev',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'nev'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'afa_szazalek'); ?>
		<?php echo $form->textField($model,'afa_szazalek'); ?>
		<?php echo $form->error($model,'afa_szazalek'); ?>
	</div>

	<?php if (Yii::app()->user->checkAccess('Admin')): ?>
		<div class="row active">
			<?php echo $form->checkBox($model,'torolt'); ?>
			<?php echo $form->label($model,'torolt'); ?>
			<?php echo $form->error($model,'torolt'); ?>
		</div>
	<?php endif; ?>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Mentés'); ?>
		<?php echo CHtml::button('Vissza', array('submit' => Yii::app()->request->urlReferrer)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->endWidget();?>
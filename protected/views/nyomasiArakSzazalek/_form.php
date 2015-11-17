<?php
/* @var $this NyomasiArakSzazalekController */
/* @var $model NyomasiArakSzazalek */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Nyomási termékár adatai</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nyomasi-arak-szazalek-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'user_id'); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'peldanyszam_tol'); ?>
		<?php echo $form->textField($model,'peldanyszam_tol'); ?>
		<?php echo $form->error($model,'peldanyszam_tol'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'peldanyszam_ig'); ?>
		<?php echo $form->textField($model,'peldanyszam_ig'); ?>
		<?php echo $form->error($model,'peldanyszam_ig'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alap'); ?>
		<?php echo $form->textField($model,'alap'); ?>
		<?php echo $form->error($model,'alap'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kp'); ?>
		<?php echo $form->textField($model,'kp'); ?>
		<?php echo $form->error($model,'kp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'utal'); ?>
		<?php echo $form->textField($model,'utal'); ?>
		<?php echo $form->error($model,'utal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kis_tetel'); ?>
		<?php echo $form->textField($model,'kis_tetel'); ?>
		<?php echo $form->error($model,'kis_tetel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nagy_tetel'); ?>
		<?php echo $form->textField($model,'nagy_tetel'); ?>
		<?php echo $form->error($model,'nagy_tetel'); ?>
	</div>

	<?php if (Yii::app()->user->checkAccess('Admin')): ?>
		<div class="row active">
			<?php echo $form->checkBox($model,'torolt'); ?>
			<?php echo $form->label($model,'torolt'); ?>
			<?php echo $form->error($model,'torolt'); ?>
		</div>
	<?php endif; ?>

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

<?php $this->endWidget(); ?>
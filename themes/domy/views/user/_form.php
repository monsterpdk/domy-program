<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Felhasználó adatai</strong>",
	));
?>

	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'user-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo $form->labelEx($model,'username'); ?>
			<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>128)); ?>
			<?php echo $form->error($model,'username'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'fullname'); ?>
			<?php echo $form->textField($model,'fullname',array('size'=>60,'maxlength'=>256)); ?>
			<?php echo $form->error($model,'fullname'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'new_password'); ?>
			<?php echo $form->passwordField($model,'new_password', array('size'=>60,'maxlength'=>40, 'autocomplete'=>'off')); ?>
			<?php echo $form->error($model,'new_password'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'new_password_repeat'); ?>
			<?php echo $form->passwordField($model,'new_password_repeat', array('size'=>60,'maxlength'=>40, 'autocomplete'=>'off')); ?>
			<?php echo $form->error($model,'new_password_repeat'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'gepterem_dolgkod'); ?>
			<?php echo $form->textField($model,'gepterem_dolgkod',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'gepterem_dolgkod'); ?>
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
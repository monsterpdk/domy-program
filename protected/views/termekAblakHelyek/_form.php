<?php
/* @var $this TermekAblakHelyekController */
/* @var $model TermekAblakHelyek */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Ablakhely adatai</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'termek-ablak-helyek-form',
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
		<?php echo $form->labelEx($model,'hely'); ?>
		<?php echo DHtml::enumDropDownList($model, 'hely'); ?>
		<?php echo $form->error($model,'hely'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'x_pozicio_honnan'); ?>
		<?php echo DHtml::enumDropDownList( $model,'x_pozicio_honnan'); ?>
		<?php echo $form->error($model,'x_pozicio_honnan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'x_pozicio_mm'); ?>
		<?php echo $form->textField($model,'x_pozicio_mm'); ?>
		<?php echo $form->error($model,'x_pozicio_mm'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'y_pozicio_honnan'); ?>
		<?php echo DHtml::enumDropDownList( $model,'y_pozicio_honnan'); ?>
		<?php echo $form->error($model,'y_pozicio_honnan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'y_pozicio_mm'); ?>
		<?php echo $form->textField($model,'y_pozicio_mm'); ?>
		<?php echo $form->error($model,'y_pozicio_mm'); ?>
	</div>

	<div class="row active">
		<?php echo $form->checkBox($model,'aktiv'); ?>
		<?php echo $form->label($model,'aktiv'); ?>
		<?php echo $form->error($model,'aktiv'); ?>
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
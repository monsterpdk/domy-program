<?php
/* @var $this TermekMeretekController */
/* @var $model TermekMeretek */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Termékméret adatai</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'termek-meretek-form',
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
		<?php echo $form->labelEx($model,'magassag'); ?>
		<?php echo $form->textField($model,'magassag'); ?>
		<?php echo $form->error($model,'magassag'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szelesseg'); ?>
		<?php echo $form->textField($model,'szelesseg'); ?>
		<?php echo $form->error($model,'szelesseg'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vastagsag'); ?>
		<?php echo $form->textField($model,'vastagsag'); ?>
		<?php echo $form->error($model,'vastagsag'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'suly'); ?>
		<?php echo $form->textField($model,'suly'); ?>
		<?php echo $form->error($model,'suly'); ?>
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
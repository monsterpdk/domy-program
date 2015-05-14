<?php
/* @var $this FizetesiMoralokController */
/* @var $model FizetesiMoralok */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Cégforma adatai</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'fizetesi-moralok-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'moral_szam'); ?>
		<?php echo $form->textField($model,'moral_szam'); ?>
		<?php echo $form->error($model,'moral_szam'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'keses_tol'); ?>
		<?php echo $form->textField($model,'keses_tol'); ?>
		<?php echo $form->error($model,'keses_tol'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'keses_ig'); ?>
		<?php echo $form->textField($model,'keses_ig'); ?>
		<?php echo $form->error($model,'keses_ig'); ?>
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
<?php
/* @var $this TermekCsoportokController */
/* @var $model Termekcsoportok */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'termekcsoportok-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Termékcsoport adatai</strong>",
		));
	?>
	
		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo $form->labelEx($model,'nev'); ?>
			<?php echo $form->textField($model,'nev',array('size'=>30,'maxlength'=>30)); ?>
			<?php echo $form->error($model,'nev'); ?>
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
	
<?php $this->endWidget(); ?>

</div><!-- form -->
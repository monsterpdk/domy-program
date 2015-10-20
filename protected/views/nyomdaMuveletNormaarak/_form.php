<?php
/* @var $this NyomdaMuveletNormaarakController */
/* @var $model NyomdaMuveletNormaarak */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Művelet ár adatai</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nyomda-muvelet-normaarak-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'muvelet_id'); ?>
		
			<?php echo CHtml::activeDropDownList($model, 'muvelet_id',
				CHtml::listData(NyomdaMuveletek::model()->findAll(array("condition"=>"torolt=0")), 'id', 'muvelet_nev')
			); ?>
			
		<?php echo $form->error($model,'muvelet_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gep_id'); ?>
		
			<?php echo CHtml::activeDropDownList($model, 'gep_id',
				CHtml::listData(Nyomdagepek::model()->findAll(array("condition"=>"torolt=0")), 'id', 'gepnev')
			); ?>
			
		<?php echo $form->error($model,'gep_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oradij'); ?>
		<?php echo $form->textField($model,'oradij',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'oradij'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szazalek_tol'); ?>
		<?php echo $form->textField($model,'szazalek_tol'); ?>
		<?php echo $form->error($model,'szazalek_tol'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szazalek_ig'); ?>
		<?php echo $form->textField($model,'szazalek_ig'); ?>
		<?php echo $form->error($model,'szazalek_ig'); ?>
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

<?php $this->endWidget(); ?>
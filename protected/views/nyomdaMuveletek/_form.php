<?php
/* @var $this NyomdaMuveletekController */
/* @var $model NyomdaMuveletek */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Nyomdakönyvi művelet adatai</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nyomda-muveletek-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'gep_id'); ?>
		
			<?php echo CHtml::activeDropDownList($model, 'gep_id',
				CHtml::listData(Nyomdagepek::model()->findAll(array("condition"=>"torolt=0")), 'id', 'gepnev')
			); ?>
			
		<?php echo $form->error($model,'gep_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'muvelet_nev'); ?>
		<?php echo $form->textField($model,'muvelet_nev',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'muvelet_nev'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'elokeszites_ido'); ?>
		<?php echo $form->textField($model,'elokeszites_ido'); ?>
		<?php echo $form->error($model,'elokeszites_ido'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'muvelet_ido'); ?>
		<?php echo $form->textField($model,'muvelet_ido'); ?>
		<?php echo $form->error($model,'muvelet_ido'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szinszam_tol'); ?>
		<?php echo CHtml::activeDropDownList($model, 'szinszam_tol', array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4'), array()); ?>
		<?php echo $form->error($model,'szinszam_tol'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'szinszam_ig'); ?>
		<?php echo CHtml::activeDropDownList($model, 'szinszam_ig', array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4'), array()); ?>
		<?php echo $form->error($model,'szinszam_ig'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'geptermi_kod'); ?>
		<?php echo $form->textField($model,'geptermi_kod',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'geptermi_kod'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'megjegyzes'); ?>
		<?php echo $form->textArea($model,'megjegyzes',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'megjegyzes'); ?>
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
<?php
/* @var $this NyomdagepTipusokController */
/* @var $model NyomdagepTipusok */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Nyomdagép típus adatai</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nyomdagep-tipusok-form',
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
		<?php echo $form->labelEx($model,'tipusnev'); ?>
		<?php echo $form->textField($model,'tipusnev',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'tipusnev'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fordulat_kis_boritek'); ?>
		<?php echo $form->textField($model,'fordulat_kis_boritek',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'fordulat_kis_boritek'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fordulat_nagy_boritek'); ?>
		<?php echo $form->textField($model,'fordulat_nagy_boritek',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'fordulat_nagy_boritek'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fordulat_egyeb'); ?>
		<?php echo $form->textField($model,'fordulat_egyeb',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'fordulat_egyeb'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szinszam_tol'); ?>
		<?php echo CHtml::activeDropDownList($model, 'szinszam_tol', array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9'), array()); ?>
		<?php echo $form->error($model,'szinszam_tol'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'szinszam_ig'); ?>
		<?php echo CHtml::activeDropDownList($model, 'szinszam_ig', array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9'), array()); ?>
		<?php echo $form->error($model,'szinszam_ig'); ?>
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
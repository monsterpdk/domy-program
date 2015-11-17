<?php
/* @var $this NyomasiArakController */
/* @var $model NyomasiArak */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nyomasi-arak-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Alapadatok</strong>",
		));
	?>
		
		<?php echo $form->hiddenField($model, 'user_id'); ?>
		
		<div class="row">
			<?php echo $form->labelEx($model,'kategoria_tipus'); ?>
			<?php echo $form->textField($model,'kategoria_tipus',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'kategoria_tipus'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'boritek_fajtak'); ?>
			<?php echo $form->textField($model,'boritek_fajtak',array('size'=>60,'maxlength'=>128)); ?>
			<?php echo $form->error($model,'boritek_fajtak'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'lehetseges_szinek'); ?>
			<?php echo $form->textField($model,'lehetseges_szinek',array('size'=>60,'maxlength'=>128)); ?>
			<?php echo $form->error($model,'lehetseges_szinek'); ?>
		</div>

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
			<?php echo $form->labelEx($model,'szin_egy'); ?>
			<?php echo $form->textField($model,'szin_egy'); ?>
			<?php echo $form->error($model,'szin_egy'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'szin_ketto'); ?>
			<?php echo $form->textField($model,'szin_ketto'); ?>
			<?php echo $form->error($model,'szin_ketto'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'szin_harom'); ?>
			<?php echo $form->textField($model,'szin_harom'); ?>
			<?php echo $form->error($model,'szin_harom'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'szin_tobb'); ?>
			<?php echo $form->textField($model,'szin_tobb'); ?>
			<?php echo $form->error($model,'szin_tobb'); ?>
		</div>
	<?php $this->endWidget(); ?>
	
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Leírások</strong>",
		));
	?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'grafika'); ?>
			<?php echo $form->textArea($model,'grafika',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'grafika'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'grafika_roviden'); ?>
			<?php echo $form->textArea($model,'grafika_roviden',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'grafika_roviden'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'megjegyzes'); ?>
			<?php echo $form->textArea($model,'megjegyzes',array('rows'=>6, 'cols'=>50)); ?>
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

<?php $this->endWidget(); ?>

</div><!-- form -->
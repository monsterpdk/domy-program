<?php
/* @var $this TermekSavosCsomagarakController */
/* @var $model TermekSavosCsomagarak */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'savos-csomagarak-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'termek_id'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nev'); ?>
		<?php echo $form->textField($model,'nev',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'nev'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'csomagszam_tol'); ?>
		<?php echo $form->textArea($model,'csomagszam_tol',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'csomagszam_tol'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'csomagszam_ig'); ?>
		<?php echo $form->textArea($model,'csomagszam_ig',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'csomagszam_ig'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'csomag_ar_szamolashoz'); ?>
		<?php echo $form->textArea($model,'csomag_ar_szamolashoz',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'csomag_ar_szamolashoz'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'csomag_ar_nyomashoz'); ?>
		<?php echo $form->textArea($model,'csomag_ar_nyomashoz',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'csomag_ar_nyomashoz'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'csomag_eladasi_ar'); ?>
		<?php echo $form->textArea($model,'csomag_eladasi_ar',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'csomag_eladasi_ar'); ?>
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
						'name'=>'cancelForm',
						'caption'=>'Mégse',
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'onclick'=>'js: $("#dialogTermekSavosCsomagarak").dialog("close"); return false;'),
					 )); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->
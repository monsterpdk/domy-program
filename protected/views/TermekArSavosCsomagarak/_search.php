<?php
/* @var $this TermekSavosCsomagarakController */
/* @var $model TermekSavosCsomagarak */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'termek_id'); ?>
		<?php echo $form->textField($model,'termek_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'csomagszam_tol'); ?>
		<?php echo $form->textField($model,'csomagszam_tol'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'csomagszam_ig'); ?>
		<?php echo $form->textField($model,'csomagszam_ig'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'csomag_ar_szamolashoz'); ?>
		<?php echo $form->textField($model,'csomag_ar_szamolashoz'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'csomag_ar_nyomashoz'); ?>
		<?php echo $form->textField($model,'csomag_ar_nyomashoz'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'csomag_eladasi_ar'); ?>
		<?php echo $form->textField($model,'csomag_eladasi_ar'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'torolt'); ?>
		<?php echo $form->textField($model,'torolt'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
<?php
/* @var $this ZuhController */
/* @var $model Zuh */
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
		<?php echo $form->label($model,'nyomasi_kategoria'); ?>
		<?php echo $form->textField($model,'nyomasi_kategoria',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'db_tol'); ?>
		<?php echo $form->textField($model,'db_tol',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'db_ig'); ?>
		<?php echo $form->textField($model,'db_ig',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szin_1_db'); ?>
		<?php echo $form->textField($model,'szin_1_db',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szin_2_db'); ?>
		<?php echo $form->textField($model,'szin_2_db',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szin_3_db'); ?>
		<?php echo $form->textField($model,'szin_3_db',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tobb_szin_db'); ?>
		<?php echo $form->textField($model,'tobb_szin_db',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szin_1_szazalek'); ?>
		<?php echo $form->textField($model,'szin_1_szazalek'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szin_2_szazalek'); ?>
		<?php echo $form->textField($model,'szin_2_szazalek'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szin_3_szazalek'); ?>
		<?php echo $form->textField($model,'szin_3_szazalek'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tobb_szin_szazalek'); ?>
		<?php echo $form->textField($model,'tobb_szin_szazalek'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'aruhaz_kod'); ?>
		<?php echo $form->textField($model,'aruhaz_kod',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'megjegyzes'); ?>
		<?php echo $form->textField($model,'megjegyzes',array('size'=>60,'maxlength'=>127)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
<?php
/* @var $this TermekArakController */
/* @var $model TermekArak */
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
		<?php echo $form->label($model,'csomag_beszerzesi_ar'); ?>
		<?php echo $form->textField($model,'csomag_beszerzesi_ar'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'db_beszerzesi_ar'); ?>
		<?php echo $form->textField($model,'db_beszerzesi_ar'); ?>
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
		<?php echo $form->label($model,'db_ar_nyomashoz'); ?>
		<?php echo $form->textField($model,'db_ar_nyomashoz'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'csomag_eladasi_ar'); ?>
		<?php echo $form->textField($model,'csomag_eladasi_ar'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'db_eladasi_ar'); ?>
		<?php echo $form->textField($model,'db_eladasi_ar'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'csomag_ar2'); ?>
		<?php echo $form->textField($model,'csomag_ar2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'db_ar2'); ?>
		<?php echo $form->textField($model,'db_ar2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'csomag_ar3'); ?>
		<?php echo $form->textField($model,'csomag_ar3'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'db_ar3'); ?>
		<?php echo $form->textField($model,'db_ar3'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'datum_mettol'); ?>
		<?php echo $form->textField($model,'datum_mettol'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'datum_meddig'); ?>
		<?php echo $form->textField($model,'datum_meddig'); ?>
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
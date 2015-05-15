<?php
/* @var $this TermekekController */
/* @var $model Termekek */
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
		<?php echo $form->label($model,'nev'); ?>
		<?php echo $form->textField($model,'nev',array('size'=>60,'maxlength'=>127)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kodszam'); ?>
		<?php echo $form->textField($model,'kodszam',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'meret_id'); ?>
		<?php echo $form->textField($model,'meret_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'suly'); ?>
		<?php echo $form->textField($model,'suly'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'zaras_id'); ?>
		<?php echo $form->textField($model,'zaras_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ablakmeret_id'); ?>
		<?php echo $form->textField($model,'ablakmeret_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ablakhely_id'); ?>
		<?php echo $form->textField($model,'ablakhely_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'papir_id'); ?>
		<?php echo $form->textField($model,'papir_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'redotalp'); ?>
		<?php echo $form->textField($model,'redotalp',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kategoria_tipus'); ?>
		<?php echo $form->textField($model,'kategoria_tipus',array('size'=>32,'maxlength'=>32)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'gyarto_id'); ?>
		<?php echo $form->textField($model,'gyarto_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ksh_kod'); ?>
		<?php echo $form->textField($model,'ksh_kod',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'csom_egys'); ?>
		<?php echo $form->textField($model,'csom_egys',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'minimum_raktarkeszlet'); ?>
		<?php echo $form->textField($model,'minimum_raktarkeszlet',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'maximum_raktarkeszlet'); ?>
		<?php echo $form->textField($model,'maximum_raktarkeszlet',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'doboz_suly'); ?>
		<?php echo $form->textField($model,'doboz_suly'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'raklap_db'); ?>
		<?php echo $form->textField($model,'raklap_db',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'doboz_hossz'); ?>
		<?php echo $form->textField($model,'doboz_hossz'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'doboz_szelesseg'); ?>
		<?php echo $form->textField($model,'doboz_szelesseg'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'doboz_magassag'); ?>
		<?php echo $form->textField($model,'doboz_magassag'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'megjegyzes'); ?>
		<?php echo $form->textArea($model,'megjegyzes',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'megjelenes_mettol'); ?>
		<?php echo $form->textField($model,'megjelenes_mettol'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'megjelenes_meddig'); ?>
		<?php echo $form->textField($model,'megjelenes_meddig'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'datum'); ?>
		<?php echo $form->textField($model,'datum'); ?>
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
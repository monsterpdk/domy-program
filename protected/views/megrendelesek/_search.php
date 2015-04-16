<?php
/* @var $this MegrendelesekController */
/* @var $model Megrendelesek */
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
		<?php echo $form->label($model,'sorszam'); ?>
		<?php echo $form->textField($model,'sorszam',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ugyfel_id'); ?>
		<?php echo $form->textField($model,'ugyfel_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cimzett'); ?>
		<?php echo $form->textField($model,'cimzett',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'arkategoria_id'); ?>
		<?php echo $form->textField($model,'arkategoria_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'egyedi_ar'); ?>
		<?php echo $form->textField($model,'egyedi_ar'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rendeles_idopont'); ?>
		<?php echo $form->textField($model,'rendeles_idopont'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rendelest_rogzito_user_id'); ?>
		<?php echo $form->textField($model,'rendelest_rogzito_user_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rendelest_lezaro_user_id'); ?>
		<?php echo $form->textField($model,'rendelest_lezaro_user_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'afakulcs_id'); ?>
		<?php echo $form->textField($model,'afakulcs_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'arajanlat_id'); ?>
		<?php echo $form->textField($model,'arajanlat_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'proforma_szamla_sorszam'); ?>
		<?php echo $form->textField($model,'proforma_szamla_sorszam',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'proforma_szamla_fizetve'); ?>
		<?php echo $form->textField($model,'proforma_szamla_fizetve'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szamla_sorszam'); ?>
		<?php echo $form->textField($model,'szamla_sorszam',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ugyfel_tel'); ?>
		<?php echo $form->textField($model,'ugyfel_tel',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ugyfel_fax'); ?>
		<?php echo $form->textField($model,'ugyfel_fax',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'visszahivas_jegyzet'); ?>
		<?php echo $form->textField($model,'visszahivas_jegyzet',array('size'=>60,'maxlength'=>127)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'jegyzet'); ?>
		<?php echo $form->textField($model,'jegyzet',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reklamszoveg'); ?>
		<?php echo $form->textField($model,'reklamszoveg',array('size'=>60,'maxlength'=>127)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'egyeb_megjegyzes'); ?>
		<?php echo $form->textField($model,'egyeb_megjegyzes',array('size'=>60,'maxlength'=>127)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'megrendeles_forras_id'); ?>
		<?php echo $form->textField($model,'megrendeles_forras_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nyomdakonyv_munka_id'); ?>
		<?php echo $form->textField($model,'nyomdakonyv_munka_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sztornozva'); ?>
		<?php echo $form->textField($model,'sztornozva'); ?>
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
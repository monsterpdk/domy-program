<?php
/* @var $this ArajanlatTetelekController */
/* @var $model ArajanlatTetelek */
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
		<?php echo $form->label($model,'arajanlat_id'); ?>
		<?php echo $form->textField($model,'arajanlat_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'termek_id'); ?>
		<?php echo $form->textField($model,'termek_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szinek_szama1'); ?>
		<?php echo $form->textField($model,'szinek_szama1'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szinek_szama2'); ?>
		<?php echo $form->textField($model,'szinek_szama2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'darabszam'); ?>
		<?php echo $form->textField($model,'darabszam',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'netto_darabar'); ?>
		<?php echo $form->textField($model,'netto_darabar'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'megjegyzes'); ?>
		<?php echo $form->textField($model,'megjegyzes',array('size'=>60,'maxlength'=>127)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mutacio'); ?>
		<?php echo $form->textField($model,'mutacio'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hozott_boritek'); ?>
		<?php echo $form->textField($model,'hozott_boritek'); ?>
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
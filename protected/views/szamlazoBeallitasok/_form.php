<?php
/* @var $this SzamlazoBeallitasokController */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Számlázó program kapcsolati beállítások</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'szamlazo-beallitasok-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'AlapertelmezettFizetesiMod'); ?>
		
			<?php echo CHtml::activeDropDownList($model, 'AlapertelmezettFizetesiMod',
				CHtml::listData(FizetesiModok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
			); ?>
			
		<?php echo $form->error($model,'AlapertelmezettFizetesiMod'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'SzamlaImportPath'); ?>
		<?php echo $form->textField($model,'SzamlaImportPath', array('size'=>100,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'SzamlaImportPath'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SzamlaImportVisszaigazolasPath'); ?>
		<?php echo $form->textField($model,'SzamlaImportVisszaigazolasPath', array('size'=>100,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'SzamlaImportVisszaigazolasPath'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Mentés'); ?>
		<?php echo CHtml::button('Vissza', array('submit' => Yii::app()->request->urlReferrer)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->endWidget();?>
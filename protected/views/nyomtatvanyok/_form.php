<?php
/* @var $this NyomtatvanyokController */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Nyomtatvány lábléc beállítások</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nyomtatvanyok-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'AnyagBeszallitasokAtveteli'); ?>
		<?php echo $form->textArea($model,'AnyagBeszallitasokAtveteli', array('style'=>"width:600px")); ?>
		<?php echo $form->error($model,'AnyagBeszallitasokAtveteli'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'AnyagBeszallitasokRaktar'); ?>
		<?php echo $form->textArea($model,'AnyagBeszallitasokRaktar', array('style'=>"width:600px")); ?>
		<?php echo $form->error($model,'AnyagBeszallitasokRaktar'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'AnyagrendelesekArNelkul'); ?>
		<?php echo $form->textArea($model,'AnyagrendelesekArNelkul', array('style'=>"width:600px")); ?>
		<?php echo $form->error($model,'AnyagrendelesekArNelkul'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'AnyagrendelesekArral'); ?>
		<?php echo $form->textArea($model,'AnyagrendelesekArral', array('style'=>"width:600px")); ?>
		<?php echo $form->error($model,'AnyagrendelesekArral'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'Arajanlat'); ?>
		<?php echo $form->textArea($model,'Arajanlat', array('style'=>"width:600px")); ?>
		<?php echo $form->error($model,'Arajanlat'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'MegrendelesekProforma'); ?>
		<?php echo $form->textArea($model,'MegrendelesekProforma', array('style'=>"width:600px")); ?>
		<?php echo $form->error($model,'MegrendelesekProforma'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'MegrendelesekVisszaigazolas'); ?>
		<?php echo $form->textArea($model,'MegrendelesekVisszaigazolas', array('style'=>"width:600px")); ?>
		<?php echo $form->error($model,'MegrendelesekVisszaigazolas'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'NyomdakonyvCtp'); ?>
		<?php echo $form->textArea($model,'NyomdakonyvCtp', array('style'=>"width:600px")); ?>
		<?php echo $form->error($model,'NyomdakonyvCtp'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'NyomdakonyvMunkataska'); ?>
		<?php echo $form->textArea($model,'NyomdakonyvMunkataska', array('style'=>"width:600px")); ?>
		<?php echo $form->error($model,'NyomdakonyvMunkataska'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'NyomdakonyvUtemezes'); ?>
		<?php echo $form->textArea($model,'NyomdakonyvUtemezes', array('style'=>"width:600px")); ?>
		<?php echo $form->error($model,'NyomdakonyvUtemezes'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'Szallitolevel'); ?>
		<?php echo $form->textArea($model,'Szallitolevel', array('style'=>"width:600px")); ?>
		<?php echo $form->error($model,'Szallitolevel'); ?>
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
						'name'=>'back',
						'caption'=>'Vissza',
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => Yii::app()->request->urlReferrer),
					 )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->endWidget();?>
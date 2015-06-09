<?php
/* @var $this GyartokController */
/* @var $model Gyartok */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Gyártó adatai</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'gyartok-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cegnev'); ?>
		<?php echo $form->textField($model,'cegnev',array('size'=>60,'maxlength'=>127)); ?>
		<?php echo $form->error($model,'cegnev'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kapcsolattarto'); ?>
		<?php echo $form->textField($model,'kapcsolattarto',array('size'=>60,'maxlength'=>127)); ?>
		<?php echo $form->error($model,'kapcsolattarto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'irsz'); ?>
		<?php echo $form->textField($model,'irsz',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'irsz'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'orszag'); ?>
		
			<?php echo CHtml::activeDropDownList($model, 'orszag',
				CHtml::listData(Orszagok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
			); ?>
			
		<?php echo $form->error($model,'orszag'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'varos'); ?>
		<?php
			$this->widget('ext.typeahead.TbTypeAhead',array(
				 'model' => $model,
				 'attribute' => 'varos',
				 'enableHogan' => true,
				 'options' => array(
					 array(
						 'name' => 'countries',
						 'valueKey' => 'varosnev',
						 'remote' => array(
							 'url' => Yii::app()->createUrl('/ugyfelek/autocomplete') . '?term=%QUERY',
						 ),
						 'template' => '<p>{{varosnev}}</p>',
						 'engine' => new CJavaScriptExpression('Hogan'),
					 )
				 ),
			));
		?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'cim'); ?>
		<?php echo $form->textField($model,'cim',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'cim'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telefon'); ?>
		<?php echo $form->textField($model,'telefon',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'telefon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fax'); ?>
		<?php echo $form->textField($model,'fax',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'fax'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>20,'maxlength'=>127)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	
	
	<div class="row active">
		<?php echo $form->checkBox($model,'netto_ar'); ?>
		<?php echo $form->label($model,'netto_ar'); ?>
		<?php echo $form->error($model,'netto_ar'); ?>
	</div>

	<?php if (Yii::app()->user->checkAccess('Admin')): ?>
		<div class="row active">
			<?php echo $form->checkBox($model,'torolt'); ?>
			<?php echo $form->label($model,'torolt'); ?>
			<?php echo $form->error($model,'torolt'); ?>
		</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Mentés'); ?>
		<?php echo CHtml::button('Vissza', array('submit' => Yii::app()->request->urlReferrer)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->endWidget();?>
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
		
		<?php
			$this->widget('ext.typeahead.TbTypeAhead',array(
				 'model' => $model,
				 'attribute' => 'irsz',
				 'enableHogan' => true,
				 'options' => array(
					 array(
						 'name' => 'irsz',
						 'valueKey' => 'iranyitoszam',
						 'minLength' => 2,
						 'remote' => array(
							 'url' => Yii::app()->createUrl('/varosok/autoCompleteZipCode') . '?term=%QUERY',
							 'filter' => new CJavaScriptExpression('function(parsedResponse) {
								  var dataset = [];
									for(i = 0; i < parsedResponse.length; i++) {
										if (i == 0) {
											$("#Gyartok_varos").val(parsedResponse[i].varosnev).off("blur");
										}
										
										dataset.push({
											iranyitoszam: parsedResponse[i].iranyitoszam,
											varosnev: parsedResponse[i].varosnev,
										});
									}
									return dataset;
							 }'),
						 ),
						 'template' => '<p>{{iranyitoszam}}</p>',
						 'engine' => new CJavaScriptExpression('Hogan'),
					 )
				 ),
				'events' => array(
					   'selected' => new CJavascriptExpression("function(evt,data) {
						   $('#Gyartok_varos').val (data.varosnev).off('blur');
					   }"),
					   'autocompleted' => new CJavascriptExpression("function(evt,data) {
						   $('#Gyartok_varos').val (data.varosnev).off('blur');
					   }"),
				),
			));
		?>		
		
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

		<?php $this->widget("ext.maskedInput.MaskedInput", array(
                "model" => $model,
                "attribute" => "telefon",
                "mask" => '(99) 99-999-9999'                
            ));
		?>

		<?php echo $form->error($model,'telefon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fax'); ?>

		<?php $this->widget("ext.maskedInput.MaskedInput", array(
                "model" => $model,
                "attribute" => "fax",
                "mask" => '(99) 99-999-9999'                
            ));
		?>
		
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
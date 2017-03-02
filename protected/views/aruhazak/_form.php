<?php
/* @var $this AruhazakController */
/* @var $model Aruhazak */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'aruhazak-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>"<strong>Áruházadatok</strong>",
			));
		?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'kod'); ?>
			<?php echo $form->textField($model,'kod',array('size'=>2,'maxlength'=>2)); ?>
			<?php echo $form->error($model,'kod'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'aruhaz_nev'); ?>
			<?php echo $form->textField($model,'aruhaz_nev',array('size'=>30,'maxlength'=>30)); ?>
			<?php echo $form->error($model,'aruhaz_nev'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'aruhaz_url'); ?>
			<?php echo $form->textField($model,'aruhaz_url',array('size'=>60,'maxlength'=>127)); ?>
			<?php echo $form->error($model,'aruhaz_url'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'aruhaz_megrendelesek_xml_url'); ?>
			<?php echo $form->textField($model,'aruhaz_megrendelesek_xml_url',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'aruhaz_megrendelesek_xml_url'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'aruhaz_megrendeles_order_prefix'); ?>
			<?php echo $form->textField($model,'aruhaz_megrendeles_order_prefix',array('size'=>4,'maxlength'=>2)); ?>
			<?php echo $form->error($model,'aruhaz_megrendeles_order_prefix'); ?>
		</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bankszamlaszam_proforman'); ?>
		<?php echo $form->textField($model,'bankszamlaszam_proforman',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'bankszamlaszam_proforman'); ?>
	</div>

		<div class="row">
			<?php echo $form->labelEx($model,'arkategoria_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'arkategoria_id',
					CHtml::listData(Arkategoriak::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
				); ?>
				
			<?php echo $form->error($model,'arkategoria_id'); ?>
		</div>

		<div class="row active">
			<?php echo $form->checkBox($model,'ingyen_szallitas'); ?>
			<?php echo $form->label($model,'ingyen_szallitas'); ?>
			<?php echo $form->error($model,'ingyen_szallitas'); ?>
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

<?php $this->endWidget(); ?>
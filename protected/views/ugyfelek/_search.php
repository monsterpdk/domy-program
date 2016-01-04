<?php
/* @var $this UgyfelekController */
/* @var $model Ugyfelek */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'htmlOptions'=>array('class'=>'well'),
		));
	?>

		<div class="row">
			<?php echo $form->label($model,'ugyfel_tipus'); ?>
			<?php echo DHtml::enumDropDownList($model, 'ugyfel_tipus'); ?>
		</div>

		<div class="row">
			<?php echo $form->label($model,'cegnev'); ?>
			<?php echo $form->textField($model,'cegnev',array('size'=>10,'maxlength'=>30)); ?>
		</div>
		
		<div class="row active">
			<?php echo $form->label($model,'archiv'); ?>
			<?php echo $form->checkBox($model,'archiv'); ?>
		</div>

		<div class="row buttons">
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
				 array(
					'name'=>'submit',
					'caption'=>'Keresés',
					'htmlOptions' => array ('class' => 'btn btn-info btn-lg',),
				 )); ?>
		</div>
		
		<div class="clear"></div>
		
	<?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
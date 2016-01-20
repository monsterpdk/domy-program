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

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'htmlOptions'=>array('class'=>'well'),
		));
	?>
	
		<div class="row">
			<?php echo $form->label($model,'termeknev_search'); ?>
			<?php echo $form->textField($model,'termeknev_search',array('size'=>10,'maxlength'=>127)); ?>
		</div>

		<div class="row buttons">
			<?php echo CHtml::submitButton('Keresés'); ?>
		</div>
		
		<div class="clear"></div>
		
	<?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
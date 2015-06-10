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

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'htmlOptions'=>array('class'=>'well'),
		));
	?>
	
		<div class="row">
			<?php echo $form->label($model,'sorszam'); ?>
			<?php echo $form->textField($model,'sorszam',array('size'=>10,'maxlength'=>10)); ?>
		</div>

		<div class="row">
			<?php echo $form->label($model,'cegnev_search'); ?>
			<?php echo $form->textField($model,'cegnev_search',array('size'=>10,'maxlength'=>10)); ?>
		</div>

		<div class="row buttons">
			<?php echo CHtml::submitButton('Keresés'); ?>
		</div>

		<div class="clear"></div>
		
	<?php $this->endWidget(); ?>
	
<?php $this->endWidget(); ?>

</div><!-- search-form -->
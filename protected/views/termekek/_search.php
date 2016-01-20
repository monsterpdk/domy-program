<?php
/* @var $this TermekekController */
/* @var $model Termekek */
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
		<?php echo $form->label($model,'nev'); ?>
		<?php echo $form->textField($model,'nev',array('size'=>60,'maxlength'=>127)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kodszam'); ?>
		<?php echo $form->textField($model,'kodszam',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'meret_search'); ?>
		<?php echo $form->textField($model,'meret_search',array('size'=>10,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'zaras_search'); ?>
		<?php echo $form->textField($model,'zaras_search',array('size'=>10,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ablakhely_search'); ?>
		<?php echo $form->textField($model,'ablakhely_search',array('size'=>10,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ablakmeret_search'); ?>
		<?php echo $form->textField($model,'ablakmeret_search',array('size'=>10,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'papirtipus_search'); ?>
		<?php echo $form->textField($model,'papirtipus_search',array('size'=>10,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gyarto_search'); ?>
		<?php echo $form->textField($model,'gyarto_search',array('size'=>10,'maxlength'=>30)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Keresés'); ?>
	</div>
	
	<div class="clear"></div>

	<?php $this->endWidget(); ?>
	
<?php $this->endWidget(); ?>

</div><!-- search-form -->
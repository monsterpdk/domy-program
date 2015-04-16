<?php
/* @var $this NyomasiArakController */
/* @var $model NyomasiArak */
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
			<?php echo $form->label($model,'kategoria_tipus'); ?>
			<?php echo $form->textField($model,'kategoria_tipus',array('size'=>32,'maxlength'=>32)); ?>
		</div>
	
		<div class="row">
			<?php echo $form->label($model,'peldanyszam_tol'); ?>
			<?php echo $form->textField($model,'peldanyszam_tol'); ?>
		</div>

		<div class="row">
			<?php echo $form->label($model,'peldanyszam_ig'); ?>
			<?php echo $form->textField($model,'peldanyszam_ig'); ?>
		</div>

		<div class="row">
			<?php echo $form->label($model,'tipus'); ?>
			 <select id = 'tipus' name = 'tipus'>
			  <option value=""></option>
			  <option value="ervenyes">Érvényes</option>
			  <option value="inaktiv">Inaktív</option>
			  <option value="archiv">Archív</option>
			</select> 
		</div>

		<div class="row">
			<?php echo $form->label($model,'ervenyesseg_tol'); ?>
			<?php echo $form->textField($model,'ervenyesseg_tol'); ?>
		</div>

		<div class="row buttons">
			<?php echo CHtml::submitButton('Keresés'); ?>
		</div>

		<div class="clear"></div>
		
	<?php $this->endWidget(); ?>
	
<?php $this->endWidget(); ?>

</div><!-- search-form -->
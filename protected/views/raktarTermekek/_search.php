<?php
/* @var $this ArajanlatokController */
/* @var $model Arajanlatok */
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
			<?php echo $form->label($model,'raktar_search'); ?>
			<?php
				echo $form->dropDownList($model, 'raktar_search',
					CHtml::listData(Raktarak::model()->findAll(array("condition"=>"torolt=0", 'order'=>'nev')), 'nev', 'nev'),
					array(
						'empty'=>'--Minden--',
					)
				);
			?>
		</div>

		<div class="row">
			<?php echo $form->label($model,'raktar_hely_search'); ?>
			<?php
				echo $form->dropDownList($model, 'raktar_hely_search',
					CHtml::listData(RaktarHelyek::model()->findAll(array("condition"=>"", 'order'=>'nev')), 'nev', 'nev'),
					array(
						'empty'=>'--Minden--',
					)
				);
			?>
		</div>

		<div class="row">
			<?php echo $form->label($model, 'termek_search'); ?>
			<?php echo $form->textField($model, 'termek_search',array('size'=>10,'maxlength'=>50)); ?>
		</div>
		
		<div class="row buttons">
			<?php echo CHtml::submitButton('Keresés'); ?>
		</div>
		
		<div class="clear"></div>

	<?php $this->endWidget(); ?>
	
<?php $this->endWidget(); ?>

</div><!-- search-form -->
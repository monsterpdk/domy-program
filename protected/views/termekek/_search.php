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
		<?php echo $form->label($model,'cikkszam'); ?>
		<?php echo $form->textField($model,'cikkszam',array('size'=>15,'maxlength'=>15)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'meret_search'); ?>
		<?php
			echo $form->dropDownList($model, 'meret_id',
				CHtml::listData(TermekMeretek::model()->findAll(array("condition"=>"torolt=0", 'order'=>'nev')), 'id', 'nev'),
				array(
					'empty'=>'--Minden--',
				)
			);
		?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'zaras_search'); ?>
		<?php
			echo $form->dropDownList($model, 'zaras_id',
				CHtml::listData(TermekZarasiModok::model()->findAll(array("condition"=>"torolt=0 AND aktiv=1", 'order'=>'nev')), 'id', 'nev'),
				array(
					'empty'=>'--Minden--',
				)
			);
		?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ablakhely_search'); ?>
				<?php
			echo $form->dropDownList($model, 'ablakhely_id',
				CHtml::listData(TermekAblakHelyek::model()->findAll(array("condition"=>"torolt=0 AND aktiv=1", 'order'=>'nev')), 'id', 'nev'),
				array(
					'empty'=>'--Minden--',
				)
			);
		?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ablakmeret_search'); ?>
		<?php
			echo $form->dropDownList($model, 'ablakmeret_id',
				CHtml::listData(TermekAblakMeretek::model()->findAll(array("condition"=>"torolt=0 AND aktiv=1", 'order'=>'nev')), 'id', 'nev'),
				array(
					'empty'=>'--Minden--',
				)
			);
		?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'papirtipus_search'); ?>
		<?php
			echo $form->dropDownList($model, 'papir_id',
				CHtml::listData(PapirTipusok::model()->findAll(array("condition"=>"torolt=0 AND aktiv=1", 'order'=>'nev')), 'id', 'fullName'),
				array(
					'empty'=>'--Minden--',
				)
			);
		?>
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
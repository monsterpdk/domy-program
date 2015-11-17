<?php
/* @var $this NyomdakonyvController */
/* @var $model Nyomdakonyv */
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
		<?php echo $form->label($model,'taskaszam'); ?>
		<?php echo $form->textField($model,'taskaszam',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'megrendeles_tetel.munka_neve'); ?>
		<?php echo $form->textField($model,'munkanev_search',array('size'=>12,'maxlength'=>127)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'megrendeles_tetel.megrendeles.ugyfel.cegnev'); ?>
		<?php echo $form->textField($model,'megrendelonev_search',array('size'=>12,'maxlength'=>127)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'megrendeles_tetel.termek.zaras.nev'); ?>
		<?php echo $form->textField($model,'boritek_tipus_search',array('size'=>12,'maxlength'=>127)); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($model,'darabszam_search'); ?>
		<?php echo $form->textField($model,'darabszam_tol_search',array('size'=>8,'maxlength'=>127, 'style'=>'width: 50px')); ?>
		<?php echo $form->textField($model,'darabszam_ig_search',array('size'=>8,'maxlength'=>127, 'style'=>'width: 50px')); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'szinszam1_search'); ?>
		<?php echo $form->textField($model,'szinszam1_tol_search',array('size'=>8,'maxlength'=>127, 'style'=>'width: 50px')); ?>
		<?php echo $form->textField($model,'szinszam1_ig_search',array('size'=>8,'maxlength'=>127, 'style'=>'width: 50px')); ?>

		<br />
		
		<?php echo $form->labelEx($model,'szinszam2_search'); ?>
		<?php echo $form->textField($model,'szinszam2_tol_search',array('size'=>8,'maxlength'=>127, 'style'=>'width: 50px')); ?>
		<?php echo $form->textField($model,'szinszam2_ig_search',array('size'=>8,'maxlength'=>127, 'style'=>'width: 50px')); ?>
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
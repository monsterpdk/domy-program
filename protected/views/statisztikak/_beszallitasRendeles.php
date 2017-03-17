<?php
	/* @var $this StatisztikaController */
	
	// kezdő dátum értékek meghatározása: 'aktuális dátum - 1 év'   -   'aktuális dátum'
	$ev = date('Y');

	$lekerdezheto_evek = array() ;
	for ($i = -10; $i <= 0; $i++) {
		$lekerdezheto_evek[$ev + $i] = $ev + $i ;
	}
?>

<h1>Beszállítás - eladás statisztika</h1>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'method'=>'post',
)); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'htmlOptions'=>array('class'=>'well'),
		));
	?>
	
	<?php 
		echo $form->errorSummary($model); 
	?>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'ev'); ?>

		<?php echo CHtml::DropDownList('ev', $ev, $lekerdezheto_evek); ?>

		<?php $this->widget('zii.widgets.jui.CJuiButton',
			 array(
				'name'=>'submitForm',
				'caption'=>'Lekérés',
				'htmlOptions' => array ('class' => 'btn btn-primary btn-lg',),
			 )); ?>
			
	</div>
	
	<div class="clear"></div>

	<?php $this->endWidget(); ?>
	
<?php $this->endWidget(); ?>

</div>


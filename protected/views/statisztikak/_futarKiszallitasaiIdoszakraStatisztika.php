<?php
	// kezdő dátum értékek meghatározása: 'aktuális dátum - 1 év'   -   'aktuális dátum'
	$now = new DateTime('now');

	$statisztika_mettol = $now -> modify('-1 year') -> format('Y-m-d');
	$statisztika_meddig = date('Y-m-d');

?>

<h1>Futár kiszállításai időszakra statisztika</h1>

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

		<?php echo $form->labelEx($model,'futar_id'); ?>
		
			<?php echo CHtml::activeDropDownList($model, 'futar_id',
				CHtml::listData(SzallitoCegFutarok::model()->findAll(array("condition"=>"torolt=0", 'order' => 'nev')), 'id', 'nev'), array('empty' => '-- Minden futár --', )
			); ?>
		
		<?php echo $form->labelEx($model, 'statisztika_mettol'); ?>
			
			<?php
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$model,
					'attribute'=>'statisztika_mettol',
					'language' => 'hu',
					'options'=>array('dateFormat'=>'yy-mm-dd',),
					'htmlOptions'=>array('style' => 'width:123px', 'value' => $statisztika_mettol),
				));			
			?>

		<?php echo $form->labelEx($model, 'statisztika_meddig'); ?>
			
			<?php
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$model,
					'attribute'=>'statisztika_meddig',
					'language' => 'hu',
					'options'=>array('dateFormat'=>'yy-mm-dd',),
					'htmlOptions'=>array('style' => 'width:123px', 'value' => $statisztika_meddig),
				));			
			?>
			
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


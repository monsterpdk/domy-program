<?php
	/* @var $this StatisztikaController */
?>

<h1>Elfekvő termékek</h1>

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
		<?php echo $form->labelEx($model,'nap_filter'); ?>
			
			<div class="boritekMeretRadioGroup">
				<?php 
					echo $form -> radioButtonList($model, 'nap_filter', array("30" => 30, "60" => 60, "90" => 90), array( 'separator' => "  ", 'template' => '{label} {input}')); 
				?>
			</div>
			
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
				 array(
					'name'=>'submitForm',
					'caption'=>'Lekérés',
					'htmlOptions' => array ('class' => 'btn btn-primary btn-lg', 'style' => 'margin-top:20px'),
				 )); ?>
			
	</div>
	
	<div class="clear"></div>

	<?php $this->endWidget(); ?>
	
<?php $this->endWidget(); ?>

</div>


<?php
	/* @var $this StatisztikaController */
	
	// kezdő dátum értékek meghatározása: 'aktuális dátum - 1 év'   -   'aktuális dátum'
	$now = new DateTime('now');

	$statisztika_mettol = $now -> modify('-1 year') -> format('Y-m-d');
	$statisztika_meddig = date('Y-m-d');

?>

<h1>Ki nem számlázott tételek</h1>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'method'=>'post',
)); ?>
	<?php echo $form->hiddenField($model, 'ugyfel_id'); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'htmlOptions'=>array('class'=>'well'),
		));
	?>
	
	<?php 
		echo $form->errorSummary($model); 
	?>
	
	<div class="row">
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
			
			<?php echo $form->labelEx($model,'stat_type_filter'); ?>
			
			<div class="statChooser" style='margin-bottom:20px;'>
				<?php 
					echo $form -> radioButtonList($model, 'stat_type_filter', array("nem_kerult_szallitora" => "tételek, melyek még nem kerültek szállítólevélre (de megrendeléseikhez akár készülhetett már számla)", "nem_keszult_szamla" => "tételek, melyek megrendeléseihez egyáltalán nem készült még szállítólevél"), array( 'separator' => "  ", 'template' => '{input} {label} <br />')); 
				?>
			</div>			
			
		<?php echo $form->labelEx($model,'ugyfel_id'); ?>

		<?php
		$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'source'=>$this->createUrl('statisztikak/autoCompleteUgyfel'),
			'id' => 'autocomplete-link-'.uniqid(),
			'model' => $model,
			'name' => 'autocomplete-link-'.uniqid(),
			'attribute' => 'autocomplete_ugyfel_name',
			'options'=> array(
				'showAnim'=>'fold',
				'minLength' => '1',
				'select'=>"js:function(event, ui) {
															$('#StatisztikakKiNemSzamlazottTetelek_ugyfel_id').val (ui.item.id);
														}",
				'change'=>"js:function(event, ui) {
															if (!ui.item) {
																$('#StatisztikakUgyfelRendelesei_ugyfel_id').val (ui.item.id);
															}
														   }",

			),
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


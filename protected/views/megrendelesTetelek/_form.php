<?php
/* @var $this MegrendelesTetelekController */
/* @var $model MegrendelesTetelek */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'megrendeles-tetelek-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'megrendeles_id'); ?>
	<?php echo $form->hiddenField($model, 'termek_id'); ?>
	<?php echo $form->hiddenField($model, 'szorzo_tetel_arhoz'); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'termek_id'); ?>

			<?php
				if ($model->arajanlatbol_letrehozva == 1) {
					echo $form->textField($model,'autocomplete_termek_name', ($model->arajanlatbol_letrehozva == 1 ? array('disabled'=>'true') : array()));
				} else {
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'source'=>$this->createUrl('megrendelesTetelek/autoCompleteTermek'),
						'model'     => $model,
						'attribute' => 'autocomplete_termek_name',
						'options'=> array(
							'showAnim'=>'fold',
							'select'=>"js:function(event, ui) {
																$('#MegrendelesTetelek_termek_id').val (ui.item.id);

																// a termékhez tartozó ár és a megadott árkategória alapján készül a 'beajánlott ár'
																$('#MegrendelesTetelek_netto_darabar').val ( $('#MegrendelesTetelek_szorzo_tetel_arhoz').val () * ui.item.ar );
															}",
							'change'=>"js:function(event, ui) {
																if (!ui.item) {
																	$('#MegrendelesTetelek_termek_id').val('');
																}
															   }",
						),
					));
				}
			?>
		
		<?php echo $form->error($model,'termek_id'); ?>
	</div>

	<div style="clear:both;">
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szinek_szama1'); ?>
		<?php echo CHtml::activeDropDownList($model, 'szinek_szama1', array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4'), ($model->arajanlatbol_letrehozva == 1 ? array('disabled'=>'true') : array())); ?>
		<?php echo $form->error($model,'szinek_szama1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szinek_szama2'); ?>
		<?php echo CHtml::activeDropDownList($model, 'szinek_szama2', array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4'), ($model->arajanlatbol_letrehozva == 1 ? array('disabled'=>'true') : array())); ?>
		<?php echo $form->error($model,'szinek_szama2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'darabszam'); ?>
		<?php echo $form->textField($model,'darabszam',array('size'=>10,'maxlength'=>10, 'disabled' => ($model->arajanlatbol_letrehozva == 1 ? 'true' : ''))); ?>
		<?php echo $form->error($model,'darabszam'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'netto_darabar'); ?>
		<?php echo $form->textField($model,'netto_darabar', ($model->arajanlatbol_letrehozva == 1 ? array('disabled'=>'true') : array())); ?>
		<?php echo $form->error($model,'netto_darabar'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'munka_neve'); ?>
		<?php echo $form->textArea($model,'munka_neve',array('size'=>60,'maxlength'=>127)); ?>
		<?php echo $form->error($model,'munka_neve'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'megjegyzes'); ?>
		<?php echo $form->textArea($model,'megjegyzes',array('size'=>60,'maxlength'=>127, 'disabled' => ($model->arajanlatbol_letrehozva == 1 ? 'true' : ''))); ?>
		<?php echo $form->error($model,'megjegyzes'); ?>
	</div>

	<div class="row active">
		<?php echo $form->checkBox($model,'mutacio', ($model->arajanlatbol_letrehozva == 1 ? array('disabled'=>'true') : array())); ?>
		<?php echo $form->label($model,'mutacio'); ?>
		<?php echo $form->error($model,'mutacio'); ?>
	</div>

	<div class="row active">
		<?php echo $form->checkBox($model,'hozott_boritek', ($model->arajanlatbol_letrehozva == 1 ? array('disabled'=>'true') : array())); ?>
		<?php echo $form->label($model,'hozott_boritek'); ?>
		<?php echo $form->error($model,'hozott_boritek'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Mentés'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php
/* @var $this AnyagrendelesTermekekController */
/* @var $model AnyagrendelesTermekek */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'anyagrendeles-termekek-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<!-- Termék tallózásához szükséges kódblokk -->
	<div class="row">
		<?php echo $form->labelEx($model, 'termek_id'); ?>
		
		<?php echo $form->hiddenField($model,'termek_id'); ?>
		<?php echo $form->hiddenField($model,'anyagrendeles_id'); ?>
		
		<input type="text" name="termeknev" id="termeknev" readonly value="<?php if ($model -> termek_id != null) echo Termekek::model()->findByPk($model -> termek_id)->nev; ?>">

		<?php if ($model->termek_id == null) echo CHtml::Button('x', array('name' => 'del_termeknev', 'id' => 'del_termeknev', 'onclick' => '$("#termeknev").val(""); $("#termek_id").val("")')) ?>

		<!-- CJUIDIALOG -->
		<?php 
		  $this->beginWidget('zii.widgets.jui.CJuiDialog', 
			   array(   'id'=>'termek_dialog',
						'options'=>array(
										'title'=>'Gyártó termékei',
										'width'=>'auto',
										'autoOpen'=>false,
										),
								));
		/* CGRIDVIEW */
		$this->widget('zii.widgets.grid.CGridView', 
		   array( 'id'=>'termekek-grid' . $grid_id,
				  'dataProvider'=>$termek->search(),
				  'filter'=>$termek,
				  'selectableRows'=>1,
				  'columns'=>array(
								'nev',
								'kodszam',
								array(
									'name' => 'zaras.nev',
									'header' => 'Zárásmód',
									'filter' => CHtml::activeTextField($termek, 'zaras_search'),
									'value' => '$data->zaras->nev',
								),
								array(
								  'header'=>'',
								  'type'=>'raw',
								  'value'=>'CHtml::Button("+", 
															array("name" => "send_termek", 
																"id" => "send_termek", 
																"onClick" => "$(\"#termek_dialog\").dialog(\"close\"); $(\"#termeknev\").val(\"$data->nev\"); $(\"#AnyagrendelesTermekek_termek_id\").val(\"$data->id\");"))',
															),
								   ),
				));

		$this->endWidget('zii.widgets.jui.CJuiDialog');

		if ($model->termek_id == null)
			echo CHtml::Button('Termék kiválasztása', 
							  array('onclick'=>'$("#termek_dialog").dialog("open"); $("#termek_dialog").dialog("moveToTop"); return false;',
						   ));

		 echo $form->error($model,'termek_id'); ?>
	</div>
	
	<!-- Termék tallózásához szükséges kódblokk vége -->
	
	<div class="row">
		<?php echo $form->labelEx($model,'rendelt_darabszam'); ?>
		<?php echo $form->textField($model,'rendelt_darabszam',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'rendelt_darabszam'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rendeleskor_netto_darabar'); ?>
		<?php echo $form->textField($model,'rendeleskor_netto_darabar'); ?>
		<?php echo $form->error($model,'rendeleskor_netto_darabar'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Mentés'); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->
<?php
/* @var $this SzallitolevelekController */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'szallitolevelek-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	 'htmlOptions'=>array(
		'onsubmit'=>"
			var data = [];

			$('#megrendelesenLevoTetelek-grid tr').each(function(rowIndex) {
				$(this).find('td').each(function(cellIndex) {
					if (cellIndex == 4)
						data.push($(this).text());
				});
			});

			$('#Szallitolevelek_szallito_darabszamok').val ( data.join('$#$') );
		",
	),
)); ?>

	<?php echo $form->hiddenField($model, 'szallito_darabszamok'); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'sorszam'); ?>
		<?php echo $form->textField($model,'sorszam',array('size'=>12, 'maxlength'=>10, 'readonly'=>true)); ?>
		<?php echo $form->error($model,'sorszam'); ?>
	</div>

	<?php			
		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'megrendelesenLevoTetelek-grid',
			'enablePagination' => false,
			'dataProvider'=>$dataProvider,
			'summaryText' => '',
			'columns'=>array(
				array( 'name'=>'id','header'=>'Id', 'value'=>'$data->id' ),
				array( 'name'=>'termek.nev', 'header'=>'Terméknév', 'value'=>'$data->termek->getDisplayTermekTeljesNev()' ),
				array( 'name'=>'munka_neve', 'header'=>'Munka neve', 'value'=>'$data->munka_neve' ),
				array( 'name'=>'darabszam', 'header'=>'Megrendelőn lévő darabszám (db)', 'value'=>'$data->darabszam' ),
				array( 
				  'class' => 'editable.EditableColumn',
				  'name'  => 'darabszam',
				  'value' => function($data, $row) use ($model){
						return ($model->tetelek != null && count($model->tetelek) > 0) ? $model->tetelek[$row]->darabszam : $data->darabszam;
				  },
				  'header' => 'Szállítólevélre rakva (db)',
				  'editable' => array(
					  'placement'     => 'right',
					  'validate' => 'js: function(value) {
							darabszam = $(this).closest("td").prev().text();

							if ( ($.trim(value) == "") || !(value % 1 === 0) || !($.isNumeric(value) && parseInt(value) >= 0) || (parseInt(darabszam) < parseInt(value)) ) return "Csak 0, vagy annál nagyobb érték írható be, de kisebb kell legyen, mint a megrendelésen lévő darabszám (" + darabszam + " db) !";
					   }'
					  
				  ),
			 ), 
			)
		));
	?>

	<div class="row">
		<?php echo $form->labelEx($model,'egyeb'); ?>
		<?php echo $form->textArea($model,'egyeb',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'egyeb'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'megjegyzes'); ?>
		<?php echo $form->textArea($model,'megjegyzes',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'megjegyzes'); ?>
	</div>

	<div class="row buttons">
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'submitForm',
						'caption'=>'Mentés',
						'htmlOptions' => array ('class' => 'btn btn-primary btn-lg',),
					 )); ?>
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'back',
						'caption'=>'Vissza',
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => Yii::app()->request->urlReferrer),
					 )); ?>
	</div>
	
</div>

<?php $this->endWidget(); ?>
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
	<?php echo $form->hiddenField($model, 'id'); ?>

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
						if ($model->tetelek != null && count($model->tetelek) > 0) {
							foreach ($model->tetelek as $tetel) {
									if ($tetel->megrendeles_tetel_id == $data->id) {
										return $tetel->darabszam;
									}
							}
							
							return 0;
						} else
							return $data->darabszam;
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
					 
			<?php if (!$model->isNewRecord) $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'print',
						'caption'=>'Nyomtatás',
						'onclick'=>new CJavaScriptExpression('function() {  
							openPrintDialog(); return false;
						}'),
						'htmlOptions' => array ('class' => 'btn btn-warning btn-lg', 'style' => 'margin-left: 20px;'),
					 )); ?>
	</div>
	
</div>

<?php	
	// LI: print dialog inicializálása
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogSzellitolevelPrint',
            
            'options'=>array(
                'title'=>'Szállítólevél nyomtatása',
				'width'=> '400px',
                'modal' => true,
				'buttons' => array('Nyomtatás' => 'js:function() {
						var copies = $("#print_copies").val();
						var futarszolgalatos = $("#checkboxFutarszolgalatos").prop("checked") ? 1 : 0;
						
						if ( (copies % 1 === 0) && (copies > 0) ) {
							model_id = $(this).data("model_id");
							$(location).attr("href", "/index.php/szallitolevelek/printPDF?id=" + model_id + "&copies=" + copies + "&futaros=" + futarszolgalatos);
						} else {
							alert("Hibás a beírt példányszám:" + copies);
							return false;
						}
				}'),
                'autoOpen'=>false,
        )));

		echo '<p> A kiválaszott szállítólevél és a hozzá kapcsolódó tételek nyomtatása. </p>';
		
		echo 'Példányszám:';
		
			$this->widget("ext.maskedInput.MaskedInput", array(
					"name" => "print_copies",
					"value" => 3,
					"mask" => '99',
					"defaults" =>array('placeholder' =>''),
					"options" => array ('style' => 'width:40px!important'),
				));

		echo ' db <br /> Futárszolgálatos ';

		echo CHtml::checkbox ("checkboxFutarszolgalatos", false);
		
		$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php $this->endWidget(); ?>

<script type="text/javascript">
		function openPrintDialog () {
			row_id = $('#Szallitolevelek_id').val();
			
			$("#dialogSzellitolevelPrint").data('model_id', row_id).dialog("open");
		}
</script>
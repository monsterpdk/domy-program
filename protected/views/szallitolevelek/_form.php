<?php
/* @var $this ArajanlatokController */
/* @var $model Arajanlatok */
/* @var $form CActiveForm */

	Yii::app() -> clientScript->registerScript('updateGridView', '
		$.updateGridView = function(gridID, name, value) {
			$("#" + gridID + " input[name=\'" + name + "\'], #" + gridID + " select[name=\'" + name + "\']").val(value);
			
			$.fn.yiiGridView.update(gridID, {data: $.param(
				$("#"+gridID+" .filters input, #"+gridID+" .filters select")
			)});
		}
		', CClientScript::POS_READY);

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'megrendelesek-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->hiddenField($model, 'id'); ?>
	<?php echo $form->hiddenField($model, 'ugyfel_id'); ?>
	<?php echo $form->hiddenField($model, 'egyedi_ar'); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Megrendelés adatai #1</strong>",
		));
	?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'sorszam'); ?>
			<?php echo $form->textField($model,'sorszam',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'sorszam'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'afakulcs_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'afakulcs_id',
					CHtml::listData(AfaKulcsok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'display_nev_szazalek')
				); ?>
				
			<?php echo $form->error($model,'afakulcs_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'arkategoria_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'arkategoria_id',
					CHtml::listData(Aruhazak::model()->findAll(array("condition"=>"torolt=0")), 'id', 'display_aruhaz_arkategoria')
				); ?>
				
			<?php echo $form->error($model,'arkategoria_id'); ?>
		</div>

			<div class="row">
			<?php echo $form->labelEx($model,'ugyfel_id'); ?>
			
			<?php
				$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
					'source'=>$this->createUrl('arajanlatok/autoCompleteUgyfel'),
					'model'     => $model,
					'attribute' => 'autocomplete_ugyfel_name',
					'options'=> array(
						'showAnim'=>'fold',
						'select'=>"js:function(event, ui) {
															$('#Megrendelesek_ugyfel_id').val (ui.item.id);
															$('#Megrendelesek_ugyfel_tel').val (ui.item.tel);
															$('#Megrendelesek_ugyfel_fax').val (ui.item.fax);
															
															$('#Megrendelesek_autocomplete_ugyfel_cim').val(ui.item.cim);
															$('#Megrendelesek_autocomplete_ugyfel_adoszam').val(ui.item.adoszam);
															$('#Megrendelesek_autocomplete_ugyfel_fizetesi_moral').val(ui.item.fizetesi_moral);
															$('#Megrendelesek_autocomplete_ugyfel_max_fizetesi_keses').val(ui.item.max_fizetesi_keses);
															$('#Megrendelesek_autocomplete_ugyfel_atlagos_fizetesi_keses').val(ui.item.atlagos_fizetesi_keses);
															$('#Megrendelesek_autocomplete_ugyfel_rendelesi_tartozas_limit').val(ui.item.rendelesi_tartozas_limit);
															$('#Megrendelesek_autocomplete_ugyfel_fontos_megjegyzes').val(ui.item.fontos_megjegyzes);
															$('#Megrendelesek_cimzett').val(ui.item.cimzett);
														}",
						'change'=>"js:function(event, ui) {
															if (!ui.item) {
																$('#Megrendelesek_ugyfel_id').val('');
																$('#Megrendelesek_ugyfel_tel').val('');
																$('#Megrendelesek_ugyfel_fax').val('');
																
																$('#Megrendelesek_autocomplete_ugyfel_cim').val('');
																$('#Megrendelesek_autocomplete_ugyfel_adoszam').val('');
																$('#Megrendelesek_autocomplete_ugyfel_fizetesi_moral').val('');
																$('#Megrendelesek_autocomplete_ugyfel_max_fizetesi_keses').val('');
																$('#Megrendelesek_autocomplete_ugyfel_atlagos_fizetesi_keses').val('');
																$('#Megrendelesek_autocomplete_ugyfel_rendelesi_tartozas_limit').val('');
																$('#Megrendelesek_autocomplete_ugyfel_fontos_megjegyzes').val('');
																$('#Megrendelesek_cimzett').val('');
															}
														   }",
														
					),
				));
			?>
			
			<?php echo $form->error($model,'ugyfel_id'); ?>
			
			<br />
			
			<?php
				$this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'button_create_ugyfel',
					'caption'=>'Ügyfél létrehozása',
					'buttonType'=>'link',
					'htmlOptions'=>array('class'=>'bt btn-primary search-button', 'style'=>'margin-bottom:10px', 'target' => '_blank'),
					'url'=>array('ugyfelek/create'),
				));
			?>
			
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'autocomplete_ugyfel_cim'); ?>
			<?php echo $form->textField($model,'autocomplete_ugyfel_cim',array('size'=>10, 'maxlength'=>10, 'readonly'=>true)); ?>
			<?php echo $form->error($model,'autocomplete_ugyfel_cim'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'cimzett'); ?>
			<?php echo $form->textField($model,'cimzett',array('size'=>10,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'cimzett'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'autocomplete_ugyfel_adoszam'); ?>
			<?php echo $form->textField($model,'autocomplete_ugyfel_adoszam',array('size'=>10, 'maxlength'=>10, 'readonly'=>true)); ?>
			<?php echo $form->error($model,'autocomplete_ugyfel_adoszam'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'autocomplete_ugyfel_fizetesi_moral'); ?>
			<?php echo $form->textField($model,'autocomplete_ugyfel_fizetesi_moral',array('size'=>10, 'maxlength'=>10, 'readonly'=>true)); ?>
			<?php echo $form->error($model,'autocomplete_ugyfel_fizetesi_moral'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'autocomplete_ugyfel_max_fizetesi_keses'); ?>
			<?php echo $form->textField($model,'autocomplete_ugyfel_max_fizetesi_keses',array('size'=>10, 'maxlength'=>10, 'readonly'=>true)); ?>
			<?php echo $form->error($model,'autocomplete_ugyfel_max_fizetesi_keses'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'autocomplete_ugyfel_atlagos_fizetesi_keses'); ?>
			<?php echo $form->textField($model,'autocomplete_ugyfel_atlagos_fizetesi_keses',array('size'=>10, 'maxlength'=>10, 'readonly'=>true)); ?>
			<?php echo $form->error($model,'autocomplete_ugyfel_atlagos_fizetesi_keses'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'autocomplete_ugyfel_rendelesi_tartozas_limit'); ?>
			<?php echo $form->textField($model,'autocomplete_ugyfel_rendelesi_tartozas_limit',array('size'=>10, 'maxlength'=>10, 'readonly'=>true)); ?>
			<?php echo $form->error($model,'autocomplete_ugyfel_rendelesi_tartozas_limit'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'autocomplete_ugyfel_fontos_megjegyzes'); ?>
			<?php echo $form->textArea($model,'autocomplete_ugyfel_fontos_megjegyzes',array('size'=>10, 'maxlength'=>255, 'readonly'=>true)); ?>
			<?php echo $form->error($model,'autocomplete_ugyfel_fontos_megjegyzes'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'rendeles_idopont'); ?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'rendeles_idopont',
						'options'=>array('dateFormat'=>'yy-mm-dd',)
					));
				?>
				
			<?php echo $form->error($model,'rendeles_idopont'); ?>
		</div>
	
	<?php $this->endWidget(); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Megrendelés adatai #2</strong>",
		));
	?>

		<div class="row">
			<?php echo $form->labelEx($model,'ugyfel_tel'); ?>
			<?php echo $form->textField($model,'ugyfel_tel',array('size'=>30,'maxlength'=>30)); ?>
			<?php echo $form->error($model,'ugyfel_tel'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'ugyfel_fax'); ?>
			<?php echo $form->textField($model,'ugyfel_fax',array('size'=>30,'maxlength'=>30)); ?>
			<?php echo $form->error($model,'ugyfel_fax'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'visszahivas_jegyzet'); ?>
			<?php echo $form->textArea($model,'visszahivas_jegyzet',array('size'=>60,'maxlength'=>127)); ?>
			<?php echo $form->error($model,'visszahivas_jegyzet'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'jegyzet'); ?>
			<?php echo $form->textArea($model,'jegyzet',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'jegyzet'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'reklamszoveg'); ?>
			<?php echo $form->textArea($model,'reklamszoveg',array('size'=>60,'maxlength'=>127)); ?>
			<?php echo $form->error($model,'reklamszoveg'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'egyeb_megjegyzes'); ?>
			<?php echo $form->textArea($model,'egyeb_megjegyzes',array('size'=>60,'maxlength'=>127)); ?>
			<?php echo $form->error($model,'egyeb_megjegyzes'); ?>
		</div>

		<?php if ($model -> sztornozva == 1): ?>
			<div class="row">
				<?php echo $form->labelEx($model,'sztornozas_oka'); ?>
				<?php echo $form->textArea($model,'sztornozas_oka',array('size'=>60,'maxlength'=>255, 'readonly'=>true)); ?>
				<?php echo $form->error($model,'sztornozas_oka'); ?>
			</div>
		<?php endif; ?>

		<div class="row active">
			<input id = "egyedi_ar_dsp" type="checkbox" value="<?php echo $model->egyedi_ar; ?>" <?php if ($model->egyedi_ar == 1) echo " checked "; ?> name="egyedi_ar_dsp" disabled >
			<?php echo $form->label($model,'egyedi_ar'); ?>
			<?php echo $form->error($model,'egyedi_ar'); ?>
		</div>

		<div class="row active">
			<?php echo $form->checkBox($model,'proforma_szamla_fizetve'); ?>
			<?php echo $form->label($model,'proforma_szamla_fizetve'); ?>
			<?php echo $form->error($model,'proforma_szamla_fizetve'); ?>
		</div>

		<div class="row active">
			<input id = "sztornozva_dsp" type="checkbox" value="<?php echo $model->sztornozva; ?>" <?php if ($model->sztornozva == 1) echo " checked "; ?> name="sztornozva_dsp" disabled >
			<?php echo $form->label($model,'sztornozva'); ?>
			<?php echo $form->error($model,'sztornozva'); ?>
		</div>

		<?php if (Yii::app()->user->checkAccess('Admin')): ?>
			<div class="row active">
				<?php echo $form->checkBox($model,'torolt'); ?>
				<?php echo $form->label($model,'torolt'); ?>
				<?php echo $form->error($model,'torolt'); ?>
			</div>
		<?php endif; ?>
	
		<div class="row buttons">
			<?php echo CHtml::submitButton('Mentés', array('id' => 'megrendelesek_form_submit')); ?>
			<?php echo CHtml::button('Vissza', array('submit' => Yii::app()->request->urlReferrer)); ?>
		</div>
		
	<?php $this->endWidget(); ?>
	
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Megrendelt tételek</strong>",
		));

			if (Yii::app()->user->checkAccess('MegrendelesTetelek.Create')) {
				
				$this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'button_create_megrendelesTetel',
					'caption'=>'Tétel hozzáadása',
					'buttonType'=>'link',
					'onclick'=>new CJavaScriptExpression('function() {addUpdateMegrendelesTetel("create", $(this));}'),
					'htmlOptions'=>array('class'=>'btn btn-success'),
				));
			}
			
			// a dialógus ablak inicializálása
			$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
				'id'=>'dialogArajanlatTetel',
				'options'=>array(
					'title'=>'Termék hozzáadása',
					'autoOpen'=>false,
					'modal'=>true,
					'width'=>750,
					'height'=>650,
				),
			));
			
			echo "<div class='divForForm'></div>";
			
			$this->endWidget();
			
			
		// GRIDVIEW BEGIN
			$config = array();
			$dataProvider=new CActiveDataProvider('MegrendelesTetelek',
				array( 'data' => $model->tetelek,
						'sort'=>array(
							'attributes'=>array(
								'id' => array(
									'asc' => 'id ASC',
									'desc' => 'id DESC',
								),
							),
						),
				)
			);

			$this->widget('zii.widgets.grid.CGridView', array(
				'id' => 'megrendelesTetelek-grid',
				'enablePagination' => false,
				'dataProvider'=>$dataProvider,
				'columns'=>array(
					'termek.nev',
					'szinek_szama1',
					'szinek_szama2',
					'munka_neve',
					'darabszam',
					'hozott_boritek:boolean',
					'egyedi_ar:boolean',
					'netto_darabar',
					array(
								'class' => 'bootstrap.widgets.TbButtonColumn',
								'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
								'template' => '{update} {delete_item}',
								
								'updateButtonOptions'=>array('class'=>'btn btn-success btn-mini'),
								
								'buttons' => array(
									'update' => array(
										'label' => 'Szerkeszt',
										'icon'=>'icon-white icon-pencil',
										'url'=>'',
										'click'=>'function() {addUpdateMegrendelesTetel("update", $(this));}',
										'visible' => "Yii::app()->user->checkAccess('MegrendelesTetelek.Update')",
									),
							        'delete_item' => array
									(
										'label'=>'Töröl',
										'icon'=>'icon-white icon-remove-sign',
										'options'=>array(
											'class'=>'btn btn-danger btn-mini',
											),
										'url'=>'"#"',
										'visible' => "Yii::app()->user->checkAccess('MegrendelesTetelek.Delete')",
										'click'=>"function(){
														$.fn.yiiGridView.update('megrendelesTetelek-grid', {
															type:'POST',
															dataType:'json',
															url:$(this).attr('href'),
															success:function(data) {
																// az egyedi ár checkbox-ot kézzel átbillentjük a megfelelő értékre (a db-ben már a helyens érték van, csak a UI-on kell az interaktivitás miatt változtatni)
																$('#egyedi_ar_dsp').prop('checked', (data.egyedi == '1' ? true : false));
																$('#Megrendelesek_egyedi_ar').val (data.egyedi);
																
																$.fn.yiiGridView.update('megrendelesTetelek-grid');
															}
														})
														return false;
												  }
										 ",
										 'url'=> 'Yii::app()->createUrl("megrendelesTetelek/delete/" . $data->id)',
									),
								),
						),
				)
			));
		// GRIDVIEW END
	$this->endWidget();
	?>

<?php $this->endWidget(); ?>


</div><!-- form -->

<script type="text/javascript">
	
		function addUpdateMegrendelesTetel (createOrUpdate, buttonObj)
		{
		
			redirectUrl = "";
			try {
				redirectUrl = createOrUpdate.target.action;
			} catch (e) {
				redirectUrl = "";
			}
			
			if (typeof buttonObj != 'undefined')
				hrefString = buttonObj.parent().children().eq(1).attr('href');
				
			isUpdate = createOrUpdate == "update" || (typeof redirectUrl != 'undefined' && redirectUrl != '' && redirectUrl.indexOf("update") != -1);
			op = (isUpdate) ? "update" : "create";
			id = (isUpdate) ? hrefString.substr(hrefString.lastIndexOf("/") + 1) : $("#Megrendelesek_id").val();
			arkategoria_id = $("#Megrendelesek_arkategoria_id").val();
			dialog_title = (isUpdate) ? "Tétel módosítása" : "Tétel hozzáadása";

			<?php echo CHtml::ajax(array(
					'url'=> "js:'/index.php/megrendelesTetelek/' + op + '/id/' + id + '/arkategoria_id/' + arkategoria_id + '/grid_id/' + new Date().getTime()",
					'data'=> "js:$(this).serialize()",
					'type'=>'post',
					'id' => 'send-link-'.uniqid(),
					'replace' => '',
					'dataType'=>'json',
					'success'=>"function(data)
					{
						if (data.status == 'failure')
						{
							$('#dialogArajanlatTetel div.divForForm').html(data.div);
							$('#dialogArajanlatTetel div.divForForm form').submit(addUpdateMegrendelesTetel);
						}
						else
						{
							$.fn.yiiGridView.update(\"megrendelesTetelek-grid\",{ complete: function(jqXHR, status) {}})
							
							// az egyedi ár checkbox-ot kézzel átbillentjük a megfelelő értékre (a db-ben már a helyens érték van, csak a UI-on kell az interaktivitás miatt változtatni)
							$('#egyedi_ar_dsp').prop('checked', (data.egyedi == '1' ? true : false));
							$('#Megrendelesek_egyedi_ar').val (data.egyedi);
							
							$('#dialogArajanlatTetel div.divForForm').html(data.div);
							$('#dialogArajanlatTetel').dialog('close');
						}
		 
					} ",
			))?>;

			
			$("#dialogArajanlatTetel").dialog("open");
			$("#dialogArajanlatTetel").dialog('option', 'title', dialog_title);
			
			return false; 
		}
	 
	</script>
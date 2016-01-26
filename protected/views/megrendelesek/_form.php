<?php
/* @var $this MegrendelesekController */
/* @var $model Megrendelesek */
/* @var $form CActiveForm */

	Yii::app() -> clientScript->registerScript('updateGridView', '
		$.updateGridView = function(gridID, nameList, valueList) {
			var index;
				
			for	(index = 0; index < nameList.length; index++) {
				$("#" + gridID + " input[name=\'" + nameList[index] + "\'], #" + gridID + " select[name=\'" + nameList[index] + "\']").val(valueList[index]);				
			} 

			$.fn.yiiGridView.update(gridID, {
				data: $.param($("#"+gridID+" .filters input, #"+gridID+" .filters select"))
			});
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
			<?php echo $form->textField($model,'sorszam',array('size'=>10,'maxlength'=>12)); ?>
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
					'htmlOptions'=>array('class'=>'btn btn-primary search-button', 'style'=>'margin-bottom:10px', 'target' => '_blank'),
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
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'rendeles_idopont',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						),
						'htmlOptions'=>array('style' => 'width:135px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_rendeles_idopont',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Megrendelesek_rendeles_idopont").datetimepicker("setDate", (new Date()) );
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:65px', 'target' => '_blank'),
					));
				?>
				
			<?php echo $form->error($model,'rendeles_idopont'); ?>
		</div>
	
	<?php $this->endWidget(); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Megrendelés adatai #2</strong>",
			'htmlOptions'=>array('class'=>"portlet right-widget"),
		));
	?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'proforma_kiallitas_datum'); ?>
				
				<?php
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'proforma_kiallitas_datum',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						),
						'htmlOptions'=>array('style' => 'width:135px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_proforma_kiallitas_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Megrendelesek_proforma_kiallitas_datum").datetimepicker("setDate", (new Date()) );
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:65px', 'target' => '_blank'),
					));
				?>
				
			<?php echo $form->error($model,'proforma_kiallitas_datum'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'proforma_teljesites_datum'); ?>
				
				<?php
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'proforma_teljesites_datum',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						),
						'htmlOptions'=>array('style' => 'width:135px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_proforma_teljesites_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Megrendelesek_proforma_teljesites_datum").datetimepicker("setDate", (new Date()) );
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:65px', 'target' => '_blank'),
					));
				?>
				
			<?php echo $form->error($model,'proforma_teljesites_datum'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'proforma_fizetesi_hatarido'); ?>
				
				<?php
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'proforma_fizetesi_hatarido',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						),
						'htmlOptions'=>array('style' => 'width:135px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_proforma_fizetesi_hatarido',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Megrendelesek_proforma_fizetesi_hatarido").datetimepicker("setDate", (new Date()) );
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:65px', 'target' => '_blank'),
					));
				?>
				
			<?php echo $form->error($model,'proforma_fizetesi_hatarido'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'proforma_fizetesi_mod'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'proforma_fizetesi_mod',
					CHtml::listData(FizetesiModok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
				); ?>
				
			<?php echo $form->error($model,'proforma_fizetesi_mod'); ?>
		</div>

	<?php $this->endWidget(); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Megrendelés adatai #3</strong>",
			'htmlOptions'=>array('class'=>"portlet right-widget"),
		));
	?>

		<div class="row">
			<?php echo $form->labelEx($model,'ugyfel_tel'); ?>

			<?php $this->widget("ext.maskedInput.MaskedInput", array(
					"model" => $model,
					"attribute" => "ugyfel_tel",
					"mask" => '(99) 99-999-9999'                
				));
			?>
			
			<?php echo $form->error($model,'ugyfel_tel'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'ugyfel_fax'); ?>

			<?php $this->widget("ext.maskedInput.MaskedInput", array(
					"model" => $model,
					"attribute" => "ugyfel_fax",
					"mask" => '(99) 99-999-9999'                
				));
			?>
			
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
	<?php $this->endWidget(); ?>
		
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Megrendelt tételek</strong>",
			'htmlOptions'=>array('class'=>"portlet tetelek"),
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
				'id'=>'dialogMegrendelesTetel',
				'options'=>array(
					'title'=>'Termék hozzáadása',
					'autoOpen'=>false,
					'modal'=>true,
					'width'=>950,
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
					'termek.DisplayTermekTeljesNev',
					'szinek_szama1',
					'szinek_szama2',
					
					// a munka neve szerkeszthető, ha üres, egyébként pedig statikusan jelenik meg, mint a többi
					array(
						'class' => 'editable.EditableColumn',
						'name'  => 'munka_neve',
						'value' => function($data, $row) use ($model){
							return $data->munka_neve;
						},
						'header' => 'Munka neve',
						'editable' => array(
						   'apply'     => 'trim($data->munka_neve) == ""',
 						   'placement' => 'right',
						   'url'       => $this->createUrl('megrendelesTetelek/updateMunkaNeve'),
						)),

					'DarabszamFormazott',
					'egyedi_ar:boolean',
					'netto_darabar',
					array(
								'class' => 'bootstrap.widgets.TbButtonColumn',
								'htmlOptions'=>array('style'=>'width: 60px; text-align: center;'),
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

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Vezérlőpult</strong>",
		));
	?>		
		<div class="row buttons">
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'megrendelesek_form_submit',
						'caption'=>'Mentés',
						'htmlOptions' => array ('class' => 'btn btn-primary btn-lg',),
					 )); ?>
			<?php if ($model -> nyomdakonyv_munka_id == 0) {
						$this->widget('zii.widgets.jui.CJuiButton', 
						 array(
							'name'=>'nyomdakonyvbeKuldesButton',
							'caption'=>'Nyomdakönybe küldés',
							'onclick'=>new CJavaScriptExpression('function() {return checkMunkaNevek();}'),
							'htmlOptions' => array ('class' => 'btn btn-success btn-lg'),
						 ));
						 
						 $this->widget('zii.widgets.jui.CJuiButton', 
						 array(
							'name'=>'nyomdakonyvbeKuldesButtonHidden',
							'caption'=>'Nyomdakönybe küldés',
							'htmlOptions' => array ('class' => 'btn btn-success btn-lg', 'style' => 'display:none', 'submit' => Yii::app()->createUrl("/megrendelesek/munkakGeneralasaMegrendelesbol/", array("id" => $model->id))),
						 ));
					}
			?>
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'back',
						'caption'=>'Vissza',
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => Yii::app()->request->urlReferrer),
					 )); ?>
		</div>

		<div class="row buttons">		
	<?php
		if ($model->ugyfel_id > 0 && count($model->tetelek) > 0) {
			if (Yii::app()->user->checkAccess('MegrendelesSzallitolevelek.Create')) {
				
				$this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'button_create_szallitolevel',
					'caption'=>'Szállítólevél készítése',
					'buttonType'=>'link',
					'onclick'=>new CJavaScriptExpression('function() {szallitolevelek("create");}'),
					'htmlOptions'=>array('class'=>'btn btn-primary'),
				));
				
				$this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'button_list_szallitolevel',
					'caption'=>'Elkészült szállítólevelek',
					'buttonType'=>'link',
					'onclick'=>new CJavaScriptExpression('function() {szallitolevelek("list");}'),
					'htmlOptions'=>array('class'=>'btn btn-info'),
				));
				
				$this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'button_list_szamla_generalas',
					'caption'=>'Számla generálása',
					'buttonType'=>'link',
					'onclick'=>new CJavaScriptExpression('function() {szamlageneralas();}'),
					'htmlOptions'=>array('class'=>'btn btn-info'),
				));				
				
			}
		}
	?>
		</div>
		

	<?php $this->endWidget(); ?>

	
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
			afakulcs_id = $("#Megrendelesek_afakulcs_id").val();
			dialog_title = (isUpdate) ? "Tétel módosítása" : "Tétel hozzáadása";

			<?php echo CHtml::ajax(array(
					'url'=> "js:'/index.php/megrendelesTetelek/' + op + '/id/' + id + '/arkategoria_id/' + arkategoria_id + '/afakulcs_id/' + afakulcs_id + '/grid_id/' + new Date().getTime()",
					'data'=> "js:$(this).serialize()",
					'type'=>'post',
					'id' => 'send-link-'.uniqid(),
					'replace' => '',
					'dataType'=>'json',
					'success'=>"function(data)
					{
						if (data.status == 'failure')
						{
							$('#dialogMegrendelesTetel div.divForForm').html(data.div);
							$('#dialogMegrendelesTetel div.divForForm form').submit(addUpdateMegrendelesTetel);
						}
						else
						{
							$.fn.yiiGridView.update(\"megrendelesTetelek-grid\",{ complete: function(jqXHR, status) {}})
							
							// az egyedi ár checkbox-ot kézzel átbillentjük a megfelelő értékre (a db-ben már a helyes érték van, csak a UI-on kell az interaktivitás miatt változtatni)
							$('#egyedi_ar_dsp').prop('checked', (data.egyedi == '1' ? true : false));
							$('#Megrendelesek_egyedi_ar').val (data.egyedi);
							
							$('#dialogMegrendelesTetel div.divForForm').html(data.div);
							$('#dialogMegrendelesTetel').dialog('close');
						}
		 
					} ",
			))?>;

			
			$("#dialogMegrendelesTetel").dialog("open");
			$("#dialogMegrendelesTetel").dialog('option', 'title', dialog_title);
			
			return false; 
		}
		
		function szallitolevelek(createOrList) {
			var redirectUrl = "" ;
			var megrendelesId = $("#Megrendelesek_id").val() ;
			if (createOrList == "create") {
				redirectUrl = "/index.php/szallitolevelek/create/" + megrendelesId ;
			}
			else
			{
				redirectUrl = "/index.php/szallitolevelek/index/" + megrendelesId ;	
			}
			window.open (redirectUrl);
		}
	 
		function disableNyomdakonyvButton () {
			$("#nyomdakonyvbeKuldesButton").attr("disabled", true);
		}

		function enableNyomdakonyvButton () {
			$("#nyomdakonyvbeKuldesButton").attr("disabled", false);
		}
		
		function szamlageneralas(buttonObj) {
			id = 0 ;
			if ($("#Megrendelesek_id").val() != "") {
				id = $("#Megrendelesek_id").val() ;
			}
			if (id > 0) {
				<?php echo CHtml::ajax(array(
					'url'=> "js:'/index.php/megrendelesek/szamlageneralas/id/' + id",
					'data'=> "js:$(this).serialize()",
					'type'=>'get',
					'id' => 'send-link-'.uniqid(),
					'replace' => '',
					'dataType'=>'json',
					'success'=>"function(data)
					{
						if (data.status == 'failure')
						{
							//
						}
						else
						{
							alert('Számla xml legenerálva') ;
						}		 
					} ",
				))?>;
			}
		}
		
		function checkMunkaNevek () {
			disableNyomdakonyvButton();
			
			var megrendelesId = 0 ;
			if ($("#Megrendelesek_id").val() != "") {
				megrendelesId = $("#Megrendelesek_id").val() ;
			}
			if (megrendelesId > 0) {	
				<?php echo CHtml::ajax(array(
					'url'=> "js:'/index.php/megrendelesTetelek/checkMunkaNevek/megrendelesId/' + megrendelesId",
					'data'=> "js:$(this).serialize()",
					'type'=>'get',
					'id' => 'send-link-'.uniqid(),
					'replace' => '',
					'dataType'=>'json',
					'success'=>"function(data)
					{
						if (data.result == 'true')
						{
							$('#nyomdakonyvbeKuldesButtonHidden').click();
						}
						else
						{
							alert('Minden megrendelés tétel esetén kötelező kitölteni a \'munka neve\' mezőt! Ezt a sárgával jelzett oszlopokra kattintva teheti meg.');
							enableNyomdakonyvButton();
							
							return false;
						}		 
					} ",
				)); ?>			
			}
			
			return false;
		}
	</script>
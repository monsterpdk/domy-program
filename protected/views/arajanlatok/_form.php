<?php
/* @var $this ArajanlatokController */
/* @var $model Arajanlatok */
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
	'id'=>'arajanlatok-form',
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
			'title'=>"<strong>Árajánlat adatai #1</strong>",
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
					'id' => 'autocomplete-link-'.uniqid(),
					'model' => $model,
					'name' => 'autocomplete-link-'.uniqid(),
					'attribute' => 'autocomplete_ugyfel_name',
					'options'=> array(
						'showAnim'=>'fold',
						'minLength' => '1',
						'select'=>"js:function(event, ui) {
															$('#Arajanlatok_ugyfel_id').val (ui.item.id);
															$('#Arajanlatok_ugyfel_tel').val (ui.item.tel);
															$('#Arajanlatok_ugyfel_fax').val (ui.item.fax);
															
															$('#Arajanlatok_autocomplete_ugyfel_cim').val(ui.item.cim);
															$('#Arajanlatok_autocomplete_ugyfel_adoszam').val(ui.item.adoszam);
															$('#Arajanlatok_autocomplete_ugyfel_fizetesi_moral').val(ui.item.fizetesi_moral);
															$('#Arajanlatok_autocomplete_ugyfel_max_fizetesi_keses').val(ui.item.max_fizetesi_keses);
															$('#Arajanlatok_autocomplete_ugyfel_atlagos_fizetesi_keses').val(ui.item.atlagos_fizetesi_keses);
															$('#Arajanlatok_autocomplete_ugyfel_rendelesi_tartozas_limit').val(ui.item.rendelesi_tartozas_limit);
															$('#Arajanlatok_autocomplete_ugyfel_fontos_megjegyzes').html(ui.item.fontos_megjegyzes);
															$('#Arajanlatok_cimzett').val(ui.item.cimzett);
															$('#Ugyfel_fontos_megjegyzes_dialog').html(ui.item.fontos_megjegyzes) ;
															if (ui.item.fontos_megjegyzes != '') {
																$('#Ugyfel_fontos_megjegyzes_dialog').dialog('open') ;
															}
															
															// frissítjük a választható ügyintézők listáját
															$('#Arajanlatok_ugyintezo_id')
																.find('option')
																.remove()
																.end()
																.append(ui.item.ugyintezok);
																
															$('#Arajanlatok_autocomplete_arajanlat_osszes_darabszam').val ('');
															$('#Arajanlatok_autocomplete_arajanlat_osszes_ertek').val ('');
															$('#Arajanlatok_autocomplete_arajanlat_osszes_tetel').val ('');
															$('#Arajanlatok_autocomplete_megrendeles_osszes_darabszam').val ('');
															$('#Arajanlatok_autocomplete_megrendeles_osszes_ertek').val ('');
															$('#Arajanlatok_autocomplete_megrendeles_osszes_tetel').val ('');
															$('#Arajanlatok_autocomplete_arajanlat_megrendeles_elfogadas').val ('');
							
															// frissítjük az ügyfél statisztikáit
															getUgyfelStat(ui.item.id);
														}",
						'change'=>"js:function(event, ui) {
															if (!ui.item) {
																$('#Arajanlatok_ugyfel_id').val (ui.item.id);
																$('#Arajanlatok_ugyfel_tel').val (ui.item.tel);
																$('#Arajanlatok_ugyfel_fax').val (ui.item.fax);
																
																$('#Arajanlatok_autocomplete_ugyfel_cim').val(ui.item.cim);
																$('#Arajanlatok_autocomplete_ugyfel_adoszam').val(ui.item.adoszam);
																$('#Arajanlatok_autocomplete_ugyfel_fizetesi_moral').val(ui.item.fizetesi_moral);
																$('#Arajanlatok_autocomplete_ugyfel_max_fizetesi_keses').val(ui.item.max_fizetesi_keses);
																$('#Arajanlatok_autocomplete_ugyfel_atlagos_fizetesi_keses').val(ui.item.atlagos_fizetesi_keses);
																$('#Arajanlatok_autocomplete_ugyfel_rendelesi_tartozas_limit').val(ui.item.rendelesi_tartozas_limit);
																$('#Arajanlatok_autocomplete_ugyfel_fontos_megjegyzes').html(ui.item.fontos_megjegyzes);
																$('#Arajanlatok_cimzett').val(ui.item.cimzett);
																$('#Ugyfel_fontos_megjegyzes_dialog').html(ui.item.fontos_megjegyzes) ;
																if (ui.item.fontos_megjegyzes != '') {
																	$('#Ugyfel_fontos_megjegyzes_dialog').dialog('open') ;
																}
																
																// frissítjük az ügyfél statisztikáit
																getUgyfelStat(ui.item.id);
															}
														   }",
														
					),
				));
			?>
			
			<?php
				$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
					'id'=>'Ugyfel_fontos_megjegyzes_dialog',
					// additional javascript options for the dialog plugin
					'options'=>array(
						'title'=>'Fontos megjegyzés',
						'autoOpen'=>false,
						'dialogClass'=>"figyelmeztetes-dialog"
					),
				));
				
					echo 'dialog content here';			
				
				$this->endWidget('zii.widgets.jui.CJuiDialog');
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
	
	<?php $this->endWidget(); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Ügyfél statisztika</strong>",
			'htmlOptions'=>array('class'=>"portlet right-widget"),
		));
	?>

		<div class="row">
			<?php echo $form->labelEx($model,'autocomplete_arajanlat_osszes_darabszam'); ?>
			<?php echo $form->textField($model,'autocomplete_arajanlat_osszes_darabszam',array('size'=>10, 'maxlength'=>10, 'readonly'=>true)); ?>
			<?php echo $form->error($model,'autocomplete_arajanlat_osszes_darabszam'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'autocomplete_megrendeles_osszes_darabszam'); ?>
			<?php echo $form->textField($model,'autocomplete_megrendeles_osszes_darabszam',array('size'=>10, 'maxlength'=>10, 'readonly'=>true)); ?>
			<?php echo $form->error($model,'autocomplete_megrendeles_osszes_darabszam'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'autocomplete_arajanlat_osszes_ertek'); ?>
			<?php echo $form->textField($model,'autocomplete_arajanlat_osszes_ertek',array('size'=>10, 'maxlength'=>10, 'readonly'=>true, 'style' => 'width: 189px')); ?> Ft
			<?php echo $form->error($model,'autocomplete_arajanlat_osszes_ertek'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'autocomplete_megrendeles_osszes_ertek'); ?>
			<?php echo $form->textField($model,'autocomplete_megrendeles_osszes_ertek',array('size'=>10, 'maxlength'=>10, 'readonly'=>true, 'style' => 'width: 189px')); ?> Ft
			<?php echo $form->error($model,'autocomplete_megrendeles_osszes_ertek'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'autocomplete_arajanlat_osszes_tetel'); ?>
			<?php echo $form->textField($model,'autocomplete_arajanlat_osszes_tetel',array('size'=>10, 'maxlength'=>10, 'readonly'=>true)); ?>
			<?php echo $form->error($model,'autocomplete_arajanlat_osszes_tetel'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'autocomplete_megrendeles_osszes_tetel'); ?>
			<?php echo $form->textField($model,'autocomplete_megrendeles_osszes_tetel',array('size'=>10, 'maxlength'=>10, 'readonly'=>true)); ?>
			<?php echo $form->error($model,'autocomplete_megrendeles_osszes_tetel'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'autocomplete_arajanlat_megrendeles_elfogadas', array('style' => 'font-weight:bold')); ?>
			<?php echo $form->textField($model,'autocomplete_arajanlat_megrendeles_elfogadas',array('size'=>10, 'maxlength'=>10, 'readonly'=>true, 'style' => 'font-weight:bold')); ?>
			<?php echo $form->error($model,'autocomplete_arajanlat_megrendeles_elfogadas'); ?>
		</div>
	<?php $this->endWidget(); ?>	
	
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Árajánlat adatai #2</strong>",
			'htmlOptions'=>array('class'=>"portlet right-widget"),
		));
	?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'ajanlat_datum'); ?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'ajanlat_datum',
						'options'=>array('dateFormat'=>'yy-mm-dd',),
						'htmlOptions'=>array('style' => 'width:123px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_arajanlat_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Arajanlatok_ajanlat_datum").datepicker("setDate", new Date());
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'margin-left:10px; height:32px', 'target' => '_blank'),
					));
				?>
			
			<?php echo $form->error($model,'ajanlat_datum'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'ervenyesseg_datum'); ?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'ervenyesseg_datum',
						'options'=>array('dateFormat'=>'yy-mm-dd',),
						'htmlOptions'=>array('style' => 'width:123px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_ervenyesseg_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Arajanlatok_ervenyesseg_datum").datepicker("setDate", new Date());
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'margin-left:10px; height:32px', 'target' => '_blank'),
					));
				?>
			
			<?php echo $form->error($model,'ervenyesseg_datum'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'kovetkezo_hivas_ideje'); ?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'kovetkezo_hivas_ideje',
						'options'=>array('dateFormat'=>'yy-mm-dd',),
						'htmlOptions'=>array('style' => 'width:123px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_kovetkezo_hivas_idejem',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Arajanlatok_kovetkezo_hivas_ideje").datepicker("setDate", new Date());
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'margin-left:10px; height:32px', 'target' => '_blank'),
					));
				?>
			
			<?php echo $form->error($model,'kovetkezo_hivas_ideje'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'hatarido'); ?>
			<?php echo $form->textField($model,'hatarido',array('size'=>15,'maxlength'=>15)); ?>
			<?php echo $form->error($model,'hatarido'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Árajánlat adatai #3</strong>",
			'htmlOptions'=>array('class'=>"portlet"),
		));
	?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'ugyintezo_id'); ?>
			
				<?php
					$ugyfel_id = $model->ugyfel == null ? 0 : $model->ugyfel->id;
					
					echo CHtml::activeDropDownList($model, 'ugyintezo_id',
					CHtml::listData(UgyfelUgyintezok::model()->findAll(array("condition"=>"torolt=0 AND ugyfel_id = $ugyfel_id")), 'id', 'nev')
				); ?>
				
			<?php echo $form->error($model,'ugyintezo_id'); ?>
		</div>

		<div class="row">
			
		</div>
		
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

		
		<div class="row active">
			<input id = "egyedi_ar_dsp" type="checkbox" value="<?php echo $model->egyedi_ar; ?>" <?php if ($model->egyedi_ar == 1) echo " checked "; ?> name="egyedi_ar_dsp" disabled >
			<?php echo $form->label($model,'egyedi_ar'); ?>
			<?php echo $form->error($model,'egyedi_ar'); ?>
		</div>

		<div class="row active">
			<?php echo $form->checkBox($model,'visszahivas_lezarva'); ?>
			<?php echo $form->label($model,'visszahivas_lezarva'); ?>
			<?php echo $form->error($model,'visszahivas_lezarva'); ?>
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
			'title'=>"<strong>Visszahívások</strong>",
			'htmlOptions'=>array('class'=>"portlet right-widget"),
		));

			if (Yii::app()->user->checkAccess('ArajanlatVisszahivasok.Create')) {
				
				$this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'button_create_arajanlatVisszahivas',
					'caption'=>'Visszahívás hozzáadása',
					'buttonType'=>'link',
					'onclick'=>new CJavaScriptExpression('function() {addUpdateArajanlatVisszahivas("create", $(this));}'),
					'htmlOptions'=>array('class'=>'btn btn-success'),
				));
			}
			
			// a dialógus ablak inicializálása
			$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
				'id'=>'dialogArajanlatVisszahivas',
				'options'=>array(
					'title'=>'Visszahívás hozzáadása',
					'autoOpen'=>false,
					'modal'=>true,
					'width'=>400,
					'height'=>400,
				),
			));
			
			echo "<div class='divForForm'></div>";
			
			$this->endWidget();
			
			
		// GRIDVIEW BEGIN
			$dataProvider=new CActiveDataProvider('ArajanlatVisszahivasok',
				array( 'data' => $model->visszahivasok,
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
				'id' => 'arajanlatVisszahivasok-grid',
				'enablePagination' => false,
				'dataProvider'=>$dataProvider,
				'columns'=>array(
					'user.fullname',
					'idopont',
					'jegyzet',
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
										'click'=>'function() {addUpdateArajanlatVisszahivas("update", $(this));}',
										'visible' => "Yii::app()->user->checkAccess('ArajanlatVisszahivasok.Update')",
									),
									'delete_item' => array
									(
										'label'=>'Töröl',
										'icon'=>'icon-white icon-remove-sign',
										'options'=>array(
											'class'=>'btn btn-danger btn-mini',
											),
										'url'=>'"#"',
										'visible' => "Yii::app()->user->checkAccess('ArajanlatVisszahivasok.Delete')",
										'click'=>"function(){
														$.fn.yiiGridView.update('arajanlatVisszahivasok-grid', {
															type:'POST',
															dataType:'json',
															url:$(this).attr('href'),
															success:function(data) {
																$.fn.yiiGridView.update('arajanlatVisszahivasok-grid');
															}
														})
														return false;
												  }
										 ",
										 'url'=> 'Yii::app()->createUrl("arajanlatVisszahivasok/delete/" . $data->id)',
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
			'title'=>"<strong>Ajánlati lista</strong>",
			'htmlOptions'=>array('class'=>"portlet tetelek"),
		));

			if (Yii::app()->user->checkAccess('ArajanlatTetelek.Create')) {
				
				$this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'button_create_arajanlatTetel',
					'caption'=>'Tétel hozzáadása',
					'buttonType'=>'link',
					'onclick'=>new CJavaScriptExpression('function() {addUpdateArajanlatTetel("create", $(this));}'),
					'htmlOptions'=>array('class'=>'btn btn-success'),
				));
				
				$this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'button_arajanlatTetel_elozmenyek',
					'caption'=>'Előzmények',
					'buttonType'=>'link',
					'onclick'=>new CJavaScriptExpression('function() {ArajanlatTetelElozmenyek($(this));}'),
					'htmlOptions'=>array('class'=>'btn btn-info'),
				));
				
			}
			
			// a dialógus ablak inicializálása
			$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
				'id'=>'dialogArajanlatTetel',
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
			$dataProvider=new CActiveDataProvider('ArajanlatTetelek',
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
				'id' => 'arajanlatTetelek-grid',
				'enablePagination' => false,
				'dataProvider'=>$dataProvider,
				'columns'=>array(
					'termek.cikkszam',
					'termek.DisplayTermekTeljesNev',
					'szinek_szama1',
					'szinek_szama2',
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
										'click'=>'function() {addUpdateArajanlatTetel("update", $(this));}',
										'visible' => "Yii::app()->user->checkAccess('ArajanlatTetelek.Update')",
									),
									'delete_item' => array
									(
										'label'=>'Töröl',
										'icon'=>'icon-white icon-remove-sign',
										'options'=>array(
											'class'=>'btn btn-danger btn-mini',
											),
										'url'=>'"#"',
										'visible' => "Yii::app()->user->checkAccess('ArajanlatTetelek.Delete')",
										'click'=>"function(){
														$.fn.yiiGridView.update('arajanlatTetelek-grid', {
															type:'POST',
															dataType:'json',
															url:$(this).attr('href'),
															success:function(data) {
																// az egyedi ár checkbox-ot kézzel átbillentjük a megfelelő értékre (a db-ben már a helyens érték van, csak a UI-on kell az interaktivitás miatt változtatni)
																$('#egyedi_ar_dsp').prop('checked', (data.egyedi == '1' ? true : false));
																$('#Arajanlatok_egyedi_ar').val (data.egyedi);
																
																$.fn.yiiGridView.update('arajanlatTetelek-grid');
															}
														})
														return false;
												  }
										 ",
										 'url'=> 'Yii::app()->createUrl("arajanlatTetelek/delete/" . $data->id)',
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
						'name'=>'anyagrendelesek_form_submit',
						'caption'=>'Mentés',
						'htmlOptions' => array ('class' => 'btn btn-primary btn-lg',),
						'onclick'=>new CJavaScriptExpression('function(){saveOrBack("save"); this.blur(); return false;}')
					 )); ?>
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'back',
						'caption'=>'Vissza',
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg'),
						'onclick'=>new CJavaScriptExpression('function(){saveOrBack("back"); this.blur(); return false;}')
					 )); ?>
		</div>

	<?php $this->endWidget(); ?>	

<?php $this->endWidget(); ?>

<?php
 $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'confirmationDialog',
        'options'=>array(
            'title'=>'Figyelmeztetés',
            'autoOpen'=>false,
            'modal'=>true,
            'buttons'=>array(
                'Ok'=>'js:function(){deleteAndRedirect()}',
                'Mégse'=>'js:function(){ $(this).dialog("close");}',
            ),
        ),
    ));
	
	echo 'Nem található egy felvett tétel sem. Ha folytatja, akkor az árajánlat törlése kerül. Biztosan folytatja ?';
	
	$this->endWidget();
?>

</div><!-- form -->

<!-- View Popup  -->
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'arajanlatElozmenyekModal')); ?>
<!-- Popup Header -->
<div class="modal-header">
<h4>View Employee Details</h4>
</div>
<!-- Popup Content -->
<div class="modal-body">
<p>Employee Details</p>
</div>
<!-- Popup Footer -->
<div class="modal-footer">

<!-- close button -->
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Close',
    'url'=>'#',
    'htmlOptions'=>array('data-dismiss'=>'modal'),
)); ?>
<!-- close button ends-->
</div>
<?php $this->endWidget(); ?>
<!-- View Popup ends -->

<script type="text/javascript">
		// LI: ha nincs tétel felvéve egy árajánlathoz, akkor ha a felhasználó 'mentés' vagy 'Vissza' gombot
		//	   nyom törölnünk kell az árajánlatot
		function deleteAndRedirect () {
			window.location = '<?php echo $this->createUrl('arajanlatok/deleteAndRedirect'); ?>/arajanlatId/' + $("#Arajanlatok_id").val();
		}
		
		// LI: a mentés és vissza gomb onclick eseményének kezelése átkerült kliens oldalra, mert
		//	   ellenőrizni kell ezen műveletek elvégzése előtt, hogy van-e felvéve legalább 1 tétel
		//	   FALSE-sal tér vissza, ha 1 db tétel sincs
		function saveOrBack (operation) {
				var id = $("#Arajanlatok_id").val();
				
				<?php echo CHtml::ajax(array(
					'url'=> "js:'/index.php/arajanlatok/checkTetelSzam/arajanlatId/' + id + '/saveOrBack/' + operation",
					'data'=> "js:$(this).serialize()",
					'type'=>'post',
					'id' => 'send-link-'.uniqid(),
					'replace' => '',
					'dataType'=>'json',
					'success'=>"function(data)
					{
						if (data.status == 'vanTetel') {
							if (data.redirectUrl != '') {
								// vissza gombot nyomtunk, így visszalépünk a nézet korábbi állapotába
								window.location = data.redirectUrl;
							} else {
								// mentést nyomtunk, így submit-ot küldünk a formra
								$( '#arajanlatok-form' ).submit();
							}
						} else {
							// nem találtunk tételt az árajánlathoz
							$('#confirmationDialog').dialog('open');
						}
					} ",
				))?>;
		}
		
		function ArajanlatTetelElozmenyek (buttonObj)
		{
			var ugyfel_id = $("#Arajanlatok_ugyfel_id").val() ;
			var id = $("#Arajanlatok_id").val();
			if (ugyfel_id != "0") {
				dialog_title = $("#Arajanlatok_autocomplete_ugyfel_name").val() + " részére eddig adott ajánlati tételek a múltban";
	
				<?php echo CHtml::ajax(array(
					'url'=> "js:'/index.php/arajanlatok/ArajanlatTetelElozmenyek/ugyfel_id/' + ugyfel_id + '/grid_id/' + new Date().getTime()",
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
//							$('#dialogArajanlatTetel div.divForForm form').submit(ArajanlatTetelElozmenyek);
						}
						else
						{
							$.fn.yiiGridView.update(\"arajanlatTetelek-grid\",{ complete: function(jqXHR, status) {}})
														
							$('#dialogArajanlatTetel div.divForForm').html(data.div);
							$('#dialogArajanlatTetel').dialog('close');
						}
		 
					} ",
				))?>;
				
				$("#dialogArajanlatTetel").dialog("open");
				$("#dialogArajanlatTetel").dialog('option', 'title', dialog_title);
				
				return false; 
			}
			else
			{
				alert("Nincs kiválasztott ügyfél!") ;	
			}
		}


		function addUpdateArajanlatTetel (createOrUpdate, buttonObj)
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
			id = (isUpdate) ? hrefString.substr(hrefString.lastIndexOf("/") + 1) : $("#Arajanlatok_id").val();
			arkategoria_id = $("#Arajanlatok_arkategoria_id").val();
			afakulcs_id = $("#Arajanlatok_afakulcs_id").val();
			dialog_title = (isUpdate) ? "Tétel módosítása" : "Tétel hozzáadása";

			<?php echo CHtml::ajax(array(
					'url'=> "js:'/index.php/arajanlatTetelek/' + op + '/id/' + id + '/arkategoria_id/' + arkategoria_id + '/afakulcs_id/' + afakulcs_id + '/grid_id/' + new Date().getTime()",
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
							$('#dialogArajanlatTetel div.divForForm form').submit(addUpdateArajanlatTetel);
						}
						else
						{
							$.fn.yiiGridView.update(\"arajanlatTetelek-grid\",{ complete: function(jqXHR, status) {}})
							
							// az egyedi ár checkbox-ot kézzel átbillentjük a megfelelő értékre (a db-ben már a helyes érték van, csak a UI-on kell az interaktivits miatt változtatni)
							$('#egyedi_ar_dsp').prop('checked', (data.egyedi == '1' ? true : false));
							$('#Arajanlatok_egyedi_ar').val (data.egyedi);
							
							$('#dialogArajanlatTetel div.divForForm').html(data.div);
							$('#dialogArajanlatTetel').dialog('close');
						}
		 
					} ",
			))?>;

			
			$("#dialogArajanlatTetel").dialog("open");
			$("#dialogArajanlatTetel").dialog('option', 'title', dialog_title);
			
			return false; 
		}
		
		function addUpdateArajanlatVisszahivas (createOrUpdate, buttonObj)
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
			id = (isUpdate) ? hrefString.substr(hrefString.lastIndexOf("/") + 1) : $("#Arajanlatok_id").val();
			dialog_title = (isUpdate) ? "Visszahívás módosítása" : "Visszahívás hozzáadása";

			<?php echo CHtml::ajax(array(
					'url'=> "js:'/index.php/arajanlatVisszahivasok/' + op + '/id/' + id + '/grid_id/' + new Date().getTime()",
					'data'=> "js:$(this).serialize()",
					'type'=>'post',
					'id' => 'send-link-'.uniqid(),
					'replace' => '',
					'dataType'=>'json',
					'success'=>"function(data)
					{
						if (data.status == 'failure')
						{
							$('#dialogArajanlatVisszahivas div.divForForm').html(data.div);
							$('#dialogArajanlatVisszahivas div.divForForm form').submit(addUpdateArajanlatVisszahivas);
						}
						else
						{
							$.fn.yiiGridView.update(\"arajanlatVisszahivasok-grid\",{ complete: function(jqXHR, status) {}})
														
							$('#dialogArajanlatVisszahivas div.divForForm').html(data.div);
							$('#dialogArajanlatVisszahivas').dialog('close');
						}
		 
					} ",
			))?>;

			
			$("#dialogArajanlatVisszahivas").dialog("open");
			$("#dialogArajanlatVisszahivas").dialog('option', 'title', dialog_title);
			
			return false; 
		}

		function getUgyfelStat (ugyfelId)
		{

			<?php echo CHtml::ajax(array(
					'url'=> "js:'/index.php/arajanlatok/getUgyfelStat/ugyfelId/' + ugyfelId",
					'data'=> "js:$(this).serialize()",
					'type'=>'post',
					'id' => 'get-ugyfel-stat-link-'.uniqid(),
					'replace' => '',
					'dataType'=>'json',
					'success'=>"function(data)
					{
						if (data.status == 'failure')
						{}
						else
						{
							$('#Arajanlatok_autocomplete_arajanlat_osszes_darabszam').val (data.autocomplete_arajanlat_osszes_darabszam);
							$('#Arajanlatok_autocomplete_arajanlat_osszes_ertek').val (data.autocomplete_arajanlat_osszes_ertek);
							$('#Arajanlatok_autocomplete_arajanlat_osszes_tetel').val (data.autocomplete_arajanlat_osszes_tetel);
							$('#Arajanlatok_autocomplete_megrendeles_osszes_darabszam').val (data.autocomplete_megrendeles_osszes_darabszam);
							$('#Arajanlatok_autocomplete_megrendeles_osszes_ertek').val (data.autocomplete_megrendeles_osszes_ertek);
							$('#Arajanlatok_autocomplete_megrendeles_osszes_tetel').val (data.autocomplete_megrendeles_osszes_tetel);
							$('#Arajanlatok_autocomplete_arajanlat_megrendeles_elfogadas').val (data.autocomplete_arajanlat_megrendeles_elfogadas);
						}
		 
					} ",
			))?>;
			
			return false; 
		}		
	 
	</script>
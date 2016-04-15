<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'raktar-kiadasok-termek-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<!-- Termék tallózásához szükséges kódblokk -->
	<div class="row">
		<?php echo "Termék neve"; ?>
		
		<?php
			$meretek =  CHtml::listData(TermekMeretek::model()->findAll(array('select' => 'nev')), 'nev', 'nev');
			$meretek = array('114x162 mm'=>'LC/6', '110x220 mm'=>'LA/4', '114x229 mm' => 'C6/C5', '162x229 mm' => 'LC/5', '176x250 mm' => 'TB/5', '229x324 mm' => 'LC/4', '229x324 mm' => 'TC/4', '250x353 mm' => 'TB/4') ;
			$zarodasok = array(' '=>'Nincs', 'enyvezett'=>'enyvezett', 'öntapadó'=>'öntapadó', 'szilikonos'=>'szilikonos');
			$ablakmeretek = CHtml::listData(TermekAblakMeretek::model()->findAll(array('select' => 'nev', 'order'=>'nev')), 'nev', 'nev');
			$termekcsoportok = CHtml::listData(Termekcsoportok::model()->findAll(array('select' => 'nev', 'order'=>'nev')), 'nev', 'nev');
		?>
		
		<!-- szűrő blokk -->
		<div class="row search-options">
			<fieldset>
				<legend>Méret</legend>
				<div class="boritekMeretRadioGroup">
					<?php 
						echo CHtml::radioButtonList('boritek_meret', '' ,$meretek, array( 'separator' => "  ", 'template' => '{label} {input}')); 
					?>
				Légpárnás <?php echo CHtml::checkBox('legparnas',false); ?>
				</div>
			</fieldset>
			
			<fieldset>
				<legend>Záródás</legend>
				<div class="boritekZarodasRadioGroup">
					<?php
						echo CHtml::radioButtonList('boritek_zarodas', '' ,$zarodasok, array( 'separator' => "  ", 'template' => '{label} {input}')); 								
					?>
				</div>
			</fieldset>

			<fieldset style='width: 46%; float:left; margin-right:10px'>
				<legend>Ablakméretek</legend>
				<div class="boritekAblakMeretRadioGroup">
					<?php echo CHtml::dropDownList('boritek_ablakmeret', '-=Válasszon=-', $ablakmeretek, array('empty'=>'-=Válasszon=-',)); ?>
				</div>
			</fieldset>
			
			<fieldset style='width: 46%; float:left;'>
				<legend>Termékcsoportok</legend>
				<div class="boritekAblakMeretRadioGroup">
					<?php echo CHtml::dropDownList('termekcsoport', '-=Válasszon=-', $termekcsoportok, array('empty'=>'-=Válasszon=-',)); ?>
				</div>
			</fieldset>
			
		</div>

		<div class="row boritekMeretRadioGroup">
			<label>Termék kereső</label>
			 <?php echo CHtml::textField('termek_kereso', '', array('maxlength' => 128)); ?>
			 <?php echo CHtml::Button('Termék', array('name' => 'search_termek', 'id' => 'search_termek', 'onclick' =>
												'
												var valasztott_meret = $("input[name=boritek_meret]:checked", "#raktar-kiadasok-termek-form").val()
												var valasztott_zaras = $("input[name=boritek_zarodas]:checked", "#raktar-kiadasok-termek-form").val()
												var valasztott_ablakmeret = $("#boritek_ablakmeret").val();
												var valasztott_termekcsoport = $("#termekcsoport").val() ;
												var valasztott_legparnas = $("#legparnas").prop("checked") ;	
												
												var paramKeys = [];
												var paramValues = [];
												
												if (valasztott_ablakmeret != "valasszon") {
													paramKeys.push("Termekek[ablakmeret_search]");
													paramValues.push(valasztott_ablakmeret);
												} else {
													paramKeys.push("Termekek[ablakmeret_search]");
													paramValues.push("");
												}
												
												if (valasztott_termekcsoport != "valasszon") {
													paramKeys.push("Termekek[termekcsoport_search]");
													paramValues.push(valasztott_termekcsoport);
												} else {
													paramKeys.push("Termekek[termekcsoport_search]");
													paramValues.push("");
												}
												
												paramKeys.push("Termekek[meret_search]");
												paramValues.push(valasztott_meret);
											
												paramKeys.push("Termekek[zaras_search]");
												paramValues.push(valasztott_zaras);

												if (valasztott_legparnas) {
													paramKeys.push("Termekek[nev]") ;
													paramValues.push("Légpárnás");
												}
												else
												{
													paramKeys.push("Termekek[nev]");
													paramValues.push($("#termek_kereso").val());
												}

												$.updateGridView("termekek-grid' . $grid_id . '", paramKeys, paramValues);

												$("#termek_dialog' . $grid_id . '").dialog("open");
												$("#termek_dialog' . $grid_id . '").dialog("moveToTop"); return false;
												'
											)); ?>
		</div>

		<div style="clear:both;">
		</div>

	</div>
	
	<!-- Termék tallózásához szükséges kódblokk vége -->
	
	<!-- CJUIDIALOG BEGIN -->
		<?php 
		  $this->beginWidget('zii.widgets.jui.CJuiDialog', 
			   array(   'id'=>'termek_dialog' . $grid_id,
						'options'=>array(
										'title'=>'Termék kiválasztása',
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
								array(
									'name' => 'termekcsoport.nev',
									'header' => 'Termékcsoport',
									'filter' => CHtml::activeTextField($termek, 'termekcsoport_search'),
									'value' => '$data->termekcsoport == null ? "" : $data->termekcsoport->nev',
								),
								array(
									'name' => 'meret.nev',
									'header' => 'Méret',
									'filter' => CHtml::activeTextField($termek, 'meret_search'),
									'value' => '$data->meret == null ? "" : $data->meret->nev',
								),
								array(
									'name' => 'gyarto.cegnev',
									'header' => 'Gyártó',
									'filter' => CHtml::activeTextField($termek, 'gyarto_search'),
									'value' => '$data->gyarto == null ? "" : $data->gyarto->cegnev',
								),
								array(
									'name' => 'papirtipus.nev',
									'header' => 'Papírtípus',
									'filter' => CHtml::activeTextField($termek, 'papirtipus_search'),
									'value' => '$data->papirtipus == null ? "" : $data->papirtipus->nev',
								),
								array(
									'name' => 'zaras.nev',
									'header' => 'Záródás',
									'filter' => CHtml::activeTextField($termek, 'zaras_search'),
									'value' => '$data->zaras == null ? "" : $data->zaras->nev',
								),
								array(
									'name' => 'ablakhely.nev',
									'header' => 'Ablakhely',
									'filter' => CHtml::activeTextField($termek, 'ablakhely_search'),
									'value' => '$data->ablakhely == null ? "" : $data->ablakhely->nev',
								),
								array(
									'name' => 'ablakmeret.nev',
									'header' => 'Ablakméret',
									'filter' => CHtml::activeTextField($termek, 'ablakmeret_search'),
									'value' => '$data->ablakmeret == null ? "" : $data->ablakmeret->nev',
								),								
								array(
								  'header'=>'',
								  'type'=>'raw',
								  'value'=>'CHtml::Button("+", 
															array("name" => "send_termek", 
																"id" => "send_termek", 
																"onClick" => "$(\"#termek_dialog' . $grid_id . '\").dialog(\"close\");
																
																				  $(\"#RaktarKiadasok_termek_id\").val(\"$data->id\");
																				  $(\"#RaktarKiadasok_autocomplete_termek_name\").val(\"$data->nev\");
																				  $(\"#dialogRaktarKiadasokTermek\").dialog(\"close\");
																				  
																			  "))',
															),
								   ),
				));

		$this->endWidget('zii.widgets.jui.CJuiDialog');
	?>
	<!-- CJUIDIALOG END -->
	
<?php $this->endWidget(); ?>

</div><!-- form -->
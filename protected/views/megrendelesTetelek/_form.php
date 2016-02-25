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
	<?php
//		$ablakhelyek = CHtml::listData(TermekAblakHelyek::model()->findAll(array('select' => 'nev')), 'nev', 'nev');
//		$meretek =  CHtml::listData(TermekMeretek::model()->findAll(array('select' => 'nev')), 'nev', 'nev');
		$meretek = array('114x162 mm'=>'LC/6', '110x220 mm'=>'LA/4', '114x229 mm' => 'C6/C5', '162x229 mm' => 'LC/5', '176x250 mm' => 'TB/5', '229x324 mm' => 'LC/4', '229x324 mm' => 'TC/4', '250x353 mm' => 'TB/4', 'Légpárnás' => 'Légpárnás') ;
		
//		$zarodasok = CHtml::listData(TermekZarasiModok::model()->findAll(array('select' => 'nev')), 'nev', 'nev');
//		$zarodasok[" "] = "Nincs" ;
		$zarodasok = array(' '=>'Nincs', 'enyvezett'=>'enyvezett', 'öntapadó'=>'öntapadó', 'szilikonos'=>'szilikonos');
		
		$ablakmeretek = CHtml::listData(TermekAblakMeretek::model()->findAll(array('select' => 'nev', 'order'=>'nev')), 'nev', 'nev');
		//$ablakmeretek["valasszon"] = "-=Válasszon=-" ; 		
		
		$termekcsoportok = CHtml::listData(Termekcsoportok::model()->findAll(array('select' => 'nev', 'order'=>'nev')), 'nev', 'nev');
		//$termekcsoportok["valasszon"] = "-=Válasszon=-" ;
		
//		$meretek["valasszon"] = "-=Válasszon=-" ; 		
//		$zarodasok["valasszon"] = "-=Válasszon=-" ; 		
	?>
	
	<div class="row search-options">
		<fieldset>
			<legend>Méret</legend>
			<div class="boritekMeretRadioGroup">
				<?php 
					echo CHtml::radioButtonList('boritek_meret', '' ,$meretek, array( 'separator' => "  ", 'template' => '{label} {input}')); 
//					echo CHtml::dropDownList('boritek_meret', 'valasszon' ,$meretek); 				
				?>
			</div>
		</fieldset>
		
		<fieldset>
			<legend>Záródás</legend>
			<div class="boritekZarodasRadioGroup">
				<?php
					echo CHtml::radioButtonList('boritek_zarodas', '' ,$zarodasok, array( 'separator' => "  ", 'template' => '{label} {input}')); 								
//					echo CHtml::dropDownList('boritek_zarodas', 'valasszon' ,$zarodasok); 
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
		 <?php echo CHtml::textField('termek_kereso', '', array('maxlength' => 128, 'readonly'=> $model->arajanlatbol_letrehozva == 1)); ?>
		 <?php if ($model->arajanlatbol_letrehozva != 1) echo CHtml::Button('Termék', array('name' => 'search_termek', 'id' => 'search_termek', 'onclick' =>
											'
											var valasztott_meret = $("input[name=boritek_meret]:checked", "#megrendeles-tetelek-form").val()
											var valasztott_zaras = $("input[name=boritek_zarodas]:checked", "#megrendeles-tetelek-form").val()
											var valasztott_ablakmeret = $("#boritek_ablakmeret").val() ;
											var valasztott_termekcsoport = $("#termekcsoport").val() ;
											
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
											}

											paramKeys.push("Termekek[meret_search]");
											paramValues.push(valasztott_meret);
											
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

											paramKeys.push("Termekek[nev]");
											paramValues.push($("#termek_kereso").val());

											$.updateGridView("termekek-grid' . $grid_id . '", paramKeys, paramValues);
											
											$("#termek_dialog' . $grid_id . '").dialog("open");
											$("#termek_dialog' . $grid_id . '").dialog("moveToTop"); return false;
											'
										)); ?>
		 <?php if ($model->arajanlatbol_letrehozva != 1) echo CHtml::Button('Szolgáltatás', array('name' => 'search_szolgaltatas', 'id' => 'search_szolgaltatas', 'onclick' => '' )); ?>
	</div>
	
	<div style="clear:both">	
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'termek_id'); ?>
		<?php echo $form->textField($model,'autocomplete_termek_name', array('style' => 'width:445px!important', 'disabled' => 'true') ); ?>
		<?php echo $form->error($model,'termek_id'); ?>
	</div>

	<div style="clear:both;">
	</div>
 
	<div class="row">
		<?php echo $form->labelEx($model,'szinek_szama1'); ?>
		<?php echo CHtml::activeDropDownList($model, 'szinek_szama1', array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4'), ($model->arajanlatbol_letrehozva == 1 ? array('disabled'=>'true','onChange'=>'javascript:nettoar_kalkulal();') : array('onChange'=>'javascript:nettoar_kalkulal();'))); ?>
		<?php echo $form->error($model,'szinek_szama1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szinek_szama2'); ?>
		<?php echo CHtml::activeDropDownList($model, 'szinek_szama2', array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4'), ($model->arajanlatbol_letrehozva == 1 ? array('disabled'=>'true','onChange'=>'javascript:nettoar_kalkulal();') : array('onChange'=>'javascript:nettoar_kalkulal();'))); ?>
		<?php echo $form->error($model,'szinek_szama2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'darabszam'); ?>
		<?php echo $form->textField($model,'darabszam',array('size'=>10,'maxlength'=>10,'onChange'=>'javascript:nettoar_kalkulal();', 'disabled' => ($model->arajanlatbol_letrehozva == 1 ? 'true' : ''))); ?>
		<?php echo $form->error($model,'darabszam'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'netto_darabar'); ?>
		<?php echo $form->textField($model,'netto_darabar', ($model->arajanlatbol_letrehozva == 1 ? array('disabled'=>'true') : array('onChange'=>'javascript:nettoar_kalkulal();'))); ?>
		<?php echo $form->error($model,'netto_darabar'); ?>
		
		<?php echo $form->labelEx($model,'netto_ar'); ?>
		<?php echo $form->textField($model,'netto_ar',  array('disabled'=>'true', 'maxlength' => 128)); ?>

		<?php echo $form->labelEx($model,'brutto_ar'); ?>
		<?php echo $form->textField($model,'brutto_ar',  array('disabled'=>'true', 'maxlength' => 128)); ?>
	</div>

	<script>
		$( "#MegrendelesTetelek_darabszam" ).on("keyup", keyPressEvent);
		$( "#MegrendelesTetelek_netto_darabar" ).on("keyup", keyPressEvent);
		
		// mikor megnyitjuk a tétel űrlapot (akár újat veszünk fel, akár szerkesztünk) meghívjuk a nettó és bruttó árat frissítő metódust
		nettoar_kalkulal();
		
		//2000 db alatt fix árat kapunk a nyomási árnál, ezeknél a db ár egyenlő lesz az összeggel, tehát nem kell darabszámmal szorozni, ekkor fix_ar = true
		function osszegSzamol() {
			var darabszam = $.isNumeric ($( "#MegrendelesTetelek_darabszam" ).val()) ? $( "#MegrendelesTetelek_darabszam" ).val() : 0;
			var netto_darabar = $.isNumeric ($( "#MegrendelesTetelek_netto_darabar" ).val()) ? $( "#MegrendelesTetelek_netto_darabar" ).val() : 0;
			
			$( "#MegrendelesTetelek_netto_ar" ).val (Math.round(darabszam * netto_darabar));			
		}
		
		function keyPressEvent() {
			$( "#MegrendelesTetelek_netto_darabar" ).val($( "#MegrendelesTetelek_netto_darabar" ).val().replace(",",".")) ;
			if (!$("#MegrendelesTetelek_egyedi_ar").prop('checked')) {			
				$( "#MegrendelesTetelek_netto_darabar" ).val("0") ;
				nettoar_kalkulal() ;
				osszegSzamol() ;
			}
		}
		
		function nettoar_kalkulal() {
			if (!$("#MegrendelesTetelek_egyedi_ar").prop('checked')) {			
				var termek_id = $("#MegrendelesTetelek_termek_id").val() ;
				calculateTermekNettoDarabAr(termek_id) ;
			}
			else
			{
				$( "#MegrendelesTetelek_netto_darabar" ).val($( "#MegrendelesTetelek_netto_darabar" ).val().replace(",",".")) ;
				$('#MegrendelesTetelek_netto_ar' ).val ($('#MegrendelesTetelek_netto_darabar').val () * $( "#MegrendelesTetelek_darabszam" ).val());
				$('#MegrendelesTetelek_brutto_ar' ).val ($('#MegrendelesTetelek_netto_ar' ).val () * 1.27);			//TODO: Betenni az aktuális áfa értéket, ne legyen így bedrótozva					
			}
		}
		
		function calculateTermekNettoDarabAr (termekId) {
			var darabszam = $.isNumeric ($( "#MegrendelesTetelek_darabszam" ).val()) ? $( "#MegrendelesTetelek_darabszam" ).val() : 0;
			var szinszam1 = $.isNumeric ($( "#MegrendelesTetelek_szinek_szama1" ).val()) ? $( "#MegrendelesTetelek_szinek_szama1" ).val() : 0;
			var szinszam2 = $.isNumeric ($( "#MegrendelesTetelek_szinek_szama2" ).val()) ? $( "#MegrendelesTetelek_szinek_szama2" ).val() : 0;
			var ugyfel_id = $('#Megrendelesek_ugyfel_id').val ();
			var afakulcs_id = $('#Megrendelesek_afakulcs_id').val ();
			
			var hozott_boritek = 0 ;
			if ($("#MegrendelesTetelek_hozott_boritek").prop('checked')) {
				hozott_boritek = 1 ;	
			}			
			<?php echo CHtml::ajax(array(
					'url'=> "js:'/index.php/megrendelesTetelek/calculateNettoDarabAr/ugyfel_id/' + ugyfel_id + '/afakulcs_id/' + afakulcs_id + '/termek_id/' + termekId + '/db/' + darabszam + '/szinszam1/' + szinszam1 + '/szinszam2/' + szinszam2 + '/hozott_boritek/' + hozott_boritek",
					'data'=> "js:$(this).serialize()",
					'type'=>'post',
					'id' => 'send-link-'.uniqid(),
					'replace' => '',
					'dataType'=>'json',
					'success'=>"function(data)
					{
						if (data.status == 'failure')
						{
						}
						else
						{
							$('#MegrendelesTetelek_netto_darabar').val (data[0].ar);
							$('#MegrendelesTetelek_netto_ar' ).val (data[0].netto_osszeg);
							$('#MegrendelesTetelek_brutto_ar' ).val (data[0].brutto_osszeg);
						}
		 
					} ",
			)); ?>;
		}
		
	</script>
	
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
		<?php echo $form->checkBox($model,'egyedi_ar'); ?>
		<?php echo $form->label($model,'egyedi_ar'); ?>
		<?php echo $form->error($model,'egyedi_ar'); ?>
	</div>	
	
	<div class="row active">
		<?php echo $form->checkBox($model,'mutacio', ($model->arajanlatbol_letrehozva == 1 ? array('disabled'=>'true') : array())); ?>
		<?php echo $form->label($model,'mutacio'); ?>
		<?php echo $form->error($model,'mutacio'); ?>
	</div>
	
	<div class="row active">
		<?php echo $form->checkBox($model,'hozott_boritek', ($model->arajanlatbol_letrehozva == 1 ? array('disabled'=>'true') : array('onclick'=>'javascript:keyPressEvent();'))); ?>
		<?php echo $form->label($model,'hozott_boritek'); ?>
		<?php echo $form->error($model,'hozott_boritek'); ?>
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
						'name'=>'cancelForm',
						'caption'=>'Mégse',
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'onclick'=>'js: $("#dialogMegrendelesTetel").dialog("close"); return false;'),
					 )); ?>
	</div>

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
																
																			  $(\"#MegrendelesTetelek_termek_id\").val(\"$data->id\");
																			  $(\"#MegrendelesTetelek_autocomplete_termek_name\").val(\"$data->nev\");
																			  
																			  calculateTermekNettoDarabAr (\"$data->id\");
																			 "))',
															),
								   ),
				));

		$this->endWidget('zii.widgets.jui.CJuiDialog');
	?>
	<!-- CJUIDIALOG END -->
	
<?php $this->endWidget(); ?>

</div><!-- form -->
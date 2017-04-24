<?php
/* @var $this AnyagbeszallitasTermekekController */
/* @var $model AnyagbeszallitasTermekek */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'anyagbeszallitas-termekek-form',
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
		<?php echo $form->hiddenField($model,'anyagbeszallitas_id'); ?>
		<?php echo CHtml::hiddenField('nyomdakonyv_id_hidden' , $model -> nyomdakonyv_id, array('id' => 'nyomdakonyv_id_hidden')); ?>
		
		<?php
			$meretek =  CHtml::listData(TermekMeretek::model()->findAll(array('select' => 'nev')), 'nev', 'nev');
			$meretek = array('114x162 mm'=>'LC/6', '110x220 mm'=>'LA/4', '114x229 mm' => 'C6/C5', '162x229 mm' => 'LC/5', '176x250 mm' => 'TB/5', '229x324 mm' => 'LC/4', '229x324 mm' => 'TC/4', '250x353 mm' => 'TB/4') ;

//			$zarodasok = CHtml::listData(TermekZarasiModok::model()->findAll(array('select' => 'nev')), 'nev', 'nev');
//			$zarodasok[" "] = "Nincs" ;
			$zarodasok = array(' '=>'Nincs', 'enyvezett'=>'enyvezett', 'öntapadó'=>'öntapadó', 'szilikonos'=>'szilikonos');

			$ablakmeretek = CHtml::listData(TermekAblakMeretek::model()->findAll(array('select' => 'nev', 'order'=>'nev')), 'nev', 'nev');
			//$ablakmeretek["valasszon"] = "-=Válasszon=-" ;
			
			$termekcsoportok = CHtml::listData(Termekcsoportok::model()->findAll(array('select' => 'nev', 'order'=>'nev')), 'nev', 'nev');
			//$termekcsoportok["valasszon"] = "-=Válasszon=-" ; 		
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
												var valasztott_meret = $("input[name=boritek_meret]:checked", "#anyagbeszallitas-termekek-form").val()
												var valasztott_zaras = $("input[name=boritek_zarodas]:checked", "#anyagbeszallitas-termekek-form").val()
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
			 <?php //if ($model->arajanlatbol_letrehozva != 1) echo CHtml::Button('Szolgáltatás', array('name' => 'search_szolgaltatas', 'id' => 'search_szolgaltatas', 'onclick' => '' )); ?>
		</div>

		<div style="clear:both"></div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'termek_id'); ?>
			<?php echo $form->textField($model,'autocomplete_termek_name', array('style' => 'width:445px!important', 'disabled' => 'true',) ); ?>
			<?php echo $form->error($model,'termek_id'); ?>
		</div>
		
		<div style="clear:both;">
		</div>

	</div>
	
	<!-- Termék tallózásához szükséges kódblokk vége -->
	
	<div class="row">
		<?php echo $form->labelEx($model,'darabszam'); ?>
		<?php echo $form->textField($model,'darabszam',array('size'=>10,'maxlength'=>10, /* LI: ha nettó összeget is meg kell jeleníteni 'onChange'=>'javascript:nettoar_kalkulal();',*/)); ?>
		<?php echo $form->error($model,'darabszam'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'netto_darabar'); ?>
		<?php echo $form->textField($model,'netto_darabar', array('maxlength' => 128, 'readonly'=> true)); ?>
		<?php echo $form->error($model,'netto_darabar'); ?>
	</div>

	<div class="row active">
		<?php echo $form->checkBox($model,'hozott_boritek', array('checked' => ($model->hozott_boritek == 1) ? 'checked' : '', 'onChange'=>'javascript:showNyomdakonyvSelector();')); ?>
		<?php echo $form->label($model,'hozott_boritek'); ?>
		<?php echo $form->error($model,'hozott_boritek'); ?>
	</div>

	<div id ="nyomdakonyvValaszto" class="row" <?php if ($model->nyomdakonyv_id == null || $model->nyomdakonyv_id == 0) { echo " style='display:none'"; } ?>>
		<?php echo $form->labelEx($model,'nyomdakonyv_id'); ?>
		<?php echo $form->dropDownList($model, 'nyomdakonyv_id', array('-=Válasszon=-'), array()); ?>
		<?php echo $form->error($model,'nyomdakonyv_id'); ?>
	</div>
	
	<div class="row buttons">
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
				 array(
					'name'=>'submitForm',
					'caption'=>'Mentés',
					'htmlOptions' => array ('class' => 'btn btn-primary btn-lg',),
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
									'name' => 'papirtipus.suly',
									'header' => 'Papír súly',
									'filter' => CHtml::activeTextField($termek, 'papirsuly_search'),
									'value' => '$data->papirtipus == null ? "" : $data->papirtipus->suly',
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
																
																			  $(\"#AnyagbeszallitasTermekek_termek_id\").val(\"$data->id\");
																			  $(\"#AnyagbeszallitasTermekek_autocomplete_termek_name\").val(\"$data->DisplayTermekTeljesNev\");
																			  
																			  calculateTermekNettoDarabAr (\"$data->id\");
																			  
																			  // frissíteni kell a kiválasztott termékhez tartozó nyomdakönyvi munkákat (ha a hozott boríték checkbox be van jelölve)
																			  termekValtozas ();
																			 "))',
															),
								   ),
				));

		$this->endWidget('zii.widgets.jui.CJuiDialog');
	?>
	<!-- CJUIDIALOG END -->
	
<?php $this->endWidget(); ?>

<script>
	// LI: arra az esetre, ha nem csak darabár, hanem nettó összeg is kell, egyelőre nem használjuk
	//$( "#AnyagbeszallitasTermekek_rendelt_darabszam" ).on("keyup", keyPressEvent);
	
	// LI: arra az esetre, ha nem csak darabár, hanem nettó összeg is kell, egyelőre nem használjuk
	function osszegSzamol() {
		var darabszam = $.isNumeric ($( "#AnyagbeszallitasTermekek_rendelt_darabszam" ).val()) ? $( "#AnyagbeszallitasTermekek_rendelt_darabszam" ).val() : 0;
		var netto_darabar = $.isNumeric ($( "#AnyagbeszallitasTermekek_netto_darabar" ).val()) ? $( "#AnyagbeszallitasTermekek_netto_darabar" ).val() : 0;
		
		$( "#AnyagbeszallitasTermekek_netto_darabar" ).val (Math.round(darabszam * netto_darabar));			
	}
	
	function keyPressEvent() {
		$( "#AnyagbeszallitasTermekek_netto_darabar" ).val($( "#AnyagbeszallitasTermekek_netto_darabar" ).val().replace(",",".")) ;
		$( "#AnyagbeszallitasTermekek_netto_darabar" ).val("0") ;
		nettoar_kalkulal() ;
		//osszegSzamol() ;
	}
	
	function nettoar_kalkulal() {
		var termek_id = $("#AnyagbeszallitasTermekek_termek_id").val() ;
		calculateTermekNettoDarabAr(termek_id) ;
	}
	
	function calculateTermekNettoDarabAr (termekId) {
		var darabszam = $.isNumeric ($( "#AnyagbeszallitasTermekek_rendelt_darabszam" ).val()) ? $( "#AnyagbeszallitasTermekek_rendelt_darabszam" ).val() : 0;
		var ugyfel_id = $('#Anyagrendelesek_gyarto_id').val ();

		<?php echo CHtml::ajax(array(
				'url'=> "js:'/index.php/AnyagbeszallitasTermekek/calculateNettoDarabAr/ugyfel_id/' + ugyfel_id + '/termek_id/' + termekId + '/darabszam/' + darabszam",
				'data'=> "js:$(this).serialize()",
				'type'=>'post',
				'id' => 'send-link-'.uniqid(),
				'replace' => '',
				'dataType'=>'json',
				'success'=>"function(data)
				{
					$('#AnyagbeszallitasTermekek_netto_darabar' ).val (data);
				} ",
		)); ?>
	}
	
	// a hozott boríték checkbox nyomkodásakor lefutó kódrész
	function showNyomdakonyvSelector() {
		if ($("#AnyagbeszallitasTermekek_hozott_boritek").prop("checked")) {
			$( "#nyomdakonyvValaszto" ).show();
		} else {
			$( "#nyomdakonyvValaszto" ).hide();
		}
		
		termekValtozas ();
	}
	
	// termék választásakor lefutó kódrész
	function termekValtozas () {
		// csak akkor foglalkozunk ezzel, ha a 'hozott boríték' checkbox be van jelölve
		if ($("#AnyagbeszallitasTermekek_hozott_boritek").prop("checked")) {
			if ($("#AnyagbeszallitasTermekek_termek_id").val () != '') {
				<?php echo CHtml::ajax(array(
					'url'=> "js:'/index.php/Anyagbeszallitasok/nyomdakonyvListazas/termek_id/' + $('#AnyagbeszallitasTermekek_termek_id').val() + '/nyomdakonyv_id/' + $('#nyomdakonyv_id_hidden').val()",
					'data'=> "",
					'type'=>'post',
					'id' => 'send-link-'.uniqid(),
					'success'=>"js:function(data)
					{
						// az első elem kivételével minden option tag-et törlünk
						$('option', '#AnyagbeszallitasTermekek_nyomdakonyv_id').not(':eq(0)').remove();
						
						$('#AnyagbeszallitasTermekek_nyomdakonyv_id').append(data);
					}",
				)); ?>
			}
		}
	}

	$(function() {
		showNyomdakonyvSelector();
	});
</script>

</div><!-- form -->
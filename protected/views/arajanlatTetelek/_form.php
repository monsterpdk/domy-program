<?php
/* @var $this ArajanlatTetelekController */
/* @var $model ArajanlatTetelek */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'arajanlat-tetelek-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'arajanlat_id'); ?>
	<?php echo $form->hiddenField($model, 'termek_id'); ?>
	<?php echo $form->hiddenField($model, 'szorzo_tetel_arhoz'); ?>
	<?php
		$ablakhelyek = CHtml::listData(TermekAblakHelyek::model()->findAll(array('select' => 'nev')), 'nev', 'nev');
		$meretek =  CHtml::listData(TermekMeretek::model()->findAll(array('select' => 'nev')), 'nev', 'nev');
//		$meretek = array('LC/6'=>'LC/6', 'LA/4'=>'LA/4', 'C6/C5' => 'C6/C5', 'LC/5' => 'LC/5', 'TC/5' => 'TC/5', 'TB/5' => 'TB/5', 'LC/4' => 'LC/4', 'TC/4' => 'TC/4', 'TB/4' => 'TB/4') ;
		$zarodasok =  CHtml::listData(TermekZarasiModok::model()->findAll(array('select' => 'nev')), 'nev', 'nev');
		$ablakhelyek["valasszon"] = "-=Válasszon=-" ; 		
		$meretek["valasszon"] = "-=Válasszon=-" ; 		
		$zarodasok["valasszon"] = "-=Válasszon=-" ; 		
	?>
	
	<div class="row search-options">
		<fieldset>
			<legend>Méret</legend>
			<div class="boritekMeretRadioGroup">
				<?php 
//					echo CHtml::radioButtonList('boritek_meret', '' ,$meretek, array( 'separator' => "  ", 'template' => '{label} {input}')); 
					echo CHtml::dropDownList('boritek_meret', 'valasszon' ,$meretek); 				
				?>
			</div>
		</fieldset>
		
		<fieldset>
			<legend>Záródás</legend>
			<div class="boritekZarodasRadioGroup">
				<?php echo CHtml::dropDownList('boritek_zarodas', 'valasszon' ,$zarodasok); ?>			
			</div>
		</fieldset>

		<fieldset>
			<legend>Ablakhely</legend>
			<div class="boritekAblakhelyRadioGroup">
				<?php echo CHtml::dropDownList('boritek_ablakhely', 'valasszon' ,$ablakhelyek); ?>			
			</div>
		</fieldset>
		
	</div>
	
	<div class="row boritekMeretRadioGroup">
		<label>Termék kereső</label>
		 <?php echo CHtml::textField('termek_kereso', '', array('maxlength' => 128)); ?>
		 <?php echo CHtml::Button('Termék', array('name' => 'search_termek', 'id' => 'search_termek', 'onclick' =>
											'
											var valasztott_meret = $("#boritek_meret").val() ;
											var valasztott_zaras = $("#boritek_zarodas").val() ;
											var valasztott_ablakhely = $("#boritek_ablakhely").val() ;
											if (valasztott_meret != "valasszon") {
												$.updateGridView("termekek-grid' . $grid_id . '", "Termekek[meret_search]", valasztott_meret) ;
											}
											if (valasztott_zaras != "valasszon") {
												$.updateGridView("termekek-grid' . $grid_id . '", "Termekek[zaras_search]", valasztott_zaras) ;
											}
											if (valasztott_ablakhely != "valasszon") {
												$.updateGridView("termekek-grid' . $grid_id . '", "Termekek[ablakhely_search]", valasztott_ablakhely) ;
											}
											$.updateGridView("termekek-grid' . $grid_id . '", "Termekek[nev]", $("#termek_kereso").val());
											
											$("#termek_dialog' . $grid_id . '").dialog("open");
											$("#termek_dialog' . $grid_id . '").dialog("moveToTop"); return false;
											'
										)); ?>
		 <?php echo CHtml::Button('Szolgáltatás', array('name' => 'search_szolgaltatas', 'id' => 'search_szolgaltatas', 'onclick' => '' )); ?>
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
		<?php echo CHtml::activeDropDownList($model, 'szinek_szama1', array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4'),array('onChange'=>'javascript:nettoar_kalkulal();')); ?>
		<?php echo $form->error($model,'szinek_szama1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szinek_szama2'); ?>
		<?php echo CHtml::activeDropDownList($model, 'szinek_szama2', array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4'),array('onChange'=>'javascript:nettoar_kalkulal();')); ?>
		<?php echo $form->error($model,'szinek_szama2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'darabszam'); ?>
		<?php echo $form->textField($model,'darabszam',array('size'=>10,'maxlength'=>10,'onChange'=>'javascript:nettoar_kalkulal();')); ?>
		<?php echo $form->error($model,'darabszam'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'netto_darabar'); ?>
		<?php echo $form->textField($model,'netto_darabar'); ?>
		<?php echo $form->error($model,'netto_darabar'); ?>

		<?php echo $form->labelEx($model,'netto_ar'); ?>
		<?php echo $form->textField($model,'netto_ar',  array('disabled'=>'true', 'maxlength' => 128)); ?>

		<?php echo $form->labelEx($model,'brutto_ar'); ?>
		<?php echo $form->textField($model,'brutto_ar',  array('disabled'=>'true', 'maxlength' => 128)); ?>
	</div>

	<script>
		$( "#ArajanlatTetelek_darabszam" ).on("keyup", keyPressEvent);
		$( "#ArajanlatTetelek_netto_darabar" ).on("keyup", keyPressEvent);
		
		// mikor megnyitjuk a tétel űrlapot (akár újat veszünk fel, akár szerkesztünk) meghívjuk a nettó és bruttó árat frissítő metódust
		nettoar_kalkulal();
		
		//2000 db alatt fix árat kapunk a nyomási árnál, ezeknél a db ár egyenlő lesz az összeggel, tehát nem kell darabszámmal szorozni, ekkor fix_ar = true
		function osszegSzamol() {
			var darabszam = $.isNumeric ($( "#ArajanlatTetelek_darabszam" ).val()) ? $( "#ArajanlatTetelek_darabszam" ).val() : 0;
			var netto_darabar = $.isNumeric ($( "#ArajanlatTetelek_netto_darabar" ).val()) ? $( "#ArajanlatTetelek_netto_darabar" ).val() : 0;
			
			$( "#ArajanlatTetelek_netto_ar" ).val (Math.round(darabszam * netto_darabar));
		}
			
		function keyPressEvent() {
			$( "#ArajanlatTetelek_netto_darabar" ).val("0") ;
			$( "#ArajanlatTetelek_brutto_darabar" ).val("0") ;
			nettoar_kalkulal() ;
			osszegSzamol() ;
		}
		
		function nettoar_kalkulal() {
			var termek_id = $("#ArajanlatTetelek_termek_id").val() ;
			calculateTermekNettoDarabAr(termek_id) ;
		}
		
		function calculateTermekNettoDarabAr (termekId) {
			var darabszam = $.isNumeric ($( "#ArajanlatTetelek_darabszam" ).val()) ? $( "#ArajanlatTetelek_darabszam" ).val() : 0;
			var szinszam1 = $.isNumeric ($( "#ArajanlatTetelek_szinek_szama1" ).val()) ? $( "#ArajanlatTetelek_szinek_szama1" ).val() : 0;
			var szinszam2 = $.isNumeric ($( "#ArajanlatTetelek_szinek_szama2" ).val()) ? $( "#ArajanlatTetelek_szinek_szama2" ).val() : 0;
			var ugyfel_id = $('#Arajanlatok_ugyfel_id').val ();
			var afakulcs_id = $('#Arajanlatok_afakulcs_id').val ();
			
			var hozott_boritek = 0 ;
			if ($("#ArajanlatTetelek_hozott_boritek").prop('checked')) {
				hozott_boritek = 1 ;	
			}
			<?php echo CHtml::ajax(array(
					'url'=> "js:'/index.php/arajanlatTetelek/calculateNettoDarabAr/ugyfel_id/' + ugyfel_id + '/afakulcs_id/' + afakulcs_id + '/termek_id/' + termekId + '/db/' + darabszam + '/szinszam1/' + szinszam1 + '/szinszam2/' + szinszam2 + '/hozott_boritek/' + hozott_boritek",
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
							$('#ArajanlatTetelek_netto_darabar').val (data[0].ar);
							$('#ArajanlatTetelek_netto_ar' ).val (data[0].netto_osszeg);
							$('#ArajanlatTetelek_brutto_ar' ).val (data[0].brutto_osszeg);
						}
		 
					} ",
			)); ?>;
		}
			
	</script>
	
	<div class="row">
		<?php echo $form->labelEx($model,'megjegyzes'); ?>
		<?php echo $form->textArea($model,'megjegyzes',array('size'=>60,'maxlength'=>127)); ?>
		<?php echo $form->error($model,'megjegyzes'); ?>
	</div>

	<div class="row">
		<?php echo $form->checkBox($model,'mutacio'); ?>
		<?php echo $form->label($model,'mutacio'); ?>
		<?php echo $form->error($model,'mutacio'); ?>
	</div>

	<div class="row">
		<?php echo $form->checkBox($model,'hozott_boritek',array('onclick'=>'javascript:keyPressEvent();')); ?>
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
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'onclick'=>'js: $("#dialogArajanlatTetel").dialog("close"); return false;'),
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
									'name' => 'meret.nev',
									'header' => 'Méret',
									'filter' => CHtml::activeTextField($termek, 'meret_search'),
									'value' => '$data->meret->nev',
								),
								array(
									'name' => 'gyarto.cegnev',
									'header' => 'Gyártó',
									'filter' => CHtml::activeTextField($termek, 'gyarto_search'),
									'value' => '$data->gyarto->cegnev',
								),
								array(
									'name' => 'papirtipus.nev',
									'header' => 'Papírtípus',
									'filter' => CHtml::activeTextField($termek, 'papirtipus_search'),
									'value' => '$data->papirtipus->nev',
								),
								array(
									'name' => 'zaras.nev',
									'header' => 'Záródás',
									'filter' => CHtml::activeTextField($termek, 'zaras_search'),
									'value' => '$data->zaras->nev',
								),
								array(
									'name' => 'ablakhely.nev',
									'header' => 'Ablakhely',
									'filter' => CHtml::activeTextField($termek, 'ablakhely_search'),
									'value' => '$data->ablakhely->nev',
								),
								array(
								  'header'=>'',
								  'type'=>'raw',
								  'value'=>'CHtml::Button("+", 
															array("name" => "send_termek", 
																"id" => "send_termek", 
																"onClick" => "$(\"#termek_dialog' . $grid_id . '\").dialog(\"close\");
																
																			  $(\"#ArajanlatTetelek_termek_id\").val(\"$data->id\");
																			  $(\"#ArajanlatTetelek_autocomplete_termek_name\").val(\"$data->nev\");
																			  
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
<?php
/* @var $this NyomdakonyvReklamaciokController */
/* @var $model NyomdakonyvReklamaciok */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerCoreScript('jquery');

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nyomdakonyv-reklamaciok-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'nyomdakonyv_id'); ?>

	<!-- --------------------- Nyomdakönyv adatai ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Nyomdakönyv adatai</strong>",
			'htmlOptions'=>array('style' => 'width: 1064!important;border: 1px solid #dddddd;border-radius: 3px;box-shadow: 0 1px 0 #f9f9f9 inset; margin-bottom:20px'),
		));
	?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'nyomdakonyv.taskaszam'); ?>
			<?php echo Chtml::textField('taskaszam', $model->nyomdakonyv->taskaszam, array('size'=>12, 'maxlength'=>12, 'readonly'=>true)); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'nyomdakonyv.megrendeles_tetel.munka_neve'); ?>
			<?php echo Chtml::textField('munka_neve', mb_strtoupper($model->nyomdakonyv->megrendeles_tetel->munka_neve, "UTF-8"), array('size'=>12, 'maxlength'=>127, 'readonly'=>true, 'style' => 'width: 500px')); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'datum'); ?>
			<?php echo $form->textField($model,'datum', array('size'=>12, 'maxlength'=>12, 'readonly'=>true)); ?>
		</div>
	
	<div style ='clear:both'></div>
	
	<?php $this->endWidget(); ?>
	
	<!-- --------------------- Fejléc adatai ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Fejlécadatok</strong>",
			'htmlOptions'=>array('style' => 'float:left; width: 700px!important;border: 1px solid #dddddd;border-radius: 3px;box-shadow: 0 1px 0 #f9f9f9 inset; margin-bottom:20px'),
		));
	?>

		<div class="row">
			<?php echo $form->labelEx($model,'selejt_leiras'); ?>
			<?php echo $form->textField($model,'selejt_leiras',array('size'=>60,'maxlength'=>255, 'style' => 'width: 600px')); ?>
			<?php echo $form->error($model,'selejt_leiras'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'aru_kiado'); ?>
			<?php echo $form->textField($model,'aru_kiado',array('size'=>60,'maxlength'=>255, 'style' => 'width: 600px')); ?>
			<?php echo $form->error($model,'aru_kiado'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'gepmester'); ?>
			<?php echo $form->textField($model,'gepmester',array('size'=>60,'maxlength'=>255, 'style' => 'width: 600px')); ?>
			<?php echo $form->error($model,'gepmester'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'kereszt_ellenor'); ?>
			<?php echo $form->textField($model,'kereszt_ellenor',array('size'=>60,'maxlength'=>255, 'style' => 'width: 600px')); ?>
			<?php echo $form->error($model,'kereszt_ellenor'); ?>
		</div>
		
		<div style ='clear:both'></div>
		
	<?php $this->endWidget(); ?>
	
		<!-- --------------------- Felelősök ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Felelősök listája</strong>",
			'htmlOptions'=>array('style' => 'float:left; height:336px;  width: 365px!important;border: 1px solid #dddddd;border-radius: 3px;box-shadow: 0 1px 0 #f9f9f9 inset; margin-bottom:20px; margin-left:20px'),
		));
	?>
	
		<?php $this->widget('application.extensions.multicomplete.MultiComplete', array(
			  'model'=>$model,
			  'attribute'=>'felelosok',
			  'splitter'=>',',
			  'sourceUrl'=>$this->createUrl('nyomdakonyvReklamaciok/searchFelelosok'),
			  'htmlOptions'=>array(
			  					 'style' => 'height:245px;width:310px!important'
			  ),
			  'options'=>array(
					  'minLength'=>'1',
			  ),
			));
		?>
	
	<?php $this->endWidget(); ?>
	
	<div style ='clear:both'></div>
	
	<!-- --------------------- Selejt oka ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Selejt oka</strong>",
			'htmlOptions'=>array('style' => 'width: 280px!important; float:left;border: 1px solid #dddddd;border-radius: 3px;box-shadow: 0 1px 0 #f9f9f9 inset; margin-bottom:20px'),
		));
	?>
		<div class="row active">
			<?php echo $form->checkBox($model,'selejt_oka_rossz_munka_kiadas'); ?>
			<?php echo $form->labelEx($model,'selejt_oka_rossz_munka_kiadas'); ?>
			<?php echo $form->error($model,'selejt_oka_rossz_munka_kiadas'); ?>
		</div>

		<div class="row active">
			<?php echo $form->checkBox($model,'selejt_oka_szin_hiba'); ?>
			<?php echo $form->labelEx($model,'selejt_oka_szin_hiba'); ?>
			<?php echo $form->error($model,'selejt_oka_szin_hiba'); ?>
		</div>

		<div class="row active">
			<?php echo $form->checkBox($model,'selejt_oka_passzer_hiba'); ?>
			<?php echo $form->labelEx($model,'selejt_oka_passzer_hiba'); ?>
			<?php echo $form->error($model,'selejt_oka_passzer_hiba'); ?>
		</div>

		<div class="row active">
			<?php echo $form->checkBox($model,'selejt_oka_hatarido_csuszas'); ?>
			<?php echo $form->labelEx($model,'selejt_oka_hatarido_csuszas'); ?>
			<?php echo $form->error($model,'selejt_oka_hatarido_csuszas'); ?>
		</div>

		<div class="row active">
			<?php echo $form->checkBox($model,'selejt_oka_peldanyszam_elteres'); ?>
			<?php echo $form->labelEx($model,'selejt_oka_peldanyszam_elteres'); ?>
			<?php echo $form->error($model,'selejt_oka_peldanyszam_elteres'); ?>
		</div>

		<div class="row active">
			<?php echo $form->checkBox($model,'selejt_oka_elhelyezes_hiba'); ?>
			<?php echo $form->labelEx($model,'selejt_oka_elhelyezes_hiba'); ?>
			<?php echo $form->error($model,'selejt_oka_elhelyezes_hiba'); ?>
		</div>

		<div class="row active">
			<?php echo $form->checkBox($model,'selejt_oka_hibas_boritek_valasztas'); ?>
			<?php echo $form->labelEx($model,'selejt_oka_hibas_boritek_valasztas'); ?>
			<?php echo $form->error($model,'selejt_oka_hibas_boritek_valasztas'); ?>
		</div>

		<div style = 'margin-left: 30px'>
			<div class="row active">
				<?php echo $form->checkBox($model,'selejt_oka_rossz_meret'); ?>
				<?php echo $form->labelEx($model,'selejt_oka_rossz_meret'); ?>
				<?php echo $form->error($model,'selejt_oka_rossz_meret'); ?>
			</div>

			<div class="row active">
				<?php echo $form->checkBox($model,'selejt_oka_rossz_ablak'); ?>
				<?php echo $form->labelEx($model,'selejt_oka_rossz_ablak'); ?>
				<?php echo $form->error($model,'selejt_oka_rossz_ablak'); ?>
			</div>

			<div class="row active">
				<?php echo $form->checkBox($model,'selejt_oka_rossz_rag_mod'); ?>
				<?php echo $form->labelEx($model,'selejt_oka_rossz_rag_mod'); ?>
				<?php echo $form->error($model,'selejt_oka_rossz_rag_mod'); ?>
			</div>
		</div>
		
		<div style ='clear:both'></div>
		
		<div class="row buttons" style = 'margin-top:70px; padding-bottom:8px'>
			<?php echo CHtml::ajaxSubmitButton('Mentés', CHtml::normalizeUrl(array('nyomdakonyvReklamaciok/reklamacio/id/' . $model->nyomdakonyv_id . '/form/1')),
					 array(
						 'dataType'=>'json',
						 'type'=>'post',
						 'success'=>'function(data) {
							// $("#ajaxLoader").hide();  
								if (data.status=="success"){
									$("#nyomdakonyv-reklamacio-dialog").dialog("close");
								} else {
									$.each(data.div, function(key, val) {
										$("#nyomdakonyv-reklamaciok-form #NyomdakonyvReklamaciok_" + key + "_em_").text (val);                                                    
										$("#nyomdakonyv-reklamaciok-form #NyomdakonyvReklamaciok_" + key + "_em_").show ();
									});
								}       
						}',                    
						 'beforeSend'=>'function(){                        
							   // $("#ajaxLoader").show();
						  }'
						 ),array('id'=>'reklamacioMentesButton' . round(microtime(true) * 1000),'class'=>'btn btn-primary btn-lg'));
			 ?>
			 
			 <?php $this->widget('zii.widgets.jui.CJuiButton', 
				 array(
					'name'=>'back',
					'caption'=>'Vissza',
					'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'onclick'=>'js: $("#nyomdakonyv-reklamacio-dialog").dialog("close"); return false;'),
			 )); ?>
		</div>


	<?php $this->endWidget(); ?>
	
	<!-- --------------------- Észrevétel helye ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Észrevétel helye</strong>",
			'htmlOptions'=>array('style' => 'width: 435px!important; float:left;border: 1px solid #dddddd;border-radius: 3px;box-shadow: 0 1px 0 #f9f9f9 inset; margin-bottom:20px; margin-left:20px'),
		));
	?>
		
		<div class="row active">
			<?php echo $form->checkBox($model,'eszrevetel_helye_cegen_belul'); ?>
			<?php echo $form->labelEx($model,'eszrevetel_helye_cegen_belul'); ?>
			<?php echo $form->error($model,'eszrevetel_helye_cegen_belul'); ?>
		</div>

		<div class="row active">
			<?php echo $form->checkBox($model,'eszrevetel_helye_cegen_kivul'); ?>
			<?php echo $form->labelEx($model,'eszrevetel_helye_cegen_kivul'); ?>
			<?php echo $form->error($model,'eszrevetel_helye_cegen_kivul'); ?>
		</div>

		<br />
		
		<table>
			<tr>
				<th> </th>
				<th>Ellenőrzési pontok</th>
				<th>Hiba észlelése</th>
			</tr>

			<tr>
				<td>iroda munka felvétel</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'ellenorzesi_pontok_iroda_munka_felvetel'); ?>
						<?php echo $form->labelEx($model,'ellenorzesi_pontok_iroda_munka_felvetel'); ?>
						<?php echo $form->error($model,'ellenorzesi_pontok_iroda_munka_felvetel'); ?>
					</div>
				</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'hiba_eszlelese_iroda_munka_felvetel'); ?>
						<?php echo $form->labelEx($model,'hiba_eszlelese_iroda_munka_felvetel'); ?>
						<?php echo $form->error($model,'hiba_eszlelese_iroda_munka_felvetel'); ?>
					</div>				
				</td>
			</tr>
			
			<tr>
				<td>iroda munka kiadás</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'ellenorzesi_pontok_iroda_munka_kiadas'); ?>
						<?php echo $form->labelEx($model,'ellenorzesi_pontok_iroda_munka_kiadas'); ?>
						<?php echo $form->error($model,'ellenorzesi_pontok_iroda_munka_kiadas'); ?>
					</div>				
				</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'hiba_eszlelese_iroda_munka_kiadas'); ?>
						<?php echo $form->labelEx($model,'hiba_eszlelese_iroda_munka_kiadas'); ?>
						<?php echo $form->error($model,'hiba_eszlelese_iroda_munka_kiadas'); ?>
					</div>				
				</td>
			</tr>
			
			<tr>
				<td>raktári kiadás</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'ellenorzesi_pontok_raktari_kiadas'); ?>
						<?php echo $form->labelEx($model,'ellenorzesi_pontok_raktari_kiadas'); ?>
						<?php echo $form->error($model,'ellenorzesi_pontok_raktari_kiadas'); ?>
					</div>				
				</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'hiba_eszlelese_raktari_kiadas'); ?>
						<?php echo $form->labelEx($model,'hiba_eszlelese_raktari_kiadas'); ?>
						<?php echo $form->error($model,'hiba_eszlelese_raktari_kiadas'); ?>
					</div>				
				</td>
			</tr>
			
			<tr>
				<td>gépmester átvétel</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'ellenorzesi_pontok_gepmester_atvetel'); ?>
						<?php echo $form->labelEx($model,'ellenorzesi_pontok_gepmester_atvetel'); ?>
						<?php echo $form->error($model,'ellenorzesi_pontok_gepmester_atvetel'); ?>
					</div>
				</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'hiba_eszlelese_gepmester_atvetel'); ?>
						<?php echo $form->labelEx($model,'hiba_eszlelese_gepmester_atvetel'); ?>
						<?php echo $form->error($model,'hiba_eszlelese_gepmester_atvetel'); ?>
					</div>				
				</td>
			</tr>
			
			<tr>
				<td>keresztellenőr</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'ellenorzesi_pontok_keresztellenor'); ?>
						<?php echo $form->labelEx($model,'ellenorzesi_pontok_keresztellenor'); ?>
						<?php echo $form->error($model,'ellenorzesi_pontok_keresztellenor'); ?>
					</div>
				</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'hiba_eszlelese_keresztellenor'); ?>
						<?php echo $form->labelEx($model,'hiba_eszlelese_keresztellenor'); ?>
						<?php echo $form->error($model,'hiba_eszlelese_keresztellenor'); ?>
					</div>				
				</td>
			</tr>
			
			<tr>
				<td>készre jelentés gépmester</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'ellenorzesi_pontok_keszre_jelentes_gepmester'); ?>
						<?php echo $form->labelEx($model,'ellenorzesi_pontok_keszre_jelentes_gepmester'); ?>
						<?php echo $form->error($model,'ellenorzesi_pontok_keszre_jelentes_gepmester'); ?>
					</div>				
				</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'hiba_eszlelese_keszre_jelentes_gepmester'); ?>
						<?php echo $form->labelEx($model,'hiba_eszlelese_keszre_jelentes_gepmester'); ?>
						<?php echo $form->error($model,'hiba_eszlelese_keszre_jelentes_gepmester'); ?>
					</div>				
				</td>
			</tr>
			
			<tr>
				<td>készre jelentés ellenőr</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'ellenorzesi_pontok_keszre_jelentes_ellenor'); ?>
						<?php echo $form->labelEx($model,'ellenorzesi_pontok_keszre_jelentes_ellenor'); ?>
						<?php echo $form->error($model,'ellenorzesi_pontok_keszre_jelentes_ellenor'); ?>
					</div>				
				</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'hiba_eszlelese_keszre_jelentes_ellenor'); ?>
						<?php echo $form->labelEx($model,'hiba_eszlelese_keszre_jelentes_ellenor'); ?>
						<?php echo $form->error($model,'hiba_eszlelese_keszre_jelentes_ellenor'); ?>
					</div>				
				</td>
			</tr>
			
			<tr>
				<td>raktári visszavét</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'ellenorzesi_pontok_raktari_visszavet'); ?>
						<?php echo $form->labelEx($model,'ellenorzesi_pontok_raktari_visszavet'); ?>
						<?php echo $form->error($model,'ellenorzesi_pontok_raktari_visszavet'); ?>
					</div>				
				</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'hiba_eszlelese_raktari_visszavet'); ?>
						<?php echo $form->labelEx($model,'hiba_eszlelese_raktari_visszavet'); ?>
						<?php echo $form->error($model,'hiba_eszlelese_raktari_visszavet'); ?>
					</div>				
				</td>
			</tr>
			
			<tr>
				<td>iroda munka átvétel</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'ellenorzesi_pontok_iroda_munka_atvetel'); ?>
						<?php echo $form->labelEx($model,'ellenorzesi_pontok_iroda_munka_atvetel'); ?>
						<?php echo $form->error($model,'ellenorzesi_pontok_iroda_munka_atvetel'); ?>
					</div>				
				</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'hiba_eszlelese_iroda_munka_atvetel'); ?>
						<?php echo $form->labelEx($model,'hiba_eszlelese_iroda_munka_atvetel'); ?>
						<?php echo $form->error($model,'hiba_eszlelese_iroda_munka_atvetel'); ?>
					</div>				
				</td>
			</tr>
			
			<tr>
				<td>ügyfél</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'ellenorzesi_pontok_ugyfel'); ?>
						<?php echo $form->labelEx($model,'ellenorzesi_pontok_ugyfel'); ?>
						<?php echo $form->error($model,'ellenorzesi_pontok_ugyfel'); ?>
					</div>				
				</td>
				<td>
					<div class="row active">
						<?php echo $form->checkBox($model,'hiba_eszlelese_ugyfel'); ?>
						<?php echo $form->labelEx($model,'hiba_eszlelese_ugyfel'); ?>
						<?php echo $form->error($model,'hiba_eszlelese_ugyfel'); ?>
					</div>				
				</td>
			</tr>
			
		</table>
		
		<div style ='clear:both'></div>
		
	<?php $this->endWidget(); ?>

	<!-- --------------------- Javítási mód ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Javítási mód</strong>",
			'htmlOptions'=>array('style' => 'width: 328px!important; float:left;border: 1px solid #dddddd;border-radius: 3px;box-shadow: 0 1px 0 #f9f9f9 inset; margin-bottom:20px; margin-left:20px'),
		));
	?>
	
		<div class="row active">
			<?php echo $form->checkBox($model,'javitasi_mod_ujra_nyomas'); ?>
			<?php echo $form->labelEx($model,'javitasi_mod_ujra_nyomas'); ?>
			<?php echo $form->error($model,'javitasi_mod_ujra_nyomas'); ?>
		</div>

		<div class="row active">
			<?php echo $form->checkBox($model,'javitasi_mod_felul_nyomas'); ?>
			<?php echo $form->labelEx($model,'javitasi_mod_felul_nyomas'); ?>
			<?php echo $form->error($model,'javitasi_mod_felul_nyomas'); ?>
		</div>

		<div class="row active">
			<?php echo $form->checkBox($model,'javitasi_mod_arcsokkentes'); ?>
			<?php echo $form->labelEx($model,'javitasi_mod_arcsokkentes'); ?>
			<?php echo $form->error($model,'javitasi_mod_arcsokkentes'); ?>
		</div>

		<div class="row active">
			<?php echo $form->checkBox($model,'javitasi_mod_reszleges_ujranyomas'); ?>
			<?php echo $form->labelEx($model,'javitasi_mod_reszleges_ujranyomas'); ?>
			<?php echo $form->error($model,'javitasi_mod_reszleges_ujranyomas'); ?>
		</div>

		<div class="row active">
			<?php echo $form->checkBox($model,'javitasi_mod_kompenzacio'); ?>
			<?php echo $form->labelEx($model,'javitasi_mod_kompenzacio'); ?>
			<?php echo $form->error($model,'javitasi_mod_kompenzacio'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'egyeb'); ?>
			<?php echo $form->textArea($model,'egyeb',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'egyeb'); ?>
		</div>

	<?php $this->endWidget(); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'netto_kar'); ?>
		<?php echo $form->textField($model,'netto_kar'); ?> Ft
		<?php echo $form->error($model,'netto_kar'); ?>
	</div>

	<div class="row">
	
		 <?php $this->widget('zii.widgets.jui.CJuiButton', 
			 array(
				'name'=>'button_print_reklamacio',
				'caption'=>'Nyomtatás',
				'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'style' => 'display:none'),
		 )); ?>
	
		 <?php $this->widget('zii.widgets.jui.CJuiButton', 
			 array(
				'name'=>'button_print_reklamacio',
				'buttonType'=>'link',
				'caption'=>'Nyomtatás',
				'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'style' => 'color: #FFFFFF!important', 'target' => '_blank'),
				'url'=>array('nyomdakonyvReklamaciok/printPdf/id/' . $model -> id),
		 )); ?>
		
	</div>
			
	<?php
		$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
			'model'=>$model,
			'attribute'=>'datum',
			'language' => 'hu',
			'options'=>array(
				'timeFormat' => 'hh:mm:ss',
				'dateFormat'=>'yy-mm-dd',
			),
			'htmlOptions'=>array('style' => 'width:135px; display:none'),
		));
	?>
	
<?php $this->endWidget(); ?>

</div><!-- form -->
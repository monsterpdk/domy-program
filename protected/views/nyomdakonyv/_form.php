<?php
/* @var $this NyomdakonyvController */
/* @var $model Nyomdakonyv */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nyomdakonyv-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<!-- --------------------- Táska adatai ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Táska adatai</strong>",
		));
	?>

		<?php echo $form->hiddenField($model, 'megrendeles_tetel_id'); ?>

		<div class="row">
			<?php echo $form->labelEx($model,'taskaszam'); ?>
			<?php echo Chtml::textField('taskaszam', $model->taskaszam, array('size'=>12, 'maxlength'=>12, 'readonly'=>true)); ?>
			<?php echo $form->error($model,'taskaszam'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'megrendeles_tetel.munka_neve'); ?>
			<?php echo Chtml::textField('munka_neve', $model->megrendeles_tetel->munka_neve, array('size'=>12, 'maxlength'=>127, 'readonly'=>true)); ?>
		</div>

	<?php $this->endWidget();?>
	
	<!-- --------------------- Vevő adatai ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Vevő adatai</strong>",
		));
	?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'megrendeles_tetel.megrendeles.ugyfel.id'); ?>
			<?php echo Chtml::textField('ugyfel_id', $model->megrendeles_tetel->megrendeles->ugyfel->id, array('size'=>12, 'maxlength'=>12, 'readonly'=>true)); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'megrendeles_tetel.megrendeles.ugyfel.cegnev_teljes'); ?>
			<?php echo Chtml::textField('cegnev_teljes', $model->megrendeles_tetel->megrendeles->ugyfel->cegnev_teljes, array('size'=>12, 'maxlength'=>12, 'readonly'=>true)); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'megrendeles_tetel.megrendeles.ugyfel.display_ugyfel_cim'); ?>
			<?php echo Chtml::textField('display_ugyfel_cim', $model->megrendeles_tetel->megrendeles->ugyfel->display_ugyfel_cim, array('size'=>12, 'maxlength'=>12, 'readonly'=>true)); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'megrendeles_tetel.megrendeles.ugyfel.kapcsolattarto_nev'); ?>
			<?php echo Chtml::textField('kapcsolattarto_nev', $model->megrendeles_tetel->megrendeles->ugyfel->kapcsolattarto_nev, array('size'=>12, 'maxlength'=>12, 'readonly'=>true)); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'megrendeles_tetel.megrendeles.ugyfel.kapcsolattarto_telefon'); ?>
			<?php echo Chtml::textField('kapcsolattarto_telefon', $model->megrendeles_tetel->megrendeles->ugyfel->kapcsolattarto_telefon, array('size'=>12, 'maxlength'=>12, 'readonly'=>true)); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'megrendeles_tetel.megrendeles.ugyfel.ceg_fax'); ?>
			<?php echo Chtml::textField('ceg_fax', $model->megrendeles_tetel->megrendeles->ugyfel->ceg_fax, array('size'=>12, 'maxlength'=>12, 'readonly'=>true)); ?>
		</div>
	
	<?php $this->endWidget();?>
	
	
	<!-- --------------------- Termék adatai ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Termék adatai</strong>",
		));
	?>

		<div class="row">
			<?php echo $form->labelEx($model,'megrendeles_tetel.termek.nev'); ?>
			<?php echo Chtml::textField('termek_nev', $model->megrendeles_tetel->termek->displayTermekTeljesNev, array('size'=>12, 'maxlength'=>12, 'readonly'=>true, 'style'=>'width:575px')); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'megrendeles_tetel.displayTermekSzinekSzama'); ?>
			<?php echo Chtml::textField('displayTermekSzinekSzama', $model->megrendeles_tetel->displayTermekSzinekSzama, array('size'=>12, 'maxlength'=>12, 'readonly'=>true, 'style'=>'width:50px')); ?>
		</div>

		<div class="row checkbox_group_horizontal">
			<?php echo $form->checkBox($model,'szin_c'); ?>
			<?php echo $form->labelEx($model,'szin_c'); ?>
			<?php echo $form->error($model,'szin_c'); ?>
			
			<?php echo $form->checkBox($model,'szin_m'); ?>
			<?php echo $form->labelEx($model,'szin_m'); ?>
			<?php echo $form->error($model,'szin_m'); ?>

			<?php echo $form->checkBox($model,'szin_y'); ?>
			<?php echo $form->labelEx($model,'szin_y'); ?>
			<?php echo $form->error($model,'szin_y'); ?>

			<?php echo $form->checkBox($model,'szin_k'); ?>
			<?php echo $form->labelEx($model,'szin_k'); ?>
			<?php echo $form->error($model,'szin_k'); ?>
			
			<?php echo $form->checkBox($model,'szin_mutaciok'); ?>
			<?php echo $form->labelEx($model,'szin_mutaciok'); ?>
			<?php echo $form->error($model,'szin_mutaciok'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'pantone'); ?>
			<?php echo $form->textField($model,'pantone',array('size'=>10, 'maxlength'=>255, 'readonly'=>true, 'style'=>'width:575px')); ?>
		</div>
		
	<?php $this->endWidget();?>
	
	
	<!-- --------------------- Nyomás adatai ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Nyomás adatai</strong>",
		));
	?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'nyomas_tipus'); ?>
			<?php echo DHtml::enumDropDownList($model, 'nyomas_tipus'); ?>
			<?php echo $form->error($model,'nyomas_tipus'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'utasitas_ctp_nek'); ?>
			<?php echo $form->textArea($model,'utasitas_ctp_nek',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'utasitas_ctp_nek'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'utasitas_gepmesternek'); ?>
			<?php echo $form->textArea($model,'utasitas_gepmesternek',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'utasitas_gepmesternek'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'kiszallitasi_informaciok'); ?>
			<?php echo $form->textArea($model,'kiszallitasi_informaciok',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'kiszallitasi_informaciok'); ?>
		</div>
	
	<?php $this->endWidget();?>
	
	
	<!-- --------------------- Dátumok ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Dátum adatok</strong>",
		));
	?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'megrendeles_tetel.megrendeles.rendeles_idopont'); ?>
			<?php
				echo Chtml::textField('munka_neve', $model->megrendeles_tetel->megrendeles->rendeles_idopont, array('size'=>12, 'maxlength'=>127, 'readonly'=>true));
			?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'munka_beerkezes_datum'); ?>
				
				<?php
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'munka_beerkezes_datum',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						)
					));
				?>
				
			<?php echo $form->error($model,'munka_beerkezes_datum'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'hatarido'); ?>
				
				<?php
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'hatarido',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						)
					));
				?>
				
			<?php echo $form->error($model,'hatarido'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'taska_kiadasi_datum'); ?>
				
				<?php
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'taska_kiadasi_datum',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						)
					));
				?>
				
			<?php echo $form->error($model,'taska_kiadasi_datum'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'elkeszulesi_datum'); ?>
				
				<?php
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'elkeszulesi_datum',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						)
					));
				?>
				
			<?php echo $form->error($model,'elkeszulesi_datum'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'ertesitesi_datum'); ?>
				
				<?php
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'ertesitesi_datum',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						)
					));
				?>
				
			<?php echo $form->error($model,'ertesitesi_datum'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'szallitolevel_datum'); ?>
				
				<?php
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'szallitolevel_datum',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						)
					));
				?>
				
			<?php echo $form->error($model,'szallitolevel_datum'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'szallitolevel_sorszam'); ?>
			<?php echo $form->textField($model,'szallitolevel_sorszam',array('size'=>30,'maxlength'=>30)); ?>
			<?php echo $form->error($model,'szallitolevel_sorszam'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'szamla_datum'); ?>
				
				<?php
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'szamla_datum',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						)
					));
				?>
				
			<?php echo $form->error($model,'szamla_datum'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'szamla_sorszam'); ?>
			<?php echo $form->textField($model,'szamla_sorszam',array('size'=>30,'maxlength'=>30)); ?>
			<?php echo $form->error($model,'szamla_sorszam'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'raktarbol_kiadva_datum'); ?>
				
				<?php
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'raktarbol_kiadva_datum',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						)
					));
				?>
				
			<?php echo $form->error($model,'raktarbol_kiadva_datum'); ?>
		</div>
	
	<?php $this->endWidget();?>
	
	
	<div class="row">
		<?php echo $form->labelEx($model,'hatarido'); ?>
		<?php echo $form->textField($model,'hatarido'); ?>
		<?php echo $form->error($model,'hatarido'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pantone'); ?>
		<?php echo $form->textField($model,'pantone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'pantone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'munka_beerkezes_datum'); ?>
		<?php echo $form->textField($model,'munka_beerkezes_datum'); ?>
		<?php echo $form->error($model,'munka_beerkezes_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'taska_kiadasi_datum'); ?>
		<?php echo $form->textField($model,'taska_kiadasi_datum'); ?>
		<?php echo $form->error($model,'taska_kiadasi_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'elkeszulesi_datum'); ?>
		<?php echo $form->textField($model,'elkeszulesi_datum'); ?>
		<?php echo $form->error($model,'elkeszulesi_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ertesitesi_datum'); ?>
		<?php echo $form->textField($model,'ertesitesi_datum'); ?>
		<?php echo $form->error($model,'ertesitesi_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szallitolevel_sorszam'); ?>
		<?php echo $form->textField($model,'szallitolevel_sorszam',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'szallitolevel_sorszam'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szallitolevel_datum'); ?>
		<?php echo $form->textField($model,'szallitolevel_datum'); ?>
		<?php echo $form->error($model,'szallitolevel_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szamla_sorszam'); ?>
		<?php echo $form->textField($model,'szamla_sorszam',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'szamla_sorszam'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szamla_datum'); ?>
		<?php echo $form->textField($model,'szamla_datum'); ?>
		<?php echo $form->error($model,'szamla_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sos'); ?>
		<?php echo $form->textField($model,'sos'); ?>
		<?php echo $form->error($model,'sos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szin_c'); ?>
		<?php echo $form->textField($model,'szin_c'); ?>
		<?php echo $form->error($model,'szin_c'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szin_m'); ?>
		<?php echo $form->textField($model,'szin_m'); ?>
		<?php echo $form->error($model,'szin_m'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szin_y'); ?>
		<?php echo $form->textField($model,'szin_y'); ?>
		<?php echo $form->error($model,'szin_y'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szin_k'); ?>
		<?php echo $form->textField($model,'szin_k'); ?>
		<?php echo $form->error($model,'szin_k'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szin_mutaciok'); ?>
		<?php echo $form->textField($model,'szin_mutaciok'); ?>
		<?php echo $form->error($model,'szin_mutaciok'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kifuto_bal'); ?>
		<?php echo $form->textField($model,'kifuto_bal'); ?>
		<?php echo $form->error($model,'kifuto_bal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kifuto_fent'); ?>
		<?php echo $form->textField($model,'kifuto_fent'); ?>
		<?php echo $form->error($model,'kifuto_fent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kifuto_jobb'); ?>
		<?php echo $form->textField($model,'kifuto_jobb'); ?>
		<?php echo $form->error($model,'kifuto_jobb'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kifuto_lent'); ?>
		<?php echo $form->textField($model,'kifuto_lent'); ?>
		<?php echo $form->error($model,'kifuto_lent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'forditott_levezetes'); ?>
		<?php echo $form->textField($model,'forditott_levezetes'); ?>
		<?php echo $form->error($model,'forditott_levezetes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hossziranyu_levezetes'); ?>
		<?php echo $form->textField($model,'hossziranyu_levezetes'); ?>
		<?php echo $form->error($model,'hossziranyu_levezetes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nyomas_tipus'); ?>
		<?php echo $form->textField($model,'nyomas_tipus',array('size'=>29,'maxlength'=>29)); ?>
		<?php echo $form->error($model,'nyomas_tipus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'utasitas_ctp_nek'); ?>
		<?php echo $form->textField($model,'utasitas_ctp_nek',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'utasitas_ctp_nek'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'utasitas_gepmesternek'); ?>
		<?php echo $form->textField($model,'utasitas_gepmesternek',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'utasitas_gepmesternek'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kiszallitasi_informaciok'); ?>
		<?php echo $form->textField($model,'kiszallitasi_informaciok',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'kiszallitasi_informaciok'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gep_id'); ?>
		<?php echo $form->textField($model,'gep_id'); ?>
		<?php echo $form->error($model,'gep_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kifutos'); ?>
		<?php echo $form->textField($model,'kifutos'); ?>
		<?php echo $form->error($model,'kifutos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fekete_flekkben_szin_javitando'); ?>
		<?php echo $form->textField($model,'fekete_flekkben_szin_javitando'); ?>
		<?php echo $form->error($model,'fekete_flekkben_szin_javitando'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'magas_szinterheles_nagy_feluleten'); ?>
		<?php echo $form->textField($model,'magas_szinterheles_nagy_feluleten'); ?>
		<?php echo $form->error($model,'magas_szinterheles_nagy_feluleten'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'magas_szinterheles_szovegben'); ?>
		<?php echo $form->textField($model,'magas_szinterheles_szovegben'); ?>
		<?php echo $form->error($model,'magas_szinterheles_szovegben'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ofszet_festek'); ?>
		<?php echo $form->textField($model,'ofszet_festek'); ?>
		<?php echo $form->error($model,'ofszet_festek'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nyomas_minta_szerint'); ?>
		<?php echo $form->textField($model,'nyomas_minta_szerint'); ?>
		<?php echo $form->error($model,'nyomas_minta_szerint'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nyomas_vagojel_szerint'); ?>
		<?php echo $form->textField($model,'nyomas_vagojel_szerint'); ?>
		<?php echo $form->error($model,'nyomas_vagojel_szerint'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nyomas_specialis'); ?>
		<?php echo $form->textField($model,'nyomas_specialis',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'nyomas_specialis'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gepindulasra_jon_ugyfel'); ?>
		<?php echo $form->textField($model,'gepindulasra_jon_ugyfel'); ?>
		<?php echo $form->error($model,'gepindulasra_jon_ugyfel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ctp_nek_atadas_datum'); ?>
		<?php echo $form->textField($model,'ctp_nek_atadas_datum'); ?>
		<?php echo $form->error($model,'ctp_nek_atadas_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ctp_kezdes_datum'); ?>
		<?php echo $form->textField($model,'ctp_kezdes_datum'); ?>
		<?php echo $form->error($model,'ctp_kezdes_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ctp_belenyulasok'); ?>
		<?php echo $form->textField($model,'ctp_belenyulasok',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'ctp_belenyulasok'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ctp_hibalista'); ?>
		<?php echo $form->textField($model,'ctp_hibalista',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'ctp_hibalista'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jovahagyas'); ?>
		<?php echo $form->textField($model,'jovahagyas',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'jovahagyas'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ctp_kesz_datum'); ?>
		<?php echo $form->textField($model,'ctp_kesz_datum'); ?>
		<?php echo $form->error($model,'ctp_kesz_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nyomas_kezdes_datum'); ?>
		<?php echo $form->textField($model,'nyomas_kezdes_datum'); ?>
		<?php echo $form->error($model,'nyomas_kezdes_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'raktarbol_kiadva_datum'); ?>
		<?php echo $form->textField($model,'raktarbol_kiadva_datum'); ?>
		<?php echo $form->error($model,'raktarbol_kiadva_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kep_file_nev'); ?>
		<?php echo $form->textField($model,'kep_file_nev',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'kep_file_nev'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sztornozva'); ?>
		<?php echo $form->textField($model,'sztornozva'); ?>
		<?php echo $form->error($model,'sztornozva'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'torolt'); ?>
		<?php echo $form->textField($model,'torolt'); ?>
		<?php echo $form->error($model,'torolt'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
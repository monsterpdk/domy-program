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
	'htmlOptions' => array('enctype' => 'multipart/form-data',),
)); ?>

	<?php echo $form->errorSummary($model); ?>

<div class = 'clear'>
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
			<?php echo Chtml::textField('munka_neve', mb_strtoupper($model->megrendeles_tetel->munka_neve, "UTF-8"), array('size'=>12, 'maxlength'=>127, 'readonly'=>true)); ?>
		</div>

		<div class="row checkbox_group_horizontal">
			<?php echo $form->checkBox($model,'ctp'); ?>
			<?php echo $form->labelEx($model,'ctp'); ?>
			<?php echo $form->error($model,'ctp'); ?>

			<?php echo $form->checkBox($model,'sos'); ?>
			<?php echo $form->labelEx($model,'sos'); ?>
			<?php echo $form->error($model,'sos'); ?>
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
</div>	


<div class = 'clear'>
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
			<strong>Előoldal:</strong>
			
			<?php echo $form->checkBox($model,'szin_c_elo'); ?>
			<?php echo $form->labelEx($model,'szin_c_elo'); ?>
			<?php echo $form->error($model,'szin_c_elo'); ?>
			
			<?php echo $form->checkBox($model,'szin_m_elo'); ?>
			<?php echo $form->labelEx($model,'szin_m_elo'); ?>
			<?php echo $form->error($model,'szin_m_elo'); ?>

			<?php echo $form->checkBox($model,'szin_y_elo'); ?>
			<?php echo $form->labelEx($model,'szin_y_elo'); ?>
			<?php echo $form->error($model,'szin_y_elo'); ?>

			<?php echo $form->checkBox($model,'szin_k_elo'); ?>
			<?php echo $form->labelEx($model,'szin_k_elo'); ?>
			<?php echo $form->error($model,'szin_k_elo'); ?>
		</div>

		<div class="row checkbox_group_horizontal">
			<strong>Hátoldal:</strong>
		
			<?php echo $form->checkBox($model,'szin_c_hat'); ?>
			<?php echo $form->labelEx($model,'szin_c_hat'); ?>
			<?php echo $form->error($model,'szin_c_hat'); ?>
			
			<?php echo $form->checkBox($model,'szin_m_hat'); ?>
			<?php echo $form->labelEx($model,'szin_m_hat'); ?>
			<?php echo $form->error($model,'szin_m_hat'); ?>

			<?php echo $form->checkBox($model,'szin_y_hat'); ?>
			<?php echo $form->labelEx($model,'szin_y_hat'); ?>
			<?php echo $form->error($model,'szin_y_hat'); ?>

			<?php echo $form->checkBox($model,'szin_k_hat'); ?>
			<?php echo $form->labelEx($model,'szin_k_hat'); ?>
			<?php echo $form->error($model,'szin_k_hat'); ?>
		</div>

		<div class="row checkbox">
			<?php echo $form->checkBox($model,'szin_mutaciok'); ?>
			<?php echo $form->labelEx($model,'szin_mutaciok'); ?>
			<?php echo $form->error($model,'szin_mutaciok'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'megrendeles_tetel.darabszam'); ?>
			<?php echo Chtml::textField('darabszam', $model->megrendeles_tetel->darabszam, array('size'=>12, 'maxlength'=>12, 'readonly'=>true, 'style'=>'width:170px')); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'megrendeles_tetel.netto_darabar'); ?>
			<?php echo Chtml::textField('netto_darabar', $model->megrendeles_tetel->netto_darabar, array('size'=>12, 'maxlength'=>12, 'readonly'=>true, 'style'=>'width:170px')); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'Nettó ár'); ?>
			<?php echo Chtml::textField('netto_ar', $model->megrendeles_tetel->darabszam * $model->megrendeles_tetel->netto_darabar, array('size'=>12, 'maxlength'=>12, 'readonly'=>true, 'style'=>'width:170px')); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'megrendeles_tetel.termek.kategoria_tipus'); ?>
			<?php echo Chtml::textField('kategoria_tipus', $model->megrendeles_tetel->termek->kategoria_tipus, array('size'=>12, 'maxlength'=>12, 'readonly'=>true, 'style'=>'width:170px')); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'megrendeles_tetel.termek.gyarto.cegnev'); ?>
			<?php echo Chtml::textField('cegnev', $model->megrendeles_tetel->termek->gyarto->cegnev, array('size'=>12, 'maxlength'=>12, 'readonly'=>true, 'style'=>'width:170px')); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'megrendeles_tetel.termek.ksh_kod'); ?>
			<?php echo Chtml::textField('ksh_kod', $model->megrendeles_tetel->termek->ksh_kod, array('size'=>12, 'maxlength'=>12, 'readonly'=>true, 'style'=>'width:170px')); ?>
		</div>

		<div class="row checkbox_group_horizontal">
			<?php echo $form->checkBox($model,'forditott_levezetes'); ?>
			<?php echo $form->labelEx($model,'forditott_levezetes'); ?>
			<?php echo $form->error($model,'forditott_levezetes'); ?>
			
			<?php echo $form->checkBox($model,'hossziranyu_levezetes'); ?>
			<?php echo $form->labelEx($model,'hossziranyu_levezetes'); ?>
			<?php echo $form->error($model,'hossziranyu_levezetes'); ?>
		</div>

		<div class='row'>
			<table>
				<tr>
					<td></td>
					<td align = 'center'> <?php echo $form->checkBox($model,'kifuto_fent', array('onclick'=>'if (($("#Nyomdakonyv_kifuto_fent").is(":checked"))) $("#Nyomdakonyv_forditott_levezetes").prop("checked", true );')); ?> </td>
					<td></td>
				</tr>
				<tr>
					<td> <?php echo $form->checkBox($model,'kifuto_bal'); ?> </td>
						<td>
							<?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/boritek_kifuto.jpg', "", array()); ?>
						</td>
					<td> <?php echo $form->checkBox($model,'kifuto_jobb'); ?> </td>
				</tr>
				<tr>
					<td></td>
					<td align = 'center'> <?php echo $form->checkBox($model,'kifuto_lent'); ?> </td>
					<td></td>
				</tr>
			</table>
		</div>
		
	<?php $this->endWidget();?>
	
	
	<!-- --------------------- Nyomás adatai ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Nyomás adatai</strong>",
		));
	?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'gep_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'gep_id',
					CHtml::listData(Nyomdagepek::model()->findAll(array("condition"=>"torolt=0")), 'id', 'gepnev')
				); ?>
				
			<?php echo $form->error($model,'gep_id'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'max_fordulat'); ?>
			<?php echo $form->textField($model, 'max_fordulat'); ?>
			<?php echo $form->error($model,'max_fordulat'); ?>
		</div>

		<div class='clear'>
			<div class="row">
				<?php echo $form->labelEx($model,'nyomas_tipus'); ?>
				<?php echo DHtml::enumDropDownList($model, 'nyomas_tipus'); ?>
				<?php echo $form->error($model,'nyomas_tipus'); ?>
			</div>
		
			<div class="row">
				<?php echo $form->labelEx($model,'munkatipus_id'); ?>
				<?php
					$darabszam = $model->megrendeles_tetel->darabszam;
					$szinek_szama1 = $model->megrendeles_tetel->szinek_szama1;
					$szinek_szama2 = $model->megrendeles_tetel->szinek_szama2;		
					$termek_id = $model->megrendeles_tetel->termek_id;

					$munkatipusok = Utils::getAllMunkatipusToNyomdakonyv ($darabszam, $szinek_szama1, $szinek_szama2, $termek_id );

					echo $form->dropDownList($model, 'munkatipus_id', CHtml::listData($munkatipusok ,'id','munkatipus_nev'));
				?>
				<?php echo $form->error($model,'munkatipus_id'); ?>
				
				<br />

				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_norma_szamitasa',
						'caption'=>'Normaszámítás',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {normaSzamitas();}'),
						'htmlOptions'=>array('class'=>'bt btn-primary search-button', 'style'=>'margin-bottom:10px', 'target' => '_blank',),
					));
				?>

			</div>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'display_normaido'); ?>
			<?php echo Chtml::textField('normaido', '', array('size'=>12, 'maxlength'=>127, 'readonly'=>true)); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'display_normaar'); ?>
			<?php echo Chtml::textField('normaar', '', array('size'=>12, 'maxlength'=>127, 'readonly'=>true)); ?>
		</div>
		
		<div class='clear'>
		
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
		</div>
		
		<div class = "row">
			<?php echo $form->labelEx($model,'kiszallitasi_informaciok'); ?>
			<?php echo $form->textArea($model,'kiszallitasi_informaciok',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'kiszallitasi_informaciok'); ?>
		</div>
	
	<?php $this->endWidget();?>
</div>	


<div class = 'clear'>
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


	<!-- --------------------- Egyéb nyomási adatok ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Egyéb nyomási adatok</strong>",
		));
	?>

		<div class="row">
			<?php echo $form->labelEx($model,'erkezett'); ?>
			<?php echo DHtml::enumDropDownList($model, 'erkezett'); ?>
			<?php echo $form->error($model,'erkezett'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'file_beerkezett'); ?>
				
				<?php
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'file_beerkezett',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						)
					));
				?>
				
			<?php echo $form->error($model,'file_beerkezett'); ?>
		</div>
	
		<div class="row active">
			<?php echo $form->checkBox($model,'kifutos'); ?>
			<?php echo $form->labelEx($model,'kifutos'); ?>
			<?php echo $form->error($model,'kifutos'); ?>
		</div>
		
		<div class="row active">
			<?php echo $form->checkBox($model,'fekete_flekkben_szin_javitando'); ?>
			<?php echo $form->labelEx($model,'fekete_flekkben_szin_javitando'); ?>
			<?php echo $form->error($model,'fekete_flekkben_szin_javitando'); ?>
		</div>
		
		<div class="row active">
			<?php echo $form->checkBox($model,'magas_szinterheles_nagy_feluleten'); ?>
			<?php echo $form->labelEx($model,'magas_szinterheles_nagy_feluleten'); ?>
			<?php echo $form->error($model,'magas_szinterheles_nagy_feluleten'); ?>
		</div>
		
		<div class="row active">
			<?php echo $form->checkBox($model,'magas_szinterheles_szovegben'); ?>
			<?php echo $form->labelEx($model,'magas_szinterheles_szovegben'); ?>
			<?php echo $form->error($model,'magas_szinterheles_szovegben'); ?>
		</div>
		
		<div class="row active">
			<?php echo $form->checkBox($model,'ofszet_festek'); ?>
			<?php echo $form->labelEx($model,'ofszet_festek'); ?>
			<?php echo $form->error($model,'ofszet_festek'); ?>
		</div>
		
		<div class="row active">
			<?php echo $form->checkBox($model,'nyomas_minta_szerint'); ?>
			<?php echo $form->labelEx($model,'nyomas_minta_szerint'); ?>
			<?php echo $form->error($model,'nyomas_minta_szerint'); ?>
		</div>
		
		<div class="row active">
			<?php echo $form->checkBox($model,'nyomas_vagojel_szerint'); ?>
			<?php echo $form->labelEx($model,'nyomas_vagojel_szerint'); ?>
			<?php echo $form->error($model,'nyomas_vagojel_szerint'); ?>
		</div>

		<div class="row active">
			<?php echo $form->checkBox($model,'nyomas_domy_szerint'); ?>
			<?php echo $form->labelEx($model,'nyomas_domy_szerint'); ?>
			<?php echo $form->error($model,'nyomas_domy_szerint'); ?>
		</div>

		<div class="row active">
			<?php echo $form->checkBox($model,'gepindulasra_jon_ugyfel'); ?>
			<?php echo $form->labelEx($model,'gepindulasra_jon_ugyfel'); ?>
			<?php echo $form->error($model,'gepindulasra_jon_ugyfel'); ?>
		</div>

		<div class="row active">
			<?php echo $form->labelEx($model,'nyomas_specialis'); ?>
			<?php echo $form->textArea($model,'nyomas_specialis',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'nyomas_specialis'); ?>
		</div>
		
	<?php $this->endWidget();?>
</div>

	
<div class = 'clear'>
	<!-- --------------------- Vezérlőpult ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Vezérlőpult</strong>",
		));
	?>

		<div class="row">
			<?php echo $form->labelEx($model,'kep_file_nev'); ?>
			<?php echo CHtml::activeFileField($model, 'kep_file_nev'); ?>
			<?php echo $form->error($model,'kep_file_nev'); ?>
		</div>
		
		<?php if ($model -> isNewRecord != '1' && !empty($model -> kep_file_nev)) { ?>
			<div class="row">
				 <?php echo CHtml::image(Yii::app()->request->baseUrl . '/uploads/nyomdakonyv/' . $model->id . '/' . $model->kep_file_nev, "Feltöltött kép", array("width" => 200)); ?>
			</div>
		<?php } ?>

		<?php if ($model -> sztornozva == 1): ?>
			<div class="row">
				<?php echo $form->labelEx($model,'sztornozas_oka'); ?>
				<?php echo $form->textArea($model,'sztornozas_oka',array('size'=>60,'maxlength'=>255, 'readonly'=>true)); ?>
				<?php echo $form->error($model,'sztornozas_oka'); ?>
			</div>
		<?php endif; ?>
		
		<?php if (Yii::app()->user->checkAccess('Admin')): ?>
			<div class="row active">
				<?php echo $form->checkBox($model,'torolt'); ?>
				<?php echo $form->label($model,'torolt'); ?>
				<?php echo $form->error($model,'torolt'); ?>
			</div>
		<?php endif; ?>

		<div class="row active">
			<input id = "sztornozva_dsp" type="checkbox" value="<?php echo $model->sztornozva; ?>" <?php if ($model->sztornozva == 1) echo " checked "; ?> name="sztornozva_dsp" disabled >
			<?php echo $form->label($model,'sztornozva'); ?>
			<?php echo $form->error($model,'sztornozva'); ?>
		</div>

		<div class="row buttons">
			<?php echo CHtml::submitButton('Mentés', array('title'=>'OK')); ?>
			<?php echo CHtml::button('Vissza', array('submit' => Yii::app()->request->urlReferrer)); ?>
		</div>

	<?php $this->endWidget();?>
	
	
	<!-- --------------------- CTP adatok ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>CTP adatok</strong>",
		));
	?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'ctp_nek_atadas_datum'); ?>
				
				<?php
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'ctp_nek_atadas_datum',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						)
					));
				?>
				
			<?php echo $form->error($model,'ctp_nek_atadas_datum'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'ctp_kezdes_datum'); ?>
				
				<?php
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'ctp_kezdes_datum',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						)
					));
				?>
				
			<?php echo $form->error($model,'ctp_kezdes_datum'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'ctp_belenyulasok'); ?>
			<?php echo $form->textArea($model,'ctp_belenyulasok',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'ctp_belenyulasok'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'ctp_hibalista'); ?>
			<?php echo $form->textArea($model,'ctp_hibalista',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'ctp_hibalista'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'jovahagyas'); ?>
			<?php echo DHtml::enumDropDownList($model, 'jovahagyas'); ?>
			<?php echo $form->error($model,'jovahagyas'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'ctp_kesz_datum'); ?>
				
				<?php
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'ctp_kesz_datum',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						)
					));
				?>
				
			<?php echo $form->error($model,'ctp_kesz_datum'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'nyomas_kezdes_datum'); ?>
				
				<?php
					$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
						'model'=>$model,
						'attribute'=>'nyomas_kezdes_datum',
						'language' => 'hu',
						'options'=>array(
							'timeFormat' => 'hh:mm:ss',
							'dateFormat'=>'yy-mm-dd',
						)
					));
				?>
				
			<?php echo $form->error($model,'nyomas_kezdes_datum'); ?>
		</div>
		
		<div class="row active">
			<?php echo $form->checkBox($model,'nyomhato'); ?>
			<?php echo $form->labelEx($model,'nyomhato'); ?>
			<?php echo $form->error($model,'nyomhato'); ?>
		</div>

	<?php $this->endWidget();?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	function normaSzamitas () {
		var termek_id = $('#Nyomdakonyv_megrendeles_tetel_id').val();
		var gep_id = $('#Nyomdakonyv_gep_id').val();
		var munkatipus_id = $('#Nyomdakonyv_munkatipus_id').val();
		var max_fordulatszam = $('#Nyomdakonyv_max_fordulat').val();

		if (gep_id != null && munkatipus_id != null) {
			<?php echo CHtml::ajax(array(
				'url'=> "js:'/index.php/nyomdakonyv/normaSzamitas/termekId/' + termek_id + '/gepId/' + gep_id + '/munkatipusId/' + munkatipus_id + '/maxFordulat/' + max_fordulatszam",
				'data'=> "js:$(this).serialize()",
				'type'=>'post',
				'id' => 'norma-szamitas-'.uniqid(),
				'dataType'=>'json',
				'success'=>"function(data)
				{
					if (data.status == 'failure')
					{
						$('#normaar').val('0');
						$('#normaido').val('0');
					}
					else
					{
						$('#normaar').val(data.normaar);
						$('#normaido').val(data.normaido);
					}

				} ",
			))?>;
		} else {
			alert ("A gép és munkatípus kiválasztása kötelező!");
		}
	}
</script>

<script>

$( document ).ready(function() {
	$("#button_norma_szamitasa").attr('disabled', 'disabled');
	
	$('#Nyomdakonyv_gep_id').on('change', function() {
		checkNormaszamitasState ();
	});

	// egyelőre ugyanaz, mint a fenti
	$('#Nyomdakonyv_munkatipus_id').on('change', function() {
		checkNormaszamitasState ();
	});
	
	function checkNormaszamitasState () {
		var bState = ( $('#Nyomdakonyv_gep_id').val() == null || $('#Nyomdakonyv_munkatipus_id').val() == null);

		if (bState) {
			$("#button_norma_szamitasa").attr('disabled', 'disabled');
		} else {
			$('#button_norma_szamitasa').removeAttr('disabled');
		}
	}
	
	checkNormaszamitasState ();
});

</script>
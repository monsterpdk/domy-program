<?php
/* @var $this NyomdakonyvController */
/* @var $model Nyomdakonyv */
/* @var $form CActiveForm */
?>

<?php 
	use yii\helpers\Url;
	
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/fancybox/jquery.fancybox-1.3.4.css');

	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/css/fancybox/jquery.fancybox-1.3.4.js');
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

		<?php echo $form->hiddenField($model, 'id'); ?>
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
			<?php echo $form->checkBox($model,'ctp',array('onclick'=>'if (($("#Nyomdakonyv_ctp").is(":checked"))) $("#Nyomdakonyv_film").prop("checked", false );')); ?>
			<?php echo $form->labelEx($model,'ctp'); ?>
			<?php echo $form->error($model,'ctp'); ?>

			<?php echo $form->checkBox($model,'film',array('onclick'=>'if (($("#Nyomdakonyv_film").is(":checked"))) $("#Nyomdakonyv_ctp").prop("checked", false );')); ?>
			<?php echo $form->labelEx($model,'film'); ?>
			<?php echo $form->error($model,'film'); ?>

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
			<?php echo $form->labelEx($model,'megrendeles_tetel.megrendeles.ugyfel.cegnev'); ?>
			<?php echo Chtml::textField('cegnev', $model->megrendeles_tetel->megrendeles->ugyfel->cegnev, array('size'=>12, 'maxlength'=>12, 'readonly'=>true)); ?>
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
			<?php echo $form->checkBox($model,'szin_mutaciok', array('onclick'=>'$("#Nyomdakonyv_szin_mutaciok_szam").prop("disabled", !$("#Nyomdakonyv_szin_mutaciok").is(":checked") );')); ?>
			<?php echo $form->labelEx($model,'szin_mutaciok'); ?>
			<?php echo $form->error($model,'szin_mutaciok'); ?>
		</div>

		<div class='row'>
			<?php echo $form->labelEx($model,'szin_mutaciok_szam'); ?>
			<?php echo $form->textField($model,'szin_mutaciok_szam', array('style'=>'width:45px')); ?>
			<?php echo $form->error($model,'szin_mutaciok_szam'); ?>
		</div>

		<?php $this->widget('application.extensions.multicomplete.MultiComplete', array(
			  'model'=>$model,
			  'attribute'=>'szin_pantone',
			  'splitter'=>',',
			  'sourceUrl'=>$this->createUrl('nyomdakonyv/searchPantones'),
			  'options'=>array(
					  'minLength'=>'1',
			  ),
			  'htmlOptions'=>array(
					  'style'=>'width:575px',
			  ),
			));
		?>
			
		<div class = 'clear'>
			<div class="row">
				<?php echo $form->labelEx($model,'megrendeles_tetel.darabszam'); ?>
				<?php echo Chtml::textField('darabszam', $model->megrendeles_tetel->darabszam, array('size'=>12, 'maxlength'=>12, 'readonly'=>true, 'style'=>'width:170px')); ?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($model,'megrendeles_tetel.netto_darabar'); ?>
				<?php echo Chtml::textField('netto_darabar', $model->megrendeles_tetel->netto_darabar, array('size'=>12, 'maxlength'=>12, 'readonly'=>true, 'style'=>'width:170px')); ?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($model,'megrendeles_tetel.netto_ar'); ?>
				<?php echo Chtml::textField('netto_ar', $model->megrendeles_tetel->darabszam * $model->megrendeles_tetel->netto_darabar, array('size'=>12, 'maxlength'=>12, 'readonly'=>true, 'style'=>'width:170px')); ?>
			</div>
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
			
			<br />
			
			<?php
				$this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'button_reklamacio',
					'caption'=>'Reklamáció',
					'buttonType'=>'link',
					'onclick'=>new CJavaScriptExpression('function() { openReklamacio(); }'),
					'htmlOptions'=>array('class'=>'btn btn-primary search-button', 'style'=>'margin-top:10px', 'target' => '_blank',),
				));
			?>

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
						'htmlOptions'=>array('class'=>'btn btn-primary search-button', 'style'=>'margin-bottom:10px', 'target' => '_blank',),
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
				<?php echo $form->labelEx($model,'utannyomas_valtoztatassal'); ?>
				<?php echo $form->textArea($model,'utannyomas_valtoztatassal',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'utannyomas_valtoztatassal'); ?>
			</div>
		
			<div class="row">
				<?php echo $form->labelEx($model,'utasitas_ctp_nek'); ?>
				<?php echo $form->textArea($model,'utasitas_ctp_nek',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'utasitas_ctp_nek'); ?>
			</div>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'utasitas_gepmesternek'); ?>
			<?php echo $form->textArea($model,'utasitas_gepmesternek',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'utasitas_gepmesternek'); ?>
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
						),
						'htmlOptions'=>array('style' => 'width:135px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_munka_beerkezes_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Nyomdakonyv_munka_beerkezes_datum").datetimepicker("setDate", (new Date()) );
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:65px', 'target' => '_blank'),
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
						),
						'htmlOptions'=>array('style' => 'width:135px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_hatarido',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Nyomdakonyv_hatarido").datetimepicker("setDate", (new Date()) );
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:65px', 'target' => '_blank'),
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
						),
						'htmlOptions'=>array('style' => 'width:135px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_taska_kiadasi_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Nyomdakonyv_taska_kiadasi_datum").datetimepicker("setDate", (new Date()) );
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:65px', 'target' => '_blank'),
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
						),
						'htmlOptions'=>array('style' => 'width:135px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_elkeszulesi_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Nyomdakonyv_elkeszulesi_datum").datetimepicker("setDate", (new Date()) );
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:65px', 'target' => '_blank'),
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
						),
						'htmlOptions'=>array('style' => 'width:135px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_ertesitesi_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Nyomdakonyv_ertesitesi_datum").datetimepicker("setDate", (new Date()) );
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:65px', 'target' => '_blank'),
					));
				?>
				
			<?php echo $form->error($model,'ertesitesi_datum'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'dsp_szallitolevel_datum'); ?>
			<?php echo $form->textField($model,'dsp_szallitolevel_datum',array('size'=>30,'maxlength'=>255, 'readonly'=>true)); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'dsp_szallitolevel_sorszam'); ?>
			<?php echo $form->textField($model,'dsp_szallitolevel_sorszam',array('size'=>30,'maxlength'=>255, 'readonly'=>true)); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'dsp_szamla_datum'); ?>
			<?php echo $form->textField($model,'dsp_szamla_datum',array('size'=>30,'maxlength'=>30, 'readonly'=>true)); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'dsp_szamla_sorszam'); ?>
			<?php echo $form->textField($model,'dsp_szamla_sorszam',array('size'=>30,'maxlength'=>30, 'readonly'=>true)); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'dsp_proforma_datum'); ?>
			<?php echo $form->textField($model,'dsp_proforma_datum',array('size'=>30,'maxlength'=>30, 'readonly'=>true)); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'dsp_proforma_sorszam'); ?>
			<?php echo $form->textField($model,'dsp_proforma_sorszam',array('size'=>30,'maxlength'=>30, 'readonly'=>true)); ?>
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
						),
						'htmlOptions'=>array('style' => 'width:135px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_raktarbol_kiadva_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Nyomdakonyv_raktarbol_kiadva_datum").datetimepicker("setDate", (new Date()) );
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:65px', 'target' => '_blank'),
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
						),
						'htmlOptions'=>array('style' => 'width:135px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_file_beerkezett',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Nyomdakonyv_file_beerkezett").datetimepicker("setDate", (new Date()) );
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:65px', 'target' => '_blank'),
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
	<!-- --------------------- Gépterem ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Gépterem</strong>",
		));
	?>

		<div class="row">
			<?php echo $form->labelEx($model,'folyamatban_levo_muvelet'); ?>
			<?php echo $form->textField($model,'folyamatban_levo_muvelet',array('size'=>30,'maxlength'=>30,'readonly'=>true)); ?>
			<?php echo $form->error($model,'folyamatban_levo_muvelet'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'varhato_befejezes'); ?>
			<?php echo $form->textField($model,'varhato_befejezes',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'varhato_befejezes'); ?>
		</div>		
		
		<div class="row" style="width:90%;" id="gepterem_message">
		
		</div>

		<div class="row">
			<?php
				$this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'button_gepterem',
					'caption'=>'Gépterem',
					'buttonType'=>'link',
					'onclick'=>new CJavaScriptExpression('function() {gepteremAdatkuld();}'),
					'htmlOptions'=>array('class'=>'btn btn-primary search-button', 'style'=>'margin-bottom:10px', 'target' => '_blank',),
				));
			?>		
		</div>

		<?php		
			if (Yii::app()->user->checkAccess('NyomdakonyvLejelentes.Create')) {
				
				$this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'button_create_nyomdakonyvLejelentes',
					'caption'=>'Kézi lejelentés',
					'buttonType'=>'link',
					'onclick'=>new CJavaScriptExpression('function() {addUpdateNyomdakonyvLejelentes("create", $(this));}'),
					'htmlOptions'=>array('class'=>'btn btn-success'),
				));
			}
			
			// a dialógus ablak inicializálása
			$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
				'id'=>'dialogNyomdakonyvLejelentes',
				'options'=>array(
					'title'=>'Kézi lejelentés',
					'autoOpen'=>false,
					'modal'=>true,
					'width'=>950,
					'height'=>650,
				),
			));
			
			echo "<div class='divForForm'></div>";
			
			$this->endWidget();
		?>		

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
						),
						'htmlOptions'=>array('style' => 'width:135px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_ctp_nek_atadas_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Nyomdakonyv_ctp_nek_atadas_datum").datetimepicker("setDate", (new Date()) );
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:65px', 'target' => '_blank'),
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
						),
						'htmlOptions'=>array('style' => 'width:135px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_ctp_kezdes_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Nyomdakonyv_ctp_kezdes_datum").datetimepicker("setDate", (new Date()) );
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:65px', 'target' => '_blank'),
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
						),
						'htmlOptions'=>array('style' => 'width:135px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_ctp_kesz_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Nyomdakonyv_ctp_kesz_datum").datetimepicker("setDate", (new Date()) );
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:65px', 'target' => '_blank'),
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
						),
						'htmlOptions'=>array('style' => 'width:135px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_nyomas_kezdes_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Nyomdakonyv_nyomas_kezdes_datum").datetimepicker("setDate", (new Date()) );
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:65px', 'target' => '_blank'),
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
	
<div class = 'clear'>
	<!-- --------------------- Vezérlőpult ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Vezérlőpult</strong>",
		));
	?>

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
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'submitForm',
						'caption'=>'Mentés',
						'htmlOptions' => array ('class' => 'btn btn-primary btn-lg',),
					 )); ?>
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'back',
						'caption'=>'Vissza',
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => Yii::app()->request->urlReferrer),
					 )); ?>
		</div>
	<?php $this->endWidget();?>
	
	
	<!-- --------------------- Képek ----------------------------- -->
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Képek</strong>",
		));
	?>

	<!-- KÉP #1 -->
	<p> <strong> Kép #1 </strong> </p>
		<?php
		if ($model -> isNewRecord != '1') {
			$this->widget('ext.EFineUploader.EFineUploader',
				array(
					'id'=>'FineUploader',
					'config'=>array(
							   'template'=>'qq-thumbnails-template',
							   'autoUpload'=>true,
							   'multiple'=>true,
							   'text'=> array(
									'uploadButton'=>"<i class='icon-plus icon-white'></i> Kép feltöltése"
								),
							   'request'=>array(
									'endpoint'=>$this->createUrl('uploadImage'),
									'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken, 'nyomdakonyvId' => $model -> id, 'kepSorszam' => ''),
								),
								'deleteFile'=> array(
									'enabled'=>true,
									'forceConfirm'=>true,
									'method'=>'POST',
									'endpoint'=>$this->createUrl('deleteImage'),
								),	   
								'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
								'chunking'=>array('enable'=>true,'partSize'=>100),//bytes
								'callbacks'=>array(
												'onComplete'=>"js:function(id, name, response){
													var serverPathToFile = response.filePath,
													fileItem = this.getItemByFileId(id);

													if (response.success) {
														var viewBtn = qq(fileItem).getByClass(\"view-link\")[0];
														viewBtn.setAttribute(\"href\", response.imageUrl);
														
														$('#FineUploader').hide();
														
														$('#nyomdakonyv_image img').attr( 'src', decodeURIComponent(response.imageUrl.replace(/\+/g, ' ')) + '?dt=' + (new Date()) );
														$('#nyomdakonyv_image').attr( 'href', decodeURIComponent(response.imageUrl.replace(/\+/g, ' ')) + '?dt=' + (new Date()) );
														$('#nyomdakonyv_image_div').show();
													}
												}",
												'onSubmitDelete' => "js:function(id) {
													this.setDeleteFileParams({filename: this.getName(id), nyomdakonyvId: $('#Nyomdakonyv_id').val(), kepSorszam: ''}, id);
												}",
												'onValidateBatch' => "js:function(fileOrBlobData) {}",
												 ),
								'validation'=>array(
										 'allowedExtensions'=>array('jpg', 'jpeg', 'gif', 'png'),
										 // max. file limit 5 MB
										 'sizeLimit'=>5 * 1024 * 1024,
												),
				)
			  ));
			}	 
		?>

		<div id = 'nyomdakonyv_image_div' style = '<?php echo ($model -> isNewRecord == '1' || empty($model -> kep_file_nev)) ? "display:none;" : "" ?>'>
			
			<div style = "float: left; margin-right: 10px">
				<a id = "nyomdakonyv_image" href="<?php echo Yii::app()->request->baseUrl . '/uploads/nyomdakonyv/' . $model->id . '/' . $model->kep_file_nev  . "?dt=" . time(); ?> ">
					<?php echo CHtml::image(Yii::app()->request->baseUrl . '/uploads/nyomdakonyv/' . $model->id . '/' . $model->kep_file_nev . "?dt=" . time(), "Feltöltött kép", array("width" => 180)); ?>
				</a>
			</div>
			
			<div style = "float: left">
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'rotate_image_left',
						'caption' => 'Balra forgat',
						'buttonType'=>'link',
						'options'=>array(
							'icons'=>array(
								'primary'=>'ui-icon-circle-arrow-w',
							)
						),						
						'onclick'=>new CJavaScriptExpression('function() {
							$.post( "../rotateNyomdakonyvImage?filename=" + encodeURIComponent($("#nyomdakonyv_image img").attr( "src").split("?dt=")[0]) + "&degree=90", function (data) {
												$("#nyomdakonyv_image img").attr( "src", decodeURIComponent(data.replace(/\+/g, " ")) + "?dt=" + (new Date()) );
												$("#nyomdakonyv_image").attr( "href", decodeURIComponent(data.replace(/\+/g, " ")) + "?dt=" + (new Date()) );
											});
						}'),
						'htmlOptions'=>array('class' => 'btn', 'style' => 'height:32px; width:140px; margin-bottom: 20px', 'target' => '_blank'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'send_image',
						'caption' => 'Kép küldése',
						'buttonType' => 'link',
						'options' => array(
							'icons' => array(
								'primary' => 'ui-icon-mail-closed',
							)
						),
						'onclick'=>new CJavaScriptExpression('function() {
							$("#juiDialogEmailBody").dialog("open");
						}'),
						'htmlOptions' => array('class' => 'btn', 'style' => 'height:32px; width:140px; margin-bottom: 20px', 'target' => '_blank'),
					));
				?>
				
				<br />

				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'rotate_image_right',
						'caption' => 'Jobbra forgat',
						'buttonType'=>'link',
						'options'=>array(
							'icons'=>array(
								'primary'=>'ui-icon-circle-arrow-e',
							)
						),						
						'onclick'=>new CJavaScriptExpression('function() {
							$.post( "../rotateNyomdakonyvImage?filename=" + encodeURIComponent($("#nyomdakonyv_image img").attr( "src").split("?dt=")[0]) + "&degree=-90", function (data) {
												$("#nyomdakonyv_image img").attr( "src", decodeURIComponent(data.replace(/\+/g, " ")) + "?dt=" + (new Date()) );
												$("#nyomdakonyv_image").attr( "href", decodeURIComponent(data.replace(/\+/g, " ")) + "?dt=" + (new Date()) );
											});
						}'),
						'htmlOptions'=>array('class' => 'btn', 'style' => 'height:32px; width:140px; margin-bottom: 20px', 'target' => '_blank'),
					));
				?>

				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'delete_image',
						'caption' => 'Törlés',
						'buttonType'=>'link',
						'options'=>array(
							'icons'=>array(
								'primary'=>'ui-icon-trash',
							)
						),						
						'onclick'=>new CJavaScriptExpression('function() {
							$.post( "../deleteImage?filename=" + encodeURIComponent($("#nyomdakonyv_image img").attr( "src").split("?dt=")[0]) + "&kepSorszam=&nyomdakonyvId=" + $("#Nyomdakonyv_id").val(), function (data) {
												$("#nyomdakonyv_image_div").hide();
												$(".qq-upload-list-selector").empty();
												
												$("#FineUploader").show();
											});
						}'),
						'htmlOptions'=>array('class' => 'btn', 'style' => 'height:32px; width:140px; margin-bottom: 20px', 'target' => '_blank'),
					));
				?>

				<?php 
					$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
									'id' => 'juiDialogEmailBody',
									'options' => array(
											'title' => 'Kép küldése e-mail-ben',
											'autoOpen' => false,
											'modal' => true,
											'width' => '400px',
											'height' => 'auto',
										),
									));

						echo '<label for="textAreaEmailBody">E-mail szövege</label>';
						echo CHtml::textArea('textAreaEmailBody', Yii::app()->config->get('NyomdakonyvPicEmailText'), array('rows' => 6, 'maxlength' => 1024, 'style' => 'width: 352px')); 
						
						echo "<div align='center'>";
							$this->widget('zii.widgets.jui.CJuiButton', array(
								'name'=>'send_image_to_server2',
								'caption' => 'Küldés',
								'buttonType' => 'link',
								'options' => array(
									'icons' => array(
										'primary' => 'ui-icon-mail-closed',
									)
								),
								'onclick'=>new CJavaScriptExpression('function() {
										$.post( "../emailPicture?filename=" + encodeURIComponent($("#nyomdakonyv_image img").attr( "src").split("?dt=")[0]) + "&nyomdakonyv_id=" + $("#Nyomdakonyv_id").val() + "&email_body=" + encodeURIComponent($("#textAreaEmailBody").val()), function (data) {
											if (data == "ERROR") {
												alert("Az e-mail küldése során hiba lépett fel!");
											} else {
												alert("Az e-mail sikeresen elküldve!");
											}
											
											$("#juiDialogEmailBody").dialog("close");
										});								
								}'),
								'htmlOptions' => array('class' => 'btn', 'style' => 'height:32px; width:140px; margin-bottom: 20px', 'target' => '_blank'),
							));
						echo "</div>";
						
					$this->endWidget();
				?>
			</div>
			<div style = 'clear: both'> </div>
		</div>
	
	<!-- KÉP #2 -->
	<p style = 'margin-top: 10px;'> <strong> Kép #2 </strong> </p>
		<?php
		if ($model -> isNewRecord != '1') {
			$this->widget('ext.EFineUploader.EFineUploader',
				array(
					'id'=>'FineUploader2',
					'config'=>array(
							   'template'=>'qq-thumbnails-template',
							   'autoUpload'=>true,
							   'multiple'=>true,
							   'text'=> array(
									'uploadButton'=>"<i class='icon-plus icon-white'></i> Kép feltöltése"
								),
							   'request'=>array(
									'endpoint'=>$this->createUrl('uploadImage'),
									'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken, 'nyomdakonyvId' => $model -> id, 'kepSorszam' => 2),
								),
								'deleteFile'=> array(
									'enabled'=>true,
									'forceConfirm'=>true,
									'method'=>'POST',
									'endpoint'=>$this->createUrl('deleteImage'),
								),	   
								'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
								'chunking'=>array('enable'=>true,'partSize'=>100),//bytes
								'callbacks'=>array(
												'onComplete'=>"js:function(id, name, response){
													var serverPathToFile = response.filePath,
													fileItem = this.getItemByFileId(id);

													if (response.success) {
														var viewBtn = qq(fileItem).getByClass(\"view-link\")[0];
														viewBtn.setAttribute(\"href\", response.imageUrl);
														
														$('#FineUploader2').hide();
														
														$('#nyomdakonyv_image2 img').attr( 'src', decodeURIComponent(response.imageUrl.replace(/\+/g, ' ')) + '?dt=' + (new Date()) );
														$('#nyomdakonyv_image2').attr( 'href', decodeURIComponent(response.imageUrl.replace(/\+/g, ' ')) + '?dt=' + (new Date()) );
														$('#nyomdakonyv_image2_div').show();
													}
												}",
												'onSubmitDelete' => "js:function(id) {
													this.setDeleteFileParams({filename: this.getName(id), nyomdakonyvId: $('#Nyomdakonyv_id').val(), kepSorszam: 2}, id);
												}",
												'onValidateBatch' => "js:function(fileOrBlobData) {}",
												 ),
								'validation'=>array(
										 'allowedExtensions'=>array('jpg', 'jpeg', 'gif', 'png'),
										 // max. file limit 5 MB
										 'sizeLimit'=>5 * 1024 * 1024,
												),
				)
			  ));
			}	 
		?>

	<div id = 'nyomdakonyv_image2_div' style = '<?php echo ($model -> isNewRecord == '1' || empty($model -> kep_file_nev2)) ? "display:none;" : "" ?>'>
			
			<div style = "float: left; margin-right: 10px">
				<a id = "nyomdakonyv_image2" href="<?php echo Yii::app()->request->baseUrl . '/uploads/nyomdakonyv/' . $model->id . '/' . $model->kep_file_nev2  . "?dt=" . time(); ?> ">
					<?php echo CHtml::image(Yii::app()->request->baseUrl . '/uploads/nyomdakonyv/' . $model->id . '/' . $model->kep_file_nev2 . "?dt=" . time(), "Feltöltött kép", array("width" => 180)); ?>
				</a>
			</div>
			
			<div style = "float: left">
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'rotate_image_left2',
						'caption' => 'Balra forgat',
						'buttonType'=>'link',
						'options'=>array(
							'icons'=>array(
								'primary'=>'ui-icon-circle-arrow-w',
							)
						),						
						'onclick'=>new CJavaScriptExpression('function() {
							$.post( "../rotateNyomdakonyvImage?filename=" + encodeURIComponent($("#nyomdakonyv_image2 img").attr( "src").split("?dt=")[0]) + "&degree=90", function (data) {
												$("#nyomdakonyv_image2 img").attr( "src", decodeURIComponent(data.replace(/\+/g, " ")) + "?dt=" + (new Date()) );
												$("#nyomdakonyv_image2").attr( "href", decodeURIComponent(data.replace(/\+/g, " ")) + "?dt=" + (new Date()) );
											});
						}'),
						'htmlOptions'=>array('class' => 'btn', 'style' => 'height:32px; width:140px; margin-bottom: 20px', 'target' => '_blank'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'send_image2',
						'caption' => 'Kép küldése',
						'buttonType' => 'link',
						'options' => array(
							'icons' => array(
								'primary' => 'ui-icon-mail-closed',
							)
						),
						'onclick'=>new CJavaScriptExpression('function() {
							$("#juiDialogEmailBody2").dialog("open");
						}'),
						'htmlOptions' => array('class' => 'btn', 'style' => 'height:32px; width:140px; margin-bottom: 20px', 'target' => '_blank'),
					));
				?>
				
				<br />

				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'rotate_image_right2',
						'caption' => 'Jobbra forgat',
						'buttonType'=>'link',
						'options'=>array(
							'icons'=>array(
								'primary'=>'ui-icon-circle-arrow-e',
							)
						),						
						'onclick'=>new CJavaScriptExpression('function() {
							$.post( "../rotateNyomdakonyvImage?filename=" + encodeURIComponent($("#nyomdakonyv_image2 img").attr( "src").split("?dt=")[0]) + "&degree=-90", function (data) {
												$("#nyomdakonyv_image2 img").attr( "src", decodeURIComponent(data.replace(/\+/g, " ")) + "?dt=" + (new Date()) );
												$("#nyomdakonyv_image2").attr( "href", decodeURIComponent(data.replace(/\+/g, " ")) + "?dt=" + (new Date()) );
											});
						}'),
						'htmlOptions'=>array('class' => 'btn', 'style' => 'height:32px; width:140px; margin-bottom: 20px', 'target' => '_blank'),
					));
				?>

				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'delete_image2',
						'caption' => 'Törlés',
						'buttonType'=>'link',
						'options'=>array(
							'icons'=>array(
								'primary'=>'ui-icon-trash',
							)
						),						
						'onclick'=>new CJavaScriptExpression('function() {
							$.post( "../deleteImage?filename=" + encodeURIComponent($("#nyomdakonyv_image2 img").attr( "src").split("?dt=")[0]) + "&kepSorszam=2&nyomdakonyvId=" + $("#Nyomdakonyv_id").val(), function (data) {
												$("#nyomdakonyv_image2_div").hide();
												$(".qq-upload-list-selector").empty();
												
												$("#FineUploader2").show();
											});
						}'),
						'htmlOptions'=>array('class' => 'btn', 'style' => 'height:32px; width:140px; margin-bottom: 20px', 'target' => '_blank'),
					));
				?>

				<?php 
					$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
									'id' => 'juiDialogEmailBody2',
									'options' => array(
											'title' => 'Kép küldése e-mail-ben',
											'autoOpen' => false,
											'modal' => true,
											'width' => '400px',
											'height' => 'auto',
										),
									));

						echo '<label for="textAreaEmailBody">E-mail szövege</label>';
						echo CHtml::textArea('textAreaEmailBody', Yii::app()->config->get('NyomdakonyvPicEmailText'), array('rows' => 6, 'maxlength' => 1024, 'style' => 'width: 352px')); 
						
						echo "<div align='center'>";
							$this->widget('zii.widgets.jui.CJuiButton', array(
								'name'=>'send_image_to_server2',
								'caption' => 'Küldés',
								'buttonType' => 'link',
								'options' => array(
									'icons' => array(
										'primary' => 'ui-icon-mail-closed',
									)
								),
								'onclick'=>new CJavaScriptExpression('function() {
										$.post( "../emailPicture?filename=" + encodeURIComponent($("#nyomdakonyv_image2 img").attr( "src").split("?dt=")[0]) + "&nyomdakonyv_id=" + $("#Nyomdakonyv_id").val() + "&email_body=" + encodeURIComponent($("#textAreaEmailBody").val()), function (data) {
											if (data == "ERROR") {
												alert("Az e-mail küldése során hiba lépett fel!");
											} else {
												alert("Az e-mail sikeresen elküldve!");
											}
											
											$("#juiDialogEmailBody2").dialog("close");
										});								
								}'),
								'htmlOptions' => array('class' => 'btn', 'style' => 'height:32px; width:140px; margin-bottom: 20px', 'target' => '_blank'),
							));
						echo "</div>";
						
					$this->endWidget();
				?>
			</div>
			<div style = 'clear: both'> </div>
		</div>
		
<!-- KÉP #3 -->
	<p style = 'margin-top: 10px;'> <strong> Kép #3 </strong> </p>
		<?php
		if ($model -> isNewRecord != '1') {
			$this->widget('ext.EFineUploader.EFineUploader',
				array(
					'id'=>'FineUploader3',
					'config'=>array(
							   'template'=>'qq-thumbnails-template',
							   'autoUpload'=>true,
							   'multiple'=>true,
							   'text'=> array(
									'uploadButton'=>"<i class='icon-plus icon-white'></i> Kép feltöltése"
								),
							   'request'=>array(
									'endpoint'=>$this->createUrl('uploadImage'),
									'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken, 'nyomdakonyvId' => $model -> id, 'kepSorszam' => 3),
								),
								'deleteFile'=> array(
									'enabled'=>true,
									'forceConfirm'=>true,
									'method'=>'POST',
									'endpoint'=>$this->createUrl('deleteImage'),
								),	   
								'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
								'chunking'=>array('enable'=>true,'partSize'=>100),//bytes
								'callbacks'=>array(
												'onComplete'=>"js:function(id, name, response){
													var serverPathToFile = response.filePath,
													fileItem = this.getItemByFileId(id);

													if (response.success) {
														var viewBtn = qq(fileItem).getByClass(\"view-link\")[0];
														viewBtn.setAttribute(\"href\", response.imageUrl);
														
														$('#FineUploader3').hide();
														
														$('#nyomdakonyv_image3 img').attr( 'src', decodeURIComponent(response.imageUrl.replace(/\+/g, ' ')) + '?dt=' + (new Date()) );
														$('#nyomdakonyv_image3').attr( 'href', decodeURIComponent(response.imageUrl.replace(/\+/g, ' ')) + '?dt=' + (new Date()) );
														$('#nyomdakonyv_image3_div').show();
													}
												}",
												'onSubmitDelete' => "js:function(id) {
													this.setDeleteFileParams({filename: this.getName(id), nyomdakonyvId: $('#Nyomdakonyv_id').val(), kepSorszam: 3}, id);
												}",
												'onValidateBatch' => "js:function(fileOrBlobData) {}",
												 ),
								'validation'=>array(
										 'allowedExtensions'=>array('jpg', 'jpeg', 'gif', 'png'),
										 // max. file limit 5 MB
										 'sizeLimit'=>5 * 1024 * 1024,
												),
				)
			  ));
			}	 
		?>

	<div id = 'nyomdakonyv_image3_div' style = '<?php echo ($model -> isNewRecord == '1' || empty($model -> kep_file_nev3)) ? "display:none;" : "" ?>'>
			
			<div style = "float: left; margin-right: 10px">
				<a id = "nyomdakonyv_image3" href="<?php echo Yii::app()->request->baseUrl . '/uploads/nyomdakonyv/' . $model->id . '/' . $model->kep_file_nev3  . "?dt=" . time(); ?> ">
					<?php echo CHtml::image(Yii::app()->request->baseUrl . '/uploads/nyomdakonyv/' . $model->id . '/' . $model->kep_file_nev3 . "?dt=" . time(), "Feltöltött kép", array("width" => 180)); ?>
				</a>
			</div>
			
			<div style = "float: left">
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'rotate_image_left3',
						'caption' => 'Balra forgat',
						'buttonType'=>'link',
						'options'=>array(
							'icons'=>array(
								'primary'=>'ui-icon-circle-arrow-w',
							)
						),						
						'onclick'=>new CJavaScriptExpression('function() {
							$.post( "../rotateNyomdakonyvImage?filename=" + encodeURIComponent($("#nyomdakonyv_image3 img").attr( "src").split("?dt=")[0]) + "&degree=90", function (data) {
												$("#nyomdakonyv_image3 img").attr( "src", decodeURIComponent(data.replace(/\+/g, " ")) + "?dt=" + (new Date()) );
												$("#nyomdakonyv_image3").attr( "href", decodeURIComponent(data.replace(/\+/g, " ")) + "?dt=" + (new Date()) );
											});
						}'),
						'htmlOptions'=>array('class' => 'btn', 'style' => 'height:32px; width:140px; margin-bottom: 20px', 'target' => '_blank'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'send_image3',
						'caption' => 'Kép küldése',
						'buttonType' => 'link',
						'options' => array(
							'icons' => array(
								'primary' => 'ui-icon-mail-closed',
							)
						),
						'onclick'=>new CJavaScriptExpression('function() {
							$("#juiDialogEmailBody3").dialog("open");
						}'),
						'htmlOptions' => array('class' => 'btn', 'style' => 'height:32px; width:140px; margin-bottom: 20px', 'target' => '_blank'),
					));
				?>
				
				<br />

				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'rotate_image_right3',
						'caption' => 'Jobbra forgat',
						'buttonType'=>'link',
						'options'=>array(
							'icons'=>array(
								'primary'=>'ui-icon-circle-arrow-e',
							)
						),						
						'onclick'=>new CJavaScriptExpression('function() {
							$.post( "../rotateNyomdakonyvImage?filename=" + encodeURIComponent($("#nyomdakonyv_image3 img").attr( "src").split("?dt=")[0]) + "&degree=-90", function (data) {
												$("#nyomdakonyv_image3 img").attr( "src", decodeURIComponent(data.replace(/\+/g, " ")) + "?dt=" + (new Date()) );
												$("#nyomdakonyv_image3").attr( "href", decodeURIComponent(data.replace(/\+/g, " ")) + "?dt=" + (new Date()) );
											});
						}'),
						'htmlOptions'=>array('class' => 'btn', 'style' => 'height:32px; width:140px; margin-bottom: 20px', 'target' => '_blank'),
					));
				?>

				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'delete_image3',
						'caption' => 'Törlés',
						'buttonType'=>'link',
						'options'=>array(
							'icons'=>array(
								'primary'=>'ui-icon-trash',
							)
						),						
						'onclick'=>new CJavaScriptExpression('function() {
							$.post( "../deleteImage?filename=" + encodeURIComponent($("#nyomdakonyv_image3 img").attr( "src").split("?dt=")[0]) + "&kepSorszam=3&nyomdakonyvId=" + $("#Nyomdakonyv_id").val(), function (data) {
												$("#nyomdakonyv_image3_div").hide();
												$(".qq-upload-list-selector").empty();
												
												$("#FineUploader3").show();
											});
						}'),
						'htmlOptions'=>array('class' => 'btn', 'style' => 'height:32px; width:140px; margin-bottom: 20px', 'target' => '_blank'),
					));
				?>

				<?php 
					$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
									'id' => 'juiDialogEmailBody3',
									'options' => array(
											'title' => 'Kép küldése e-mail-ben',
											'autoOpen' => false,
											'modal' => true,
											'width' => '400px',
											'height' => 'auto',
										),
									));

						echo '<label for="textAreaEmailBody">E-mail szövege</label>';
						echo CHtml::textArea('textAreaEmailBody', Yii::app()->config->get('NyomdakonyvPicEmailText'), array('rows' => 6, 'maxlength' => 1024, 'style' => 'width: 352px')); 
						
						echo "<div align='center'>";
							$this->widget('zii.widgets.jui.CJuiButton', array(
								'name'=>'send_image_to_server3',
								'caption' => 'Küldés',
								'buttonType' => 'link',
								'options' => array(
									'icons' => array(
										'primary' => 'ui-icon-mail-closed',
									)
								),
								'onclick'=>new CJavaScriptExpression('function() {
										$.post( "../emailPicture?filename=" + encodeURIComponent($("#nyomdakonyv_image3 img").attr( "src").split("?dt=")[0]) + "&nyomdakonyv_id=" + $("#Nyomdakonyv_id").val() + "&email_body=" + encodeURIComponent($("#textAreaEmailBody").val()), function (data) {
											if (data == "ERROR") {
												alert("Az e-mail küldése során hiba lépett fel!");
											} else {
												alert("Az e-mail sikeresen elküldve!");
											}
											
											$("#juiDialogEmailBody3").dialog("close");
										});								
								}'),
								'htmlOptions' => array('class' => 'btn', 'style' => 'height:32px; width:140px; margin-bottom: 20px', 'target' => '_blank'),
							));
						echo "</div>";
						
					$this->endWidget();
				?>
			</div>
			<div style = 'clear: both'> </div>
		</div>
		
	<?php $this->endWidget();?>
</div>

<?php $this->endWidget(); ?>

<?php // Reklamációs dialog-hoz szükséges kódblokk

	// CJUIDIALOG BEGIN
	  $this->beginWidget('zii.widgets.jui.CJuiDialog', 
		   array(   'id'=>'nyomdakonyv-reklamacio-dialog',
				'options'=>array(
								'title'=>'Reklamáció',
								'position'=>array('auto', 0),
								'modal'=>true,
								'width'=>'1120',
								'autoOpen'=>false,
								),
						));
						
		echo "<div class='divForReklamacioForm'></div>";
	
	$this->endWidget('zii.widgets.jui.CJuiDialog');
	// CJUIDIALOG END
?>

</div><!-- form -->

<script type="text/template" id="qq-thumbnails-template">
	<div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Húzza a feltöltendő képet ide" style="min-height:110px">
		<div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
			<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
		</div>
		<div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
			<span class="qq-upload-drop-area-text-selector"></span>
		</div>
		<div class="qq-upload-button-selector qq-upload-button">
			<div><i class="icon-plus icon-white"></i> Kép feltöltése</div>
		</div>
		<span class="qq-drop-processing-selector qq-drop-processing">
			<span>Képek feldolgozása...</span>
			<span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
		</span>
		
		<ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
			<li>
				<div class="qq-progress-bar-container-selector">
					<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
				</div>
				<span class="qq-upload-spinner-selector qq-upload-spinner"></span>
				<a target='_blank' class="view-link"> <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale> </a>
				<span class="qq-upload-file-selector qq-upload-file"></span>
				<span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Fájlnév szerkesztése"></span>
				<input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
				<span class="qq-upload-size-selector qq-upload-size"></span>
				<button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Mégse</button>
				<button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Újra</button>
				<button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Törlés</button>
				<span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
			</li>
		</ul>

		<dialog class="qq-alert-dialog-selector">
			<div class="qq-dialog-message-selector"></div>
			<div class="qq-dialog-buttons">
				<button type="button" class="qq-cancel-button-selector">Bezár</button>
			</div>
		</dialog>

		<dialog class="qq-confirm-dialog-selector">
			<div class="qq-dialog-message-selector"></div>
			<div class="qq-dialog-buttons">
				<button type="button" class="qq-cancel-button-selector">Nem</button>
				<button type="button" class="qq-ok-button-selector">Igen</button>
			</div>
		</dialog>

		<dialog class="qq-prompt-dialog-selector">
			<div class="qq-dialog-message-selector"></div>
			<input type="text">
			<div class="qq-dialog-buttons">
				<button type="button" class="qq-cancel-button-selector">Mégse</button>
				<button type="button" class="qq-ok-button-selector">Ok</button>
			</div>
		</dialog>
	</div>
</script>

<script type="text/javascript">

	function openReklamacio ()
	{
		id = $("#Nyomdakonyv_id").val();
			
		<?php echo CHtml::ajax(array(
				'url'=> "js:'/index.php/nyomdakonyvReklamaciok/reklamacio/id/' + id",
				'data'=> "js:$(this).serialize()",
				'type'=>'post',
				'id' => 'open-reklamacio-'.uniqid(),
				'replace' => '',
				'dataType'=>'json',
				'success'=>"function(data)
				{
					if (data.status == 'success')
					{
						$('#nyomdakonyv-reklamacio-dialog div.divForReklamacioForm').html(data.div);
					}
					else
					{
						$('#nyomdakonyv-reklamacio-dialog div.divForReklamacioForm').html(data.div);
						$('#nyomdakonyv-reklamacio-dialog').dialog('close');
					}
				
				} ",
		))?>;
		
		$("#nyomdakonyv-reklamacio-dialog").dialog("open");
		
		return false; 		
	}
	
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
	
	function gepteremAdatkuld() {
		<?php echo CHtml::ajax(array(
			'url'=> "js:'/index.php/nyomdakonyv/gepteremHivas/munka_id/" . $model->id . "'",
			'data'=> "js:$(this).serialize()",
			'type'=>'post',
			'id' => 'gepterem-hivas-'.uniqid(),
			'dataType'=>'json',
			'success'=>"function(data)
			{
				if (data.status == 'ok')
				{
					$('#Nyomdakonyv_folyamatban_levo_muvelet').val(data.muvelet);
//						$('#Nyomdakonyv_nyomas_kezdes_datum').val(data.nyomas_kezdes);
					if (data.nyomas_kesz == '') {
						$('#Nyomdakonyv_varhato_befejezes').val(data.muvelet_vege);
					}
					else {
						$('#Nyomdakonyv_varhato_befejezes').val(data.nyomas_kesz);
					}
				}
				else if (data.status = 'inserted') {
					$('#gepterem_message').removeClass('alert').removeClass('alert-danger').addClass('alert').addClass('alert-success').html(data.message) ;
				}
				else if (data.status = 'failed') {
					$('#gepterem_message').removeClass('alert').removeClass('alert-success').addClass('alert').addClass('alert-danger').html(data.message) ;
				}
				else
				{
//						$('#normaar').val(data.normaar);
//						$('#normaido').val(data.normaido);
				}

			} ",
		))?>;
	}
	
	var lejelentes_dialog ;
	function addUpdateNyomdakonyvLejelentes (createOrUpdate, buttonObj)
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

		<?php echo CHtml::ajax(array(
				'url'=> "js:'/index.php/nyomdakonyvLejelentes/' + op + '/id/" . $model->id . "'",
				'data'=> "js:$(this).serialize()",
				'type'=>'post',
				'id' => 'send-link-'.uniqid(),
				'replace' => '',
				'dataType'=>'json',
				'success'=>"function(data)
				{
					if (data.status == 'failure')
					{
						$('#dialogNyomdakonyvLejelentes div.divForForm').html(data.div);
						$('#dialogNyomdakonyvLejelentes div.divForForm form').submit(addUpdateNyomdakonyvLejelentes);
					}
					else
					{
/*						$.fn.yiiGridView.update(\"megrendelesTetelek-grid\",{ complete: function(jqXHR, status) {}})
						
						// az egyedi ár checkbox-ot kézzel átbillentjük a megfelelő értékre (a db-ben már a helyes érték van, csak a UI-on kell az interaktivitás miatt változtatni)
						$('#egyedi_ar_dsp').prop('checked', (data.egyedi == '1' ? true : false));
						$('#Megrendelesek_egyedi_ar').val (data.egyedi);
						
						$('#dialogMegrendelesTetel div.divForForm').html(data.div);
						$('#dialogMegrendelesTetel').dialog('close');*/
					}
	 
				} ",
		))?>;

		
	lejelentes_dialog = $("#dialogNyomdakonyvLejelentes").dialog({
		title: 'Kézi lejelentés',
		autoOpen:false,
		modal:true,
		width:950,
		height:650,
		
	});
		lejelentes_dialog.dialog("open");
//		$("#dialogNyomdakonyvLejelentes").dialog('option', 'title', 'Kézi lejelentés');
		
		return false; 
	}	
</script>

<script>

$( document ).ready(function() {
	$("a#nyomdakonyv_image").fancybox();
	$("a#nyomdakonyv_image2").fancybox();
	$("a#nyomdakonyv_image3").fancybox();
	
	<?php
		if (!empty($model -> kep_file_nev)) {
			echo '$("#FineUploader").hide();';
		}
	?>

	<?php
		if (!empty($model -> kep_file_nev2)) {
			echo '$("#FineUploader2").hide();';
		}
	?>
	
	<?php
		if (!empty($model -> kep_file_nev3)) {
			echo '$("#FineUploader3").hide();';
		}
	?>
	
	$("#button_norma_szamitasa").attr('disabled', 'disabled');
	
	// ha a mutáció nincs bepipálva, akkor le kell tiltani a 'mutáció színszám' mezőt
	$("#Nyomdakonyv_szin_mutaciok_szam").prop("disabled", !$("#Nyomdakonyv_szin_mutaciok").is(":checked") );
	
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
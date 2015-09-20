<?php
/* @var $this NyomdakonyvController */
/* @var $model Nyomdakonyv */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'megrendeles_tetel_id'); ?>
		<?php echo $form->textField($model,'megrendeles_tetel_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'taskaszam'); ?>
		<?php echo $form->textField($model,'taskaszam',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hatarido'); ?>
		<?php echo $form->textField($model,'hatarido'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pantone'); ?>
		<?php echo $form->textField($model,'pantone',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'munka_beerkezes_datum'); ?>
		<?php echo $form->textField($model,'munka_beerkezes_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'taska_kiadasi_datum'); ?>
		<?php echo $form->textField($model,'taska_kiadasi_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'elkeszulesi_datum'); ?>
		<?php echo $form->textField($model,'elkeszulesi_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ertesitesi_datum'); ?>
		<?php echo $form->textField($model,'ertesitesi_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szallitolevel_sorszam'); ?>
		<?php echo $form->textField($model,'szallitolevel_sorszam',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szallitolevel_datum'); ?>
		<?php echo $form->textField($model,'szallitolevel_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szamla_sorszam'); ?>
		<?php echo $form->textField($model,'szamla_sorszam',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szamla_datum'); ?>
		<?php echo $form->textField($model,'szamla_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sos'); ?>
		<?php echo $form->textField($model,'sos'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szin_c'); ?>
		<?php echo $form->textField($model,'szin_c'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szin_m'); ?>
		<?php echo $form->textField($model,'szin_m'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szin_y'); ?>
		<?php echo $form->textField($model,'szin_y'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szin_k'); ?>
		<?php echo $form->textField($model,'szin_k'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'szin_mutaciok'); ?>
		<?php echo $form->textField($model,'szin_mutaciok'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kifuto_bal'); ?>
		<?php echo $form->textField($model,'kifuto_bal'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kifuto_fent'); ?>
		<?php echo $form->textField($model,'kifuto_fent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kifuto_jobb'); ?>
		<?php echo $form->textField($model,'kifuto_jobb'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kifuto_lent'); ?>
		<?php echo $form->textField($model,'kifuto_lent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'forditott_levezetes'); ?>
		<?php echo $form->textField($model,'forditott_levezetes'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hossziranyu_levezetes'); ?>
		<?php echo $form->textField($model,'hossziranyu_levezetes'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nyomas_tipus'); ?>
		<?php echo $form->textField($model,'nyomas_tipus',array('size'=>29,'maxlength'=>29)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'utasitas_ctp_nek'); ?>
		<?php echo $form->textField($model,'utasitas_ctp_nek',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'utasitas_gepmesternek'); ?>
		<?php echo $form->textField($model,'utasitas_gepmesternek',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kiszallitasi_informaciok'); ?>
		<?php echo $form->textField($model,'kiszallitasi_informaciok',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gep_id'); ?>
		<?php echo $form->textField($model,'gep_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kifutos'); ?>
		<?php echo $form->textField($model,'kifutos'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fekete_flekkben_szin_javitando'); ?>
		<?php echo $form->textField($model,'fekete_flekkben_szin_javitando'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'magas_szinterheles_nagy_feluleten'); ?>
		<?php echo $form->textField($model,'magas_szinterheles_nagy_feluleten'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'magas_szinterheles_szovegben'); ?>
		<?php echo $form->textField($model,'magas_szinterheles_szovegben'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ofszet_festek'); ?>
		<?php echo $form->textField($model,'ofszet_festek'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nyomas_minta_szerint'); ?>
		<?php echo $form->textField($model,'nyomas_minta_szerint'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nyomas_vagojel_szerint'); ?>
		<?php echo $form->textField($model,'nyomas_vagojel_szerint'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nyomas_specialis'); ?>
		<?php echo $form->textField($model,'nyomas_specialis',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gepindulasra_jon_ugyfel'); ?>
		<?php echo $form->textField($model,'gepindulasra_jon_ugyfel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ctp_nek_atadas_datum'); ?>
		<?php echo $form->textField($model,'ctp_nek_atadas_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ctp_kezdes_datum'); ?>
		<?php echo $form->textField($model,'ctp_kezdes_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ctp_belenyulasok'); ?>
		<?php echo $form->textField($model,'ctp_belenyulasok',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ctp_hibalista'); ?>
		<?php echo $form->textField($model,'ctp_hibalista',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'jovahagyas'); ?>
		<?php echo $form->textField($model,'jovahagyas',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ctp_kesz_datum'); ?>
		<?php echo $form->textField($model,'ctp_kesz_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nyomas_kezdes_datum'); ?>
		<?php echo $form->textField($model,'nyomas_kezdes_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'raktarbol_kiadva_datum'); ?>
		<?php echo $form->textField($model,'raktarbol_kiadva_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kep_file_nev'); ?>
		<?php echo $form->textField($model,'kep_file_nev',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sztornozva'); ?>
		<?php echo $form->textField($model,'sztornozva'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'torolt'); ?>
		<?php echo $form->textField($model,'torolt'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
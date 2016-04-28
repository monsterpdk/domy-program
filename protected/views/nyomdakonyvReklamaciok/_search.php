<?php
/* @var $this NyomdakonyvReklamaciokController */
/* @var $model NyomdakonyvReklamaciok */
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
		<?php echo $form->label($model,'nyomdakonyv_id'); ?>
		<?php echo $form->textField($model,'nyomdakonyv_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'datum'); ?>
		<?php echo $form->textField($model,'datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'selejt_leiras'); ?>
		<?php echo $form->textField($model,'selejt_leiras',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'aru_kiado'); ?>
		<?php echo $form->textField($model,'aru_kiado',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gepmester'); ?>
		<?php echo $form->textField($model,'gepmester',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kereszt_ellenor'); ?>
		<?php echo $form->textField($model,'kereszt_ellenor',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'selejt_oka_rossz_munka_kiadas'); ?>
		<?php echo $form->textField($model,'selejt_oka_rossz_munka_kiadas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'selejt_oka_szin_hiba'); ?>
		<?php echo $form->textField($model,'selejt_oka_szin_hiba'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'selejt_oka_passzer_hiba'); ?>
		<?php echo $form->textField($model,'selejt_oka_passzer_hiba'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'selejt_oka_hatarido_csuszas'); ?>
		<?php echo $form->textField($model,'selejt_oka_hatarido_csuszas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'selejt_oka_peldanyszam_elteres'); ?>
		<?php echo $form->textField($model,'selejt_oka_peldanyszam_elteres'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'selejt_oka_elhelyezes_hiba'); ?>
		<?php echo $form->textField($model,'selejt_oka_elhelyezes_hiba'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'selejt_oka_hibas_boritek_valasztas'); ?>
		<?php echo $form->textField($model,'selejt_oka_hibas_boritek_valasztas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'selejt_oka_rossz_meret'); ?>
		<?php echo $form->textField($model,'selejt_oka_rossz_meret'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'selejt_oka_rossz_ablak'); ?>
		<?php echo $form->textField($model,'selejt_oka_rossz_ablak'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'selejt_oka_rossz_rag_mod'); ?>
		<?php echo $form->textField($model,'selejt_oka_rossz_rag_mod'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'eszrevetel_helye_cegen_belul'); ?>
		<?php echo $form->textField($model,'eszrevetel_helye_cegen_belul'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'eszrevetel_helye_cegen_kivul'); ?>
		<?php echo $form->textField($model,'eszrevetel_helye_cegen_kivul'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ellenorzesi_pontok_iroda_munka_felvetel'); ?>
		<?php echo $form->textField($model,'ellenorzesi_pontok_iroda_munka_felvetel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ellenorzesi_pontok_iroda_munka_kiadas'); ?>
		<?php echo $form->textField($model,'ellenorzesi_pontok_iroda_munka_kiadas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ellenorzesi_pontok_raktari_kiadas'); ?>
		<?php echo $form->textField($model,'ellenorzesi_pontok_raktari_kiadas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ellenorzesi_pontok_gepmester_atvetel'); ?>
		<?php echo $form->textField($model,'ellenorzesi_pontok_gepmester_atvetel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ellenorzesi_pontok_keresztellenor'); ?>
		<?php echo $form->textField($model,'ellenorzesi_pontok_keresztellenor'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ellenorzesi_pontok_keszre_jelentes_gepmester'); ?>
		<?php echo $form->textField($model,'ellenorzesi_pontok_keszre_jelentes_gepmester'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ellenorzesi_pontok_keszre_jelentes_ellenor'); ?>
		<?php echo $form->textField($model,'ellenorzesi_pontok_keszre_jelentes_ellenor'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ellenorzesi_pontok_raktari_visszavet'); ?>
		<?php echo $form->textField($model,'ellenorzesi_pontok_raktari_visszavet'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ellenorzesi_pontok_iroda_munka_atvetel'); ?>
		<?php echo $form->textField($model,'ellenorzesi_pontok_iroda_munka_atvetel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ellenorzesi_pontok_ugyfel'); ?>
		<?php echo $form->textField($model,'ellenorzesi_pontok_ugyfel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hiba_eszlelese_iroda_munka_felvetel'); ?>
		<?php echo $form->textField($model,'hiba_eszlelese_iroda_munka_felvetel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hiba_eszlelese_iroda_munka_kiadas'); ?>
		<?php echo $form->textField($model,'hiba_eszlelese_iroda_munka_kiadas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hiba_eszlelese_raktari_kiadas'); ?>
		<?php echo $form->textField($model,'hiba_eszlelese_raktari_kiadas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hiba_eszlelese_gepmester_atvetel'); ?>
		<?php echo $form->textField($model,'hiba_eszlelese_gepmester_atvetel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hiba_eszlelese_keresztellenor'); ?>
		<?php echo $form->textField($model,'hiba_eszlelese_keresztellenor'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hiba_eszlelese_keszre_jelentes_gepmester'); ?>
		<?php echo $form->textField($model,'hiba_eszlelese_keszre_jelentes_gepmester'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hiba_eszlelese_keszre_jelentes_ellenor'); ?>
		<?php echo $form->textField($model,'hiba_eszlelese_keszre_jelentes_ellenor'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hiba_eszlelese_raktari_visszavet'); ?>
		<?php echo $form->textField($model,'hiba_eszlelese_raktari_visszavet'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hiba_eszlelese_iroda_munka_atvetel'); ?>
		<?php echo $form->textField($model,'hiba_eszlelese_iroda_munka_atvetel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hiba_eszlelese_ugyfel'); ?>
		<?php echo $form->textField($model,'hiba_eszlelese_ugyfel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'javitasi_mod_ujra_nyomas'); ?>
		<?php echo $form->textField($model,'javitasi_mod_ujra_nyomas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'javitasi_mod_felul_nyomas'); ?>
		<?php echo $form->textField($model,'javitasi_mod_felul_nyomas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'javitasi_mod_arcsokkentes'); ?>
		<?php echo $form->textField($model,'javitasi_mod_arcsokkentes'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'javitasi_mod_reszleges_ujranyomas'); ?>
		<?php echo $form->textField($model,'javitasi_mod_reszleges_ujranyomas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'javitasi_mod_kompenzacio'); ?>
		<?php echo $form->textField($model,'javitasi_mod_kompenzacio'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'egyeb'); ?>
		<?php echo $form->textField($model,'egyeb',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'netto_kar'); ?>
		<?php echo $form->textField($model,'netto_kar'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
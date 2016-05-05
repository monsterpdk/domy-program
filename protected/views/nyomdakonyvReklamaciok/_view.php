<?php
/* @var $this NyomdakonyvReklamaciokController */
/* @var $data NyomdakonyvReklamaciok */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nyomdakonyv_id')); ?>:</b>
	<?php echo CHtml::encode($data->nyomdakonyv_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datum')); ?>:</b>
	<?php echo CHtml::encode($data->datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('selejt_leiras')); ?>:</b>
	<?php echo CHtml::encode($data->selejt_leiras); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aru_kiado')); ?>:</b>
	<?php echo CHtml::encode($data->aru_kiado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gepmester')); ?>:</b>
	<?php echo CHtml::encode($data->gepmester); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kereszt_ellenor')); ?>:</b>
	<?php echo CHtml::encode($data->kereszt_ellenor); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('selejt_oka_rossz_munka_kiadas')); ?>:</b>
	<?php echo CHtml::encode($data->selejt_oka_rossz_munka_kiadas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('selejt_oka_szin_hiba')); ?>:</b>
	<?php echo CHtml::encode($data->selejt_oka_szin_hiba); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('selejt_oka_passzer_hiba')); ?>:</b>
	<?php echo CHtml::encode($data->selejt_oka_passzer_hiba); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('selejt_oka_hatarido_csuszas')); ?>:</b>
	<?php echo CHtml::encode($data->selejt_oka_hatarido_csuszas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('selejt_oka_peldanyszam_elteres')); ?>:</b>
	<?php echo CHtml::encode($data->selejt_oka_peldanyszam_elteres); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('selejt_oka_elhelyezes_hiba')); ?>:</b>
	<?php echo CHtml::encode($data->selejt_oka_elhelyezes_hiba); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('selejt_oka_hibas_boritek_valasztas')); ?>:</b>
	<?php echo CHtml::encode($data->selejt_oka_hibas_boritek_valasztas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('selejt_oka_rossz_meret')); ?>:</b>
	<?php echo CHtml::encode($data->selejt_oka_rossz_meret); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('selejt_oka_rossz_ablak')); ?>:</b>
	<?php echo CHtml::encode($data->selejt_oka_rossz_ablak); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('selejt_oka_rossz_rag_mod')); ?>:</b>
	<?php echo CHtml::encode($data->selejt_oka_rossz_rag_mod); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eszrevetel_helye_cegen_belul')); ?>:</b>
	<?php echo CHtml::encode($data->eszrevetel_helye_cegen_belul); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eszrevetel_helye_cegen_kivul')); ?>:</b>
	<?php echo CHtml::encode($data->eszrevetel_helye_cegen_kivul); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ellenorzesi_pontok_iroda_munka_felvetel')); ?>:</b>
	<?php echo CHtml::encode($data->ellenorzesi_pontok_iroda_munka_felvetel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ellenorzesi_pontok_iroda_munka_kiadas')); ?>:</b>
	<?php echo CHtml::encode($data->ellenorzesi_pontok_iroda_munka_kiadas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ellenorzesi_pontok_raktari_kiadas')); ?>:</b>
	<?php echo CHtml::encode($data->ellenorzesi_pontok_raktari_kiadas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ellenorzesi_pontok_gepmester_atvetel')); ?>:</b>
	<?php echo CHtml::encode($data->ellenorzesi_pontok_gepmester_atvetel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ellenorzesi_pontok_keresztellenor')); ?>:</b>
	<?php echo CHtml::encode($data->ellenorzesi_pontok_keresztellenor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ellenorzesi_pontok_keszre_jelentes_gepmester')); ?>:</b>
	<?php echo CHtml::encode($data->ellenorzesi_pontok_keszre_jelentes_gepmester); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ellenorzesi_pontok_keszre_jelentes_ellenor')); ?>:</b>
	<?php echo CHtml::encode($data->ellenorzesi_pontok_keszre_jelentes_ellenor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ellenorzesi_pontok_raktari_visszavet')); ?>:</b>
	<?php echo CHtml::encode($data->ellenorzesi_pontok_raktari_visszavet); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ellenorzesi_pontok_iroda_munka_atvetel')); ?>:</b>
	<?php echo CHtml::encode($data->ellenorzesi_pontok_iroda_munka_atvetel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ellenorzesi_pontok_ugyfel')); ?>:</b>
	<?php echo CHtml::encode($data->ellenorzesi_pontok_ugyfel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hiba_eszlelese_iroda_munka_felvetel')); ?>:</b>
	<?php echo CHtml::encode($data->hiba_eszlelese_iroda_munka_felvetel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hiba_eszlelese_iroda_munka_kiadas')); ?>:</b>
	<?php echo CHtml::encode($data->hiba_eszlelese_iroda_munka_kiadas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hiba_eszlelese_raktari_kiadas')); ?>:</b>
	<?php echo CHtml::encode($data->hiba_eszlelese_raktari_kiadas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hiba_eszlelese_gepmester_atvetel')); ?>:</b>
	<?php echo CHtml::encode($data->hiba_eszlelese_gepmester_atvetel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hiba_eszlelese_keresztellenor')); ?>:</b>
	<?php echo CHtml::encode($data->hiba_eszlelese_keresztellenor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hiba_eszlelese_keszre_jelentes_gepmester')); ?>:</b>
	<?php echo CHtml::encode($data->hiba_eszlelese_keszre_jelentes_gepmester); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hiba_eszlelese_keszre_jelentes_ellenor')); ?>:</b>
	<?php echo CHtml::encode($data->hiba_eszlelese_keszre_jelentes_ellenor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hiba_eszlelese_raktari_visszavet')); ?>:</b>
	<?php echo CHtml::encode($data->hiba_eszlelese_raktari_visszavet); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hiba_eszlelese_iroda_munka_atvetel')); ?>:</b>
	<?php echo CHtml::encode($data->hiba_eszlelese_iroda_munka_atvetel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hiba_eszlelese_ugyfel')); ?>:</b>
	<?php echo CHtml::encode($data->hiba_eszlelese_ugyfel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('javitasi_mod_ujra_nyomas')); ?>:</b>
	<?php echo CHtml::encode($data->javitasi_mod_ujra_nyomas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('javitasi_mod_felul_nyomas')); ?>:</b>
	<?php echo CHtml::encode($data->javitasi_mod_felul_nyomas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('javitasi_mod_arcsokkentes')); ?>:</b>
	<?php echo CHtml::encode($data->javitasi_mod_arcsokkentes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('javitasi_mod_reszleges_ujranyomas')); ?>:</b>
	<?php echo CHtml::encode($data->javitasi_mod_reszleges_ujranyomas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('javitasi_mod_kompenzacio')); ?>:</b>
	<?php echo CHtml::encode($data->javitasi_mod_kompenzacio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('egyeb')); ?>:</b>
	<?php echo CHtml::encode($data->egyeb); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('netto_kar')); ?>:</b>
	<?php echo CHtml::encode($data->netto_kar); ?>
	<br />

	*/ ?>

</div>
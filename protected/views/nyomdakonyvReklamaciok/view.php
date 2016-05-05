<?php
/* @var $this NyomdakonyvReklamaciokController */
/* @var $model NyomdakonyvReklamaciok */

$this->breadcrumbs=array(
	'Nyomdakonyv Reklamacioks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List NyomdakonyvReklamaciok', 'url'=>array('index')),
	array('label'=>'Create NyomdakonyvReklamaciok', 'url'=>array('create')),
	array('label'=>'Update NyomdakonyvReklamaciok', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NyomdakonyvReklamaciok', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NyomdakonyvReklamaciok', 'url'=>array('admin')),
);
?>

<h1>View NyomdakonyvReklamaciok #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nyomdakonyv_id',
		'datum',
		'selejt_leiras',
		'aru_kiado',
		'gepmester',
		'kereszt_ellenor',
		'selejt_oka_rossz_munka_kiadas',
		'selejt_oka_szin_hiba',
		'selejt_oka_passzer_hiba',
		'selejt_oka_hatarido_csuszas',
		'selejt_oka_peldanyszam_elteres',
		'selejt_oka_elhelyezes_hiba',
		'selejt_oka_hibas_boritek_valasztas',
		'selejt_oka_rossz_meret',
		'selejt_oka_rossz_ablak',
		'selejt_oka_rossz_rag_mod',
		'eszrevetel_helye_cegen_belul',
		'eszrevetel_helye_cegen_kivul',
		'ellenorzesi_pontok_iroda_munka_felvetel',
		'ellenorzesi_pontok_iroda_munka_kiadas',
		'ellenorzesi_pontok_raktari_kiadas',
		'ellenorzesi_pontok_gepmester_atvetel',
		'ellenorzesi_pontok_keresztellenor',
		'ellenorzesi_pontok_keszre_jelentes_gepmester',
		'ellenorzesi_pontok_keszre_jelentes_ellenor',
		'ellenorzesi_pontok_raktari_visszavet',
		'ellenorzesi_pontok_iroda_munka_atvetel',
		'ellenorzesi_pontok_ugyfel',
		'hiba_eszlelese_iroda_munka_felvetel',
		'hiba_eszlelese_iroda_munka_kiadas',
		'hiba_eszlelese_raktari_kiadas',
		'hiba_eszlelese_gepmester_atvetel',
		'hiba_eszlelese_keresztellenor',
		'hiba_eszlelese_keszre_jelentes_gepmester',
		'hiba_eszlelese_keszre_jelentes_ellenor',
		'hiba_eszlelese_raktari_visszavet',
		'hiba_eszlelese_iroda_munka_atvetel',
		'hiba_eszlelese_ugyfel',
		'javitasi_mod_ujra_nyomas',
		'javitasi_mod_felul_nyomas',
		'javitasi_mod_arcsokkentes',
		'javitasi_mod_reszleges_ujranyomas',
		'javitasi_mod_kompenzacio',
		'egyeb',
		'netto_kar',
	),
)); ?>

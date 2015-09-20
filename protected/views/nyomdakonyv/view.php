<?php
/* @var $this NyomdakonyvController */
/* @var $model Nyomdakonyv */

$this->breadcrumbs=array(
	'Nyomdakonyvs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Nyomdakonyv', 'url'=>array('index')),
	array('label'=>'Create Nyomdakonyv', 'url'=>array('create')),
	array('label'=>'Update Nyomdakonyv', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Nyomdakonyv', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Nyomdakonyv', 'url'=>array('admin')),
);
?>

<h1>View Nyomdakonyv #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'megrendeles_tetel_id',
		'taskaszam',
		'hatarido',
		'pantone',
		'munka_beerkezes_datum',
		'taska_kiadasi_datum',
		'elkeszulesi_datum',
		'ertesitesi_datum',
		'szallitolevel_sorszam',
		'szallitolevel_datum',
		'szamla_sorszam',
		'szamla_datum',
		'sos',
		'szin_c',
		'szin_m',
		'szin_y',
		'szin_k',
		'szin_mutaciok',
		'kifuto_bal',
		'kifuto_fent',
		'kifuto_jobb',
		'kifuto_lent',
		'forditott_levezetes',
		'hossziranyu_levezetes',
		'nyomas_tipus',
		'utasitas_ctp_nek',
		'utasitas_gepmesternek',
		'kiszallitasi_informaciok',
		'gep_id',
		'kifutos',
		'fekete_flekkben_szin_javitando',
		'magas_szinterheles_nagy_feluleten',
		'magas_szinterheles_szovegben',
		'ofszet_festek',
		'nyomas_minta_szerint',
		'nyomas_vagojel_szerint',
		'nyomas_specialis',
		'gepindulasra_jon_ugyfel',
		'ctp_nek_atadas_datum',
		'ctp_kezdes_datum',
		'ctp_belenyulasok',
		'ctp_hibalista',
		'jovahagyas',
		'ctp_kesz_datum',
		'nyomas_kezdes_datum',
		'raktarbol_kiadva_datum',
		'kep_file_nev',
		'sztornozva',
		'torolt',
	),
)); ?>

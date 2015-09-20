<?php
/* @var $this NyomdakonyvController */
/* @var $model Nyomdakonyv */

$this->breadcrumbs=array(
	'Nyomdakonyvs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Nyomdakonyv', 'url'=>array('index')),
	array('label'=>'Create Nyomdakonyv', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#nyomdakonyv-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Nyomdakonyvs</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'nyomdakonyv-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'megrendeles_tetel_id',
		'taskaszam',
		'hatarido',
		'pantone',
		'munka_beerkezes_datum',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

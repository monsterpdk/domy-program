<?php
/* @var $this UgyfelekController */
/* @var $model Ugyfelek */

$this->breadcrumbs=array(
	'Ugyfeleks'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Ugyfelek', 'url'=>array('index')),
	array('label'=>'Create Ugyfelek', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ugyfelek-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Ugyfeleks</h1>

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
	'id'=>'ugyfelek-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'ugyfel_tipus',
		'cegnev',
		'cegnev_teljes',
		'szekhely_irsz',
		'szekhely_orszag',
		/*
		'szekhely_varos',
		'szekhely_cim',
		'posta_irsz',
		'posta_orszag',
		'posta_varos',
		'ugyvezeto_nev',
		'ugyvezeto_telefon',
		'ugyvezeto_email',
		'kapcsolattarto_nev',
		'kapcsolattarto_telefon',
		'kapcsolattarto_email',
		'ceg_telefon',
		'ceg_fax',
		'ceg_email',
		'ceg_honlap',
		'cegforma',
		'szamlaszam1',
		'szamlaszam2',
		'adoszam',
		'eu_adoszam',
		'teaor',
		'tevekenysegi_kor',
		'arbevetel',
		'foglalkoztatottak_szama',
		'adatforras',
		'besorolas',
		'megjegyzes',
		'fontos_megjegyzes',
		'fizetesi_felszolitas_volt',
		'ugyvedi_felszolitas_volt',
		'levelezes_engedelyezett',
		'email_engedelyezett',
		'kupon_engedelyezett',
		'egyedi_kuponkedvezmeny',
		'elso_vasarlas_datum',
		'utolso_vasarlas_datum',
		'max_fizetesi_keses',
		'atlagos_fizetesi_keses',
		'rendelesi_tartozasi_limit',
		'fizetesi_moral',
		'adatok_egyeztetve_datum',
		'archiv',
		'archivbol_vissza_datum',
		'felvetel_idopont',
		'torolt',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

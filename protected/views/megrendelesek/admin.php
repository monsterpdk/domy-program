<?php
/* @var $this MegrendelesekController */
/* @var $model Megrendelesek */

$this->breadcrumbs=array(
	'Megrendeleseks'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Megrendelesek', 'url'=>array('index')),
	array('label'=>'Create Megrendelesek', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#megrendelesek-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Megrendeleseks</h1>

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
	'id'=>'megrendelesek-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'sorszam',
		'ugyfel_id',
		'cimzett',
		'arkategoria_id',
		'egyedi_ar',
		/*
		'rendeles_idopont',
		'rendelest_rogzito_user_id',
		'rendelest_lezaro_user_id',
		'afakulcs_id',
		'arajanlat_id',
		'proforma_szamla_sorszam',
		'proforma_szamla_fizetve',
		'szamla_sorszam',
		'ugyfel_tel',
		'ugyfel_fax',
		'visszahivas_jegyzet',
		'jegyzet',
		'reklamszoveg',
		'egyeb_megjegyzes',
		'megrendeles_forras_id',
		'nyomdakonyv_munka_id',
		'sztornozva',
		'torolt',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php
/* @var $this TermekekController */
/* @var $model Termekek */

$this->breadcrumbs=array(
	'Termekeks'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Termekek', 'url'=>array('index')),
	array('label'=>'Create Termekek', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#termekek-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Termekeks</h1>

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
	'id'=>'termekek-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nev',
		'kodszam',
		'meret_id',
		'suly',
		'zaras_id',
		/*
		'ablakmeret_id',
		'ablakhely_id',
		'papir_id',
		'redotalp',
		'gyarto_id',
		'ksh_kod',
		'csom_egys',
		'minimum_raktarkeszlet',
		'maximum_raktarkeszlet',
		'doboz_suly',
		'raklap_db',
		'doboz_hossz',
		'doboz_szelesseg',
		'doboz_magassag',
		'megjegyzes',
		'megjelenes_mettol',
		'megjelenes_meddig',
		'datum',
		'torolt',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

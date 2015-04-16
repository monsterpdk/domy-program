<?php
/* @var $this ArajanlatokController */
/* @var $model Arajanlatok */

$this->breadcrumbs=array(
	'Arajanlatoks'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Arajanlatok', 'url'=>array('index')),
	array('label'=>'Create Arajanlatok', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#arajanlatok-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Arajanlatoks</h1>

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
	'id'=>'arajanlatok-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'sorszam',
		'ugyfel_id',
		'arkategoria_id',
		'ajanlat_datum',
		'ervenyesseg_datum',
		/*
		'hatarido',
		'afakulcs_id',
		'kovetkezo_hivas_ideje',
		'visszahivas_lezarva',
		'ugyfel_tel',
		'ugyfel_fax',
		'visszahivas_jegyzet',
		'jegyzet',
		'reklamszoveg',
		'egyeb_megjegyzes',
		'torolt',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

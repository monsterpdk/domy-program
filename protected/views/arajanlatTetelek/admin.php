<?php
/* @var $this ArajanlatTetelekController */
/* @var $model ArajanlatTetelek */

$this->breadcrumbs=array(
	'Arajanlat Teteleks'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ArajanlatTetelek', 'url'=>array('index')),
	array('label'=>'Create ArajanlatTetelek', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#arajanlat-tetelek-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Arajanlat Teteleks</h1>

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
	'id'=>'arajanlat-tetelek-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'arajanlat_id',
		'termek_id',
		'szinek_szama1',
		'szinek_szama2',
		'darabszam',
		/*
		'netto_darabar',
		'megjegyzes',
		'mutacio',
		'hozott_boritek',
		'torolt',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

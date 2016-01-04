<?php
/* @var $this NyomdakonyvLejelentesController */
/* @var $model NyomdakonyvLejelentes */

$this->breadcrumbs=array(
	'Nyomdakönyv lejelentett teljesítmények'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List NyomdakonyvLejelentes', 'url'=>array('index')),
	array('label'=>'Create NyomdakonyvLejelentes', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#nyomdakonyv-teljesitmenyek-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Nyomdakönyv lejelentett teljesítmények kezelése</h1>

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
	'id'=>'nyomdakonyv-teljesitmenyek-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nyomdakonyv_id',
		'user_id',
		'teljesitmeny_szazalek',
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

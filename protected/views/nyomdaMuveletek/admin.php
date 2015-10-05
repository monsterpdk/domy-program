<?php
/* @var $this NyomdaMuveletekController */
/* @var $model NyomdaMuveletek */

$this->breadcrumbs=array(
	'Nyomda Muveleteks'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List NyomdaMuveletek', 'url'=>array('index')),
	array('label'=>'Create NyomdaMuveletek', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#nyomda-muveletek-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Nyomda Muveleteks</h1>

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
	'id'=>'nyomda-muveletek-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'gep_id',
		'muvelet_nev',
		'elokeszites_ido',
		'muvelet_ido',
		'szinszam_tol',
		/*
		'szinszam_ig',
		'megjegyzes',
		'torolt',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

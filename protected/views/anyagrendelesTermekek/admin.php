<?php
/* @var $this AnyagrendelesTermekekController */
/* @var $model AnyagrendelesTermekek */

$this->breadcrumbs=array(
	'Anyagrendeles Termekeks'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AnyagrendelesTermekek', 'url'=>array('index')),
	array('label'=>'Create AnyagrendelesTermekek', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#anyagrendeles-termekek-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Anyagrendeles Termekeks</h1>

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
	'id'=>'anyagrendeles-termekek-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'anyagrendeles_id',
		'termek_id',
		'rendelt_darabszam',
		'rendeleskor_netto_darabar',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

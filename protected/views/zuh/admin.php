<?php
/* @var $this ZuhController */
/* @var $model Zuh */

$this->breadcrumbs=array(
	'Zuhs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Zuh', 'url'=>array('index')),
	array('label'=>'Create Zuh', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#zuh-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Zuhs</h1>

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
	'id'=>'zuh-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nyomasi_kategoria',
		'db_tol',
		'db_ig',
		'szin_1_db',
		'szin_2_db',
		'kiemelt:boolean',
		/*
		'szin_3_db',
		'tobb_szin_db',
		'szin_1_szazalek',
		'szin_2_szazalek',
		'szin_3_szazalek',
		'tobb_szin_szazalek',
		'aruhaz_kod',
		'megjegyzes',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

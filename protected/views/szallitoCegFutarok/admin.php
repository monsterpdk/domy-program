<?php
/* @var $this SzallitoCegFutarokController */
/* @var $model SzallitoCegFutarok */

$this->breadcrumbs=array(
	'Futárok'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List SzallitoCegFutarok', 'url'=>array('index')),
	array('label'=>'Create SzallitoCegFutarok', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#szallito-ceg-futarok-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Raktar Helyeks</h1>

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
	'id'=>'szallito-ceg-futarok-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'szallito_ceg_id',
		'nev',
		'telefon',
		'rendszam',
		'torolt',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php
/* @var $this NyomdagepTipusokController */
/* @var $model NyomdagepTipusok */

$this->breadcrumbs=array(
	'Nyomdagep Tipusoks'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List NyomdagepTipusok', 'url'=>array('index')),
	array('label'=>'Create NyomdagepTipusok', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#nyomdagep-tipusok-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Nyomdagep Tipusoks</h1>

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
	'id'=>'nyomdagep-tipusok-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'gep_id',
		'tipusnev',
		'fordulat_kis_boritek',
		'fordulat_nagy_boritek',
		'fordulat_egyeb',
		/*
		'aktiv',
		'szinszam_tol',
		'szinszam_ig',
		'torolt',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php
/* @var $this TermekArakController */
/* @var $model TermekArak */

$this->breadcrumbs=array(
	'Termek Araks'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TermekArak', 'url'=>array('index')),
	array('label'=>'Create TermekArak', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#termek-arak-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Termek Araks</h1>

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
	'id'=>'termek-arak-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'termek_id',
		'csomag_beszerzesi_ar',
		'db_beszerzesi_ar',
		'darab_ar_szamolashoz',
		'csomag_ar_nyomashoz',
		/*
		'db_ar_nyomashoz',
		'csomag_eladasi_ar',
		'db_eladasi_ar',
		'csomag_ar2',
		'db_ar2',
		'csomag_ar3',
		'db_ar3',
		'datum_mettol',
		'datum_meddig',
		'torolt',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

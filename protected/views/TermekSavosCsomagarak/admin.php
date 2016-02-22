<?php
/* @var $this TermekSavosCsomagarakController */
/* @var $model TermekSavosCsomagarak */

$this->breadcrumbs=array(
	'Termék sávos csomag árak'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TermekSavosCsomagarak', 'url'=>array('index')),
	array('label'=>'Create TermekSavosCsomagarak', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#savos-csomagarak-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Termék sávos csomag árak kezelése</h1>

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
	'id'=>'savos-csomagarak-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'termek_id',
		'termek.nev',
		'csomagszam_tol',
		'csomagszam_ig',
		'csomag_ar_szamolashoz',
		'csomag_ar_nyomashoz',
		'csomag_eladasi_ar',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

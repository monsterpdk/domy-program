<?php
/* @var $this NyomasiArakController */
/* @var $model NyomasiArak */

$this->breadcrumbs=array(
	'Nyomasi Araks'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List NyomasiArak', 'url'=>array('index')),
	array('label'=>'Create NyomasiArak', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#nyomasi-arak-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Nyomasi Araks</h1>

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
	'id'=>'nyomasi-arak-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'kategoria_tipus',
		'boritek_fajtak',
		'lehetseges_szinek',
		'peldanyszam_tol',
		'peldanyszam_ig',
		/*
		'szin_egy',
		'szin_ketto',
		'szin_harom',
		'szin_tobb',
		'grafika',
		'grafika_roviden',
		'megjegyzes',
		'ervenyesseg_tol',
		'ervenyesseg_ig',
		'user_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

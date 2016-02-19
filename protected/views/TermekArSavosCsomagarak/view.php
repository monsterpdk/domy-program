<?php
/* @var $this TermekSavosCsomagarakController */
/* @var $model TermekSavosCsomagarak */

$this->breadcrumbs=array(
	'Termék sávos csomag árak'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TermekSavosCsomagarak', 'url'=>array('index')),
	array('label'=>'Create TermekSavosCsomagarak', 'url'=>array('create')),
	array('label'=>'Update TermekSavosCsomagarak', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TermekSavosCsomagarak', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TermekSavosCsomagarak', 'url'=>array('admin')),
);
?>

<h1>#<?php echo $model->id; ?> árajánlat visszahívásainak megtekintése</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'termek_id',
		'termek.nev',
		'csomagszam_tol',
		'csomagszam_ig',
		'csomag_ar_szamolashoz',
		'csomag_ar_nyomashoz',
		'csomag_eladasi_ar',
		'torolt',
	),
)); ?>

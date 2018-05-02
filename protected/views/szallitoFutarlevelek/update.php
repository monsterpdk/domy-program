<?php
/* @var $this SzallitoFutarlevelekController */
/* @var $model SzallitoFutarlevelek */

$this->breadcrumbs=array(
	'SzallitoFutarlevelek'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1><?php echo $model->szamla_sorszam; ?> számla számú futárlevél adatai</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'aruk'=>$aruk)); ?>
<?php
/* @var $this TermekArakController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Raktárkészletek',
);

?>

<h1>Raktárkészletek</h1>

<?php	
	$this->widget('zii.widgets.jui.CJuiButton', array(
		'name'=>'button_print_raktarkeszlet',
		'caption'=>'Lista nyomtatás',
		'buttonType'=>'link',
		'url'=>Yii::app()->createUrl("raktarTermekek/printRaktarkeszlet"),
		'htmlOptions'=>array('class'=>'btn btn-success','target'=>'_blank'),
	));
?>

<?php $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
					'raktar.nev',
					'anyagbeszallitas.bizonylatszam',
					'termek.DisplayTermekTeljesNev',
					'osszes_db:number',
					'foglalt_db:number',
					'elerheto_db:number',
				)
)); ?>
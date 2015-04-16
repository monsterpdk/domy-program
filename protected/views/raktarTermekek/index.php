<?php
/* @var $this TermekArakController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Raktárkészletek',
);

?>

<h1>Raktárkészletek</h1>

<?php $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
					'raktar.nev',
					'raktar.tipus',
					'termek.nev',
					'osszes_db:number',
					'foglalt_db:number',
					'elerheto_db:number',
				)
)); ?>
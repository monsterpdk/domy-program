<?php
/* @var $this ArajanlatTetelekController */
/* @var $model ArajanlatTetelek */

?>

<h1>Árajánlat előzmények</h1>

<?php
/*
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_tetel_elozmenyek_view',
)); 
*/
?> 

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'id'=>'arajanlat-tetel_elozmenyek-gridview',
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
				array(
						'header' => 'Ajánlat sorszám',
						'value' => '$data["ajanlat_sorszam"]',
				),
				array(
						'header' => 'Dátum',
						'value' => '$data["ajanlat_datum"]',
				),
				array(
						'header' => 'Termék',
						'value' => '$data["termeknev"]',
				),
				array(
						'header' => 'Db',
						'value' => '$data["darabszam"]',
				),
				array(
						'header' => 'Nettó ár',
						'value' => 'number_format($data["netto_darabar"], 0, ",", " ") . " Ft"',	
						'htmlOptions'=>array('align'=>'right'),
				),
				array(
						'header' => 'Megrendelték',
						'type'=>'boolean',
						'value' => '$data["arajanlatbol_letrehozva"]',
						'htmlOptions'=>array('align'=>'center'),
				),
			)
)); ?>

<?php
/* @var $this TermekArakController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Eltéréslista',
);

?>

<h1>Raktár eltéréslista</h1>

<?php $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
					array(
						'name' => 'anyagrendeles.displayBizonylatszamDatum',
						'header' => 'Anyagrendelés (bizonylatszám - rendelés dátuma)',
					),
					array(
						'name' => 'anyagbeszallitas.displayBizonylatszamDatum',
						'header' => 'Anyagbeszállítas (bizonylatszám - beszállítás dátuma)',
					),
					'termek.DisplayTermekTeljesNev',
					'rendeleskor_leadott_db:number',
					array(
						'name' => 'iroda_altal_atvett_db',
						'header' => 'Iroda által átvett db',
						'type' => 'number',
						'cssClassExpression' => '$data["rendeleskor_leadott_db"] != $data["iroda_altal_atvett_db"] ? "difference" : ""',
					),
					array(
						'name' => 'raktar_altal_atvett_db',
						'header' => 'Raktár által átvett db',
						'type' => 'number',
						'cssClassExpression' => '$data["rendeleskor_leadott_db"] != $data["raktar_altal_atvett_db"] ? "difference" : ""',
					),
				)
)); ?>
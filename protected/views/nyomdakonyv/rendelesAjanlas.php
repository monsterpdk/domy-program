<?php
/* @var $this NyomdakonyvController */

$this->breadcrumbs=array(
	'Nyomdakönyv rendelés ajánlás',
);

$this->menu=array(
	array('label'=>'Nyomdakönyv szerkesztése', 'url'=>array('admin')),
);
?>

<h1>Nyomdakönyv rendelés ajánlás</h1>

<?php	
	$this->widget('zii.widgets.jui.CJuiButton', array(
		'name'=>'button_print_rendeles_ajanlas',
		'caption'=>'Lista nyomtatás',
		'buttonType'=>'link',
//		'onclick'=>'openPrintDialog()',
		'url'=>Yii::app()->createUrl("nyomdakonyv/printRendelesAjanlas"),
		'htmlOptions'=>array('class'=>'btn btn-success','target'=>'_blank'),
	));
?>

<?php
    $this->widget('ext.groupgridview.BootGroupGridView', array(
      'id' => 'rendeles_ajanlas_grid1',
      'itemsCssClass'=>'items group-grid-view',
      'dataProvider' => $dataProvider,
//      'maxMergedRows' => 5,
      'columns' => array(
						  array(
							  'name'=>'megrendeles_tetel.termek.gyarto.cegnev',
							  'header'=>$model->getAttributeLabel('megrendeles_tetel.termek.gyarto.cegnev'),
						  ),
						  array(
							  'name'=>'megrendeles_tetel.megrendelt_termek_nev',
							  'header'=>$model->getAttributeLabel('megrendeles_tetel.megrendelt_termek_nev'),
						  ),
						  array(
							  'name'=>'megrendeles_tetel.DarabszamFormazott',
							  'header'=>$model->getAttributeLabel('megrendeles_tetel.DarabszamFormazott'),
						  ),
						  array(
							  'name'=>'hianyzoDarabszam',
							  'header'=>$model->getAttributeLabel('hianyzoDarabszam'),
						  ),
						  array(
							  'name'=>'taskaszam',
							  'header'=>$model->getAttributeLabel('taskaszam'),
						  ),
						  array(
							  'name'=>'megrendeles_tetel.munka_neve',
							  'header'=>$model->getAttributeLabel('megrendeles_tetel.munka_neve'),
						  ),
		  				  array(
							  'name'=>'megrendeles_tetel.megrendeles.ugyfel.cegnev',
							  'header'=>$model->getAttributeLabel('megrendeles_tetel.megrendeles.ugyfel.cegnev'),
						  ),
						  array(
							  'name'=>'HataridoFormazott',
							  'header'=>$model->getAttributeLabel('HataridoFormazott'),
						  ),
						array(
							'header' => 'Törölt',
							'type'=>'boolean',
							'value' => '$data->torolt',
							'visible' => Yii::app()->user->checkAccess('Admin'),
						),
      ),
    ));
?>
    
<?php	
	$this->widget('zii.widgets.jui.CJuiButton', array(
		'name'=>'button_print_utemezes',
		'caption'=>'Lista nyomtatás',
		'buttonType'=>'link',
//		'onclick'=>'openPrintDialog()',
		'url'=>Yii::app()->createUrl("nyomdakonyv/printRendelesAjanlas"),
		'htmlOptions'=>array('class'=>'btn btn-success','target'=>'_blank'),
	));
?>


<script type="text/javascript">
		function openPrintDialog () {		
			window.open("/index.php/nyomdakonyv/printRendelesAjanlas","_blank") ;
		}
</script>
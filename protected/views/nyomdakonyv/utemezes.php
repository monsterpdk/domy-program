<?php
/* @var $this NyomdakonyvController */

$this->breadcrumbs=array(
	'Nyomdakönyv ütemezés',
);

$this->menu=array(
	array('label'=>'Nyomdakönyv szerkesztése', 'url'=>array('admin')),
);
?>

<h1>Nyomdakönyv ütemezés</h1>

<?php	
	$this->widget('zii.widgets.jui.CJuiButton', array(
		'name'=>'button_print_utemezes',
		'caption'=>'Lista nyomtatás',
		'buttonType'=>'link',
//		'onclick'=>'openPrintDialog()',
		'url'=>Yii::app()->createUrl("nyomdakonyv/printUtemezes"),
		'htmlOptions'=>array('class'=>'btn btn-success','target'=>'_blank'),
	));
?>

<?php
	if (count($eredmenyek) > 0) {
		$i = -1 ;
		foreach ($eredmenyek as $munkatipus_nev => $dataProvider) {
			$i++ ;
			echo '<p class="utemezes_munkatipus_nev">Munkatípus: ' . $munkatipus_nev .'</p>' ;
			$this->widget('ext.groupgridview.BootGroupGridView', array(
				'id' => 'utemezes_grid' . $i,
				'htmlOptions' => array('class' => 'grid-view utemezes-grid'),
				'itemsCssClass' => 'items group-grid-view',
				'dataProvider' => $dataProvider,
				'extraRowColumns' => array('HataridoFormazott'),
				'mergeColumns' => array('HataridoFormazott'),
				//      'maxMergedRows' => 5,
				'columns' => array(
					'HataridoFormazott',
					'taskaszam',
					'DisplayKifutok',
					'megrendeles_tetel.munka_neve',
					'megrendeles_tetel.megrendeles.ugyfel.cegnev',
					'megrendeles_tetel.megrendelt_termek_nev',
					'megrendeles_tetel.displayTermekSzinekSzama',
					'SzinErtekek',
					'megrendeles_tetel.DarabszamFormazott',
					'GyartasiIdo',
					array(
						'header' => 'Törölt',
						'type' => 'boolean',
						'value' => '$data->torolt',
						'visible' => Yii::app()->user->checkAccess('Admin'),
					),
				),
			));
		}
	}
?>
    
<?php
	$this->widget('zii.widgets.jui.CJuiButton', array(
		'name'=>'button_print_utemezes',
		'caption'=>'Lista nyomtatás',
		'buttonType'=>'link',
//		'onclick'=>'openPrintDialog()',
		'url'=>Yii::app()->createUrl("nyomdakonyv/printUtemezes"),
		'htmlOptions'=>array('class'=>'btn btn-success','target'=>'_blank'),
	));
?>


<script type="text/javascript">
		function openPrintDialog () {
			window.open("/index.php/nyomdakonyv/printUtemezes","_blank") ;
		}
</script>
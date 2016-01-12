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
    $this->widget('ext.groupgridview.BootGroupGridView', array(
      'id' => 'utemezes_grid1',
      'itemsCssClass'=>'items group-grid-view',
      'dataProvider' => $dataProvider,
      'extraRowColumns' => array('HataridoFormazott'),
      'mergeColumns' => array('HataridoFormazott'),
      'columns' => array(
      	  				'HataridoFormazott',
						'taskaszam',
						'DisplayKifutok',
						'megrendeles_tetel.munka_neve',
						'megrendeles_tetel.megrendeles.ugyfel.cegnev',
						'megrendeles_tetel.termek.DisplayTermekTeljesNev',
						'megrendeles_tetel.displayTermekSzinekSzama',
						'megrendeles_tetel.darabszam',
						'GyartasiIdo',
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
/*
	$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
				array(      
					'name'=>'hatarido',
					'value'=>'date("Y.m.d.", strtotime($data->hatarido))',
				),
                'megrendeles_tetel.megrendeles.sorszam',
				'taskaszam',
				'DisplayKifutok',
				'megrendeles_tetel.munka_neve',
				'megrendeles_tetel.megrendeles.ugyfel.cegnev',
				'megrendeles_tetel.termek.DisplayTermekTeljesNev',
				'megrendeles_tetel.displayTermekSzinekSzama',
				'megrendeles_tetel.darabszam',
				array(
					'header' => 'Törölt',
					'type'=>'boolean',
					'value' => '$data->torolt',
					'visible' => Yii::app()->user->checkAccess('Admin'),
				),
			)
)); 
*/
?>

<?php	
	// TÁ: print dialog inicializálása
/*    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogUtemezesPrint',
            
            'options'=>array(
                'title'=>'Nyomtatás',
				'width'=> '450px',
                'modal' => true,
				'buttons' => array('Ütemezés nyomtatása' => 'js:function()
				{
					model_id = $(this).data("model_id"), $(location).attr("href", "printUtemezes")
				}',
                'autoOpen'=>false,
                )
            )
            )
    );
		
	echo 'Ütemezés nyomtatási előnézete.';
			
	$this->endWidget('zii.widgets.jui.CJuiDialog');*/
?>


<script type="text/javascript">
		function openPrintDialog (button_obj) {		
			$("#dialogUtemezesPrint").dialog("open");
		}
</script>
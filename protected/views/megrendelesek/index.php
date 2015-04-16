<?php
/* @var $this MegrendelesekController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Megrendelések',
);

?>

<h1>Megrendelések</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
                'sorszam',
				'arajanlat.sorszam',
				'proforma_szamla_sorszam',
				'proforma_szamla_fizetve:boolean',
				'rendeles_idopont',
				'ugyfel.cegnev',
				'egyedi_ar:boolean',
				array(
						'header' => 'Törölt',
						'type'=>'boolean',
						'value' => '$data->torolt',
						'visible' => Yii::app()->user->checkAccess('Admin'),
				),
				array(
                        'class' => 'bootstrap.widgets.TbButtonColumn',
						'htmlOptions'=>array('style'=>'width: 130px; text-align: left;'),
                        'template' => '{print} {view} {update} {delete}',
						
			            'viewButtonOptions'=>array('class'=>'btn btn-warning btn-mini'),
						'updateButtonOptions'=>array('class'=>'btn btn-success btn-mini'),
						'deleteButtonOptions'=>array('class'=>'btn btn-danger btn-mini'),

						'buttons' => array(
							'print' => array(
								'label' => 'Nyomtatás',
								'icon'=>'icon-white icon-print',
								'options'=>array(
											'class'=>'btn btn-info btn-mini',
											'onclick' => 'js: openPrintDialog($(this))',
											),
								'visible' => "Yii::app()->user->checkAccess('Megrendelesek.Print')",
							),
							'view' => array(
								'label' => 'Megtekint',
								'icon'=>'icon-white icon-eye-open',
								'visible' => "Yii::app()->user->checkAccess('Megrendelesek.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => '(Yii::app()->user->checkAccess("Megrendelesek.Update") || Yii::app()->user->checkAccess("Admin")) && ($data->nyomdakonyv_munka_id == 0 && $data->proforma_szamla_sorszam == "")',
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => "Yii::app()->user->checkAccess('Megrendelesek.Delete')",
							),
						),
                ),
			)
)); ?>

<?php
	if (Yii::app()->user->checkAccess('Megrendelesek.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_megrendelesek',
			'caption'=>'Új megrendelés létrehozása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success'),
			'url'=>array('create'),
		));
	}
?>

<?php	
	// LI: print dialog inicializálása
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogMegrendelesPrint',
            
            'options'=>array(
                'title'=>'Proforma számla',
				'width'=> '400px',
                'modal' => true,
                //'buttons' => array('Előnézet' => 'js:function() { model_id = $(this).data("model_id"), $(location).attr("href", "printPDF?id=" + model_id)}'),
				'buttons' => array('Proforma készítése' => 'js:function() { alert ("Ide jön majd a proforma nyomtatási lehetőség."); }'),
                'autoOpen'=>false,
        )));
		
		echo '<p> Proforma számla készítése. </p>';
		
		$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type="text/javascript">
		function openPrintDialog (button_obj) {
			hrefString = button_obj.parent().children().eq(1).attr("href");
			row_id = hrefString.substr(hrefString.lastIndexOf("/") + 1);
			
			$("#dialogMegrendelesPrint").data('model_id', row_id).dialog("open");
		}
</script>
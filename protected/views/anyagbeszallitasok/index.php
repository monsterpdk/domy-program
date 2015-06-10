<?php
/* @var $this AnyagbeszallitasokController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Anyagbeszállítások',
);

?>

<h1>Anyagbeszállítások</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
                'bizonylatszam',
				'gyarto.cegnev',
				'beszallitas_datum',
				'kifizetes_datum',
				'displayOsszertek:number',
				'megjegyzes',
				'user.username',
				'anyagrendeles.displayBizonylatszamDatum',
				'lezarva:boolean',
				array(
                        'class' => 'bootstrap.widgets.TbButtonColumn',
						'htmlOptions'=>array('style'=>'width: 172px; text-align: left;'),
                        'template' => '{print} {view} {update} {delete} {create_anyagrendeles}',
						
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
								'visible' => "Yii::app()->user->checkAccess('Anyagbeszallitasok.Print')",
							),
							'view' => array(
								'label' => 'Megtekint',
								'icon'=>'icon-white icon-eye-open',
								'visible' => "Yii::app()->user->checkAccess('Anyagbeszallitasok.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => '(Yii::app()->user->checkAccess("Anyagbeszallitasok.Update") && $data->lezarva != 1) || (Yii::app()->user->checkAccess("Admin"))',
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => "Yii::app()->user->checkAccess('Anyagbeszallitasok.Delete')",
							),
							'create_anyagrendeles' => array(
								'label' => 'Anyagrendelés létrehozása',
								'icon'=>'icon-white icon-calendar',
								'options'=>array(
											'class'=>'btn btn-primary btn-mini',
											'style'=>'margin-left: 15px',
											),
								'url'=> 'Yii::app()->createUrl("anyagrendelesek/createFromBeszallitas/anyagbeszallitas_id/" . $data->id)',
								'visible' => 'Yii::app()->user->checkAccess("Anyagbeszallitasok.CreateAnyagrendeles") && $data->anyagrendeles_id != null && $data->anyagrendeles_id == 0 ',
							),
							
						),
                ),
			)
)); ?>

<?php
	if (Yii::app()->user->checkAccess('Anyagbeszallitasok.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_anyagbeszállítás',
			'caption'=>'Új anyagbeszállítás hozzáadása',
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
            'id'=>'dialogAnyagbeszallitasPrint',
            
            'options'=>array(
                'title'=>'Nyomtatás',
				'width'=> '400px',
                'modal' => true,
                'buttons' => array('Átvételi' => 'js:function() { model_id = $(this).data("model_id"), $(location).attr("href", "printPDF?id=" + model_id + "&type=atveteli");}', 'Raktár' => 'js:function() { model_id = $(this).data("model_id"), $(location).attr("href", "printPDF?id=" + model_id + "&type=raktar");}'),
                'autoOpen'=>false,
        )));
?>		
	<p> Nyomtatási mód kiválasztása </p>
	
<?php		
	$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type="text/javascript">
		function openPrintDialog (button_obj) {
			hrefString = button_obj.parent().children().eq(1).attr("href");
			row_id = hrefString.substr(hrefString.lastIndexOf("/") + 1);
			
			$("#dialogAnyagbeszallitasPrint").data('model_id', row_id).dialog("open");
		}
</script>

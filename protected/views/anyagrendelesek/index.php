<?php
/* @var $this AnyagrendelesekController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Anyagrendeleseks',
);

$this->menu=array(
	array('label'=>'Új anyagrendelés', 'url'=>array('create')),
	array('label'=>'Anyagrendelés szerkesztése', 'url'=>array('admin')),
);

?>

<h1>Anyagrendelések</h1>

<?php
	if (Yii::app()->user->checkAccess('Anyagrendelesek.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_anyagrendeles',
			'caption'=>'Új anyagrendelés hozzáadása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success'),
			'url'=>array('create'),
		));
	}
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'enableHistory' => true,
	'columns'=>array(
				array(
                        'class' => 'bootstrap.widgets.TbButtonColumn',
						'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
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
								'visible' => "Yii::app()->user->checkAccess('Anyagrendelesek.Print')",
							),
							'view' => array(
								'label' => 'Megtekint',
								'icon'=>'icon-white icon-eye-open',
								'visible' => "Yii::app()->user->checkAccess('Anyagrendelesek.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => '(Yii::app()->user->checkAccess("Anyagrendelesek.Update") && $data->lezarva != 1) || (Yii::app()->user->checkAccess("Admin"))',
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => "Yii::app()->user->checkAccess('Anyagrendelesek.Delete')",
							)
						),
                ),
                'bizonylatszam',
				'gyarto.cegnev',
				'rendeles_datum',
				'displayOsszertek:number',
				'megjegyzes',
				'user.username',
				'sztornozva:boolean',
				'lezarva:boolean',

			)
)); ?>

<?php	
	// LI: print dialog inicializálása
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogAnyagrendelesPrint',
            
            'options'=>array(
                'title'=>'Nyomtatás',
				'width'=> '400px',
                'modal' => true,
                'buttons' => array('Nyomtatás árral' => 'js:function() { model_id = $(this).data("model_id"), $(location).attr("href", "printPDF?id=" + model_id + "&type=arral");}', 'Nyomtatás ár nélkül' => 'js:function() { model_id = $(this).data("model_id"), $(location).attr("href", "printPDF?id=" + model_id + "&type=arnelkul");}'),
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
			
			$("#dialogAnyagrendelesPrint").data('model_id', row_id).dialog("open");
		}
</script>
<?php
/* @var $this SzallitolevelekController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Szállítólevelek',
);

?>

<h1><?php echo $megrendeles->sorszam; ?> megrendelés szállítólevelei</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
                'sorszam',
				'datum',
				'megjegyzes',
				'sztornozva:boolean',
				array(
						'header' => 'Törölt',
						'type'=>'boolean',
						'value' => '$data->torolt',
						'visible' => Yii::app()->user->checkAccess('Admin'),
				),
				array(
                        'class' => 'bootstrap.widgets.TbButtonColumn',
						'htmlOptions'=>array('style'=>'width: 180px; text-align: left;'),
                        'template' => '{print} {view} {update} {delete} {storno}',
						
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
								'visible' => "Yii::app()->user->checkAccess('Szallitolevelek.Print')",
							),
							'view' => array(
								'label' => 'Megtekint',
								'icon'=>'icon-white icon-eye-open',
								'visible' => "Yii::app()->user->checkAccess('Szallitolevelek.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => '(Yii::app()->user->checkAccess("Szallitolevelek.Update") || Yii::app()->user->checkAccess("Admin")) && $data->sztornozva != 1',
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => 'Yii::app()->user->checkAccess("Szallitolevelek.Delete") && $data->torolt != 1',
							),
							'storno' => array(
								'label' => 'Sztornózás',
								'icon'=>'icon-white icon-minus-sign',
								'options'=>array(
											'class'=>'btn btn-storno btn-mini',
											'style'=>'margin-left: 15px',
											'onclick' => 'js: openStornoDialog ($(this))',
											),
								'visible' => 'Yii::app()->user->checkAccess("Szallitolevelek.Storno") && $data->sztornozva != 1',
							),
						),
                ),
			)
)); ?>

<?php	
	// LI: print dialog inicializálása
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogSzellitolevelPrint',
            
            'options'=>array(
                'title'=>'Szállítólevél nyomtatása',
				'width'=> '400px',
                'modal' => true,
				'buttons' => array('Nyomtatás' => 'js:function() { model_id = $(this).data("model_id"), $(location).attr("href", "/index.php/szallitolevelek/printPDF?id=" + model_id);}'),
                'autoOpen'=>false,
        )));

		echo '<p> A kiválaszott szállítólevél és a hozzá kapcsolódó tételek nyomtatása. </p>';
		
		$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
	if (Yii::app()->user->checkAccess('Szallitolevelek.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_szallitolevlek',
			'caption'=>'Új szállítólevél létrehozása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success'),
			'url'=>array('create', 'id'=>$megrendeles->id),
		));
	}
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'select-storno-form',
	'action' => Yii::app()->createUrl("szallitolevelek/storno"),
	'enableAjaxValidation'=>false,
)); 

	echo CHtml::hiddenField('szallitolevel_id' , '', array('id' => 'szallitolevel_id'));
	
$this->endWidget(); ?>

<script type="text/javascript">
		function openPrintDialog (button_obj) {
			hrefString = button_obj.parent().children().eq(1).attr("href");
			row_id = hrefString.substr(hrefString.lastIndexOf("/") + 1);
			
			$("#dialogSzellitolevelPrint").data('model_id', row_id).dialog("open");
		}

		function openStornoDialog (button_obj) {
			var result = confirm("Biztos benne, hogy sztornózza a kiválasztott szállítóelvelet ?");
			if (result == true) {
				var hrefString = button_obj.parent().children().eq(1).attr("href");
				var row_id = hrefString.substr(hrefString.lastIndexOf("/") + 1);
				
				$('#szallitolevel_id').val (row_id);
				$('#select-storno-form').submit();
			}
		}
</script>
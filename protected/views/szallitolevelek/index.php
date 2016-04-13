<?php
/* @var $this SzallitolevelekController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Szállítólevelek',
);

?>

<h1><?php echo $megrendeles->sorszam; ?> megrendelés szállítólevelei</h1>

<?php
    Yii::app()->clientScript->registerScript(
       'myHideEffect',
       '$(".flash-success").animate({opacity: 1.0}, 3000).fadeOut("slow");',
       CClientScript::POS_READY
    );
?>
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

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

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
                'sorszam',
				'datum',
				'megjegyzes',
				'nyomtatva:boolean',
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
								'visible' => "Yii::app()->user->checkAccess('Szallitolevelek.PrintPDF')",
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
				'buttons' => array('Nyomtatás' => 'js:function() {
						var copies = $("#print_copies").val();
						var futarszolgalatos = $("#checkboxFutarszolgalatos").prop("checked") ? 1 : 0;
						
						if ( (copies % 1 === 0) && (copies > 0) ) {
							model_id = $(this).data("model_id");
							$(location).attr("href", "/index.php/szallitolevelek/printPDF?id=" + model_id + "&copies=" + copies + "&futaros=" + futarszolgalatos);
						} else {
							alert("Hibás a beírt példányszám:" + copies);
							return false;
						}
				}'),
                'autoOpen'=>false,
        )));

		echo '<p> A kiválaszott szállítólevél és a hozzá kapcsolódó tételek nyomtatása. </p>';
		
		echo 'Példányszám:';
		
			$this->widget("ext.maskedInput.MaskedInput", array(
					"name" => "print_copies",
					"value" => 3,
					"mask" => '99',
					"defaults" =>array('placeholder' =>''),
					"options" => array ('style' => 'width:40px!important'),
				));

		echo ' db <br /> Futárszolgálatos ';

		echo CHtml::checkbox ("checkboxFutarszolgalatos", false);
		
		$this->endWidget('zii.widgets.jui.CJuiDialog');
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
<?php
/* @var $this NyomdakonyvController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Nyomdakönyv',
);

$this->menu=array(
	array('label'=>'Nyomdakönyv szerkesztése', 'url'=>array('admin')),
);
?>

<h1>Nyomdakönyv</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
				array(
					'class' => 'bootstrap.widgets.TbButtonColumn',
					'htmlOptions'=>array('style'=>'width: 130px; text-align: left;'),
					'template' => '{update} {delete} {storno}',
					
					'updateButtonOptions'=>array('class'=>'btn btn-success btn-mini'),
					'deleteButtonOptions'=>array('class'=>'btn btn-danger btn-mini'),

					'buttons' => array(
						'update' => array(
							'label' => 'Szerkeszt',
							'icon'=>'icon-white icon-pencil',
							'visible' => "Yii::app()->user->checkAccess('Nyomdakonyv.Update')",
						),
						'delete' => array(
							'label' => 'Töröl',
							'icon'=>'icon-white icon-remove-sign',
							'visible' => 'Yii::app()->user->checkAccess("Nyomdakonyv.Delete") && $data->torolt != 1',
						),
						'storno' => array(
							'label' => 'Sztornózás',
							'icon'=>'icon-white icon-minus-sign',
							'options'=>array(
										'class'=>'btn btn-storno btn-mini',
										'style'=>'margin-left: 15px',
										'onclick' => 'js: openStornoSelectDialog ($(this))',
										),
							'visible' => 'Yii::app()->user->checkAccess("Nyomdakonyv.Storno") && $data->sztornozva != 1',
						),
					),
                ),
                'megrendeles_tetel.megrendeles.sorszam',
				'taskaszam',
				'hatarido',
				array(
					'header' => 'Munka neve',
					'value' => 'mb_strtoupper($data->megrendeles_tetel->munka_neve, "UTF-8")',
				),
				'megrendeles_tetel.megrendeles.ugyfel.id',
				'megrendeles_tetel.megrendeles.ugyfel.cegnev_teljes',
				'megrendeles_tetel.termek.displayTermekTeljesNev',
				'megrendeles_tetel.displayTermekSzinekSzama',
				'megrendeles_tetel.darabszam',
				array(
					'header' => 'Törölt',
					'type'=>'boolean',
					'value' => '$data->torolt',
					'visible' => Yii::app()->user->checkAccess('Admin'),
				),
			)
)); ?>

<?php	
	// LI: sztornózás oka dialog inicializálása
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogStornozas',
            
            'options'=>array(
                'title'=>'Sztornózás oka',
				'width'=> '400px',
                'modal' => true,
				'buttons' => array('Ok' => 'js:function() { model_id = $(this).data("model_id"); storno (model_id) }', 'Mégse' => 'js:function() { $("#dialogStornozas").dialog("close"); }'),
                'autoOpen'=>false,
        )));
		
		echo "Sztornózás oka:";
		
		$options = CHtml::listData(SztornozasOkok::model()->findAll(),'ok', 'ok');
		echo CHtml::dropDownList('sztornozasOk', '', $options, array('empty'=>''));

		$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'select-storno-form',
	'action' => Yii::app()->createUrl("nyomdakonyv/storno"),
	'enableAjaxValidation'=>false,
)); 

	echo CHtml::hiddenField('selected_storno' , '', array('id' => 'selected_storno'));
	echo CHtml::hiddenField('nyomdakonyv_id' , '', array('id' => 'nyomdakonyv_id'));
	
$this->endWidget(); ?>

<script type="text/javascript">

	function openStornoSelectDialog (button_obj) {
		hrefString = button_obj.parent().children().eq(1).attr("href");
		row_id = hrefString.substr(hrefString.lastIndexOf("/") + 1);
		
		$("#dialogStornozas").data('model_id', row_id).dialog("open");			
		
		return false;
	}
	
	function storno (model_id) {
        $('#selected_storno').val ($('#sztornozasOk').val());
		$('#nyomdakonyv_id').val (model_id);

		$('#select-storno-form').submit();
	}
	
</script>
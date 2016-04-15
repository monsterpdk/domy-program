<?php
/* @var $this RaktarKiadasokController */
/* @var $dataProvider CActiveDataProvider */
?>

<h1>Raktár kiadások</h1>

<?php
	if (Yii::app()->user->checkAccess('RaktarKiadasok.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_raktar_kiadas',
			'caption'=>'Új raktár kiadás hozzáadása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success'),
			'url'=>array('create'),
		));
	}
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'raktar-kiadasok-grid',
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'enableHistory' => true,
	'columns'=>array(
				array(
                        'class' => 'bootstrap.widgets.TbButtonColumn',
						'htmlOptions'=>array('style'=>'width: 130px; text-align: left;'),
                        'template' => '{view} {update} {storno}',
						
			            'viewButtonOptions'=>array('class'=>'btn btn-warning btn-mini'),
						'updateButtonOptions'=>array('class'=>'btn btn-success btn-mini'),

						'buttons' => array(
							'view' => array(
								'label' => 'Megtekint',
								'icon'=>'icon-white icon-eye-open',
								'visible' => "Yii::app()->user->checkAccess('RaktarKiadasok.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => "Yii::app()->user->checkAccess('RaktarKiadasok.Update')",
							),
							'storno' => array(
								'label' => 'Sztornózás',
								'icon'=>'icon-white icon-minus-sign',
								'options'=>array(
											'class'=>'btn btn-storno btn-mini',
											'style'=>'margin-left: 15px',
											'onclick' => 'js: storno ($(this))',
											),
								'visible' => 'Yii::app()->user->checkAccess("RaktarKiadasok.Storno") && $data->sztornozva != 1',
							),
						),
                ),
                'termek.DisplayTermekTeljesNev',
				'darabszam',
				'nyomdakonyv.taskaszam',
				array(
						'header' => 'Sztornózva',
						'type'=>'boolean',
						'value' => '$data->sztornozva',
						'visible' => Yii::app()->user->checkAccess('Admin'),
				),
			)
)); ?>

<script type="text/javascript">
	function storno (button_obj) {
		hrefString = button_obj.parent().children().eq(1).attr("href");
		row_id = hrefString.substr(hrefString.lastIndexOf("/") + 1);
		
		$('#raktarkiadas_id').val (row_id);
		$('#select-storno-form').submit();
	}
</script>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'select-storno-form',
	'action' => Yii::app()->createUrl("raktarKiadasok/storno"),
	'enableAjaxValidation'=>false,
)); 

	echo CHtml::hiddenField('raktarkiadas_id' , '', array('id' => 'raktarkiadas_id'));
	
$this->endWidget(); ?>
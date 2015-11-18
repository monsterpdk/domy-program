<?php
/* @var $this TermekArakController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Termekárak',
);

?>

<h1>Termékárak</h1>

<?php
	if (Yii::app()->user->checkAccess('TermekArak.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_termekar',
			'caption'=>'Új termékár hozzáadása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success'),
			'url'=>array('create'),
		));
	}
	
		// import gomb megjelenítése
	$this->widget('xupload.XUpload', array(
			'url' => Yii::app()->createUrl("termekArak/upload"),
			'model' => $model,
			'attribute' => 'file',
			'htmlOptions'=>array('class'=>'pull-right'),
			'multiple' => false,
			      'options'=>array(
                              'acceptFileTypes'=>'js:/(\.|\/)(csv)$/i',
							  ),
	));
?>

<?php $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
				array(
                        'class' => 'bootstrap.widgets.TbButtonColumn',
						'htmlOptions'=>array('style'=>'width: 130px; text-align: left;'),
                        'template' => '{view} {update} {delete}',
						
			            'viewButtonOptions'=>array('class'=>'btn btn-warning btn-mini'),
						'updateButtonOptions'=>array('class'=>'btn btn-success btn-mini'),
						'deleteButtonOptions'=>array('class'=>'btn btn-danger btn-mini'),

						'buttons' => array(
							'view' => array(
								'label' => 'Megtekint',
								'icon'=>'icon-white icon-eye-open',
								'visible' => "Yii::app()->user->checkAccess('TermekArak.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => "Yii::app()->user->checkAccess('TermekArak.Update')",
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => 'Yii::app()->user->checkAccess("TermekArak.Delete") && $data->torolt != 1',
							)
						),
                ),
                'termek.nev',
				array(										
					'name'=>'termek.belesnyomott',
					'type'=>'raw',
					'value'=>function ($model, $index, $widget) {
						return CHtml::checkbox('termek.belesnyomott[]', $model->termek->belesnyomott, ['value' => $index, 'disabled' => true]);
					},
					'htmlOptions'=>array('align'=>'center',),
					'cssClassExpression' => '$data->termek->belesnyomott == 1 ? "yellow" : ""',
				),
				'csomag_beszerzesi_ar:number',
				'db_beszerzesi_ar:number',
				'csomag_ar_nyomashoz:number',
				'db_ar_nyomashoz:number',
				'csomag_eladasi_ar:number',
				'db_eladasi_ar:number',
				'csomag_ar2:number',
				'db_ar2:number',
				'csomag_ar3:number',
				'db_ar3:number',
				'datum_mettol',
				'datum_meddig',
				array(
						'header' => 'Törölt',
						'type'=>'boolean',
						'value' => '$data->torolt',
						'visible' => Yii::app()->user->checkAccess('Admin'),
				),
			)
)); ?>

<?php
	// export gomb megjelenítése
	$this->renderExportGridButton($gridWidget,'Exportálás', array('class'=>'btn btn-info ui-button ui-widget ui-button-text-only pull-right'));
?>
<?php
/* @var $this TermekekController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Termékek',
);

?>

<h1>Termékek</h1>


<?php $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
                'nev',
				'kodszam',
				'meret.nev',
				'suly:number',
				'zaras.nev',
				'ablakmeret.nev',
				'ablakhely.nev',
				'papirtipus.nev',
				'afakulcs.afa_szazalek',
				'redotalp',
				'gyarto.cegnev',
				'megjelenes_mettol',
				'megjelenes_meddig',
				array(
						'header' => 'Törölt',
						'type'=>'boolean',
						'value' => '$data->torolt',
						'visible' => Yii::app()->user->checkAccess('Admin'),
				),
				array(
                        'class' => 'bootstrap.widgets.TbButtonColumn',
						'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
                        'template' => '{view} {update} {delete}',
						
			            'viewButtonOptions'=>array('class'=>'btn btn-warning btn-mini'),
						'updateButtonOptions'=>array('class'=>'btn btn-success btn-mini'),
						'deleteButtonOptions'=>array('class'=>'btn btn-danger btn-mini'),

						'buttons' => array(
							'view' => array(
								'label' => 'Megtekint',
								'icon'=>'icon-white icon-eye-open',
								'visible' => "Yii::app()->user->checkAccess('Termekek.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => "Yii::app()->user->checkAccess('Termekek.Update')",
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => "Yii::app()->user->checkAccess('Termekek.Delete')",
							)
						),
                ),
			)
)); ?>

<?php
	if (Yii::app()->user->checkAccess('Termekek.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_termek',
			'caption'=>'Új termék hozzáadása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success'),
			'url'=>array('create'),
		));
	}
	
	// import gomb megjelenítése
	$this->widget('xupload.XUpload', array(
			'url' => Yii::app()->createUrl("termekek/upload"),
			'model' => $model,
			'attribute' => 'file',
			'htmlOptions'=>array('class'=>'pull-right'),
			'multiple' => false,
			      'options'=>array(
                              'acceptFileTypes'=>'js:/(\.|\/)(csv)$/i',
							  ),
	));
	
	// export gomb megjelenítése
	$this->renderExportGridButton($gridWidget,'Exportálás', array('class'=>'btn btn-info ui-button ui-widget ui-button-text-only pull-right'));
?>
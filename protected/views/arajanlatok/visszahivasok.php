<?php
/* @var $this ArajanlatokController */
/* @var $dataProvider CActiveDataProvider */

	$this->breadcrumbs=array(
		'Visszahívásaim',
	);

?>

<h1>Visszahívásaim</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model -> visszahivasok_search(),
	'id'=>'arajanlatok-gridview',
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
				array(
                        'class' => 'bootstrap.widgets.TbButtonColumn',
						'htmlOptions'=>array('style'=>'width: 220px; text-align: left;'),
                        'template' => '{view} {update}',
						
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
								'visible' => "Yii::app()->user->checkAccess('Arajanlatok.Print')",
							),
							'view' => array(
								'label' => 'Megtekint',
								'icon'=>'icon-white icon-eye-open',
								'visible' => "Yii::app()->user->checkAccess('Arajanlatok.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => '(Yii::app()->user->checkAccess("Arajanlatok.Update") && $data->van_megrendeles == 0) || Yii::app()->user->checkAccess("Admin")',
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => 'Yii::app()->user->checkAccess("Arajanlatok.Delete") && $data->torolt != 1',
							),
						),
                ),
                'sorszam',
                'kovetkezo_hivas_ideje',
				array(
					'name'=>'ugyfel.cegnev',
					'htmlOptions'=>array('width'=>'500'),
				 ),
				'ugyfel_tel',
				'ajanlat_datum',
			)
)); ?>

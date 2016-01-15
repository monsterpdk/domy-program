<?php
/* @var $this ZuhController */
/* @var $dataProvider CActiveDataProvider */
?>

<h1>Zuh</h1>

<?php
	if (Yii::app()->user->checkAccess('Zuh.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_zuh',
			'caption'=>'Új zuh hozzáadása',
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
						'htmlOptions'=>array('style'=>'width: 130px; text-align: left;'),
                        'template' => '{view} {update} {delete}',
						
			            'viewButtonOptions'=>array('class'=>'btn btn-warning btn-mini'),
						'updateButtonOptions'=>array('class'=>'btn btn-success btn-mini'),
						'deleteButtonOptions'=>array('class'=>'btn btn-danger btn-mini'),

						'buttons' => array(
							'view' => array(
								'label' => 'Megtekint',
								'icon'=>'icon-white icon-eye-open',
								'visible' => "Yii::app()->user->checkAccess('Zuh.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => "Yii::app()->user->checkAccess('Zuh.Update')",
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => 'Yii::app()->user->checkAccess("Zuh.Delete")',
							)
						),
                ),
				'nyomasi_kategoria',
				'db_tol',
				'db_ig',
				'szin_1_db',
				'szin_2_db',
				'szin_3_db',
				'tobb_szin_db',
				'szin_1_szazalek',
				'szin_2_szazalek',
				'szin_3_szazalek',
				'tobb_szin_szazalek',
				'aruhaz.display_aruhazkod_nev',
			)
)); ?>
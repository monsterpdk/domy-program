<?php
/* @var $this GyartokController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Gyártók',
);

$this->menu=array(
	array('label'=>'Új gyártó', 'url'=>array('create')),
	array('label'=>'Gyártó szerkesztése', 'url'=>array('admin')),
);
?>

<h1>Gyártók</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
                'cegnev',
				'kapcsolattarto',
				'cim',
				'telefon',
				'fax',
				'netto_ar:boolean',
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
								'visible' => "Yii::app()->user->checkAccess('Gyartok.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => "Yii::app()->user->checkAccess('Gyartok.Update')",
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => "Yii::app()->user->checkAccess('Gyartok.Delete')",
							)
						),
                ),
			)
)); ?>

<?php
	if (Yii::app()->user->checkAccess('Gyartok.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_gyarto',
			'caption'=>'Új gyártó hozzáadása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success'),
			'url'=>array('create'),
		));
	}
?>
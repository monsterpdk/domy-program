<?php
/* @var $this UgyfelUgyintezokController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ügyfélügyintézők',
);

$this->menu=array(
	array('label'=>'Új ügyfélügyintéző', 'url'=>array('create')),
	array('label'=>'Ügyfélügyintéző szerkesztése', 'url'=>array('admin')),
);
?>

<h1>Ügyfélügyintézők</h1>

<?php
	if (Yii::app()->user->checkAccess('UgyfelUgyintezok.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_ugyfelugyintezo',
			'caption'=>'Új ügyfélügyintéző hozzáadása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success'),
			'url'=>array('create'),
		));
	}
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
                'ugyfel.cegnev',
				'nev',
				'telefon',
				'email',
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
								'visible' => "Yii::app()->user->checkAccess('UgyfelUgyintezok.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => "Yii::app()->user->checkAccess('UgyfelUgyintezok.Update')",
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => "Yii::app()->user->checkAccess('UgyfelUgyintezok.Delete')",
							)
						),
                ),
			)
)); ?>
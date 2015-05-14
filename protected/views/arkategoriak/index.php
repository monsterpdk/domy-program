<?php
/* @var $this ArkategoriakController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Árkategóriák',
);

$this->menu=array(
	array('label'=>'Új árkategória', 'url'=>array('create')),
	array('label'=>'Árkategória szerkesztése', 'url'=>array('admin')),
);
?>

<h1>Árkategóriák</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
                'nev',
				'szorzo',
				array(
						'header' => 'Törölt',
						'type'=>'boolean',
						'value' => '$data->torolt',
						'visible' => Yii::app()->user->checkAccess('Admin'),
				),
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
								'visible' => "Yii::app()->user->checkAccess('Arkategoriak.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => "Yii::app()->user->checkAccess('Arkategoriak.Update')",
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => 'Yii::app()->user->checkAccess("Arkategoriak.Delete") && $data->torolt != 1',
							)
						),
                ),
			)
)); ?>

<?php
	if (Yii::app()->user->checkAccess('Arkategoriak.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_arkategoria',
			'caption'=>'Új árkategória hozzáadása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success'),
			'url'=>array('create'),
		));
	}
?>
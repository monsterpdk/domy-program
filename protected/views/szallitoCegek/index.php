<?php
/* @var $this RaktarakController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Szállító cégek',
);

$this->menu=array(
	array('label'=>'Új szállító', 'url'=>array('create')),
	array('label'=>'Szállító szerkesztése', 'url'=>array('admin')),
);
?>

<h1>Szállító cégek</h1>

<?php
	if (Yii::app()->user->checkAccess('SzallitoCegek.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_szallito',
			'caption'=>'Új szállító cég hozzáadása',
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
								'visible' => 'Yii::app()->user->checkAccess("SzallitoCegek.View")',
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => 'Yii::app()->user->checkAccess("SzallitoCegek.Update")',
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => 'Yii::app()->user->checkAccess("SzallitoCegek.Delete")',
							)
						),
                ),
                'nev',
				array(
						'header' => 'Törölt',
						'type'=>'boolean',
						'value' => '$data->torolt',
						'visible' => Yii::app()->user->checkAccess('Admin'),
				),
			)
)); ?>
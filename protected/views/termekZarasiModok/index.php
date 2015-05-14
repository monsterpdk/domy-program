<?php
/* @var $this TermekZarasiModokController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Zárásmódok',
);

?>

<h1>Zárásmódok</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
                'nev',
				'aktiv:boolean',
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
								'visible' => "Yii::app()->user->checkAccess('TermekZarasiModok.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => "Yii::app()->user->checkAccess('TermekZarasiModok.Update')",
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => 'Yii::app()->user->checkAccess("TermekZarasiModok.Delete") && $data->torolt != 1',
							)
						),
                ),
			)
)); ?>

<?php
	if (Yii::app()->user->checkAccess('TermekZarasiModok.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_zarasmod',
			'caption'=>'Új zárásmód hozzáadása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success'),
			'url'=>array('create'),
		));
	}
?>
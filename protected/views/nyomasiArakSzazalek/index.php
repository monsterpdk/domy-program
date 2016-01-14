<?php
/* @var $this NyomasiArakSzazalekController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Nyomási termékár %',
);

?>
<h1>Nyomási árak</h1>

<?php

	if (Yii::app()->user->checkAccess('NyomasiArakSzazalek.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_nyomasi_ar_szazalek',
			'caption'=>'Új nyomási termékár hozzáadása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success'),
			'url'=>array('create'),
		));
	}
	
?>

<?php
	$this->widget('zii.widgets.jui.CJuiButton', array(
		'name'=>'button_search_nyomasi_ar',
		'caption'=>'Keresés',
		'buttonType'=>'link',
		'htmlOptions'=>array('class'=>'btn btn-primary search-button'),
	));
?>

<?php $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'id'=>'nyomasi-arak-szazelek-gridview',
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
								'visible' => "Yii::app()->user->checkAccess('NyomasiArakSzazalek.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => "Yii::app()->user->checkAccess('NyomasiArakSzazalek.Update')",
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => 'Yii::app()->user->checkAccess("NyomasiArakSzazalek.Delete") && $data->torolt != 1',
							)
						),
                ),
				'peldanyszam_tol',
				'peldanyszam_ig',
				'alap:number',
				'kp:number',
				'utal:number',
				'kis_tetel:number',
				'nagy_tetel:number',
				'user.username',
				array(
						'header' => 'Törölt',
						'type'=>'boolean',
						'value' => '$data->torolt',
						'visible' => Yii::app()->user->checkAccess('Admin'),
				),
			)
)); ?>
<?php
/* @var $this NyomasiArakController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Nyomási árak',
);

	Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('.search-form form').submit(function(){
			$.fn.yiiGridView.update('nyomasi-arak-gridview', { 
				data: $(this).serialize()
			});
			return false;
		});
	");
	
?>

<h1>Nyomási árak</h1>

<?php
	$this->widget('zii.widgets.jui.CJuiButton', array(
		'name'=>'button_search_nyomasi_ar',
		'caption'=>'Keresés',
		'buttonType'=>'link',
		'htmlOptions'=>array('class'=>'bt btn-primary search-button'),
	));
?>

<div class="search-form" style="display:none">
	<?php  $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
</div>

<?php $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model -> search(),
	'id'=>'nyomasi-arak-gridview',
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
				'kategoria_tipus',
				'boritek_fajtak',
				'grafika_roviden',
				'lehetseges_szinek',
				'peldanyszam_tol',
				'peldanyszam_ig',
				'szin_egy:number',
				'szin_ketto:number',
				'szin_harom:number',
				'szin_tobb:number',
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
								'visible' => "Yii::app()->user->checkAccess('NyomasiArak.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => "Yii::app()->user->checkAccess('NyomasiArak.Update')",
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => "Yii::app()->user->checkAccess('NyomasiArak.Delete')",
							)
						),
                ),
			)
)); ?>

<?php

	if (Yii::app()->user->checkAccess('NyomasiArak.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_nyomasi_ar',
			'caption'=>'Új nyomási ár hozzáadása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success'),
			'url'=>array('create'),
		));
	}
	
?>
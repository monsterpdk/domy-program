<?php
/* @var $this NyomasiArakController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Nyomási árak',
);

/*
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
	*/
?>

<h1>Nyomási árak</h1>

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

<?php
/*
	$this->widget('zii.widgets.jui.CJuiButton', array(
		'name'=>'button_search_nyomasi_ar',
		'caption'=>'Keresés',
		'buttonType'=>'link',
		'htmlOptions'=>array('class'=>'btn btn-primary search-button'),
	));
*/	
?>

<div class="search-form">
	<?php  $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
</div>

<?php $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model -> search(),
	'id'=>'nyomasi-arak-gridview',
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
								'visible' => 'Yii::app()->user->checkAccess("NyomasiArak.Delete") && $data->torolt != 1',
							)
						),
                ),
				'kategoria_tipus',
				'boritek_fajtak',
				'grafika_roviden',
				'lehetseges_szinek',
				'peldanyszam_tol',
				'peldanyszam_ig',
				array(
						'header'=>'Egy szín <br />(Ft / db)',
						'value'=>function($data){
							return number_format($data->szin_egy, 2);
						},					
				),
				array(
						'header'=>'Két szín <br />(Ft / szín / db)',
						'value'=>function($data){
							return number_format($data->szin_ketto, 2);
						},					
				),
				array(
						'header'=>'Három szín <br />(Ft / szín / db)',
						'value'=>function($data){
							return number_format($data->szin_harom, 2);
						},					
				),
				array(
						'header'=>'Több szín <br />(Ft / szín / db)',
						'value'=>function($data){
							return number_format($data->szin_tobb, 2);
						},					
				),
				array(
						'header' => 'Törölt',
						'type'=>'boolean',
						'value' => '$data->torolt',
						'visible' => Yii::app()->user->checkAccess('Admin'),
				),
			)
)); ?>
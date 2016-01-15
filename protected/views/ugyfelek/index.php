<?php
	/* @var $this UgyfelekController */
	/* @var $dataProvider CActiveDataProvider */

	$this->breadcrumbs=array(
		'Ügyfelek',
	);

	Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('.search-form form').submit(function(){
			$.fn.yiiGridView.update('ugyfelek-gridview', { 
				data: $(this).serialize()
			});
			return false;
		});
	");
?>

<h1>Ügyfelek</h1>

<?php
	$this->widget('zii.widgets.jui.CJuiButton', array(
		'name'=>'button_search_ugyfel',
		'caption'=>'Keresés',
		'buttonType'=>'link',
		'htmlOptions'=>array('class'=>'btn btn-primary search-button'),
	));
?>

<?php
	if (Yii::app()->user->checkAccess('Ugyfelek.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_ugyfel',
			'caption'=>'Új ügyfél hozzáadása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success'),
			'url'=>array('create'),
		));
	}
?>

<div class="search-form" style="display:none">
	<?php  $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
</div>

<?php $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model -> search(),
	'id'=>'ugyfelek-gridview',
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
								'visible' => "Yii::app()->user->checkAccess('Ugyfelek.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => "Yii::app()->user->checkAccess('Ugyfelek.Update')",
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => 'Yii::app()->user->checkAccess("Ugyfelek.Delete") && $data->torolt != 1',
							)
						),
                ),
                'id',
				'cegnev',
				'cegforma_dsp.cegforma',
				'arkategoria_dsp.nev',
				'szekhely_irsz',
				'szekhely_varos',
				'szekhely_cim',
				'kapcsolattarto_nev',
				'kapcsolattarto_telefon',
				'kapcsolattarto_email',
				'email_engedelyezett:boolean',
				'adoszam',
				'teaor',
				'tevekenysegi_kor',
				'szamlaszam1',
				'szamlaszam2',
				'display_ugyfel_ugyintezok',
				'elso_vasarlas_datum',
				'utolso_vasarlas_datum',
				'megjegyzes',
				'felvetel_idopont',
				array(
						'header' => 'Törölt',
						'type'=>'boolean',
						'value' => '$data->torolt',
						'visible' => Yii::app()->user->checkAccess('Admin'),
				),
			)
)); ?>

<?php
	// export gomb megjelenítése
	$this->renderExportGridButton($gridWidget,'Exportálás', array('class'=>'btn btn-info ui-button ui-widget ui-button-text-only pull-right'));
?>
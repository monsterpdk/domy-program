<?php
/* @var $this SzallitoFutarlevelekController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Futárlevelek',
);

	set_time_limit(0);

?>

<h1>Futárlevelek</h1>

<?php
	if (Yii::app()->user->checkAccess('SzallitoFutarlevelek.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_futarlevel',
			'caption'=>'Új futárlevél hozzáadása',
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
						'htmlOptions'=>array('style'=>'width: 172px; text-align: left;'),
                        'template' => '{print} {view} {update} {delete}',
						
			            'viewButtonOptions'=>array('class'=>'btn btn-warning btn-mini'),
						'updateButtonOptions'=>array('class'=>'btn btn-success btn-mini'),
						'deleteButtonOptions'=>array('class'=>'btn btn-danger btn-mini'),
						
						'buttons' => array(
							'print' => array(
								'label' => 'Nyomtatás',
								'icon'=>'icon-white icon-print',
								'options'=>array(
											'class'=>'btn btn-info btn-mini',
											'onclick' => 'js: openPrintDialog($(this))',
											),
								'visible' => "Yii::app()->user->checkAccess('SzallitoFutarlevelek.Print')",
							),
							'view' => array(
								'label' => 'Megtekint',
								'icon'=>'icon-white icon-eye-open',
								'visible' => "Yii::app()->user->checkAccess('SzallitoFutarlevelek.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => 'Yii::app()->user->checkAccess("SzallitoFutarlevelek.Update")',
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => 'Yii::app()->user->checkAccess("SzallitoFutarlevelek.Delete")',
							),

						),
                ),
                'id',
                'szallitolevel_szam',
				'szamla_sorszam',
				'szallito_ceg.nev',
				'felvetel_helye',
				'felvetel_ideje',
			)
)); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',
	array(
		'id'=>'dialogFutarlevelPrint',

		'options'=>array(
			'title'=>'Nyomtatás',
			'width'=> '400px',
			'modal' => true,
			'buttons' => array('PDF készítése' => 'js:function() { model_id = $(this).data("model_id"), $(location).attr("href", "printPDF?id=" + model_id);}'),
			'autoOpen'=>false,
		)));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>		

<script type="text/javascript">
		function openPrintDialog (button_obj) {
			hrefString = button_obj.parent().children().eq(1).attr("href");
			row_id = hrefString.substr(hrefString.lastIndexOf("/") + 1);
			
			$("#dialogFutarlevelPrint").data('model_id', row_id).dialog("open");
		}
</script>

<?php
/* @var $this ArajanlatokController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Árajánlatok',
);

?>

<h1>Árajánlatok</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
                'sorszam',
				array(
					'name'=>'ugyfel.cegnev',
					'htmlOptions'=>array('width'=>'500'),
				 ),
				'ajanlat_datum',
				'van_megrendeles:boolean',
				'egyedi_ar:boolean',
				array(
						'header' => 'Törölt',
						'type'=>'boolean',
						'value' => '$data->torolt',
						'visible' => Yii::app()->user->checkAccess('Admin'),
				),
				array(
                        'class' => 'bootstrap.widgets.TbButtonColumn',
						'htmlOptions'=>array('style'=>'width: 220px; text-align: left;'),
                        'template' => '{print} {view} {update} {delete} {create_megrendeles} {send_via_email}',
						
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
								'visible' => "Yii::app()->user->checkAccess('Arajanlatok.Print')",
							),
							'view' => array(
								'label' => 'Megtekint',
								'icon'=>'icon-white icon-eye-open',
								'visible' => "Yii::app()->user->checkAccess('Arajanlatok.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => '(Yii::app()->user->checkAccess("Arajanlatok.Update") && $data->van_megrendeles == 0) || Yii::app()->user->checkAccess("Admin")',
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => 'Yii::app()->user->checkAccess("Arajanlatok.Delete") && $data->torolt != 1',
							),
							'create_megrendeles' => array(
								'label' => 'Megrendelés létrehozása',
								'icon'=>'icon-white icon-calendar',
								'options'=>array(
											'class'=>'btn btn-primary btn-mini',
											'style'=>'margin-left: 15px',
											'onclick' => 'js: openTetelSelectDialog ($(this))',
											),
								'visible' => 'Yii::app()->user->checkAccess("Megrendelesek.CreateMegrendeles") && $data->van_megrendeles == 0 && $data->torolt == 0 && !(Utils::reachedUgyfelLimit ($data->id)) ',
							),
							'send_via_email' => array(
								'label' => 'Megrendelés küldése e-mailben',
								'icon'=>'icon-white icon-envelope',
								'options'=>array(
											'class'=>'btn btn-info btn-mini',
											'style'=>'margin-left: 15px',
											),
								//'url'=> 'Yii::app()->createUrl("arajanlatok/sendViaEmail/arajanlat_id/" . $data->id)',
								'visible' => 'Yii::app()->user->checkAccess("Megrendelesek.CreateMegrendeles") && $data->torolt == 0 ',
							),
						),
                ),
			)
)); ?>

<?php
	if (Yii::app()->user->checkAccess('Arajanlatok.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_arajanlatok',
			'caption'=>'Új árajánlat létrehozása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success'),
			'url'=>array('create'),
		));
	}
?>

<?php	
	// LI: print dialog inicializálása
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
	array(
		'id'=>'dialogArajanlatPrint',
		
		'options'=>array(
			'title'=>'Nyomtatás',
			'width'=> '400px',
			'modal' => true,
			'buttons' => array('Előnézet' => 'js:function() { model_id = $(this).data("model_id"), $(location).attr("href", "printPDF?id=" + model_id)}'),
			'autoOpen'=>false,
	)));
	
	echo '<p> Árajánlat nyomtatási előnézete. </p>';
	
	$this->endWidget('zii.widgets.jui.CJuiDialog');
	
	// ha megrendelésre visszük az árajánlatot, akkor előtte ki kell választani, hogy mely tételeket visszük át
	// ez a rész erre a célra szolgál, ide fog az ajax lekérés válasza render-elődni
	
	echo "<div id='divForGrid'></div>";

?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'select-tetel-form',
	'action' => Yii::app()->createUrl("megrendelesek/createFromArajanlat"),
	'enableAjaxValidation'=>false,
)); 

	echo CHtml::hiddenField('selected_tetel_list' , '', array('id' => 'selected_tetel_list'));
	echo CHtml::hiddenField('arajanlat_id' , '', array('id' => 'arajanlat_id'));
	
$this->endWidget(); ?>

<script type="text/javascript">

	function openPrintDialog (button_obj) {
		hrefString = button_obj.parent().children().eq(1).attr("href");
		row_id = hrefString.substr(hrefString.lastIndexOf("/") + 1);
		
		$("#dialogArajanlatPrint").data('model_id', row_id).dialog("open");
	}
	
	function openTetelSelectDialog (button_obj) {
		hrefString = button_obj.parent().children().eq(1).attr("href");
		row_id = hrefString.substr(hrefString.lastIndexOf("/") + 1);
		grid_id = new Date().getTime();
		
		// lekérjük a gridview-t
		<?php echo CHtml::ajax(array(
			'url'=> "js:'/index.php/arajanlatok/getTetelList/arajanlat_id/' + row_id + '/grid_id/' + grid_id",
			'data'=> "js:$(this).serialize()",
			'type'=>'post',
			'id' => 'tetel-list-'.uniqid(),
			'replace' => '',
			'success'=>"function(data)
			{
				$('#divForGrid').html(data);
				$('#dialogTetelSelect').data('grid_id', grid_id);
				$('#dialogTetelSelect').data('model_id', row_id).dialog('open');
			} ",
		))?>;
			
		return false;
	}
	
	function createMegrendelesWithSelectedTeteList (arajanlat_id, grid_id, buttonObj)
	{
		var arraySel = $("#arajanlatTetelek-grid" + grid_id).selGridView("getAllSelection");
        var stringSel = arraySel.join(',');
		
        $('#selected_tetel_list').val (stringSel);
		$('#arajanlat_id').val (arajanlat_id);
		
		$('#select-tetel-form').submit();
	}
	
</script>
<?php
/* @var $this MegrendelesekController */
/* @var $dataProvider CActiveDataProvider */

	$this->breadcrumbs=array(
		'Megrendelések',
	);

	Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('.search-form form').submit(function(){
			$.fn.yiiGridView.update('megrendelesek-gridview', { 
				data: $(this).serialize()
			});
			return false;
		});
	");
	
?>

<h1>Megrendelések</h1>

<?php
    Yii::app()->clientScript->registerScript(
       'myHideEffect',
       '$(".flash-success").animate({opacity: 1.0}, 3000).fadeOut("slow");',
       CClientScript::POS_READY
    );
?>
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php
	$this->widget('zii.widgets.jui.CJuiButton', array(
		'name'=>'button_search_megrendeles',
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

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model -> search(),
	'id'=>'megrendelesek-gridview',
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
				array(
                        'class' => 'bootstrap.widgets.TbButtonColumn',
						'htmlOptions'=>array('style'=>'width: 210px; text-align: left;'),
                        'template' => '{print} {view} {update} {deliveryNote} {delete} {storno}',
						
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
								'visible' => "Yii::app()->user->checkAccess('Megrendelesek.Print')",
							),
							'view' => array(
								'label' => 'Megtekint',
								'icon'=>'icon-white icon-eye-open',
								'visible' => "Yii::app()->user->checkAccess('Megrendelesek.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => '(Yii::app()->user->checkAccess("Megrendelesek.Update") || Yii::app()->user->checkAccess("Admin")) && ($data->nyomdakonyv_munka_id == 0 && $data->proforma_szamla_sorszam == "") && $data->sztornozva != 1',
							),
							'deliveryNote' => array(
								'label' => 'Szállítólevél felvétele',
								'icon'=>'icon-white icon-list',
								'url'=>'Yii::app()->createUrl("szallitolevelek/index", array("id"=>$data->id))',
								'options'=>array(
												'class'=>'btn btn-inverse btn-mini',
											),
								'visible' => 'Yii::app()->user->checkAccess("Megrendelesek.DeliveryNote") && $data->sztornozva != 1',
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => 'Yii::app()->user->checkAccess("Megrendelesek.Delete") && $data->torolt != 1',
							),
							'storno' => array(
								'label' => 'Sztornózás',
								'icon'=>'icon-white icon-minus-sign',
								'options'=>array(
											'class'=>'btn btn-storno btn-mini',
											'style'=>'margin-left: 15px',
											'onclick' => 'js: openStornoSelectDialog ($(this))',
											),
								'visible' => 'Yii::app()->user->checkAccess("Megrendelesek.Storno") && $data->sztornozva != 1',
							),
						),
                ),
                'sorszam',
				'arajanlat_sorszam',
				'proforma_szamla_sorszam',
				'proforma_szamla_fizetve:boolean',
				'rendeles_idopont',
				'ugyfel.cegnev',
				array(										
					'name'=>'netto_ar',
					'value'=>'number_format($data -> netto_ar, 0, ",", " ") . " Ft"',	
					'htmlOptions'=>array('align'=>'right'),
				),
				array(										
					'name'=>'brutto_ar',
					'value'=>'number_format($data -> brutto_ar, 0, ",", " ") . " Ft"',	
					'htmlOptions'=>array('align'=>'right'),
				),
				'sztornozva:boolean',
				array(
						'header' => 'Törölt',
						'type'=>'boolean',
						'value' => '$data->torolt',
						'visible' => Yii::app()->user->checkAccess('Admin'),
				),
			)
)); ?>

<?php
	if (Yii::app()->user->checkAccess('Megrendelesek.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_megrendelesek',
			'caption'=>'Új megrendelés létrehozása',
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
            'id'=>'dialogMegrendelesPrint',
            
            'options'=>array(
                'title'=>'Proforma számla',
				'width'=> '400px',
                'modal' => true,
                //'buttons' => array('Előnézet' => 'js:function() { model_id = $(this).data("model_id"), $(location).attr("href", "printPDF?id=" + model_id)}'),
				'buttons' => array('Proforma készítése' => 'js:function() { alert ("Ide jön majd a proforma nyomtatási lehetőség."); }'),
                'autoOpen'=>false,
        )));

		$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php	
	// LI: sztornózás oka dialog inicializálása
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogStornozas',
            
            'options'=>array(
                'title'=>'Sztornózás oka',
				'width'=> '400px',
                'modal' => true,
				'buttons' => array('Ok' => 'js:function() { model_id = $(this).data("model_id"); storno (model_id) }', 'Mégse' => 'js:function() { $("#dialogStornozas").dialog("close"); }'),
                'autoOpen'=>false,
        )));
		
		echo "Sztornózás oka:";
		
		$options = CHtml::listData(SztornozasOkok::model()->findAll(),'ok', 'ok');
		echo CHtml::dropDownList('sztornozasOk', '', $options, array('empty'=>''));

		$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'select-storno-form',
	'action' => Yii::app()->createUrl("megrendelesek/storno"),
	'enableAjaxValidation'=>false,
)); 

	echo CHtml::hiddenField('selected_storno' , '', array('id' => 'selected_storno'));
	echo CHtml::hiddenField('megrendeles_id' , '', array('id' => 'megrendeles_id'));
	
$this->endWidget(); ?>

<script type="text/javascript">
		function openPrintDialog (button_obj) {
			hrefString = button_obj.parent().children().eq(1).attr("href");
			row_id = hrefString.substr(hrefString.lastIndexOf("/") + 1);
			
			$("#dialogMegrendelesPrint").data('model_id', row_id).dialog("open");
		}
</script>

<script type="text/javascript">

	function openStornoSelectDialog (button_obj) {
		hrefString = button_obj.parent().children().eq(1).attr("href");
		row_id = hrefString.substr(hrefString.lastIndexOf("/") + 1);
		
		$("#dialogStornozas").data('model_id', row_id).dialog("open");			
		
		return false;
	}
	
	function storno (model_id) {
        $('#selected_storno').val ($('#sztornozasOk').val());
		$('#megrendeles_id').val (model_id);

		$('#select-storno-form').submit();
	}
	
</script>
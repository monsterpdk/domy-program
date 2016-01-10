<?php
/* @var $this ArajanlatokController */
/* @var $model Arajanlatok */
?>

<h1>'<?php echo $model->sorszam; ?>' adatai</h1>

<?php
	if (Yii::app()->user->checkAccess("Megrendelesek.CreateMegrendeles") && $model->van_megrendeles == 0 && $model->torolt == 0 && !(Utils::reachedUgyfelLimit ($model->id)) ) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_ugyfel',
			'caption'=>'Megrendelés létrehozása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success search-button', 'style'=>'margin-bottom:10px'),
			'onclick'=> new CJavaScriptExpression ('function() {openTetelSelectDialog ($(this)); return false;}'),
		));
	}
?>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'sorszam',
			'ugyfel.cegnev',
			'autocomplete_ugyfel_cim',
			'cimzett',
			'autocomplete_ugyfel_adoszam',
			'autocomplete_ugyfel_fizetesi_moral',
			'autocomplete_ugyfel_atlagos_fizetesi_keses',
			'arkategoria.nev',
			'ajanlat_datum',
			'ervenyesseg_datum',
			'hatarido',
			'afakulcs.nev',
			'kovetkezo_hivas_ideje',
			'visszahivas_lezarva:boolean',
			'ugyfel_tel',
			'ugyfel_fax',
			'visszahivas_jegyzet',
			'jegyzet',
			'reklamszoveg',
			'egyeb_megjegyzes',
			'van_megrendeles:boolean',
			array(
				'name' => 'torolt',
				'type'=>'boolean',
				'value' => $model->torolt,
				'visible' => Yii::app()->user->checkAccess('Admin'),
			),
		),
	)); ?>
</p>

<p>
	<?php $this->widget('zii.widgets.jui.CJuiButton', 
			 array(
				'name'=>'back',
				'caption'=>'Vissza',
				'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => Yii::app()->request->urlReferrer),
			 )); ?>
</p>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Megrendelt termékek</strong>",
	));
	
		$config = array();
		$dataProvider=new CActiveDataProvider('ArajanlatTetelek',
			array( 'data' => $model->tetelek,
				   'criteria'=>array('order' => ' id DESC',),
			)
		);

		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'anyagrendelesTermekek-grid',
			'enablePagination' => false,
			'dataProvider'=>$dataProvider,
			'columns'=>array(
					'termek.DisplayTermekTeljesNev',
					'szinek_szama1',
					'szinek_szama2',
					'darabszam',
					'hozott_boritek:boolean',
					'egyedi_ar:boolean',
					'netto_darabar',
				array(
							'class' => 'bootstrap.widgets.TbButtonColumn',
							'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
							'template' => '',
					),
			)
		));
	$this->endWidget();
?>
	
<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Visszahívások</strong>",
	));
	
		$config = array();
		$dataProvider=new CActiveDataProvider('arajanlatVisszahivasok',
			array( 'data' => $model->visszahivasok,
				   'criteria'=>array('order' => ' idopont DESC',),
			)
		);

		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'arajanlat-visszahivasok-grid',
			'enablePagination' => false,
			'dataProvider'=>$dataProvider,
			'columns'=>array(
					'user.fullname',
					'idopont',
					'jegyzet',
			)
		));
	$this->endWidget();
?>	

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'select-tetel-form',
	'action' => Yii::app()->createUrl("megrendelesek/createFromArajanlat"),
	'enableAjaxValidation'=>false,
)); 

	echo CHtml::hiddenField('selected_tetel_list' , '', array('id' => 'selected_tetel_list'));
	echo CHtml::hiddenField('arajanlat_id' , '', array('id' => 'arajanlat_id'));

	// ha megrendelésre visszük az árajánlatot, akkor előtte ki kell választani, hogy mely tételeket visszük át
	// ez a rész erre a célra szolgál, ide fog az ajax lekérés válasza render-elődni
	
	echo "<div id='divForGrid'></div>";	
	
$this->endWidget(); ?>

<?php
	$this->widget( 'application.modules.auditTrail.widgets.portlets.ShowAuditTrail', array( 'model' => $model, ) );
?>

<script type="text/javascript">
	
	function openTetelSelectDialog (button_obj) {
		row_id = <?php echo $model -> id; ?>;
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
<?php
	/* @var $this TermekArakController */
	/* @var $dataProvider CActiveDataProvider */

	$grid_id = round(microtime(true) * 1000);
?>

<h1>Raktárkészletek</h1>

<?php	
	$this->widget('zii.widgets.jui.CJuiButton', array(
		'name'=>'button_print_raktarkeszlet',
		'caption'=>'Lista nyomtatás',
		'buttonType'=>'link',
		'url'=>Yii::app()->createUrl("raktarTermekek/printRaktarkeszlet"),
		'htmlOptions'=>array('class'=>'btn btn-success','target'=>'_blank'),
	));
?>

<div class="search-form">
	<?php  $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
</div>

<?php 
    $this->widget('ext.groupgridview.BootGroupGridView', array(
      'id' => 'raktar_termekek_grid',
      'itemsCssClass'=>'items group-grid-view',
      'dataProvider' => $model -> search(),
      'extraRowColumns' => array('raktarHelyek.raktar.nev'),
      'mergeColumns' => array('raktarHelyek.raktar.nev', 'raktarHelyek.nev'),
      'columns' => array(
						array(
							'class' => 'bootstrap.widgets.TbButtonColumn',
							'htmlOptions'=>array('style'=>'width: 30px; text-align: left;'),
							'template' => '{relocate}',
							
							'buttons' => array(
								'relocate' => array(
									'url' => '$data->id',
									'label' => 'Átmozgat',
									'icon'=>'icon-white icon-move',
									'options'=>array(
												'class'=>'btn btn-info btn-mini',
												'onclick' => 'js: openRelocateDialog ( $(this).attr("href"), event ); return false;',
												),
								),
							),
						),
      	  				'raktarHelyek.raktar.nev',
						'raktarHelyek.nev',
						'anyagbeszallitas.bizonylatszam',
						'anyagbeszallitas.beszallitas_datum',
						'termek.cikkszam',
						'termek.DisplayTermekTeljesNev',
						'osszes_db:number',
						'foglalt_db:number',
						'elerheto_db:number',
      ),
	  
    ));

?>

<!-- CJUIDIALOG BEGIN -->
<?php 
  $this->beginWidget('zii.widgets.jui.CJuiDialog', 
	   array(   'id'=>'termek_athelyez_dialog' . $grid_id,
				'options'=>array(
								'title'=>'Termék áthelyezése',
								'modal'=>true,
								'width'=>1100,
								'height'=>500,
								'autoOpen'=>false,
								),
						));
?>

	<div class="divForForm"></div>

<?php $this->endWidget(); ?>
<!-- CJUIDIALOG END -->
	
<script type="text/javascript">

		// LI: áthelyező dialog összerakása
		function openRelocateDialog (row_id, event) {
			event.preventDefault();
			
			grid_id = <?php echo $grid_id; ?>;

			<?php echo CHtml::ajax(array(
				'url'=> "js:'/index.php/raktarTermekek/termekAthelyez/id/' + row_id + '/grid_id/' + grid_id",
				'data'=> "js:$(this).serialize()",
				'type'=>'post',
				'id' => 'send-link-'.uniqid(),
				'replace' => '',
				'dataType'=>'json',
				'success'=>"function(data)
					{
						if (data.status == 'failure')
						{
							$('#termek_athelyez_dialog' + grid_id + ' div.divForForm').html(data.div);
						}
						else
						{
							$('#termek_athelyez_dialog' + grid_id + ' div.divForForm').html(data.div);
							$('#termek_athelyez_dialog' + grid_id).dialog('close');
						}
		 
					} "
			)); ?>

			$("#termek_athelyez_dialog" + grid_id).dialog("open");
			
			return false;
		}
		
</script>
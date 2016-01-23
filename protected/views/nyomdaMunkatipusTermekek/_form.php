<?php 
	Yii::app() -> clientScript->registerScript('updateGridView', '
		$.updateGridView = function(gridID, name, value) {
			$("#" + gridID + " input[name=\'" + name + "\'], #" + gridID + " select[name=\'" + name + "\']").val(value);
			
			$.fn.yiiGridView.update(gridID, {data: $.param(
				$("#"+gridID+" .filters input, #"+gridID+" .filters select")
			)});
		}
		', CClientScript::POS_READY);
?>

<div class="form">

<?php

			/* CGRIDVIEW */
			$this->widget('zii.widgets.grid.CGridView', 
			   array( 'id'=>'nyomda-munkatipus-termek-grid' . $grid_id,
					  'dataProvider'=>$termek->search(),
					  'filter'=>$termek,
					  'selectableRows'=>1,
					  'columns'=>array(
									'nev',
									array(
										'name' => 'meret.nev',
										'header' => 'Méret',
										'filter' => CHtml::activeTextField($termek, 'meret_search'),
										'value' => '$data->meret == null ? "" : $data->meret->nev',
									),
									array(
										'name' => 'gyarto.cegnev',
										'header' => 'Gyártó',
										'filter' => CHtml::activeTextField($termek, 'gyarto_search'),
										'value' => '$data->gyarto == null ? "" : $data->gyarto->cegnev',
									),
									array(
										'name' => 'papirtipus.nev',
										'header' => 'Papírtípus',
										'filter' => CHtml::activeTextField($termek, 'papirtipus_search'),
										'value' => '$data->papirtipus == null ? "" : $data->papirtipus->nev',
									),
									array(
										'name' => 'zaras.nev',
										'header' => 'Záródás',
										'filter' => CHtml::activeTextField($termek, 'zaras_search'),
										'value' => '$data->zaras == null ? "" : $data->zaras->nev',
									),
									array(
										'name' => 'ablakhely.nev',
										'header' => 'Ablakhely',
										'filter' => CHtml::activeTextField($termek, 'ablakhely_search'),
										'value' => '$data->ablakhely == null ? "" : $data->ablakhely->nev',
									),
									array(
									  'header'=>'',
									  'type'=>'raw',
									  'value'=>'CHtml::Button("+", 
																array("name" => "send_termek", 
																	"id" => "send_termek", 
																	"onClick" => "
																					addTermekToMunkatipus($data->id);
																				 "))',
																),
									   ),
					));

?>

</div><!-- form -->

<script type="text/javascript">
	
	function addTermekToMunkatipus (termek_id)
	{
		var id = $('#NyomdaMunkatipusok_id').val();
		
		<?php echo CHtml::ajax(array(
				'url'=> "js:'/index.php/nyomdaMunkatipusTermekek/assignTermekToMunkatipus/id/' + id + '/termek_id/' + termek_id",
				'data'=> "js:$(this).serialize()",
				'type'=>'post',
				'id' => 'send-link-'.uniqid(),
				'replace' => '',
				'dataType'=>'json',
				'success'=>"function(data)
				{
					if (data.status == 'failure')
					{
					}
					else
					{
						$.fn.yiiGridView.update(\"termekek-grid\",{ complete: function(jqXHR, status) {}})
						$('#nyomda-munkatipus-termek-dialog').dialog('close');
					}
	 
				} ",
		))?>;
		
		$("#nyomda-munkatipus-termek-dialog").dialog("open");
		
		return false; 		
	}
	
</script>
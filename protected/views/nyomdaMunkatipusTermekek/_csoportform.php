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
			   array( 'id'=>'nyomda-munkatipus-termekcsoport-grid' . $grid_id,
					  'dataProvider'=>$termekcsoport->search(),
					  'filter'=>$termekcsoport,
					  'selectableRows'=>1,
					  'columns'=>array(
									'nev',
									array(
									  'header'=>'',
									  'type'=>'raw',
									  'value'=>'CHtml::Button("+", 
																array("name" => "send_termekcsoport", 
																	"id" => "send_termekcsoport", 
																	"onClick" => "
																					addTermekcsoportToMunkatipus($data->id);
																				 "))',
																),
									  array(
										  'header'=>'',
										  'type'=>'raw',
										  'value'=>'CHtml::Button("-", 
																			array("name" => "remove_termekcsoport", 
																				"id" => "remove_termekcsoport", 
																				"onClick" => "
																								removeTermekcsoportFromMunkatipus($data->id);
																							 "))',
									  ),
									   ),
					));

?>

</div><!-- form -->

<script type="text/javascript">
	
	function addTermekcsoportToMunkatipus (termekcsoport_id)
	{
		var id = $('#NyomdaMunkatipusok_id').val();
		
		<?php echo CHtml::ajax(array(
				'url'=> "js:'/index.php/nyomdaMunkatipusTermekek/assignTermekcsoportToMunkatipus/id/' + id + '/termekcsoport_id/' + termekcsoport_id",
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
						$('#nyomda-munkatipus-termekcsoport-dialog').dialog('close');
					}
	 
				} ",
		))?>;
		
		$("#nyomda-munkatipus-termekcsoport-dialog").dialog("open");
		
		return false; 		
	}

	function removeTermekcsoportFromMunkatipus (termekcsoport_id)
	{
		var id = $('#NyomdaMunkatipusok_id').val();

		<?php echo CHtml::ajax(array(
			'url'=> "js:'/index.php/nyomdaMunkatipusTermekek/removeTermekcsoportFromMunkatipus/id/' + id + '/termekcsoport_id/' + termekcsoport_id",
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
						$('#nyomda-munkatipus-termekcsoport-dialog').dialog('close');
					}
	 
				} ",
		))?>;

		$("#nyomda-munkatipus-termekcsoport-dialog").dialog("open");

		return false;
	}
	
</script>
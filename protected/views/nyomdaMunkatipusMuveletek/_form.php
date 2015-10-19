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
			   array( 'id'=>'nyomda-munkatipus-muvelet-grid' . $grid_id,
					  'dataProvider'=>$muvelet->search(),
					  'filter'=>$muvelet,
					  'selectableRows'=>1,
					  'columns'=>array(
									'muvelet_nev',
									'elokeszites_ido',
									'muvelet_ido',
									'szinszam_tol',
									'szinszam_ig',
									array(
									  'header'=>'',
									  'type'=>'raw',
									  'value'=>'CHtml::Button("+", 
																array("name" => "send_muvelet", 
																	"id" => "send_muvelet", 
																	"onClick" => "
																					addMuveletToMunkatipus($data->id);
																				 "))',
																),
									   ),
					));

?>

</div><!-- form -->

<script type="text/javascript">
	
	function addMuveletToMunkatipus (muvelet_id)
	{
		var id = $('#NyomdaMunkatipusok_id').val();
		<?php echo CHtml::ajax(array(
				'url'=> "js:'/index.php/nyomdaMunkatipusMuveletek/assignMuveletToMunkatipus/id/' + id + '/muvelet_id/' + muvelet_id",
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
						$.fn.yiiGridView.update(\"muveletek-grid\",{ complete: function(jqXHR, status) {}})
						$('#nyomda-munkatipus-muvelet-dialog').dialog('close');
					}
	 
				} ",
		))?>;
		
		$("#nyomda-munkatipus-muvelet-dialog").dialog("open");
		
		return false; 		
	}
	
</script>
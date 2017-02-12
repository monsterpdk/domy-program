<?php
/* @var $this RaktarKiadasokController */
/* @var $model RaktarKiadasok */
/* @var $form CActiveForm */

	Yii::app() -> clientScript->registerScript('updateGridView', '
	$.updateGridView = function(gridID, nameList, valueList) {
		var index;
			
		for	(index = 0; index < nameList.length; index++) {
			$("#" + gridID + " input[name=\'" + nameList[index] + "\'], #" + gridID + " select[name=\'" + nameList[index] + "\']").val(valueList[index]);				
		} 

		$.fn.yiiGridView.update(gridID, {
			data: $.param($("#"+gridID+" .filters input, #"+gridID+" .filters select"))
		});
	}
	', CClientScript::POS_READY);
	
	// ha túl nagy raktárkészlet akkor nálam néha kifutott a default 30 másodpercből (ezt az activeDropDown-t lehet édemes lenen valamire előregépelősre kicserélni, vagy egy külön dialog-ra)
	ini_set('max_execution_time', 300);	
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Raktár kiadás adatai</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'raktar-kiadasok-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->hiddenField($model, 'termek_id'); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'termek_id'); ?>
		<?php echo $form->textField($model,'autocomplete_termek_name', array('style' => 'width:445px!important', 'disabled' => 'true') ); ?>
		
		<?php $this->widget('zii.widgets.jui.CJuiButton', 
			 array(
				'name'=>'selectTermek',
				'caption'=>'Termék választása',
				'htmlOptions' => array ('class' => 'btn btn-success', 'style' => 'margin-bottom: 9px'),
				'buttonType'=>'link',
				'onclick'=>new CJavaScriptExpression('function() {  
							openTetelValaszto();
						}'),

		 )); ?>
	</div>
	
	<div style="clear:both;">

	<div class="row">
		<?php echo $form->labelEx($model,'darabszam'); ?>
		<?php echo $form->textField($model,'darabszam',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'darabszam'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nyomdakonyv_id'); ?>
		
			<?php echo CHtml::activeDropDownList($model, 'nyomdakonyv_id',
				CHtml::listData(Nyomdakonyv::model()->findAll(array("condition"=>"torolt=0 AND sztornozva=0 AND nyomhato=0")), 'id', 'taskaszam'), array('empty'=>'-= Válasszon munkát =-')
			); ?>
			
		<?php echo $form->error($model,'nyomdakonyv_id'); ?>
	</div>
	
	<div class="row buttons">
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'submitForm',
						'caption'=>'Mentés',
						'htmlOptions' => array ('class' => 'btn btn-primary btn-lg',),
					 )); ?>
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'back',
						'caption'=>'Vissza',
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => Yii::app()->request->urlReferrer),
					 )); ?>
	</div>

<?php $this->endWidget(); ?>

	<?php
		// a dialógus ablak inicializálása
		$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
			'id'=>'dialogRaktarKiadasokTermek',
			'options'=>array(
				'title'=>'Termék kiválasztása',
				'autoOpen'=>false,
				'modal'=>true,
				'width'=>900,
				'height'=>380,
			),
		));
	?>
	
	<div class="divForForm"></div>
	 
	<?php $this->endWidget();?>

	<div style = 'display:none'>
		<?php
		$this->widget('zii.widgets.grid.CGridView', 
			   array( 'id'=>'dummy-grid',
					  'dataProvider'=>$model->search(),
					  'selectableRows'=>1,
					  'columns'=>array(),
					  )
					  );
		?>
	</div>
</div><!-- form -->

<script type="text/javascript">
	
	function openTetelValaszto ()
	{
		<?php echo CHtml::ajax(array(
				'url'=> "js:'/index.php/raktarKiadasok/tetelValaszto/grid_id/' + new Date().getTime()",
				'data'=> "js:$(this).serialize()",
				'type'=>'post',
				'id' => 'send-link-'.uniqid(),
				'replace' => '',
				'dataType'=>'json',
				'success'=>"function(data)
				{
					if (data.status == 'failure')
					{
						$('#dialogRaktarKiadasokTermek div.divForForm').html(data.div);
					}
					else
					{
						$('#dialogRaktarKiadasokTermek div.divForForm').html(data.div);
					}
	 
				} ",
		))?>;

		
		$("#dialogRaktarKiadasokTermek").dialog("open");
		
		return false; 
	}
	
</script>

<?php $this->endWidget(); ?>
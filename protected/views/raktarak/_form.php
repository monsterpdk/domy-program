<?php
/* @var $this RaktarakController */
/* @var $model Raktarak */
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
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'raktarak-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Raktár adatai</strong>",
		));
	?>
	
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'id'); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'nev'); ?>
		<?php echo $form->textField($model,'nev',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'nev'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipus'); ?>
		<?php echo DHtml::enumDropDownList($model, 'tipus'); ?>
		<?php echo $form->error($model,'tipus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'leiras'); ?>
		<?php echo $form->textField($model,'leiras',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'leiras'); ?>
	</div>

	<?php if (Yii::app()->user->checkAccess('Admin')): ?>
		<div class="row active">
			<?php echo $form->checkBox($model,'torolt'); ?>
			<?php echo $form->label($model,'torolt'); ?>
			<?php echo $form->error($model,'torolt'); ?>
		</div>
	<?php endif; ?>
	
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
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Raktárhelyek</strong>",
	));

	if (Yii::app()->user->checkAccess('RaktarHelyek.Create')) {
		
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_raktarhely',
			'caption'=>'Raktárhely hozzáadása',
			'buttonType'=>'link',
			'onclick'=>new CJavaScriptExpression('function() {addUpdateRaktarHely("create", $(this));}'),
			'htmlOptions'=>array('class'=>'btn btn-success'),
		));
	}
	
	// a dialógus ablak inicializálása
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'dialogRaktarHelyek',
		'options'=>array(
			'title'=>'Raktárhely hozzáadása',
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>400,
			'height'=>300,
		),
	));
?>
	<div class="divForForm"></div>
	 
	<?php $this->endWidget();?>
	 
	<script type="text/javascript">
	
		function addUpdateRaktarHely(createOrUpdate, buttonObj)
		{
		
			if ($("#Raktarak_id").val() != null && $("#Raktarak_id").val().trim() != "") {
				redirectUrl = "";
				try {
					redirectUrl = createOrUpdate.target.action;
				} catch (e) {
					redirectUrl = "";
				}
				
				try {
					$('#raktarhely_dialog').dialog('destroy');
				} catch(err) {}

				if (typeof buttonObj != 'undefined')
					hrefString = buttonObj.parent().children().eq(1).attr('href');
					
				isUpdate = createOrUpdate == "update" || (typeof redirectUrl != 'undefined' && redirectUrl != '' && redirectUrl.indexOf("update") != -1);
				op = (isUpdate) ? "update" : "create";
				id = (isUpdate) ? hrefString.substr(hrefString.lastIndexOf("/") + 1) : $("#Raktarak_id").val();
				dialog_title = (isUpdate) ? "Raktárhely módosítása" : "Raktárhely";

				<?php echo CHtml::ajax(array(
						'url'=> "js:'/index.php/raktarHelyek/' + op + '/id/' + id + '/raktar_id/' + id + '/grid_id/' + new Date().getTime()",
						'data'=> "js:$(this).serialize()",
						'type'=>'post',
						'id' => 'send-link-'.uniqid(),
						'replace' => '#raktarhely_dialog',
						'dataType'=>'json',
						'success'=>"function(data)
						{
							if (data.status == 'failure')
							{
								$('#dialogRaktarHelyek div.divForForm').html(data.div);
								$('#dialogRaktarHelyek div.divForForm form').submit(addUpdateRaktarHely);
							}
							else
							{
								$.fn.yiiGridView.update(\"raktarHelyek-grid\",{ complete: function(jqXHR, status) {}})
								$('#dialogRaktarHelyek div.divForForm').html(data.div);
								$('#dialogRaktarHelyek').dialog('close');
							}
			 
						} ",
				))?>;
				
			}
			
			$("#dialogRaktarHelyek").dialog("open");
			$("#dialogRaktarHelyek").dialog('option', 'title', dialog_title);
			
			return false; 
		}
	 
	</script>

	<?php
		$config = array();
		$dataProvider=new CActiveDataProvider('RaktarHelyek',
			array( 'data' => $model->raktarHelyek,
			)
		);

		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'raktarHelyek-grid',
			'dataProvider'=>$dataProvider,
			'enablePagination' => false,
			'afterAjaxUpdate'=>'function(id,data){
			}',
			'columns'=>array(
				'nev',
				'leiras',
				array(
							'class' => 'bootstrap.widgets.TbButtonColumn',
							'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
							'template' => '{update} {delete}',
							
							'updateButtonOptions'=>array('class'=>'btn btn-success btn-mini'),
							'deleteButtonOptions'=>array('class'=>'btn btn-danger btn-mini'),
							
							'buttons' => array(
								'update' => array(
									'label' => 'Szerkeszt',
									'icon'=>'icon-white icon-pencil',
									'url'=>'',
									'click'=>'function() {addUpdateRaktarHely("update", $(this));}',
									'visible' => "Yii::app()->user->checkAccess('RaktarHelyek.Update')",
								),
								'delete' => array(
									'label' => 'Töröl',
									'icon'=>'icon-white icon-remove-sign',
									'url'=>'Yii::app()->createUrl("/raktarHelyek/delete", array("id"=>$data["id"]))',
									'visible' => "Yii::app()->user->checkAccess('RaktarHelyek.Delete')",
								),
							),
					),
			)
		));
		
		$this->endWidget();
	?>

</div><!-- form -->

<?php $this->endWidget();?>
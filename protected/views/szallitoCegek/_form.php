<?php
/* @var $this SzallitoCegekController */
/* @var $model SzallitoCegek */
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
	'id'=>'szallito-cegek-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Szállító cég adatai</strong>",
		));
	?>
	
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'id'); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'nev'); ?>
		<?php echo $form->textField($model,'nev',array('size'=>50,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nev'); ?>
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
		'title'=>"<strong>Futárok</strong>",
	));

	if (Yii::app()->user->checkAccess('SzallitoCegFutarok.Create')) {
		
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_futar',
			'caption'=>'Futár hozzáadása',
			'buttonType'=>'link',
			'onclick'=>new CJavaScriptExpression('function() {addUpdateSzallitoCegFutar("create", $(this));}'),
			'htmlOptions'=>array('class'=>'btn btn-success'),
		));
	}
	
	// a dialógus ablak inicializálása
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'dialogSzallitoCegFutarok',
		'options'=>array(
			'title'=>'Futár hozzáadása',
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
	
		function addUpdateSzallitoCegFutar(createOrUpdate, buttonObj)
		{
		
			if ($("#SzallitoCegek_id").val() != null && $("#SzallitoCegek_id").val().trim() != "") {
				redirectUrl = "";
				try {
					redirectUrl = createOrUpdate.target.action;
				} catch (e) {
					redirectUrl = "";
				}
				
				try {
					$('#futar_dialog').dialog('destroy');
				} catch(err) {}

				if (typeof buttonObj != 'undefined')
					hrefString = buttonObj.parent().children().eq(1).attr('href');
					
				isUpdate = createOrUpdate == "update" || (typeof redirectUrl != 'undefined' && redirectUrl != '' && redirectUrl.indexOf("update") != -1);
				op = (isUpdate) ? "update" : "create";
				id = (isUpdate) ? hrefString.substr(hrefString.lastIndexOf("/") + 1) : $("#SzallitoCegek_id").val();
				dialog_title = (isUpdate) ? "Futár módosítása" : "Futár";

				<?php echo CHtml::ajax(array(
						'url'=> "js:'/index.php/szallitoCegFutarok/' + op + '/id/' + id + '/szallito_ceg_id/' + id + '/grid_id/' + new Date().getTime()",
						'data'=> "js:$(this).serialize()",
						'type'=>'post',
						'id' => 'send-link-'.uniqid(),
						'replace' => '#futar_dialog',
						'dataType'=>'json',
						'success'=>"function(data)
						{
							if (data.status == 'failure')
							{
								$('#dialogSzallitoCegFutarok div.divForForm').html(data.div);
								$('#dialogSzallitoCegFutarok div.divForForm form').submit(addUpdateSzallitoCegFutar);
							}
							else
							{
								$.fn.yiiGridView.update(\"szallitoCegFutarok-grid\",{ complete: function(jqXHR, status) {}})
								$('#dialogSzallitoCegFutarok div.divForForm').html(data.div);
								$('#dialogSzallitoCegFutarok').dialog('close');
							}
			 
						} ",
				))?>;
				
			}
			
			$("#dialogSzallitoCegFutarok").dialog("open");
			$("#dialogSzallitoCegFutarok").dialog('option', 'title', dialog_title);
			
			return false; 
		}
	 
	</script>

	<?php
		$config = array();
		$dataProvider=new CActiveDataProvider('SzallitoCegFutarok',
			array( 'data' => $model->szallitoCegFutarok,
			)
		);

		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'szallitoCegFutarok-grid',
			'dataProvider'=>$dataProvider,
			'enablePagination' => false,
			'afterAjaxUpdate'=>'function(id,data){
			}',
			'columns'=>array(
				'nev',
				'telefon',
				'rendszam',
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
									'click'=>'function() {addUpdateSzallitoCegFutar("update", $(this));}',
									'visible' => "Yii::app()->user->checkAccess('SzallitoCegFutarok.Update')",
								),
								'delete' => array(
									'label' => 'Töröl',
									'icon'=>'icon-white icon-remove-sign',
									'url'=>'Yii::app()->createUrl("/szallitoCegFutarok/delete", array("id"=>$data["id"]))',
									'visible' => "Yii::app()->user->checkAccess('SzallitoCegFutarok.Delete')",
								),
							),
					),
			)
		));
		
		$this->endWidget();
	?>

</div><!-- form -->

<?php $this->endWidget();?>
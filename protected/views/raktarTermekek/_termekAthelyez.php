<?php
/* @var $model RaktarTermekek */
/* @var $form CActiveForm */
	$cs = Yii::app()->clientScript;
	$cs -> scriptMap=array(
		'jquery.js'=>false
	);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'termek-athelyez-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->hiddenField($model, 'raktarTermekId'); ?>
	<?php echo $form->hiddenField($model, 'forrasRaktarHelyId'); ?>
	
	<div id="ajaxLoader" style="display: none; margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; z-index: 30001; opacity: 0.8;">
		<p style="position: absolute; color: White; top: 50%; left: 45%;">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif">
		</p>
	</div>

	<div>
		<div class="row">
			<div class="row">
				<?php echo $form->labelEx($model,'termekNevDsp'); ?>
				<?php echo $form->textField($model,'termekNevDsp', array('style' => 'width:975px!important', 'disabled' => 'true') ); ?>
			</div>
		</div>
	</div>
	
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Forrás adatai</strong>",
		));
	?>
		
		<div class="row">
			<?php echo $form->labelEx($model,'forrasRaktarHelyId'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'forrasRaktarHelyId',
					CHtml::listData(RaktarHelyek::model()->findAll(array("condition"=>"", 'order'=>'nev')), 'id', 'displayTeljesNev'),
					array("disabled"=>"disabled",)
				); ?>
			<?php echo $form->error($model,'forrasRaktarHelyId'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'forrasElerhetoDb'); ?>
			<?php echo $form->textField($model,'forrasElerhetoDb', array('maxlength' => 11, 'readonly'=> true)); ?>
			<?php echo $form->error($model,'forrasElerhetoDb'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'forrasFoglaltDb'); ?>
			<?php echo $form->textField($model,'forrasFoglaltDb', array('maxlength' => 11, 'readonly'=> true)); ?>
			<?php echo $form->error($model,'forrasFoglaltDb'); ?>
		</div>
	<?php $this->endWidget(); ?>
	
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Cél adatai</strong>",
		));
	?>
		<div class="row">
			<?php echo $form->labelEx($model,'celRaktarHelyId'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'celRaktarHelyId',
					CHtml::listData(RaktarHelyek::model()->findAll(array("condition"=>"", 'order'=>'nev')), 'id', 'displayTeljesNev'),
					array( 'empty'=>'-= Válasszon raktárhelyet =-')
				); ?>
			<?php echo $form->error($model,'celRaktarHelyId'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'celElerhetoDb'); ?>
			<?php echo $form->textField($model,'celElerhetoDb', array('maxlength' => 11, 'readonly'=> false)); ?>
			<?php echo $form->error($model,'celElerhetoDb'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'celFoglaltDb'); ?>
			<?php echo $form->textField($model,'celFoglaltDb', array('maxlength' => 11, 'readonly'=> false)); ?>
			<?php echo $form->error($model,'celFoglaltDb'); ?>
		</div>
		
	<?php $this->endWidget(); ?>
	
	<div class="row buttons">
	     <?php echo CHtml::ajaxSubmitButton('Áthelyez', CHtml::normalizeUrl(array('raktarTermekek/termekAthelyez/id/' . $model->raktarTermekId . '/grid_id/' . $grid_id . '/form/1')),
                 array(
                     'dataType'=>'json',
                     'type'=>'post',
                     'success'=>'function(data) {
                        $("#ajaxLoader").hide();  
							if (data.status=="success"){
								$("#termek_athelyez_dialog' . $grid_id . '").dialog("close");
								$.fn.yiiGridView.update("raktar_termekek_grid");
							}
                         else{
							$.each(data, function(key, val) {
								$("#termek-athelyez-form #" + key + "_em_").text (val);                                                    
								$("#termek-athelyez-form #" + key + "_em_").show ();
							});
                        }       
                    }',                    
                     'beforeSend'=>'function(){                        
                           $("#ajaxLoader").show();
                      }'
                     ),array('id'=>'relocateTermekButton' . round(microtime(true) * 1000),'class'=>'btn btn-primary btn-lg')); ?>

			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'back',
						'caption'=>'Mégse',
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'onclick'=>'js: $("#termek_athelyez_dialog' . $grid_id . '").dialog("close"); return false;'),
					 )); ?>
	</div>
	
	<?php $this->endWidget(); ?>
	
</div><!-- form -->
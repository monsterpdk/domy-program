<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array('id'=>'authItem-child-form',)); ?>
	
	<div class="row">
		<?php echo $form->dropDownList($model, 'itemname', $itemnameSelectOptions); ?>
		<?php echo $form->error($model, 'itemname'); ?>
	</div>
	
	<div class="row buttons">
		<?php $this->widget('zii.widgets.jui.CJuiButton', 
			 array(
				'name'=>'submitForm',
				'buttonType'=>'button',
				'caption'=>'Hozzáad',
				'htmlOptions' => array ('class' => 'btn btn-primary btn-lg', 'onclick'=>'js: $("#authItem-child-form").submit()'),
			 )); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array ('id'=>'assignment-form')); ?>
	
	<div class="row">
		<?php echo $form->dropDownList($model, 'itemname', $itemnameSelectOptions); ?>
		<?php echo $form->error($model, 'itemname'); ?>
	</div>
	
	<div class="row buttons">
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
				 array(
					'name'=>'submitForm',
					'buttonType'=>'button',
					'caption'=>'Hozzárendel',
					'htmlOptions' => array ('class' => 'btn btn-primary btn-lg', 'onclick'=>'js: $("#assignment-form").submit()'),
				 )); ?>
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
				 array(
					'name'=>'back',
					'buttonType'=>'button',
					'caption'=>'Vissza',
					'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => $this->createUrl('/rights')),
				 )); ?>

	</div>

<?php $this->endWidget(); ?>

</div>
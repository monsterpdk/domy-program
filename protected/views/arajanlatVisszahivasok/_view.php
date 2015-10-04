<?php
/* @var $this ArajanlatVisszahivasokController */
/* @var $data ArajanlatVisszahivasok */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('arajanlat_id')); ?>:</b>
	<?php echo CHtml::encode($data->arajanlat_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jegyzet')); ?>:</b>
	<?php echo CHtml::encode($data->jegyzet); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idopont')); ?>:</b>
	<?php echo CHtml::encode($data->idopont); ?>
	<br />

</div>
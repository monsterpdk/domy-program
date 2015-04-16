<?php
/* @var $this GyartokController */
/* @var $data Gyartok */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cegnev')); ?>:</b>
	<?php echo CHtml::encode($data->cegnev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kapcsolattarto')); ?>:</b>
	<?php echo CHtml::encode($data->kapcsolattarto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cim')); ?>:</b>
	<?php echo CHtml::encode($data->cim); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefon')); ?>:</b>
	<?php echo CHtml::encode($data->telefon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fax')); ?>:</b>
	<?php echo CHtml::encode($data->fax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('netto_ar')); ?>:</b>
	<?php echo CHtml::encode($data->netto_ar); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />

	*/ ?>

</div>
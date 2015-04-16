<?php
/* @var $this AnyagbeszallitasokController */
/* @var $data Anyagbeszallitasok */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bizonylatszam')); ?>:</b>
	<?php echo CHtml::encode($data->bizonylatszam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('beszallitas_datum')); ?>:</b>
	<?php echo CHtml::encode($data->beszallitas_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kifizetes_datum')); ?>:</b>
	<?php echo CHtml::encode($data->kifizetes_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('megjegyzes')); ?>:</b>
	<?php echo CHtml::encode($data->megjegyzes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anyagrendeles_id')); ?>:</b>
	<?php echo CHtml::encode($data->anyagrendeles_id); ?>
	<br />


</div>
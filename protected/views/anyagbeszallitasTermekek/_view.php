<?php
/* @var $this AnyagbeszallitasTermekekController */
/* @var $data AnyagbeszallitasTermekek */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anyagbeszallitas_id')); ?>:</b>
	<?php echo CHtml::encode($data->anyagbeszallitas_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('termek_id')); ?>:</b>
	<?php echo CHtml::encode($data->termek_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('darabszam')); ?>:</b>
	<?php echo CHtml::encode($data->darabszam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('netto_darabar')); ?>:</b>
	<?php echo CHtml::encode($data->netto_darabar); ?>
	<br />


</div>
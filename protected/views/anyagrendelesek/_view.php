<?php
/* @var $this AnyagrendelesekController */
/* @var $data Anyagrendelesek */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bizonylatszam')); ?>:</b>
	<?php echo CHtml::encode($data->bizonylatszam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rendeles_datum')); ?>:</b>
	<?php echo CHtml::encode($data->rendeles_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('megjegyzes')); ?>:</b>
	<?php echo CHtml::encode($data->megjegyzes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sztornozva')); ?>:</b>
	<?php echo CHtml::encode($data->sztornozva); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lezarva')); ?>:</b>
	<?php echo CHtml::encode($data->lezarva); ?>
	<br />


</div>
<?php
/* @var $this TermekAblakHelyekController */
/* @var $data TermekAblakHelyek */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nev')); ?>:</b>
	<?php echo CHtml::encode($data->nev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hely')); ?>:</b>
	<?php echo CHtml::encode($data->hely); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('x_pozicio_honnan')); ?>:</b>
	<?php echo CHtml::encode($data->x_pozicio_honnan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('x_pozicio_mm')); ?>:</b>
	<?php echo CHtml::encode($data->x_pozicio_mm); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('y_pozicio_honnan')); ?>:</b>
	<?php echo CHtml::encode($data->y_pozicio_honnan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('y_pozicio_mm')); ?>:</b>
	<?php echo CHtml::encode($data->y_pozicio_mm); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('aktiv')); ?>:</b>
	<?php echo CHtml::encode($data->aktiv); ?>
	<br />

	*/ ?>

</div>
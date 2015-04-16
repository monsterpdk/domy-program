<?php
/* @var $this TermekAblakMeretekController */
/* @var $data TermekAblakMeretek */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nev')); ?>:</b>
	<?php echo CHtml::encode($data->nev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('magassag')); ?>:</b>
	<?php echo CHtml::encode($data->magassag); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szelesseg')); ?>:</b>
	<?php echo CHtml::encode($data->szelesseg); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aktiv')); ?>:</b>
	<?php echo CHtml::encode($data->aktiv); ?>
	<br />


</div>
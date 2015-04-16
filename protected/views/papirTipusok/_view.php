<?php
/* @var $this PapirTipusokController */
/* @var $data PapirTipusok */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nev')); ?>:</b>
	<?php echo CHtml::encode($data->nev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aktiv')); ?>:</b>
	<?php echo CHtml::encode($data->aktiv); ?>
	<br />


</div>
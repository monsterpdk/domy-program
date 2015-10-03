<?php
/* @var $this NyomdagepTipusokController */
/* @var $data NyomdagepTipusok */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gep_id')); ?>:</b>
	<?php echo CHtml::encode($data->gep_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipusnev')); ?>:</b>
	<?php echo CHtml::encode($data->tipusnev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fordulat_kis_boritek')); ?>:</b>
	<?php echo CHtml::encode($data->fordulat_kis_boritek); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fordulat_nagy_boritek')); ?>:</b>
	<?php echo CHtml::encode($data->fordulat_nagy_boritek); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fordulat_egyeb')); ?>:</b>
	<?php echo CHtml::encode($data->fordulat_egyeb); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aktiv')); ?>:</b>
	<?php echo CHtml::encode($data->aktiv); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('szinszam_tol')); ?>:</b>
	<?php echo CHtml::encode($data->szinszam_tol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szinszam_ig')); ?>:</b>
	<?php echo CHtml::encode($data->szinszam_ig); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />

	*/ ?>

</div>
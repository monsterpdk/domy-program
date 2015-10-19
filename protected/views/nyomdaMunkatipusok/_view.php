<?php
/* @var $this NyomdaMunkatipusokController */
/* @var $data NyomdaMunkatipusok */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('munkatipus_nev')); ?>:</b>
	<?php echo CHtml::encode($data->munkatipus_nev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('darabszam_tol')); ?>:</b>
	<?php echo CHtml::encode($data->darabszam_tol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('darabszam_ig')); ?>:</b>
	<?php echo CHtml::encode($data->darabszam_ig); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szinszam_tol')); ?>:</b>
	<?php echo CHtml::encode($data->szinszam_tol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szinszam_ig')); ?>:</b>
	<?php echo CHtml::encode($data->szinszam_ig); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />


</div>
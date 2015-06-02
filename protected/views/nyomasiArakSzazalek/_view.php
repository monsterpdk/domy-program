<?php
/* @var $this NyomasiArakSzazalekController */
/* @var $data NyomasiArakSzazalek */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('peldanyszam_tol')); ?>:</b>
	<?php echo CHtml::encode($data->peldanyszam_tol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('peldanyszam_ig')); ?>:</b>
	<?php echo CHtml::encode($data->peldanyszam_ig); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alap')); ?>:</b>
	<?php echo CHtml::encode($data->alap); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kp')); ?>:</b>
	<?php echo CHtml::encode($data->kp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('utal')); ?>:</b>
	<?php echo CHtml::encode($data->utal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kis_tetel')); ?>:</b>
	<?php echo CHtml::encode($data->kis_tetel); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('nagy_tetel')); ?>:</b>
	<?php echo CHtml::encode($data->nagy_tetel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />

	*/ ?>

</div>
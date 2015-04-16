<?php
/* @var $this NyomasiArakController */
/* @var $data NyomasiArak */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kategoria_tipus')); ?>:</b>
	<?php echo CHtml::encode($data->kategoria_tipus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('boritek_fajtak')); ?>:</b>
	<?php echo CHtml::encode($data->boritek_fajtak); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lehetseges_szinek')); ?>:</b>
	<?php echo CHtml::encode($data->lehetseges_szinek); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('peldanyszam_tol')); ?>:</b>
	<?php echo CHtml::encode($data->peldanyszam_tol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('peldanyszam_ig')); ?>:</b>
	<?php echo CHtml::encode($data->peldanyszam_ig); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szin_egy')); ?>:</b>
	<?php echo CHtml::encode($data->szin_egy); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('szin_ketto')); ?>:</b>
	<?php echo CHtml::encode($data->szin_ketto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szin_harom')); ?>:</b>
	<?php echo CHtml::encode($data->szin_harom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szin_tobb')); ?>:</b>
	<?php echo CHtml::encode($data->szin_tobb); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grafika')); ?>:</b>
	<?php echo CHtml::encode($data->grafika); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grafika_roviden')); ?>:</b>
	<?php echo CHtml::encode($data->grafika_roviden); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('megjegyzes')); ?>:</b>
	<?php echo CHtml::encode($data->megjegyzes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ervenyesseg_tol')); ?>:</b>
	<?php echo CHtml::encode($data->ervenyesseg_tol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ervenyesseg_ig')); ?>:</b>
	<?php echo CHtml::encode($data->ervenyesseg_ig); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	*/ ?>

</div>
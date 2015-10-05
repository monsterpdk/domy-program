<?php
/* @var $this NyomdaMuveletekController */
/* @var $data NyomdaMuveletek */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gep_id')); ?>:</b>
	<?php echo CHtml::encode($data->gep_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('muvelet_nev')); ?>:</b>
	<?php echo CHtml::encode($data->muvelet_nev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('elokeszites_ido')); ?>:</b>
	<?php echo CHtml::encode($data->elokeszites_ido); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('muvelet_ido')); ?>:</b>
	<?php echo CHtml::encode($data->muvelet_ido); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szinszam_tol')); ?>:</b>
	<?php echo CHtml::encode($data->szinszam_tol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szinszam_ig')); ?>:</b>
	<?php echo CHtml::encode($data->szinszam_ig); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('megjegyzes')); ?>:</b>
	<?php echo CHtml::encode($data->megjegyzes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />

	*/ ?>

</div>
<?php
/* @var $this NyomdaMuveletNormaarakController */
/* @var $data NyomdaMuveletNormaarak */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('muvelet_id')); ?>:</b>
	<?php echo CHtml::encode($data->muvelet_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gep_id')); ?>:</b>
	<?php echo CHtml::encode($data->gep_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oradij')); ?>:</b>
	<?php echo CHtml::encode($data->oradij); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szazalek_tol')); ?>:</b>
	<?php echo CHtml::encode($data->szazalek_tol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szazalek_ig')); ?>:</b>
	<?php echo CHtml::encode($data->szazalek_ig); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />


</div>
<?php
/* @var $this RaktarakController */
/* @var $data Raktarak */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nev')); ?>:</b>
	<?php echo CHtml::encode($data->nev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipus')); ?>:</b>
	<?php echo CHtml::encode($data->tipus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leiras')); ?>:</b>
	<?php echo CHtml::encode($data->leiras); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />


</div>
<?php
/* @var $this RaktarKiadasokController */
/* @var $data RaktarKiadasok */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('termek_id')); ?>:</b>
	<?php echo CHtml::encode($data->termek_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('darabszam')); ?>:</b>
	<?php echo CHtml::encode($data->darabszam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nyomdakonyv_id')); ?>:</b>
	<?php echo CHtml::encode($data->nyomdakonyv_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sztornozva')); ?>:</b>
	<?php echo CHtml::encode($data->sztornozva); ?>
	<br />


</div>
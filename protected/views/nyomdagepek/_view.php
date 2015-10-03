<?php
/* @var $this NyomdagepekController */
/* @var $data Nyomdagepek */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gepnev')); ?>:</b>
	<?php echo CHtml::encode($data->gepnev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_fordulat')); ?>:</b>
	<?php echo CHtml::encode($data->max_fordulat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alapertelmezett')); ?>:</b>
	<?php echo CHtml::encode($data->alapertelmezett); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />


</div>
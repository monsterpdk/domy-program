<?php
/* @var $this OrszagokController */
/* @var $data Orszagok */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nev')); ?>:</b>
	<?php echo CHtml::encode($data->nev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hosszu_nev')); ?>:</b>
	<?php echo CHtml::encode($data->hosszu_nev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iso2')); ?>:</b>
	<?php echo CHtml::encode($data->iso2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iso3')); ?>:</b>
	<?php echo CHtml::encode($data->iso3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />


</div>
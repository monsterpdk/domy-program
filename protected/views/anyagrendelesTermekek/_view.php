<?php
/* @var $this AnyagrendelesTermekekController */
/* @var $data AnyagrendelesTermekek */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anyagrendeles_id')); ?>:</b>
	<?php echo CHtml::encode($data->anyagrendeles_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('termek_id')); ?>:</b>
	<?php echo CHtml::encode($data->termek_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rendelt_darabszam')); ?>:</b>
	<?php echo CHtml::encode($data->rendelt_darabszam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rendeleskor_netto_darabar')); ?>:</b>
	<?php echo CHtml::encode($data->rendeleskor_netto_darabar); ?>
	<br />


</div>
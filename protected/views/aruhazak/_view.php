<?php
/* @var $this AruhazakController */
/* @var $data Aruhazak */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kod')); ?>:</b>
	<?php echo CHtml::encode($data->kod); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aruhaz_nev')); ?>:</b>
	<?php echo CHtml::encode($data->aruhaz_nev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aruhaz_url')); ?>:</b>
	<?php echo CHtml::encode($data->aruhaz_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('arkategoria_id')); ?>:</b>
	<?php echo CHtml::encode($data->arkategoria_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ingyen_szallitas')); ?>:</b>
	<?php echo CHtml::encode($data->ingyen_szallitas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />


</div>
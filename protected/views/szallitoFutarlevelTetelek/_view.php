<?php
/* @var $this SzallitoCegFutarokController */
/* @var $data SzallitoCegFutarok */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szallito_ceg_id')); ?>:</b>
	<?php echo CHtml::encode($data->szallito_ceg_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nev')); ?>:</b>
	<?php echo CHtml::encode($data->nev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefon')); ?>:</b>
	<?php echo CHtml::encode($data->telefon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rendszam')); ?>:</b>
	<?php echo CHtml::encode($data->rendszam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />


</div>
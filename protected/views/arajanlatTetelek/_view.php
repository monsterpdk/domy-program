<?php
/* @var $this ArajanlatTetelekController */
/* @var $data ArajanlatTetelek */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('arajanlat_id')); ?>:</b>
	<?php echo CHtml::encode($data->arajanlat_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('termek_id')); ?>:</b>
	<?php echo CHtml::encode($data->termek_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szinek_szama1')); ?>:</b>
	<?php echo CHtml::encode($data->szinek_szama1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szinek_szama2')); ?>:</b>
	<?php echo CHtml::encode($data->szinek_szama2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('darabszam')); ?>:</b>
	<?php echo CHtml::encode($data->darabszam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('netto_darabar')); ?>:</b>
	<?php echo CHtml::encode($data->netto_darabar); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('megjegyzes')); ?>:</b>
	<?php echo CHtml::encode($data->megjegyzes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mutacio')); ?>:</b>
	<?php echo CHtml::encode($data->mutacio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hozott_boritek')); ?>:</b>
	<?php echo CHtml::encode($data->hozott_boritek); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />

	*/ ?>

</div>
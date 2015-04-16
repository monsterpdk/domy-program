<?php
/* @var $this ArajanlatokController */
/* @var $data Arajanlatok */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sorszam')); ?>:</b>
	<?php echo CHtml::encode($data->sorszam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ugyfel_id')); ?>:</b>
	<?php echo CHtml::encode($data->ugyfel_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('arkategoria_id')); ?>:</b>
	<?php echo CHtml::encode($data->arkategoria_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ajanlat_datum')); ?>:</b>
	<?php echo CHtml::encode($data->ajanlat_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ervenyesseg_datum')); ?>:</b>
	<?php echo CHtml::encode($data->ervenyesseg_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hatarido')); ?>:</b>
	<?php echo CHtml::encode($data->hatarido); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('afakulcs_id')); ?>:</b>
	<?php echo CHtml::encode($data->afakulcs_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kovetkezo_hivas_ideje')); ?>:</b>
	<?php echo CHtml::encode($data->kovetkezo_hivas_ideje); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visszahivas_lezarva')); ?>:</b>
	<?php echo CHtml::encode($data->visszahivas_lezarva); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ugyfel_tel')); ?>:</b>
	<?php echo CHtml::encode($data->ugyfel_tel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ugyfel_fax')); ?>:</b>
	<?php echo CHtml::encode($data->ugyfel_fax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visszahivas_jegyzet')); ?>:</b>
	<?php echo CHtml::encode($data->visszahivas_jegyzet); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jegyzet')); ?>:</b>
	<?php echo CHtml::encode($data->jegyzet); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reklamszoveg')); ?>:</b>
	<?php echo CHtml::encode($data->reklamszoveg); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('egyeb_megjegyzes')); ?>:</b>
	<?php echo CHtml::encode($data->egyeb_megjegyzes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />

	*/ ?>

</div>
<?php
/* @var $this MegrendelesekController */
/* @var $data Megrendelesek */
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('cimzett')); ?>:</b>
	<?php echo CHtml::encode($data->cimzett); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('arkategoria_id')); ?>:</b>
	<?php echo CHtml::encode($data->arkategoria_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('egyedi_ar')); ?>:</b>
	<?php echo CHtml::encode($data->egyedi_ar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rendeles_idopont')); ?>:</b>
	<?php echo CHtml::encode($data->rendeles_idopont); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('rendelest_rogzito_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->rendelest_rogzito_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rendelest_lezaro_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->rendelest_lezaro_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('afakulcs_id')); ?>:</b>
	<?php echo CHtml::encode($data->afakulcs_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('arajanlat_id')); ?>:</b>
	<?php echo CHtml::encode($data->arajanlat_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('proforma_szamla_sorszam')); ?>:</b>
	<?php echo CHtml::encode($data->proforma_szamla_sorszam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('proforma_szamla_fizetve')); ?>:</b>
	<?php echo CHtml::encode($data->proforma_szamla_fizetve); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szamla_sorszam')); ?>:</b>
	<?php echo CHtml::encode($data->szamla_sorszam); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('megrendeles_forras_id')); ?>:</b>
	<?php echo CHtml::encode($data->megrendeles_forras_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nyomdakonyv_munka_id')); ?>:</b>
	<?php echo CHtml::encode($data->nyomdakonyv_munka_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sztornozva')); ?>:</b>
	<?php echo CHtml::encode($data->sztornozva); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />

	*/ ?>

</div>
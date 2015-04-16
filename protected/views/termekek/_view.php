<?php
/* @var $this TermekekController */
/* @var $data Termekek */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nev')); ?>:</b>
	<?php echo CHtml::encode($data->nev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kodszam')); ?>:</b>
	<?php echo CHtml::encode($data->kodszam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meret_id')); ?>:</b>
	<?php echo CHtml::encode($data->meret_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('suly')); ?>:</b>
	<?php echo CHtml::encode($data->suly); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('zaras_id')); ?>:</b>
	<?php echo CHtml::encode($data->zaras_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ablakmeret_id')); ?>:</b>
	<?php echo CHtml::encode($data->ablakmeret_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ablakhely_id')); ?>:</b>
	<?php echo CHtml::encode($data->ablakhely_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('papir_id')); ?>:</b>
	<?php echo CHtml::encode($data->papir_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('redotalp')); ?>:</b>
	<?php echo CHtml::encode($data->redotalp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gyarto_id')); ?>:</b>
	<?php echo CHtml::encode($data->gyarto_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ksh_kod')); ?>:</b>
	<?php echo CHtml::encode($data->ksh_kod); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('csom_egys')); ?>:</b>
	<?php echo CHtml::encode($data->csom_egys); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('minimum_raktarkeszlet')); ?>:</b>
	<?php echo CHtml::encode($data->minimum_raktarkeszlet); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('maximum_raktarkeszlet')); ?>:</b>
	<?php echo CHtml::encode($data->maximum_raktarkeszlet); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('doboz_suly')); ?>:</b>
	<?php echo CHtml::encode($data->doboz_suly); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('raklap_db')); ?>:</b>
	<?php echo CHtml::encode($data->raklap_db); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('doboz_hossz')); ?>:</b>
	<?php echo CHtml::encode($data->doboz_hossz); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('doboz_szelesseg')); ?>:</b>
	<?php echo CHtml::encode($data->doboz_szelesseg); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('doboz_magassag')); ?>:</b>
	<?php echo CHtml::encode($data->doboz_magassag); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('megjegyzes')); ?>:</b>
	<?php echo CHtml::encode($data->megjegyzes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('megjelenes_mettol')); ?>:</b>
	<?php echo CHtml::encode($data->megjelenes_mettol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('megjelenes_meddig')); ?>:</b>
	<?php echo CHtml::encode($data->megjelenes_meddig); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datum')); ?>:</b>
	<?php echo CHtml::encode($data->datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />

	*/ ?>

</div>
<?php
/* @var $this TermekSavosCsomagarakController */
/* @var $data TermekSavosCsomagarak */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('termek_id')); ?>:</b>
	<?php echo CHtml::encode($data->termek_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('csomagszam_tol')); ?>:</b>
	<?php echo CHtml::encode($data->csomagszam_tol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('csomagszam_ig')); ?>:</b>
	<?php echo CHtml::encode($data->csomagszam_ig); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('csomag_ar_szamolashoz')); ?>:</b>
	<?php echo CHtml::encode($data->csomag_ar_szamolashoz); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('csomag_ar_nyomashoz')); ?>:</b>
	<?php echo CHtml::encode($data->csomag_ar_nyomashoz); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('csomag_eladasi_ar')); ?>:</b>
	<?php echo CHtml::encode($data->csomag_eladasi_ar); ?>
	<br />
	
</div>
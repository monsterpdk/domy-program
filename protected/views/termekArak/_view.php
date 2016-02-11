<?php
/* @var $this TermekArakController */
/* @var $data TermekArak */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('termek_id')); ?>:</b>
	<?php echo CHtml::encode($data->termek_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('db_beszerzesi_ar')); ?>:</b>
	<?php echo CHtml::encode($data->db_beszerzesi_ar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('csomag_ar_szamolashoz')); ?>:</b>
	<?php echo CHtml::encode($data->csomag_ar_szamolashoz); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('csomag_ar_nyomashoz')); ?>:</b>
	<?php echo CHtml::encode($data->csomag_ar_nyomashoz); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('db_ar_nyomashoz')); ?>:</b>
	<?php echo CHtml::encode($data->db_ar_nyomashoz); ?>
	<br />

	<?php
	<b><?php echo CHtml::encode($data->getAttributeLabel('csomag_eladasi_ar')); ?>:</b>
	<?php echo CHtml::encode($data->csomag_eladasi_ar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('db_eladasi_ar')); ?>:</b>
	<?php echo CHtml::encode($data->db_eladasi_ar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datum_mettol')); ?>:</b>
	<?php echo CHtml::encode($data->datum_mettol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datum_meddig')); ?>:</b>
	<?php echo CHtml::encode($data->datum_meddig); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />

</div>
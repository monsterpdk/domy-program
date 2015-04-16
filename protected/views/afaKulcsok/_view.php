<?php
/* @var $this AfaKulcsokController */
/* @var $data AfaKulcsok */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nev')); ?>:</b>
	<?php echo CHtml::encode($data->nev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('afa_szazalek')); ?>:</b>
	<?php echo CHtml::encode($data->afa_szazalek); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alapertelmezett')); ?>:</b>
	<?php echo CHtml::encode($data->alapertelmezett); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />


</div>
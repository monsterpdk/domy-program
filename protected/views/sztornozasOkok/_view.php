<?php
/* @var $this SztornozasOkokController */
/* @var $data SztornozasOkok */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ok')); ?>:</b>
	<?php echo CHtml::encode($data->ok); ?>
	<br />


</div>
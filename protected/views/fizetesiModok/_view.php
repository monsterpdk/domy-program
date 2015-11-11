<?php
/* @var $this FizetesiModokController */
/* @var $data FizetesiModok */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nev')); ?>:</b>
	<?php echo CHtml::encode($data->nev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szamlazo_azonosito')); ?>:</b>
	<?php echo CHtml::encode($data->szamlazo_azonosito); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fizetesi_hatarido')); ?>:</b>
	<?php echo CHtml::encode($data->fizetesi_hatarido); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />


</div>
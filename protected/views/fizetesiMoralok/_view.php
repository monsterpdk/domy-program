<?php
/* @var $this FizetesiMoralokController */
/* @var $data FizetesiMoralok */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('moral_szam')); ?>:</b>
	<?php echo CHtml::encode($data->moral_szam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('keses_tol')); ?>:</b>
	<?php echo CHtml::encode($data->keses_tol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('keses_ig')); ?>:</b>
	<?php echo CHtml::encode($data->keses_ig); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />


</div>
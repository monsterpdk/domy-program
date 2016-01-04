<?php
/* @var $this NyomdakonyvLejelentesController */
/* @var $data NyomdakonyvLejelentes */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nyomdakonyv_id')); ?>:</b>
	<?php echo CHtml::encode($data->nyomdakonyv_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('teljesitmeny_szazalek')); ?>:</b>
	<?php echo CHtml::encode($data->teljesitmeny_szazalek); ?>
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
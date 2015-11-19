<?php
/* @var $this ZuhController */
/* @var $data Zuh */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nyomasi_kategoria')); ?>:</b>
	<?php echo CHtml::encode($data->nyomasi_kategoria); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('db_tol')); ?>:</b>
	<?php echo CHtml::encode($data->db_tol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('db_ig')); ?>:</b>
	<?php echo CHtml::encode($data->db_ig); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szin_1_db')); ?>:</b>
	<?php echo CHtml::encode($data->szin_1_db); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szin_2_db')); ?>:</b>
	<?php echo CHtml::encode($data->szin_2_db); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szin_3_db')); ?>:</b>
	<?php echo CHtml::encode($data->szin_3_db); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('tobb_szin_db')); ?>:</b>
	<?php echo CHtml::encode($data->tobb_szin_db); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szin_1_szazalek')); ?>:</b>
	<?php echo CHtml::encode($data->szin_1_szazalek); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szin_2_szazalek')); ?>:</b>
	<?php echo CHtml::encode($data->szin_2_szazalek); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szin_3_szazalek')); ?>:</b>
	<?php echo CHtml::encode($data->szin_3_szazalek); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tobb_szin_szazalek')); ?>:</b>
	<?php echo CHtml::encode($data->tobb_szin_szazalek); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aruhaz_kod')); ?>:</b>
	<?php echo CHtml::encode($data->aruhaz_kod); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('megjegyzes')); ?>:</b>
	<?php echo CHtml::encode($data->megjegyzes); ?>
	<br />

	*/ ?>

</div>
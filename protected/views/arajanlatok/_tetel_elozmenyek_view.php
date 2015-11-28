<?php
/* @var $this ArajanlatokController */
/* @var $data termek_ajanlatok */
?>

<div class="view">


	<b>Termék:</b>
	<?php echo CHtml::encode($data["termeknev"]); ?>
	<br />

	<b>Ajánlat sorszám:</b>
	<?php echo CHtml::encode($data["ajanlat_sorszam"]); ?>
	<br />

	<b>Ajánlat dátum:</b>
	<?php echo CHtml::encode($data["ajanlat_datum"]); ?>
	<br />

	<b>Megrendelték:</b>
	<?php echo CHtml::encode($data["arajanlatbol_letrehozva"]); ?>


</div>
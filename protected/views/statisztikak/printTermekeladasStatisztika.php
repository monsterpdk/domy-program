<?php
	$actualUserName = '';
	$actualUser = User::model()->findByPk(Yii::app()->user->getId());
	
	if ($actualUser != null) {
		$actualUserName	= $actualUser->fullname;
	}
	
	$termekcsoport = null;
	if ($model -> termekcsoport_id != null && $model -> termekcsoport_id != "") {
		$termekcsoport = Termekcsoportok::model()->findByPk ($model -> termekcsoport_id);
	}
	
	$cikkszam = null;
	if ($model -> cikkszam != null && $model -> cikkszam != "") {
		$cikkszamList = explode(',', $model -> cikkszam);
		
		if (is_array($cikkszamList)) {
			foreach ($cikkszamList as $cikkszamDb) {
				if (trim($cikkszamDb) != '') {
					$cikkszam .= (strlen($cikkszam) > 0 ? ', ' : '') . trim($cikkszamDb);
				}
			}
		}
	}
?>

<html>
<head></head>

<style>
	p, div {
		font-family: arial;
		font-size: 10pt;
	}
	.under {
		border-bottom: 4px double #000000;
	}
	table.items {
		border: solid thin gray;
		font-family: arial;
		font-size: 10pt;
		width: 100%;
		padding: 2px ;
		border-spacing: 1px;
		border-collapse: separate;	
		box-decoration-break: clone;
		background-color: silver ;
	}
	
	table.items th {
		color: black ;
	}
	
	table.items td {
		border-right: 2px solid #000000;
		padding: 2px ;
		background-color: white ;
	}
	   
	@page {
		margin-top: 10px;
		size: auto;
		odd-footer-name: html_myFooter2;
		even-footer-name: html_myFooter2;
		margin: 5%;
	}
</style>

<div style='text-align:center'>
	<h1> <span class='under'>Termékeladás statisztika</span> </h1>
</div>

<p style='text-align:center'>
	<strong> Lekért időszak: <?php echo $model -> statisztika_mettol . ' - ' . $model -> statisztika_meddig; ?> </strong>
</p>

<?php if ($termekcsoport != null): ?>
	<p style='text-align:center'>
		<strong> Termékcsoport: <?php echo $termekcsoport -> nev; ?> </strong>
	</p>
<?php endif; ?>

<?php if ($cikkszam != null): ?>
	<p style='text-align:center'>
		<strong> Cikkszám(ok): <?php echo $cikkszam; ?> </strong>
	</p>
<?php endif; ?>

<?php

    $this->widget('ext.groupgridview.BootGroupGridView', array(
      'id' => 'termekeladas_statisztika_grid',
      'itemsCssClass'=>'items group-grid-view',
      'dataProvider' => $dataProvider,
      //'mergeColumns' => array('ev', 'ho', 'gyarto'),
      'maxMergedRows' => 15,
	  'mergeType' => 'simple',
      'enablePagination' => false,
      'enableSorting' => false,
      'columns' => array(
						array(
						   'header'=>'Termékcsoport',
						   'name'=>'termekcsoport',
						),
						array(
						   'header'=>'Terméknév',
						   'name'=>'termek_nev',
						),
						array(
						   'header'=>'Cikkszám',
						   'name'=>'cikkszam',
						),
						/*
						array(
						   'header'=>'Teljesített megrendelések száma (db)',
						   'name'=>'teljesitett_megrendelesek_szama',
						),
						*/
						array(
						   'header'=>'Eladott darabszám',
						   'name'=>'darabszam',
						   'htmlOptions'=>array('style' => 'text-align: right;'),
						),
						array(
						   'header'=>'Nettó érték (Ft)',
						   'name'=>'osszeg',
						   'htmlOptions'=>array('style' => 'text-align: right;'),
						),
						array(
						   'header'=>'Haszon (Ft)',
						   'name'=>'haszon',
						   'htmlOptions'=>array('style' => 'text-align: right;'),
						),
					),
    ));

?>	

<!--
<p align='right'>
	<strong>Összes beszerzési érték: <?php echo $osszesBeszerzesiErtek; ?> Ft</strong>
</p>

<p align='right'>
	<strong>Összes eladási érték: <?php echo $osszesEladasiErtek; ?> Ft</strong>
</p>

<p align='right'>
	<strong>Összes haszon: <?php echo $osszesHaszon; ?> Ft</strong>
</p>
-->

<htmlpagefooter name="myFooter2" style="display:none">

<table width="100%" class = "table_footer" style="vertical-align: bottom; font-family: arial; font-size: 8pt; color: #000000;">
	<tr>
		<td width="40%"> <span> <?php echo "Lista nyomtatva: " . date('Y-m-d H:i:s'); ?> </span> </td>
		<td width='20%'> <?php echo $actualUserName; ?> </td>
		<td width="40%" style="text-align: right; "> {PAGENO} .oldal </td>
    </tr>
</table>
</htmlpagefooter>

</html>
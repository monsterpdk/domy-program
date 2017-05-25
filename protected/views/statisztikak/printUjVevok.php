<?php
	$actualUserName = '';
	$actualUser = User::model()->findByPk(Yii::app()->user->getId());
	
	if ($actualUser != null) {
		$actualUserName	= $actualUser->fullname;
	}
	
	$stat_type = $model->stat_type_filter == 'elso_arajanlat' ? 'első árajánlatot kapott ügyfelek' : 'első megrendelő ügyfelek';
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
	<h1> <span class='under'>Új vevők</span> </h1>
</div>

<p style='text-align:center'>
	<strong> Lekért időszak: <?php echo $model -> statisztika_mettol . ' - ' . $model -> statisztika_meddig; ?> </strong>
</p>

<p style='text-align:center'>
	<strong> Statisztika típusa: <?php echo $stat_type; ?> </strong>
</p>

<?php
    $this->widget('zii.widgets.grid.CGridView', array(
      'id' => 'sztornozott_megrendelesek_grid',
	  'template' => '{items}',
      'dataProvider' => $dataProvider,
      'enablePagination' => false,
      'enableSorting' => false,
      'columns' => array(
						array(
						   'header'=>'Ügyfélnév',
						   'name'=>'ugyfel_neve',
						),
						array(
						   'header'=>'Dátum',
						   'name'=>'datum',
						),
						array(
						   'header'=>'Nettó összeg (Ft)',
						   'name'=>'netto_osszeg',
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

<p align='right'>
	<strong>Összes ügyfél: <?php echo $osszUgyfelSzam; ?> db</strong>
</p>

<p align='right'>
	<strong>Összes nettó érték: <?php echo $osszErtek; ?> Ft</strong>
</p>

<p align='right'>
	<strong>Összes haszon: <?php echo $osszHaszon; ?> Ft</strong>
</p>						
						
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
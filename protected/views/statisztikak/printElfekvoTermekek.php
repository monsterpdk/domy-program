<?php
	$actualUserName = '';
	$actualUser = User::model()->findByPk(Yii::app()->user->getId());
	
	if ($actualUser != null) {
		$actualUserName	= $actualUser->fullname;
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
	<h1> <span class='under'>Elfekvő termékek</span> </h1>
</div>

<p style='text-align:center'>
	Legalább ennyi ideje raktáron lévő termékek: <strong> <?php echo $model -> nap_filter ?> nap </strong>
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
						   'header'=>'Terméknév',
						   'name'=>'termek_neve',
						),
						array(
						   'header'=>'Cikkszám',
						   'name'=>'cikkszam',
						),
						array(
						   'header'=>'Gyártó',
						   'name'=>'gyarto',
						),
						array(
						   'header'=>'Készlet darabszáma',
						   'name'=>'keszlet_darabszam',
						   'htmlOptions'=>array('style' => 'text-align: right;'),
						),
						array(
						   'header'=>'Nettó érték (Ft)',
						   'name'=>'netto_ertek',
						   'htmlOptions'=>array('style' => 'text-align: right;'),
						),
					),
    ));

?>	

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
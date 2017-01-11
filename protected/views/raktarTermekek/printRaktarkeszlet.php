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
	div {
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
		background-color: white;
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
	<h1> <span class='under'>Raktárkészlet</span> </h1>
</div>

<?php
	$reszletesLista = false;
	if (isset($_GET['RaktarTermekek'])) {
		if ($_GET['RaktarTermekek']['is_atmozgatas']) {
			$reszletesLista = $_GET['RaktarTermekek']['is_atmozgatas'] == 1;
		}
	}
	
    $this->widget('ext.groupgridview.BootGroupGridView', array(
      'id' => 'raktar_termekek_grid',
      'itemsCssClass'=>'items group-grid-view',
      'dataProvider' => $dataProvider,
      'enablePagination' => false,
      'enableSorting' => false,
      'summaryText' => '',
      'extraRowColumns' => $reszletesLista ? array('raktarHelyek.raktar.nev') : array(),
      'mergeColumns' => $reszletesLista ? array('raktarHelyek.raktar.nev', 'raktarHelyek.nev') : array(),
      'extraRowPos' => 'above',
      'maxMergedRows' => 12,
      'columns' => array(
						array(
							'name'=>'raktarHelyek.raktar.nev',
							'visible'=>$reszletesLista,
						), 
						array(
							'name'=>'raktarHelyek.nev',
							'visible'=>$reszletesLista,
						), 
						array(
							'name'=>'anyagbeszallitas.bizonylatszam',
							'visible'=>$reszletesLista,
						), 
						array(
							'name'=>'anyagbeszallitas.beszallitas_datum',
							'visible'=>$reszletesLista,
						), 
						'termek.cikkszam',
						'termek.DisplayTermekTeljesNev',
						'termek.gyarto.cegnev',
						array('name' => 'osszes_db', 'value' => 'Utils::DarabszamFormazas($data->osszes_db)', 'htmlOptions' => array('style' => 'text-align: right;')),
						array('name' => 'foglalt_db', 'value' => 'Utils::DarabszamFormazas($data->foglalt_db)', 'htmlOptions' => array('style' => 'text-align: right;')),
						array('name' => 'elerheto_db', 'value' => 'Utils::DarabszamFormazas($data->elerheto_db)', 'htmlOptions' => array('style' => 'text-align: right;')),
      ),
	  
    ));
?>	

<?php
	// összesítés kiírása a riport aljára
	echo "<div align='right' style='padding-top:15px'><strong>Összesen db: </strong> " . Utils::DarabszamFormazas($osszesen_db) . "</div>";
	echo "<div align='right' style='padding-top:15px'><strong>Összesen ft: </strong> " . Utils::DarabszamFormazas($osszesen_ft) . "</div>";
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
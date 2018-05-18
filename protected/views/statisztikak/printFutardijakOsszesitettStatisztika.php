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

	.table {
		border: solid thin gray;
		font-family: arial;
		font-size: 10pt;
		width: 100%;
		padding: 2px;
		border-spacing: 1px;
		border-collapse: separate;	
		box-decoration-break: clone;
		background-color: silver ;
	}
	
	.table th {
		color: black ;
	}
	
	.table td {
		border-right: 2px solid #000000;
		padding: 2px;
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
	<h1> <span class='under'>Futárdíjak összesített statisztika</span> </h1>
</div>

<p style='text-align:center'>
	<strong> Lekért időszak: <?php echo $model -> statisztika_mettol . ' - ' . $model -> statisztika_meddig; ?> </strong>
</p>

<?php
	echo '<table class = "table">';
	echo '<tr>
			<th>Futár</th>
			<th>Szállítás díja (Ft)</th>
		 </tr>';
	
		$actualFutarCeg = '';
		$futarCegOsszesenSzallitasiDij = 0;
		$szallitasiDijOsszesen = 0;
		
		foreach ($dataProvider -> getData() as $item) {
			if ($actualFutarCeg == '' || $actualFutarCeg != $item['futar_ceg']) {
				if ($actualFutarCeg != '') {
					echo "<tr> <td align='left'>Összesen:</td> <td align='right'> <strong> " . Utils::OsszegFormazas($futarCegOsszesenSzallitasiDij, 0) . " </strong></td> </tr>";
					
					$futarCegOsszesenSzallitasiDij = 0;
					
					echo "<tr> <td colspan='2'>&nbsp;</td> </tr>";
				}

				$actualFutarCeg = $item['futar_ceg'];

				echo "<tr> <td colspan='2'><strong>$actualFutarCeg</strong></td> </tr>";
			}

			echo "<tr>";
				echo "<td style='padding-left:20px'>" . $item['futar'] . "</td>";
				echo "<td align='right'>" . Utils::OsszegFormazas($item['szallitas_dij'], 0) . "</td>";
			echo "</tr>";
			
			$futarCegOsszesenSzallitasiDij += $item['szallitas_dij'];
			$szallitasiDijOsszesen += $item['szallitas_dij'];
		}

		if (count($dataProvider -> getData()) > 0) {
			echo "<tr> <td align='left'>Összesen:</td> <td align='right'> <strong> " . Utils::OsszegFormazas($futarCegOsszesenSzallitasiDij, 0) . " </strong></td> </tr>";
		}
	echo '</table>';
?>

<p align='right'>
	<strong>Összesen: <?php echo Utils::OsszegFormazas($szallitasiDijOsszesen, 0); ?> Ft</strong>
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
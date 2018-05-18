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

	table {
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
	
	table th {
		color: black ;
	}
	
	table td {
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
	<h1> <span class='under'>Nem elszámolt tételek statisztika</span> </h1>
</div>

<p style='text-align:center'>
	<strong> Lekért időszak: <?php echo $model -> statisztika_mettol . ' - ' . $model -> statisztika_meddig; ?> </strong>
</p>

<?php
	echo '<table class = "tetelek">';
	echo '<tr>
			<th>Termék</th>
			<th>Darab</th>
			<th>Utánvét összeg (Ft)</th>
		 </tr>';
	
		$actualFutarCeg = '';
		$actualFutar = '';
		$actualMegrendelo = '';
		
		$futarCegOsszesenDb = 0;
		$futarOsszesenDb = 0;
		$termekOsszesenDb = 0;
		
		$futarCegOsszesenUtanvetOsszeg = 0;
		$futarOsszesenUtanvetOsszeg = 0;
		$termekOsszesenUtanvetOsszeg = 0;
		
		$dbOsszesen = 0;
		$osszegOsszesen = 0;
		
		foreach ($dataProvider -> getData() as $item) {
			if ($actualFutarCeg == '' || $actualFutarCeg != $item['futar_ceg']) {
				if ($actualMegrendelo != '') {
					echo "<tr> <td align='left' style='padding-left:40px'>Összesen:</td> <td align='right'> <strong> " . Utils::DarabszamFormazas($termekOsszesenDb) . " </strong></td> <td align='right'> <strong> " . Utils::OsszegFormazas($termekOsszesenUtanvetOsszeg, 0) . " </strong> </td> </tr>";
					
					$termekOsszesenDb = 0;
					$termekOsszesenUtanvetOsszeg = 0;
				}
				
				if ($actualFutar != '') {
					echo "<tr> <td align='left' style='padding-left:20px'>Összesen:</td> <td align='right'> <strong> " . Utils::DarabszamFormazas($futarOsszesenDb) . " </strong></td> <td align='right'> <strong> " . Utils::OsszegFormazas($futarOsszesenUtanvetOsszeg, 0) . " </strong> </td> </tr>";
					
					$futarOsszesenDb = 0;
					$futarOsszesenUtanvetOsszeg = 0;
				}
				
				if ($actualFutarCeg != '') {
					echo "<tr> <td align='left'>Összesen:</td> <td align='right'> <strong> " . Utils::DarabszamFormazas($futarCegOsszesenDb) . " </strong></td> <td align='right'> <strong> " . Utils::OsszegFormazas($futarCegOsszesenUtanvetOsszeg, 0) . " </strong> </td> </tr>";
					
					$futarCegOsszesenDb = 0;
					$futarCegOsszesenUtanvetOsszeg = 0;
					
					echo "<tr> <td colspan='3'>&nbsp;</td> </tr>";
				}

				$actualFutarCeg = $item['futar_ceg'];
				
				$actualFutar = '';
				$actualMegrendelo = '';

				echo "<tr> <td colspan='3'><strong>$actualFutarCeg</strong></td> </tr>";
			}
			if ($actualFutar == '' || $actualFutar != $item['futar']) {
				if ($actualFutar != '') {
					echo "<tr> <td align='left' style='padding-left:40px'>Összesen:</td> <td align='right'> <strong> " . Utils::DarabszamFormazas($termekOsszesenDb) . " </strong></td> <td align='right'> <strong> " . Utils::OsszegFormazas($termekOsszesenUtanvetOsszeg, 0) . " </strong> </td> </tr>";
					
					$termekOsszesenDb = 0;
					$termekOsszesenUtanvetOsszeg = 0;
					
					echo "<tr> <td align='left' style='padding-left:20px'>Összesen:</td> <td align='right'> <strong> " . Utils::DarabszamFormazas($futarOsszesenDb) . " </strong></td> <td align='right'> <strong> " . Utils::OsszegFormazas($futarOsszesenUtanvetOsszeg, 0) . " </strong> </td> </tr>";
					
					$futarOsszesenDb = 0;
					$futarOsszesenUtanvetOsszeg = 0;
				}
				
				$actualFutar = $item['futar'];
				
				$actualMegrendelo = '';
				
				echo "<tr>";
					echo "<td colspan='3' style='padding-left:20px'><strong>$actualFutar</strong></td>";
				echo "</tr>";
			}
			if ($actualMegrendelo == '' || $actualMegrendelo != $item['megrendelo']) {
				if ($actualMegrendelo != '') {
					echo "<tr> <td align='left' style='padding-left:40px'>Összesen:</td> <td align='right'> <strong> " . Utils::DarabszamFormazas($termekOsszesenDb) . " </strong></td> <td align='right'> <strong> " . Utils::OsszegFormazas($termekOsszesenUtanvetOsszeg, 0) . " </strong> </td> </tr>";
					
					$termekOsszesenDb = 0;
					$termekOsszesenUtanvetOsszeg = 0;
				}
				
				$futarCegOsszesenUtanvetOsszeg += $item['utanvet_osszeg'];
				$futarOsszesenUtanvetOsszeg += $item['utanvet_osszeg'];
				$termekOsszesenUtanvetOsszeg += $item['utanvet_osszeg'];
				$osszegOsszesen += $item['utanvet_osszeg'];
				
				$actualMegrendelo = $item['megrendelo'];
				
				echo "<tr> <td colspan='3' style='padding-left:40px'><strong>$actualMegrendelo</strong></td> </tr>";
			}
			
			echo "<tr>";
				echo "<td style='padding-left:60px'>" . $item['termek'] . "</td>";
				echo "<td align='right'>" . $item['darab_dsp'] . "</td>";
				echo "<td align='right'></td>";
			echo "</tr>";
			
			$termekOsszesenDb += $item['darab'];
			$futarOsszesenDb += $item['darab'];
			$futarCegOsszesenDb += $item['darab'];
			$dbOsszesen += $item['darab'];
		}
		
		if (count($dataProvider -> getData()) > 0) {
			echo "<tr> <td align='left' style='padding-left:40px'>Összesen:</td> <td align='right'> <strong> " . Utils::DarabszamFormazas($termekOsszesenDb) . "</strong></td> <td align='right'> <strong> " . Utils::OsszegFormazas($termekOsszesenUtanvetOsszeg, 0) . " </strong> </td> </tr>";
			echo "<tr> <td align='left' style='padding-left:20px'>Összesen:</td> <td align='right'> <strong> " . Utils::DarabszamFormazas($futarOsszesenDb) . " </strong></td> <td align='right'> <strong> " . Utils::OsszegFormazas($futarOsszesenUtanvetOsszeg, 0) . " </strong> </td> </tr>";
			echo "<tr> <td align='left'>Összesen:</td> <td align='right'> <strong> " . Utils::DarabszamFormazas($futarCegOsszesenDb) . " </strong></td> <td align='right'> <strong> " . Utils::OsszegFormazas($futarCegOsszesenUtanvetOsszeg, 0) . " </strong> </td> </tr>";
		}
	echo '</table>';
?>	

<p align='right'>
	<strong>Darab összesen: <?php echo Utils::DarabszamFormazas($dbOsszesen); ?> db</strong>
</p>

<p align='right'>
	<strong>Utánvét összeg összesen: <?php echo Utils::OsszegFormazas($osszegOsszesen, 0); ?> Ft</strong>
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
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
	<h1> <span class='under'>Futár kiszállításai időszakra statisztika</span> </h1>
</div>

<p style='text-align:center'>
	<strong> Lekért időszak: <?php echo $model -> statisztika_mettol . ' - ' . $model -> statisztika_meddig; ?> </strong>
</p>

<?php
	echo '<table class = "futarok">';
	echo '<tr>
			<th>Termék</th>
			<th>Darab</th>
			<th>Megjegyzés</th>
		 </tr>';
	
		$actualFutar = '';
		$actualMegrendelo = '';
		$futarOsszesen = 0;
		
		foreach ($dataProvider -> getData() as $item) {
			if ($actualFutar == '' || $actualFutar != $item['futar']) {
				if ($actualFutar != '') {
					echo "<tr> <td colspan='3' align='right'><strong>Összesen: $futarOsszesen db</strong></td> </tr>";
					
					$futarOsszesen = 0;
				}
				
				$actualFutar = $item['futar'];
				
				echo "<tr>";
					echo "<td colspan='3'><strong>$actualFutar</strong></td>";
				echo "</tr>";
			}
			if ($actualMegrendelo == '' || $actualMegrendelo != $item['megrendelo']) {
				$actualMegrendelo = $item['megrendelo'];
				
				echo "<tr> <td colspan='3' style='padding-left:20px'><strong>$actualMegrendelo</strong></td> </tr>";
			}
			echo "<tr>";
				echo "<td style='padding-left:40px'>" . $item['termek'] . "</td>";
				echo "<td align='right'>" . $item['darab_dsp'] . "</td>";
				echo "<td>" . $item['megjegyzes'] ."</td>";
			echo "</tr>";
			
			$futarOsszesen += $item['darab'];
		}
		
		if (count($dataProvider -> getData()) > 0) {
			echo "<tr> <td colspan='3' align='right'><strong>Összesen: $futarOsszesen db</strong></td> </tr>";
		}
	echo '</table>';
?>	

<p align='right'>
	<strong>Összesen: <?php echo Utils::OsszegFormazas($osszesen, 0); ?> db</strong>
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
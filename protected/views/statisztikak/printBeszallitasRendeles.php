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
		font-size: 9pt;
	}
	.under {
		border-bottom: 4px double #000000;
	}
	table {
		border: 1px solid #000000;
		padding: 0px;
		font-family: arial;
		font-size: 9pt;
		border-spacing: 0px;
	}
	.fejlec1 {
		border: 0px;
		width: 1100px;
	}
	td.statisztika_fejlec_cim {
		font-size: 12pt;
		text-align: left ;
	}
	td.statisztika_fejlec_idoszak {
		font-size: 10pt;
		text-align: right;
	}
	table.statisztika_tablazat {
		border: solid 2px black;
		padding: 0px;
		margin: 3px 0px 0px 0px ;
		width: 1100px;
	}
	td.cim_cella_kisbetu {
		font-weight: bold;
		padding: 4px 2px 4px 2px;
	}
	.adat_cella_kisbetu {
		padding: 4px 2px 4px 2px;
	}
	.cim_cella_kisbetu_kisbetu {
		font-size:9px;
	}
	.adat_cella_kisbetu_kisbetu {
		font-size:9px;
	}
	.cim_cella_kisbetu_kozepesbetu {
		font-size:10px;
	}
	.adat_cella_kisbetu_kozepesbetu {
		font-size:10px;
	}
	table.statisztika_belso_tablazat_teljes_szelesseg {
		width: 1100px;
		padding: 0px;
		margin: 0px ;
		border: none;
	}
	.szegely_fent {
		border-top: solid 1px black ;
	}
	.szegely_jobb {
		border-right: solid 1px black ;
	}
	.szegely_alul {
		border-bottom: solid 1px black ;
	}
	.szegely_bal {
		border-left: solid 1px black ;
	}
	.nincs_szegely {
		border: none ;
	}
	.kozepre {
		text-align: center ;
	}
	.jobbra {
		text-align: right ;
	}
	.dolt {
		font-style: italic ;
	}


	.table_footer {
		border: 0px;
	}
	@page {
		margin-top: 10px;
		size: auto;
		odd-footer-name: html_myFooter2;
		even-footer-name: html_myFooter2;
	}
</style>

<div class='wide form'>

	<table class='fejlec1'>
		<tr>
			<td class="statisztika_fejlec_cim"> <strong> Beszállíás - eladás statisztika </strong> </td>
			<td class="statisztika_fejlec_idoszak">Év: <?php echo $model->ev; ?></td>
		</tr>
	</table>

	<table class="statisztika_tablazat">
		<tr>
		<td class="szegely_alul szegely_jobb" style="width: 95px;">&nbsp;</td>
		<?php
			foreach ($eladasok["eladas"]["db"] as $ho => $ertek) {
				echo '<td class="cim_cella_kisbetu kozepre szegely_alul szegely_jobb">' . $ho . '</td>' ;
			}
			echo '</tr><tr>' ;
			echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Eladás db</td>' ;
			foreach ($eladasok["eladas"]["db"] as $ho => $ertek) {
				echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::DarabszamFormazas($ertek) . '</td>' ;
			}
			echo '</tr><tr>' ;
			echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Eladás kp</td>' ;
			foreach ($eladasok["eladas"]["kp"] as $ho => $ertek) {
				echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::OsszegFormazas($ertek,0) . ' Ft </td>' ;
			}
			echo '</tr><tr>' ;
			echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Eladás átut</td>' ;
			foreach ($eladasok["eladas"]["utalas"] as $ho => $ertek) {
				echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::OsszegFormazas($ertek,0) . ' Ft </td>' ;
			}

			echo '</tr><tr>' ;
			echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Saját nyomás db</td>' ;
			foreach ($eladasok["sajatnyomas"]["db"] as $ho => $ertek) {
				echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::DarabszamFormazas($ertek) . '</td>' ;
			}
			echo '</tr><tr>' ;
			echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Saját nyomás kp</td>' ;
			foreach ($eladasok["sajatnyomas"]["kp"] as $ho => $ertek) {
				echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::OsszegFormazas($ertek,0) . ' Ft </td>' ;
			}
			echo '</tr><tr>' ;
			echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Saját nyomás átut</td>' ;
			foreach ($eladasok["sajatnyomas"]["utalas"] as $ho => $ertek) {
				echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::OsszegFormazas($ertek,0) . ' Ft </td>' ;
			}

			echo '</tr><tr>' ;
			echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Bérnyomás db</td>' ;
			foreach ($eladasok["bernyomas"]["db"] as $ho => $ertek) {
				echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::DarabszamFormazas($ertek) . '</td>' ;
			}
			echo '</tr><tr>' ;
			echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Bérnyomás kp</td>' ;
			foreach ($eladasok["bernyomas"]["kp"] as $ho => $ertek) {
				echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::OsszegFormazas($ertek,0) . ' Ft </td>' ;
			}
			echo '</tr><tr>' ;
			echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Bérnyomás átut</td>' ;
			foreach ($eladasok["bernyomas"]["utalas"] as $ho => $ertek) {
				echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::OsszegFormazas($ertek,0) . ' Ft </td>' ;
			}

			echo '</tr><tr>' ;
			echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Nyomás db</td>' ;
			foreach ($eladasok["nyomas_osszesen"]["db"] as $ho => $ertek) {
				echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::DarabszamFormazas($ertek) . '</td>' ;
			}
			echo '</tr><tr>' ;
			echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Nyomás kp</td>' ;
			foreach ($eladasok["nyomas_osszesen"]["kp"] as $ho => $ertek) {
				echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::OsszegFormazas($ertek,0) . ' Ft </td>' ;
			}
			echo '</tr><tr>' ;
			echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Nyomás átut</td>' ;
			foreach ($eladasok["nyomas_osszesen"]["utalas"] as $ho => $ertek) {
				echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::OsszegFormazas($ertek,0) . ' Ft </td>' ;
			}

			echo '</tr><tr>' ;
			echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Össz. db</td>' ;
			foreach ($eladasok["eladott_osszesen"]["db"] as $ho => $ertek) {
				echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::DarabszamFormazas($ertek) . '</td>' ;
			}
			echo '</tr><tr>' ;
			echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Össz. kp</td>' ;
			foreach ($eladasok["eladott_osszesen"]["kp"] as $ho => $ertek) {
				echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::OsszegFormazas($ertek,0) . ' Ft </td>' ;
			}
			echo '</tr><tr>' ;
			echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Össz. átut</td>' ;
			foreach ($eladasok["eladott_osszesen"]["utalas"] as $ho => $ertek) {
				echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::OsszegFormazas($ertek,0) . ' Ft </td>' ;
			}
		?>
		</tr>
		<?php
			foreach ($beszallito_adatok as $gyarto => $adatok) {
				echo '<tr><td colspan="14" class="cim_cella szegely_alul">' . $gyarto . '</td></tr>' ;
				echo '<tr>' ;
				echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Rendelve db</td>' ;
				foreach ($adatok["db"] as $ho => $ertek) {
					echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::DarabszamFormazas($ertek) . '</td>' ;
				}
				echo '</tr><tr>' ;
				echo '<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Rendelve Ft</td>' ;
				foreach ($adatok["osszeg"] as $ho => $ertek) {
					echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::OsszegFormazas($ertek,0) . ' Ft </td>' ;
				}
				echo '</tr>' ;
			}
		?>
		<tr><td colspan="14" class="cim_cella szegely_alul">Összesen</td></tr>
		<tr>
			<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Rendelve db</td>
		</tr>
		<?php
			foreach ($osszesitett_adatok["db"] as $ho => $ertek) {
				echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::DarabszamFormazas($ertek) . '</td>' ;
			}
		?>
		</tr>
		<tr>
			<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Rendelve Ft</td>
		</tr>
		<?php
		foreach ($osszesitett_adatok["osszeg"] as $ho => $ertek) {
			echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::OsszegFormazas($ertek, 0) . ' Ft</td>' ;
		}
		?>
		</tr>
		<tr>
			<td class="cim_cella_kisbetu szegely_alul szegely_jobb">Elad+Sajátny.</td>
		</tr>
		<?php
		foreach ($osszesitett_adatok["eladasok_db"] as $ho => $ertek) {
			echo '<td class="adat_cella_kisbetu jobbra szegely_alul szegely_jobb">' . Utils::DarabszamFormazas($ertek) . '</td>' ;
		}
		?>
		</tr>
	</table>


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
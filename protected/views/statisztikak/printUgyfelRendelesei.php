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
/*		border: 1px solid #000000;*/
		padding: 0px;
		font-family: arial;
		font-size: 8pt;
		border-spacing: 0px;
	}
	.fejlec1 {
		border: 0px;
		width: 700px;
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
/*		border: solid 2px black;*/
		padding: 0px;
		margin: 3px 0px 0px 0px ;
		width: 700px;
	}
	td.cim_cella {
		font-weight: bold;
	}
	.cim_cella_kisbetu {
		font-size:8px;
	}
	.adat_cella_kisbetu {
		font-size:8px;
	}
	.cim_cella_kozepesbetu {
		font-size:10px;
	}
	.adat_cella_kozepesbetu {
		font-size:10px;
	}
	table.statisztika_belso_tablazat_fel_szelesseg {
		width: 350px;
		padding: 0px;
		margin: 0px ;
		border: none;
	}
	table.statisztika_belso_tablazat_teljes_szelesseg {
		width: 700px;
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

<div style='text-align:center'>
	<h1> <span class='under'>Ügyfél rendelései</span> </h1>
</div>

<p style='text-align:center'>
	<strong> Lekért időszak: <?php echo $model -> statisztika_mettol . ' - ' . $model -> statisztika_meddig; ?> </strong>
</p>

<?php if ($ugyfel_adatok != null): ?>
	<p style='text-align:center'>
		<strong> Vevő neve: <?php echo $ugyfel_adatok -> cegnev; ?> </strong>
	</p>
<?php endif; ?>

<table class="statisztika_tablazat">
	<tr>
		<td class="cim_cella" style="width: 55px;">Rendelve</td>
		<td class="cim_cella" style="width: 65px;">Rendelésszám</td>
		<td class="cim_cella" style="width: 130px;">Számla szám</td>
		<td class="cim_cella" style="width: 75px;">Kifizetve</td>
		<td class="cim_cella" style="width: 75px;">Fizetési hati.</td>
		<td class="cim_cella" style="width: 75px;">Lejárt</td>
		<td class="cim_cella" style="width: 75px;">Tartozás</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_alul" style="width: 75px;" colspan="3">Munka neve / termék</td>
		<td class="cim_cella szegely_alul" style="width: 75px;">Darab</td>
		<td class="cim_cella szegely_alul" style="width: 45px;">Szín</td>
		<td class="cim_cella szegely_alul" style="width: 75px;">Egys. ár</td>
		<td class="cim_cella szegely_alul" style="width: 75px;">Nettó összeg</td>
	</tr>
	<?php
		if (count($ugyfel_megrendelesek) > 0) {
			foreach ($ugyfel_megrendelesek as $megrendeles) {
	?>
				<tr>
					<td class="cim_cella szegely_felul szegely_alul"><?php echo substr($megrendeles["datum"], 0, 10);?></td>
					<td class="cim_cella szegely_felul szegely_alul"><?php echo $megrendeles["sorszam"];?></td>
					<td class="cim_cella szegely_felul szegely_alul"><?php echo $megrendeles["szamla_sorszam"];?>&nbsp;&nbsp;<?php echo $megrendeles["user_nev"];?></td>
					<td class="cim_cella szegely_felul szegely_alul"><?php echo substr($megrendeles["szamla_kifizetes_datum"], 0, 10) ;?></td>
					<td class="cim_cella szegely_felul szegely_alul"><?php echo substr($megrendeles["szamla_fizetesi_hatarido"], 0, 10);?></td>
					<td class="cim_cella szegely_felul szegely_alul"><?php if ($megrendeles["szamla_sorszam"] != "" && date("Y-m-d") > $megrendeles["szamla_fizetesi_hatarido"] && $megrendeles["szamla_kifizetes_datum"] == "") echo "lejárt";?></td>
					<td class="cim_cella szegely_felul szegely_alul">&nbsp;</td>
				</tr>
				<?php
					foreach ($megrendeles["tetelek"] as $tetel) {
				?>
					<tr>
						<td colspan="7" class="adat_cella"><?php echo $tetel["munka_nev"] ;?></td>
					</tr>
					<tr>
						<td colspan="3" class="adat_cella" style="padding-left: 10px;"><?php echo $tetel["termek_nev"];?></td>
						<td class="adat_cella jobbra"><?php echo Utils::DarabszamFormazas($tetel["darabszam"]);?></td>
						<td class="adat_cella kozepre"><?php echo $tetel["szin"];?></td>
						<td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($tetel["netto_darabar"]);?> Ft</td>
						<td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($tetel["netto_osszeg"], 0);?> Ft</td>
					</tr>
					<tr>
						<td colspan="2" class="adat_cella szegely_alul dolt">Beszerzés %:</td>
						<td class="adat_cella szegely_alul dolt"><?php echo $tetel["beszerzes_szazalek"];?>%</td>
						<td class="adat_cella szegely_alul dolt">Bevétel - beszerzés %:</td>
						<td class="adat_cella szegely_alul dolt"><?php echo $tetel["bevetel_beszerzes_szazalek"];?>%</td>
						<td class="adat_cella szegely_alul dolt">Bevétel - beszerzés:</td>
						<td class="adat_cella szegely_alul jobbra dolt"><?php echo Utils::OsszegFormazas($tetel["bevetel_beszerzes"], 0);?> Ft</td>
					</tr>
				<?php
					}
				?>
	<?php
			}
	?>
		<tr>
			<td colspan="3" class="cim_cella szegely_felul">Kiszámlázva összesen:</td>
			<td class="cim_cella szegely_felul jobbra"><?php echo Utils::DarabszamFormazas($osszesites_adatok["darabszam"]);?></td>
			<td colspan="3" class="cim_cella szegely_felul jobbra"><?php echo Utils::OsszegFormazas($osszesites_adatok["osszeg"], 0);?> Ft</td>
		</tr>
		<tr>
			<td colspan="2" class="adat_cella dolt">Átlagos beszerzés %:</td>
			<td class="adat_cella dolt"><?php echo $osszesites_adatok["atlagos_beszerzes"];?>%</td>
			<td class="adat_cella dolt">Bevétel - beszerzés %:</td>
			<td class="adat_cella dolt"><?php echo $osszesites_adatok["bevetel_beszerzes_szazalek"];?>%</td>
			<td class="adat_cella dolt">Bevétel - beszerzés:</td>
			<td class="adat_cella jobbra dolt"><?php echo Utils::OsszegFormazas($osszesites_adatok["bevetel_beszerzes"], 0);?> Ft</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td colspan="4">
				<table class="statisztika_belso_tablazat_fel_szelesseg">
					<tr>
						<td class="cim_cella jobbra">Kifizetve:</td>
						<td class="cim_cella"><?php echo $osszesites_adatok["kifizetve_db"];?> db</td>
						<td class="cim_cella jobbra"><?php echo Utils::OsszegFormazas($osszesites_adatok["kifizetve_osszeg"], 0);?> Ft</td>
					</tr>
					<tr>
						<td class="adat_cella jobbra dolt">Lejárt tartozás:</td>
						<td class="adat_cella dolt"><?php echo $osszesites_adatok["lejart_tartozas_db"];?> db</td>
						<td class="adat_cella jobbra dolt"><?php echo Utils::OsszegFormazas($osszesites_adatok["lejart_tartozas_osszeg"], 0);?> Ft</td>
					</tr>
					<tr>
						<td class="adat_cella jobbra dolt">Nem lejárt tartozás:</td>
						<td class="adat_cella dolt"><?php echo $osszesites_adatok["nem_lejart_tartozas_db"];?> db</td>
						<td class="adat_cella jobbra dolt"><?php echo Utils::OsszegFormazas($osszesites_adatok["nem_lejart_tartozas_osszeg"], 0);?> Ft</td>
					</tr>
					<tr>
						<td class="cim_cella jobbra szegely_alul dolt">Tartozás:</td>
						<td class="cim_cella szegely_alul dolt"><?php echo $osszesites_adatok["tartozas_db"];?> db</td>
						<td class="cim_cella szegely_alul jobbra dolt"><?php echo Utils::OsszegFormazas($osszesites_adatok["tartozas_osszeg"], 0);?> Ft</td>
					</tr>
					<tr>
						<td class="cim_cella jobbra szegely_alul">Kiszámlázva:</td>
						<td class="cim_cella szegely_alul"><?php echo $osszesites_adatok["kiszamlazva_db"];?> db</td>
						<td class="cim_cella szegely_alul jobbra"><?php echo Utils::OsszegFormazas($osszesites_adatok["kiszamlazva_osszeg"], 0);?> Ft</td>
					</tr>
				</table>
			</td>
		</tr>
	<?php
		}
	?>

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
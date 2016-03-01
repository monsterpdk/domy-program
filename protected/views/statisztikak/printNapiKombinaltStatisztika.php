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
		border: solid 2px black;	
		padding: 0px;
		margin: 3px 0px 0px 0px ;
		width: 700px;		
	}		
	td.cim_cella {
		font-weight: bold;		
	}
	.cim_cella_kisbetu {
		font-size:8pt;	
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
		<td class="statisztika_fejlec_cim"> <strong> Statisztika </strong> </td>
		<td class="statisztika_fejlec_idoszak">Időszak: <?php echo $model->statisztika_mettol . " - " . $model->statisztika_meddig; ?></td>
	</tr>
</table>

<table class="statisztika_tablazat">
	<tr>
		<td class="szegely_alul" style="width: 55px;">&nbsp;</td>
		<td class="cim_cella szegely_alul szegely_jobb">Elkészített ajánlatok <span class="cim_cella_kisbetu">kiemelt cégek nélkül</span></td>
		<td class="cim_cella szegely_alul szegely_jobb">Megrendelések száma <span class="cim_cella_kisbetu">kiemelt cégek nélkül</span></td>
		<td class="kozepre szegely_alul" style="width:50px;">%</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_jobb" colspan="2">
			<table class="statisztika_belso_tablazat_fel_szelesseg">
				<tr>
					<td class="szegely_jobb" style="width: 55px;">Eladás</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatStatisztika_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo Utils::OsszegFormazas($stat_adatok["arajanlatOsszegEladas_kiemeltek_nelkul"],0);?> Ft</td>
				</tr>
				<tr>
					<td colspan="2" class="adat_cella kozepre szegely_alul">ebből légpárnás</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo Utils::OsszegFormazas($stat_adatok["arajanlatOsszegLegparnas_kiemeltek_nelkul"],0);?> Ft</td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="szegely_jobb szegely_alul">Nyomás</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo Utils::OsszegFormazas($stat_adatok["arajanlatOsszegNyomas_kiemeltek_nelkul"],0);?> Ft</td>
				</tr>
				<tr class="osszesen_sor">
					<td>Összesen</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo Utils::OsszegFormazas($stat_adatok["arajanlatOsszegEladas_kiemeltek_nelkul"] + $stat_adatok["arajanlatOsszegNyomas_kiemeltek_nelkul"],0);?> Ft</td>
				</tr>
			</table>
		</td>
		<td colspan="2">
			<table class="statisztika_belso_tablazat_fel_szelesseg">
				<tr>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesStatisztika_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul"],0);?> Ft</td>
					<td class="adat_cella jobbra" style="width:49px;"><?php echo $stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalek"];?></td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegLegparnas_kiemeltek_nelkul"],0);?> Ft</td>
					<td class="szegely_alul">&nbsp;</td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul"],0);?> Ft</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalek"];?></td>
				</tr>
				<tr class="osszesen_sor">
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul"],0);?> Ft</td>
					<td class="adat_cella jobbra"><?php echo $stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalek"];?></td>
				</tr>
			</table>
		</td>		
	</tr>
	<tr>
		<td colspan="4" class="szegely_fent">
			<table class="statisztika_belso_tablazat_teljes_szelesseg">
				<tr>
					<td class="cim_cella">h. fentről %:</td><td class="adat_cella jobbra szegely_jobb"><?php echo $stat_adatok["haszon_fentrol_kiemeltek_nelkul"];?> %</td>
					<td class="cim_cella">bevétel - anyag:</td><td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul"],0);?> Ft (eladás) +</td>
					<td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul"],0);?> (nyomás) =</td>
					<td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["bevetel_termekeken_osszesen_kiemeltek_nelkul"],0);?> Ft</td>
				</tr>
				<tr>
					<td class="cim_cella">h. lentről %:</td><td class="adat_cella jobbra szegely_jobb"><?php echo $stat_adatok["haszon_lentrol_kiemeltek_nelkul"];?> %</td>
					<td class="cim_cella">anyag  <span style="font-weight: normal;"><?php echo $stat_adatok["anyag_szazalek_kiemeltek_nelkul"];?> %</span></td>
					<td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["anyagkoltseg_osszesen_kiemeltek_nelkul"],0);?> Ft</td>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table class="statisztika_tablazat">
	<tr>
		<td class="cim_cella szegely_alul szegely_jobb" style="width: 350px;">Kiemelt cégek</td>
		<td class="cim_cella szegely_alul" colspan="2">Megrendelések száma</td>
	</tr>
<?php
	if (count($stat_adatok["cegek_kiemeltek"]) > 0) {
		foreach($stat_adatok["cegek_kiemeltek"] as $cegnev => $adatok) {
?>
	<tr>
		<td class="adat_cella szegely_alul szegely_jobb"><?php echo $cegnev;?></td>
		<td class="adat_cella szegely_alul jobbra"><?php echo $adatok["megrendelesszam"];?> db</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::OsszegFormazas($adatok["megrendeles_osszeg"],0);?> Ft</td>
	</tr>	
<?php
		}
	}
?>
	<tr>
		<td class="cim_cella szegely_alul szegely_felul szegely_jobb">Összesen</td>
		<td class="cim_cella szegely_alul jobbra"><?php echo $stat_adatok["cegek_megrendelesszam_osszesen_csak_kiemeltek"];?> db</td>
		<td class="cim_cella szegely_alul jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["cegek_megrendelesosszeg_csak_kiemeltek"],0);?> Ft</td>
	</tr>
	<tr>
		<td colspan="3" class="szegely_fent">
			<table class="statisztika_belso_tablazat_teljes_szelesseg">
				<tr>
					<td class="cim_cella">h. fentről %:</td><td class="adat_cella jobbra szegely_jobb"><?php echo $stat_adatok["haszon_fentrol_csak_kiemeltek"];?> %</td>
					<td class="cim_cella">bevétel - anyag:</td><td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["bevetel_termekeken_eladas_osszesen_csak_kiemeltek"],0);?> Ft (eladás) +</td>
					<td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["bevetel_termekeken_nyomas_osszesen_csak_kiemeltek"],0);?> (nyomás) =</td>
					<td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["bevetel_termekeken_osszesen_csak_kiemeltek"],0);?> Ft</td>
				</tr>
				<tr>
					<td class="cim_cella">h. lentről %:</td><td class="adat_cella jobbra szegely_jobb"><?php echo $stat_adatok["haszon_lentrol_csak_kiemeltek"];?> %</td>
					<td class="cim_cella">anyag  <span style="font-weight: normal;"><?php echo $stat_adatok["anyag_szazalek_csak_kiemeltek"];?> %</span></td>
					<td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["anyagkoltseg_osszesen_csak_kiemeltek"],0);?> Ft</td>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>	
</table>

<table class="statisztika_tablazat nincs_szegely">
	<tr>
		<td style="width: 100px;">&nbsp;</td>
		<td class="cim_cella kozepre" colspan="2">Elkészített ajánlatok összes</td>
		<td class="cim_cella kozepre" colspan="2">Megrendelések száma összes</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_felul szegely_alul szegely_balra">Összesen</td>
		<td class="cim_cella szegely_felul szegely_alul" style="padding-left: 60px;">38 db</td>
		<td class="cim_cella szegely_felul szegely_alul">3 672 237 Ft</td>
		<td class="cim_cella szegely_felul szegely_alul" style="padding-left: 60px;">24 db</td>
		<td class="cim_cella szegely_felul szegely_alul szegely_jobbra">944 753 Ft</td>
	</tr>
</table>

<table class="statisztika_tablazat">
	<tr>
		<td class="cim_cella szegely_alul" style="width: 140px;">Csak megrendelt</td>
		<td class="cim_cella szegely_alul" style="width: 280px;padding-left:70px;" colspan="2">Kiszámlázva <span class="cim_cella_kisbetu">kiemelt cégek nélkül</span></td>
		<td class="cim_cella szegely_alul" style="width: 280px;padding-left:70px;" colspan="2">Kiszámlázva összes</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_alul szegely_jobb">Boríték eladás</td>
		<td class="adat_cella szegely_alul jobbra">10 db</td>
		<td class="adat_cella szegely_alul jobbra szegely_jobb">187 052 Ft</td>
		<td class="adat_cella szegely_alul jobbra">10 db</td>
		<td class="adat_cella szegely_alul jobbra szegely_jobb">187 052 Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_alul szegely_jobb">Boríték nyomás</td>
		<td class="adat_cella szegely_alul jobbra">0 db</td>
		<td class="adat_cella szegely_alul jobbra szegely_jobb">0 Ft</td>
		<td class="adat_cella szegely_alul jobbra">0 db</td>
		<td class="adat_cella szegely_alul jobbra szegely_jobb">0 Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_jobb">Összesen</td>
		<td class="cim_cella jobbra">10 db</td>
		<td class="cim_cella jobbra szegely_jobb">187 052 Ft</td>
		<td class="cim_cella jobbra">10 db</td>
		<td class="cim_cella jobbra szegely_jobb">187 052 Ft</td>
	</tr>
</table>

<table class="statisztika_tablazat">
	<tr>
		<td class="cim_cella szegely_alul" style="width: 140px;">Összes számla</td>
		<td class="cim_cella szegely_alul" style="width: 280px;padding-left:70px;" colspan="2">Kiszámlázva <span class="cim_cella_kisbetu">kiemelt cégek nélkül</span></td>
		<td class="cim_cella szegely_alul" style="width: 280px;padding-left:70px;" colspan="2">Kiszámlázva összes</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_alul szegely_jobb">Boríték eladás</td>
		<td class="adat_cella szegely_alul jobbra">12 db</td>
		<td class="adat_cella szegely_alul jobbra szegely_jobb">217 109 Ft</td>
		<td class="adat_cella szegely_alul jobbra">12 db</td>
		<td class="adat_cella szegely_alul jobbra szegely_jobb">217 109 Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_alul szegely_jobb">Boríték nyomás</td>
		<td class="adat_cella szegely_alul jobbra">1 db</td>
		<td class="adat_cella szegely_alul jobbra szegely_jobb">47 387 Ft</td>
		<td class="adat_cella szegely_alul jobbra">1 db</td>
		<td class="adat_cella szegely_alul jobbra szegely_jobb">47 387 Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_jobb">Összesen</td>
		<td class="cim_cella jobbra">13 db</td>
		<td class="cim_cella jobbra szegely_jobb">264 496 Ft</td>
		<td class="cim_cella jobbra">13 db</td>
		<td class="cim_cella jobbra szegely_jobb">264 496 Ft</td>
	</tr>
</table>

<table class="statisztika_tablazat">
	<tr>
		<td class="cim_cella szegely_alul" style="width: 140px;">&nbsp;</td>
		<td class="cim_cella szegely_alul" style="width: 220px;padding-left:20px;" colspan="2">Pénztárba befolyt készpénz</td>
		<td class="cim_cella szegely_alul" style="width: 220px;padding-left:20px;" colspan="2">Folyószámlára érkező összeg</td>
		<td class="cim_cella szegely_alul" style="width: 120px;padding-left:20px;">Összesen</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_alul szegely_jobb" rowspan="2" style="vertical-align:top;">Boríték eladás</td>
		<td class="adat_cella jobbra" style="width: 80px;">3 db</td>
		<td class="adat_cella jobbra szegely_jobb" style="width: 140px;">39 276 Ft</td>
		<td class="adat_cella jobbra" style="width: 80px;">1 db</td>
		<td class="adat_cella jobbra szegely_jobb" style="width: 140px;">14 060 Ft</td>
		<td class="adat_cella jobbra szegely_jobb">58 658 Ft</td>
	</tr>
	<tr>
		<td class="adat_cella kozepre szegely_alul">bruttó -></td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb">49 880 Ft</td>
		<td class="adat_cella kozepre szegely_alul">&nbsp;</td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb">17 856 Ft</td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb">74 495 Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_alul szegely_jobb" rowspan="2" style="vertical-align:top;">Boríték nyomás</td>
		<td class="adat_cella jobbra" style="width: 80px;">0 db</td>
		<td class="adat_cella jobbra szegely_jobb" style="width: 140px;">0 Ft</td>
		<td class="adat_cella jobbra" style="width: 80px;">0 db</td>
		<td class="adat_cella jobbra szegely_jobb" style="width: 140px;">0 Ft</td>
		<td class="adat_cella jobbra szegely_jobb">0 Ft</td>
	</tr>
	<tr>
		<td class="adat_cella kozepre szegely_alul">bruttó -></td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb">0 Ft</td>
		<td class="adat_cella kozepre szegely_alul">&nbsp;</td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb">0 Ft</td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb">0 Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_alul szegely_jobb" rowspan="2" style="vertical-align:top;">Összesen</td>
		<td class="adat_cella jobbra" style="width: 80px;">3 db</td>
		<td class="adat_cella jobbra szegely_jobb" style="width: 140px;">39 276 Ft</td>
		<td class="adat_cella jobbra" style="width: 80px;">1 db</td>
		<td class="adat_cella jobbra szegely_jobb" style="width: 140px;">14 060 Ft</td>
		<td class="cim_cella jobbra szegely_jobb">58 658 Ft</td>
	</tr>
	<tr>
		<td class="adat_cella kozepre szegely_alul">bruttó -></td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb">49 880 Ft</td>
		<td class="adat_cella kozepre szegely_alul">&nbsp;</td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb">17 856 Ft</td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb">74 495 Ft</td>
	</tr>
</table>

<table class="statisztika_tablazat nincs_szegely">
	<tr>
		<td class="cim_cella szegely_alul" style="width: 500px;" colspan="3">Időszaktól független tartozás statisztika</td>
		<td class="cim_cella szegely_alul jobbra">bruttó</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_felul szegely_bal szegely_alul szegely_jobb">Összes (lejárt + nem lejárt)</td>
		<td class="adat_cella szegely_felul szegely_alul jobbra">1 542 db</td>
		<td class="adat_cella szegely_felul szegely_alul jobbra">12 331 159 Ft</td>
		<td class="adat_cella szegely_felul szegely_alul szegely_jobb jobbra">15 660 572 Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_bal szegely_alul szegely_jobb">Előző hónapban lejárt</td>
		<td class="adat_cella szegely_alul jobbra">51 db</td>
		<td class="adat_cella szegely_alul jobbra">457 778 Ft</td>
		<td class="adat_cella szegely_alul szegely_jobb jobbra">581 379 Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_bal szegely_alul szegely_jobb">Előző évben lejárt</td>
		<td class="adat_cella szegely_alul jobbra">518 db</td>
		<td class="adat_cella szegely_alul jobbra">685 631 Ft</td>
		<td class="adat_cella szegely_alul szegely_jobb jobbra">870 752 Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_bal szegely_alul szegely_jobb">Lejárt (ügyvédnél lévők nélkül)</td>
		<td class="adat_cella szegely_alul jobbra">1 443 db</td>
		<td class="adat_cella szegely_alul jobbra">7 759 812 Ft</td>
		<td class="adat_cella szegely_alul szegely_jobb jobbra">9 854 952 Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_bal szegely_alul szegely_jobb">Nem lejárt</td>
		<td class="adat_cella szegely_alul jobbra">96 db</td>
		<td class="adat_cella szegely_alul jobbra">4 476 836 Ft</td>
		<td class="adat_cella szegely_alul szegely_jobb jobbra">5 685 582 Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_bal szegely_alul szegely_jobb">Lejárók szeptember hónapban</td>
		<td class="adat_cella szegely_alul jobbra">267 db</td>
		<td class="adat_cella szegely_alul jobbra">7 773 573 Ft</td>
		<td class="adat_cella szegely_alul szegely_jobb jobbra">9 872 438 Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_bal szegely_alul szegely_jobb">Behajtó cégnek átadva</td>
		<td class="adat_cella szegely_alul jobbra">0 db</td>
		<td class="adat_cella szegely_alul jobbra">0 Ft</td>
		<td class="adat_cella szegely_alul szegely_jobb jobbra">0 Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_bal szegely_alul szegely_jobb">Ügyvédnek átadva</td>
		<td class="adat_cella szegely_alul jobbra">3 db</td>
		<td class="adat_cella szegely_alul jobbra">94 509 Ft</td>
		<td class="adat_cella szegely_alul szegely_jobb jobbra">120 027 Ft</td>
	</tr>
</table>

<br />
Boríték eladás: nincs színszám, Nyomás (saját+bér): van színszám. A külön nem jelzett értékek nettó Ft-ot jelentenek<br />
<hr>
<table class="statisztika_tablazat" style="border:none;">
	<tr>
		<td class="cim_cella jobbra" style="width: 200px;">Folyamatban lévő munkák:</td>
		<td class="adat_cella jobbra" style="width: 100px;">34 db</td>
		<td class="adat_cella jobbra" style="width: 200px;">1 853 286 Ft</td>
		<td class="adat_cella jobbra szegely_bal szegely_fent szegely_jobb" style="width: 200px;">Munkadíj bevétel</td>
	</tr>
	<tr>
		<td class="cim_cella jobbra">Kiszámlázva:</td>
		<td class="adat_cella jobbra">0 db</td>
		<td class="adat_cella jobbra">0 Ft</td>
		<td class="adat_cella jobbra szegely_bal szegely_jobb">100 379 Ft</td>	
	</tr> 
	<tr>
		<td class="cim_cella jobbra">Kiszámlázva adott időszakban:</td>
		<td class="adat_cella jobbra">0 db</td>
		<td class="adat_cella jobbra">0 Ft</td>
		<td class="adat_cella jobbra szegely_bal szegely_alul szegely_jobb">4 182 Ft/ó</td>	
	</tr> 
</table>

</div>

<htmlpagefooter name="myFooter2" style="display:none">
<table width="100%" class = "table_footer" style="vertical-align: bottom; font-family: arial; font-size: 8pt; color: #000000;">
	<tr>
		<td width="40%"> <span> <?php echo "Táska nyomtatva: " . date('Y-m-d h:m:s'); ?> </span> </td>
		<td width='20%'> <?php echo $actualUserName; ?> </td>
		<td width="40%" style="text-align: right; "> {PAGENO} .oldal </td>
    </tr>
</table>
</htmlpagefooter>

</html>
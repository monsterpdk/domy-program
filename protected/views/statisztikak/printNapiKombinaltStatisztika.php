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
		<td class="cim_cella szegely_felul szegely_alul" style="padding-left: 60px;"><?php echo $stat_adatok["kiadott_ajanlatok_szama_osszesen"];?> db</td>
		<td class="cim_cella szegely_felul szegely_alul"><?php echo Utils::OsszegFormazas($stat_adatok["kiadott_ajanlatok_erteke_osszesen"],0);?> Ft</td>
		<td class="cim_cella szegely_felul szegely_alul" style="padding-left: 60px;"><?php echo $stat_adatok["megrendelesek_szama_osszesen"];?> db</td>
		<td class="cim_cella szegely_felul szegely_alul szegely_jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesek_erteke_osszesen"],0);?> Ft</td>
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
		<td class="adat_cella szegely_alul jobbra"><?php echo $stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_eladas_kiemeltek_nelkul"];?> db</td>
		<td class="adat_cella szegely_alul jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszeg_kiemeltek_nelkul"],0);?> Ft</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo $stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszesen"];?> db</td>
		<td class="adat_cella szegely_alul jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszeg_osszesen"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_alul szegely_jobb">Boríték nyomás</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo $stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_nyomas_kiemeltek_nelkul"];?> db</td>
		<td class="adat_cella szegely_alul jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszeg_kiemeltek_nelkul"],0);?> Ft</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo $stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszesen"];?> db</td>
		<td class="adat_cella szegely_alul jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszeg_osszesen"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_jobb">Összesen</td>
		<td class="cim_cella jobbra"><?php echo $stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_osszesen_kiemeltek_nelkul"];?> db</td>
		<td class="cim_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_osszesen_osszeg_kiemeltek_nelkul"],0);?> Ft</td>
		<td class="cim_cella jobbra"><?php echo $stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_osszesen"];?> db</td>
		<td class="cim_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_osszeg_osszesen"],0);?> Ft</td>
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
		<td class="adat_cella szegely_alul jobbra"><?php echo $stat_adatok["szamlazott_megrendelesek_eladas_kiemeltek_nelkul"];?> db</td>
		<td class="adat_cella szegely_alul jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["szamlazott_megrendelesek_eladas_osszeg_kiemeltek_nelkul"],0);?> Ft</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo $stat_adatok["szamlazott_megrendelesek_eladas_osszesen"];?> db</td>
		<td class="adat_cella szegely_alul jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["szamlazott_megrendelesek_eladas_osszeg_osszesen"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_alul szegely_jobb">Boríték nyomás</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo $stat_adatok["szamlazott_megrendelesek_nyomas_kiemeltek_nelkul"];?> db</td>
		<td class="adat_cella szegely_alul jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["szamlazott_megrendelesek_nyomas_osszeg_kiemeltek_nelkul"],0);?> Ft</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo $stat_adatok["szamlazott_megrendelesek_nyomas_osszesen"];?> db</td>
		<td class="adat_cella szegely_alul jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["szamlazott_megrendelesek_nyomas_osszeg_osszesen"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_jobb">Összesen</td>
		<td class="cim_cella jobbra"><?php echo $stat_adatok["szamlazott_megrendelesek_osszesen_kiemeltek_nelkul"];?> db</td>
		<td class="cim_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["szamlazott_megrendelesek_osszesen_osszeg_kiemeltek_nelkul"],0);?> Ft</td>
		<td class="cim_cella jobbra"><?php echo $stat_adatok["szamlazott_megrendelesek_osszesen"];?> db</td>
		<td class="cim_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["szamlazott_megrendelesek_osszeg_osszesen"],0);?> Ft</td>
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
		<td class="adat_cella jobbra" style="width: 80px;"><?php echo $stat_adatok["termek_eladas_penztar_db"];?> db</td>
		<td class="adat_cella jobbra szegely_jobb" style="width: 140px;"><?php echo Utils::OsszegFormazas($stat_adatok["termek_eladas_penztar_netto"],0);?> Ft</td>
		<td class="adat_cella jobbra" style="width: 80px;"><?php echo $stat_adatok["termek_eladas_utalas_db"];?> db</td>
		<td class="adat_cella jobbra szegely_jobb" style="width: 140px;"><?php echo Utils::OsszegFormazas($stat_adatok["termek_eladas_utalas_netto"],0);?> Ft</td>
		<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["termek_eladas_osszesen_netto"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="adat_cella kozepre szegely_alul">bruttó -></td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["termek_eladas_penztar_brutto"],0);?> Ft</td>
		<td class="adat_cella kozepre szegely_alul">&nbsp;</td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["termek_eladas_utalas_brutto"],0);?> Ft</td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["termek_eladas_osszesen_brutto"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_alul szegely_jobb" rowspan="2" style="vertical-align:top;">Boríték nyomás</td>
		<td class="adat_cella jobbra" style="width: 80px;"><?php echo $stat_adatok["boritek_nyomas_penztar_db"];?> db</td>
		<td class="adat_cella jobbra szegely_jobb" style="width: 140px;"><?php echo Utils::OsszegFormazas($stat_adatok["boritek_nyomas_penztar_netto"],0);?> Ft</td>
		<td class="adat_cella jobbra" style="width: 80px;"><?php echo $stat_adatok["boritek_nyomas_utalas_db"];?> db</td>
		<td class="adat_cella jobbra szegely_jobb" style="width: 140px;"><?php echo Utils::OsszegFormazas($stat_adatok["boritek_nyomas_utalas_netto"],0);?> Ft</td>
		<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["boritek_nyomas_osszesen_netto"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="adat_cella kozepre szegely_alul">bruttó -></td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["boritek_nyomas_penztar_brutto"],0);?> Ft</td>
		<td class="adat_cella kozepre szegely_alul">&nbsp;</td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["boritek_nyomas_utalas_brutto"],0);?> Ft</td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["boritek_nyomas_osszesen_brutto"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_alul szegely_jobb" rowspan="2" style="vertical-align:top;">Összesen</td>
		<td class="adat_cella jobbra" style="width: 80px;"><?php echo $stat_adatok["penztar_tranzakcio_db_osszesen"];?> db</td>
		<td class="adat_cella jobbra szegely_jobb" style="width: 140px;"><?php echo Utils::OsszegFormazas($stat_adatok["penztar_tranzakcio_netto_osszesen"],0);?> Ft</td>
		<td class="adat_cella jobbra" style="width: 80px;"><?php echo $stat_adatok["utalas_tranzakcio_db_osszesen"];?> db</td>
		<td class="adat_cella jobbra szegely_jobb" style="width: 140px;"><?php echo Utils::OsszegFormazas($stat_adatok["utalas_tranzakcio_netto_osszesen"],0);?> Ft</td>
		<td class="cim_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["tranzakciok_netto_osszesen"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="adat_cella kozepre szegely_alul">bruttó -></td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["penztar_tranzakcio_brutto_osszesen"],0);?> Ft</td>
		<td class="adat_cella kozepre szegely_alul">&nbsp;</td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["utalas_tranzakcio_brutto_osszesen"],0);?> Ft</td>
		<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["tranzakciok_brutto_osszesen"],0);?> Ft</td>
	</tr>
</table>

<table class="statisztika_tablazat nincs_szegely">
	<tr>
		<td class="cim_cella szegely_alul" style="width: 500px;" colspan="3">Időszaktól független tartozás statisztika</td>
		<td class="cim_cella szegely_alul jobbra">bruttó</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_felul szegely_bal szegely_alul szegely_jobb">Összes (lejárt + nem lejárt)</td>
		<td class="adat_cella szegely_felul szegely_alul jobbra"><?php echo Utils::DarabszamFormazas($stat_adatok["osszes_nyitott_megrendeles"]["db"]);?> db</td>
		<td class="adat_cella szegely_felul szegely_alul jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["osszes_nyitott_megrendeles"]["netto"],0);?> Ft</td>
		<td class="adat_cella szegely_felul szegely_alul szegely_jobb jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["osszes_nyitott_megrendeles"]["brutto"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_bal szegely_alul szegely_jobb">Előző hónapban lejárt</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::DarabszamFormazas($stat_adatok["mult_honapban_lejartak"]["db"]);?> db</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["mult_honapban_lejartak"]["netto"],0);?> Ft</td>
		<td class="adat_cella szegely_alul szegely_jobb jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["mult_honapban_lejartak"]["brutto"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_bal szegely_alul szegely_jobb">Előző évben lejárt</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::DarabszamFormazas($stat_adatok["mult_evben_lejartak"]["db"]);?> db</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["mult_evben_lejartak"]["netto"],0);?> Ft</td>
		<td class="adat_cella szegely_alul szegely_jobb jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["mult_evben_lejartak"]["brutto"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_bal szegely_alul szegely_jobb">Lejárt (ügyvédnél lévők nélkül)</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::DarabszamFormazas($stat_adatok["lejartak"]["db"]);?> db</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["lejartak"]["netto"],0);?> Ft</td>
		<td class="adat_cella szegely_alul szegely_jobb jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["lejartak"]["brutto"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_bal szegely_alul szegely_jobb">Nem lejárt</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::DarabszamFormazas($stat_adatok["nem_lejartak"]["db"]);?> db</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["nem_lejartak"]["netto"],0);?> Ft</td>
		<td class="adat_cella szegely_alul szegely_jobb jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["nem_lejartak"]["brutto"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_bal szegely_alul szegely_jobb">Lejárók <?php echo Yii::app()->dateFormatter->format("MMMM", mktime());?> hónapban</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::DarabszamFormazas($stat_adatok["lejarnak_ebben_a_honapban"]["db"]);?> db</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["lejarnak_ebben_a_honapban"]["netto"],0);?> Ft</td>
		<td class="adat_cella szegely_alul szegely_jobb jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["lejarnak_ebben_a_honapban"]["brutto"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_bal szegely_alul szegely_jobb">Behajtó cégnek átadva</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::DarabszamFormazas($stat_adatok["behajto_cegnek_atadva"]["db"]);?> db</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["behajto_cegnek_atadva"]["netto"],0);?> Ft</td>
		<td class="adat_cella szegely_alul szegely_jobb jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["behajto_cegnek_atadva"]["brutto"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_bal szegely_alul szegely_jobb">Ügyvédnek átadva</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::DarabszamFormazas($stat_adatok["ugyvednek_atadva"]["db"]);?> db</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["ugyvednek_atadva"]["netto"],0);?> Ft</td>
		<td class="adat_cella szegely_alul szegely_jobb jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["ugyvednek_atadva"]["brutto"],0);?> Ft</td>
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
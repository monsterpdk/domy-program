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
		<td class="statisztika_fejlec_idoszak">Időszak: <?php echo substr($model->statisztika_mettol, 0, 10) . " - " . substr($model->statisztika_meddig, 0, 10); ?></td>
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
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul"] ;?> tétel</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo Utils::OsszegFormazas($stat_adatok["arajanlatOsszegEladas_kiemeltek_nelkul"] + $stat_adatok["arajanlatOsszegLegparnas_kiemeltek_nelkul"],0);?> Ft</td>
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
					<td class="szegely_alul">Összesen</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["arajanlatStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo Utils::OsszegFormazas($stat_adatok["arajanlatOsszegEladas_kiemeltek_nelkul"] + $stat_adatok["arajanlatOsszegNyomas_kiemeltek_nelkul"] + $stat_adatok["arajanlatOsszegLegparnas_kiemeltek_nelkul"],0);?> Ft</td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="szegely_alul" colspan="2">Eladás ajánlat nélkül</td>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="szegely_alul" colspan="2">Nyomás ajánlat nélkül</td>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>
				<tr class="osszesen_sor">
					<td colspan="2">Összesen ajánlat nélkül</td>
					<td class="adat_cella jobbra nincs_szegely">&nbsp;</td>
					<td class="adat_cella jobbra nincs_szegely">&nbsp;</td>
				</tr>
			</table>
		</td>
		<td colspan="2">
			<table class="statisztika_belso_tablazat_fel_szelesseg">
				<tr>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesStatisztika_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegLegparnas_kiemeltek_nelkul"],0);?> Ft</td>
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
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_jobb szegely_alul"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegLegparnas_kiemeltek_nelkul"],0);?> Ft</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalek"];?></td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesStatisztikaAjanlatNelkul_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesTetelekStatisztikaAjanlatNelkul_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladasAjanlatNelkul_kiemeltek_nelkul"],0);?> Ft</td>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesNyomasStatisztikaAjanlatNelkul_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesNyomasTetelekStatisztikaAjanlatNelkul_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegNyomasAjanlatNelkul_kiemeltek_nelkul"],0);?> Ft</td>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>
				<tr class="osszesen_sor">
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesStatisztikaAjanlatNelkul_kiemeltek_nelkul"] + $stat_adatok["megrendelesNyomasStatisztikaAjanlatNelkul_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesTetelekStatisztikaAjanlatNelkul_kiemeltek_nelkul"] + $stat_adatok["megrendelesNyomasTetelekStatisztikaAjanlatNelkul_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladasAjanlatNelkul_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegNyomasAjanlatNelkul_kiemeltek_nelkul"],0);?> Ft</td>
					<td class="adat_cella jobbra">&nbsp;</td>
				</tr>
			</table>
		</td>		
	</tr>
	<tr>
		<td colspan="4" class="szegely_fent">
			<table class="statisztika_belso_tablazat_teljes_szelesseg">
				<tr>
					<td class="cim_cella">h. fentről %:</td><td class="adat_cella jobbra szegely_jobb"><?php echo $stat_adatok["haszon_fentrol_kiemeltek_nelkul"];?> %</td>
					<td class="cim_cella">bevétel - anyag:</td><td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_eladas_kiemeltek_nelkul"],0);?> Ft (eladás) +</td>
					<td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_nyomas_kiemeltek_nelkul"],0);?> (nyomás) =</td>
					<td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_osszesen_kiemeltek_nelkul"],0);?> Ft</td>
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
					<td class="cim_cella">bevétel - anyag:</td><td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_eladas_csak_kiemeltek"],0);?> Ft (eladás) +</td>
					<td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_nyomas_csak_kiemeltek"],0);?> (nyomás) =</td>
					<td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_osszesen_csak_kiemeltek"],0);?> Ft</td>
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
		<td class="adat_cella jobbra" style="width: 100px;"><?php echo $stat_adatok["nyitott_munkak_db"];?> db</td>
		<td class="adat_cella jobbra" style="width: 200px;"><?php echo Utils::OsszegFormazas($stat_adatok["nyitott_munkak_netto"],0);?> Ft</td>
		<td class="adat_cella jobbra szegely_bal szegely_fent szegely_jobb" style="width: 200px;">Munkadíj bevétel</td>
	</tr>
	<tr>
		<td class="cim_cella jobbra">Kiszámlázva:</td>
		<td class="adat_cella jobbra"><?php echo $stat_adatok["nyitott_munkak_kiszamlazva_db"];?> db</td>
		<td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["nyitott_munkak_kiszamlazva_netto"],0);?> Ft</td>
		<td class="adat_cella jobbra szegely_bal szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["nyitott_munkak_munkadij_netto"],0);?> Ft</td>	
	</tr> 
	<tr>
		<td class="cim_cella jobbra">Kiszámlázva adott időszakban:</td>
		<td class="adat_cella jobbra"><?php echo $stat_adatok["nyitott_munkak_kiszamlazva_adott_idoszakban_db"];?> db</td>
		<td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["nyitott_munkak_kiszamlazva_adott_idoszakban_netto"],0);?> Ft</td>
		<td class="adat_cella jobbra szegely_bal szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["nyitott_munkak_munkadij_netto_orankent"],0);?> Ft/ó</td>	
	</tr> 
</table>
</div>
<pagebreak />
<!-- Statisztika 2. oldal -->
<div class='wide form'>
<table class='fejlec1'>
	<tr>
		<td class="statisztika_fejlec_cim"> <strong> Statisztika </strong> </td>
		<td class="statisztika_fejlec_idoszak">Időszak: <?php echo $model->statisztika_mettol . " - " . $model->statisztika_meddig; ?></td>
	</tr>
</table>

<table class="statisztika_tablazat">
	<tr>
		<td class="szegely_alul" style="width: 85px;">bevétel-beszerzés</td>
		<td class="cim_cella szegely_alul szegely_jobb">Elkészített ajánlatok</td>
		<td class="cim_cella szegely_alul szegely_jobb">Megrendelések száma</td>
		<td class="kozepre szegely_alul" style="width:100px;">% cég / % db</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_jobb" colspan="2">
			<table class="statisztika_belso_tablazat_fel_szelesseg">
				<tr>
					<td class="szegely_jobb" style="width: 85px;">
						Termék eladás
					</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatStatisztika_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo Utils::OsszegFormazas($stat_adatok["arajanlatOsszegEladas_kiemeltek_nelkul"] + $stat_adatok["arajanlatOsszegLegparnas_kiemeltek_nelkul"],0);?> Ft</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_eladas_kiemeltek_nelkul"],0);?> Ft</td>
					<td colspan="2" class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul"] ;?> tétel</td>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="szegely_jobb">Nyomás</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo Utils::OsszegFormazas($stat_adatok["arajanlatOsszegNyomas_kiemeltek_nelkul"],0);?> Ft</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_nyomas_kiemeltek_nelkul"],0);?> Ft</td>
					<td colspan="2" class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>				
				<tr class="osszesen_sor">
					<td class="szegely_jobb">Összesen</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul"] + $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo Utils::OsszegFormazas($stat_adatok["arajanlatOsszegEladas_kiemeltek_nelkul"] + $stat_adatok["arajanlatOsszegNyomas_kiemeltek_nelkul"] + $stat_adatok["arajanlatOsszegLegparnas_kiemeltek_nelkul"],0);?> Ft</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_eladas_kiemeltek_nelkul"] + $stat_adatok["haszon_nyomas_kiemeltek_nelkul"],0);?> Ft</td>
					<td colspan="2" class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>				

				<tr>
					<td class="szegely_nincs" colspan="4">
						Termék eladás ajánlat nélkül
					</td>					
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_eladas_kiemeltek_nelkulAjanlatNelkul"],0);?> Ft</td>
					<td colspan="3" class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="nincs_szegely" colspan="4">Nyomás ajánlat nélkül</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_nyomas_kiemeltek_nelkulAjanlatNelkul"],0);?> Ft</td>
					<td colspan="3" class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>				
				<tr class="osszesen_sor">
					<td class="nincs_szegely" colspan="4">Összesen ajánlat nélkül</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_osszesen_kiemeltek_nelkulAjanlatNelkul"],0);?> Ft</td>
					<td colspan="3" class="adat_cella jobbra nincs_szegely">&nbsp;</td>
				</tr>				
				
			</table>
		</td>
		<td colspan="2">
			<table class="statisztika_belso_tablazat_fel_szelesseg">
				<tr>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekEladas_kiemeltek_nelkul"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesStatisztika_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegLegparnas_kiemeltek_nelkul"],0);?> Ft</td>
					<td class="adat_cella jobbra" style="width:100px;"><?php echo $stat_adatok["eladas_arajanlatcegek_megrendelescegek_szazalek"];?> &nbsp;&nbsp;&nbsp;<?php echo $stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalek"];?></td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb">&nbsp;</td>
					<td class="szegely_alul">&nbsp;</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkul"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul"],0);?> Ft</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["nyomas_arajanlatcegek_megrendelescegek_szazalek"];?> &nbsp;&nbsp;&nbsp;<?php echo $stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalek"];?></td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb">&nbsp;</td>
					<td class="szegely_alul">&nbsp;</td>
				</tr>
				<tr class="osszesen_sor">
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekEladas_kiemeltek_nelkul"] + $stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkul"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegLegparnas_kiemeltek_nelkul"],0);?> Ft</td>
					<td class="adat_cella jobbra"><?php echo $stat_adatok["osszesen_arajanlatcegek_megrendelescegek_szazalek"];?> &nbsp;&nbsp;&nbsp;<?php echo $stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalek"];?></td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb">&nbsp;</td>
					<td class="szegely_alul">&nbsp;</td>
				</tr>
				
				<tr>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekEladasAjanlatNelkul_kiemeltek_nelkul"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesStatisztikaAjanlatNelkul_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladasAjanlatNelkul_kiemeltek_nelkul"],0);?> Ft</td>
					<td class="adat_cella jobbra" style="width:100px;">&nbsp;</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesTetelekStatisztikaAjanlatNelkul_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb">&nbsp;</td>
					<td class="szegely_alul">&nbsp;</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekNyomasAjanlatNelkul_kiemeltek_nelkul"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesNyomasStatisztikaAjanlatNelkul_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegNyomasAjanlatNelkul_kiemeltek_nelkul"],0);?> Ft</td>
					<td class="adat_cella jobbra nincs_szegely">&nbsp;</td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesNyomasTetelekStatisztikaAjanlatNelkul_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb">&nbsp;</td>
					<td class="szegely_alul">&nbsp;</td>
				</tr>
				<tr class="osszesen_sor">
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekEladasAjanlatNelkul_kiemeltek_nelkul"] + $stat_adatok["megrendelesCegekNyomasAjanlatNelkul_kiemeltek_nelkul"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesStatisztikaAjanlatNelkul_kiemeltek_nelkul"] + $stat_adatok["megrendelesNyomasStatisztikaAjanlatNelkul_kiemeltek_nelkul"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladasAjanlatNelkul_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegNyomasAjanlatNelkul_kiemeltek_nelkul"],0);?> Ft</td>
					<td class="adat_cella jobbra">&nbsp;</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra nincs_szegely">&nbsp;</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesTetelekStatisztikaAjanlatNelkul_kiemeltek_nelkul"] + $stat_adatok["megrendelesNyomasTetelekStatisztikaAjanlatNelkul_kiemeltek_nelkul"];?> tétel</td>
					<td class="adat_cella jobbra szegely_jobb">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>				
			</table>
		</td>		
	</tr>
</table>
<br />
Darabszám 10 000 alatt <span class="cim_cella_kisbetu">kiemelt cégek nélkül</span><br />
<table class="statisztika_tablazat">
	<tr>
		<td class="szegely_alul" style="width: 85px;">bevétel-beszerzés</td>
		<td class="cim_cella szegely_alul szegely_jobb">Elkészített ajánlatok</td>
		<td class="cim_cella szegely_alul szegely_jobb">Megrendelések száma</td>
		<td class="kozepre szegely_alul" style="width:100px;">% cég / % db</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_jobb" colspan="2">
			<table class="statisztika_belso_tablazat_fel_szelesseg">
				<tr>
					<td class="szegely_jobb" style="width: 85px;">
						Termék eladás
					</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul_10000_alatt"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatStatisztika_kiemeltek_nelkul_10000_alatt"];?> db</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo Utils::OsszegFormazas($stat_adatok["arajanlatOsszegEladas_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["arajanlatOsszegLegparnas_kiemeltek_nelkul_10000_alatt"],0);?> Ft</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_eladas_kiemeltek_nelkul_10000_alatt"],0);?> Ft</td>
					<td colspan="2" class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="szegely_jobb">Nyomás</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul_10000_alatt"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul_10000_alatt"];?> db</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo Utils::OsszegFormazas($stat_adatok["arajanlatOsszegNyomas_kiemeltek_nelkul_10000_alatt"],0);?> Ft</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_nyomas_kiemeltek_nelkul_10000_alatt"],0);?> Ft</td>
					<td colspan="2" class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>				
				<tr class="osszesen_sor">
					<td class="szegely_jobb">Összesen</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul_10000_alatt"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul_10000_alatt"];?> db</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo Utils::OsszegFormazas($stat_adatok["arajanlatOsszegEladas_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["arajanlatOsszegLegparnas_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["arajanlatOsszegNyomas_kiemeltek_nelkul_10000_alatt"],0);?> Ft</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_jobb szegely_alul"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_eladas_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["haszon_nyomas_kiemeltek_nelkul_10000_alatt"],0);?> Ft</td>
					<td colspan="2" class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>	
				
				<tr>
					<td class="szegely_nincs" colspan="4">
						Termék eladás ajánlat nélkül
					</td>					
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_eladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"],0);?> Ft</td>
					<td colspan="3" class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="nincs_szegely" colspan="4">Nyomás ajánlat nélkül</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_nyomas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"],0);?> Ft</td>
					<td colspan="3" class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>				
				<tr class="osszesen_sor">
					<td class="nincs_szegely" colspan="4">Összesen ajánlat nélkül</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra nincs_szegely"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt"],0);?> Ft</td>
					<td colspan="3" class="adat_cella jobbra nincs_szegely">&nbsp;</td>
				</tr>					
			</table>
		</td>
		<td colspan="2">
			<table class="statisztika_belso_tablazat_fel_szelesseg">
				<tr>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekEladas_kiemeltek_nelkul_10000_alatt"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesStatisztika_kiemeltek_nelkul_10000_alatt"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul_10000_alatt"],0);?> Ft</td>
					<td class="adat_cella jobbra" style="width:100px;"><?php echo $stat_adatok["eladas_arajanlatcegek_megrendelescegek_szazalek_10000_alatt"];?> &nbsp;&nbsp;&nbsp;<?php echo $stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalek_10000_alatt"];?></td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb">&nbsp;</td>
					<td class="szegely_alul">&nbsp;</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkul_10000_alatt"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul_10000_alatt"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul_10000_alatt"],0);?> Ft</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["nyomas_arajanlatcegek_megrendelescegek_szazalek_10000_alatt"];?> &nbsp;&nbsp;&nbsp;<?php echo $stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalek_10000_alatt"];?></td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb">&nbsp;</td>
					<td class="szegely_alul">&nbsp;</td>
				</tr>
				<tr class="osszesen_sor">
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekEladas_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkul_10000_alatt"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul_10000_alatt"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["megrendelesOsszegLegparnas_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul_10000_alatt"],0);?> Ft</td>
					<td class="adat_cella jobbra"><?php echo $stat_adatok["osszesen_arajanlatcegek_megrendelescegek_szazalek_10000_alatt"];?> &nbsp;&nbsp;&nbsp;<?php echo $stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalek_10000_alatt"];?></td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] ;?> tétel</td>
					<td class="adat_cella jobbra szegely_jobb szegely_alul">&nbsp;</td>
					<td class="szegely_alul">&nbsp;</td>
				</tr>
				
				<tr>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"],0);?> Ft</td>
					<td class="adat_cella jobbra" style="width:100px;">&nbsp;</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb">&nbsp;</td>
					<td class="szegely_alul">&nbsp;</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"],0);?> Ft</td>
					<td class="adat_cella jobbra nincs_szegely">&nbsp;</td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb">&nbsp;</td>
					<td class="szegely_alul">&nbsp;</td>
				</tr>
				<tr class="osszesen_sor">
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"],0);?> Ft</td>
					<td class="adat_cella jobbra">&nbsp;</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra nincs_szegely">&nbsp;</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"];?> tétel</td>
					<td class="adat_cella jobbra szegely_jobb">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>				
				
			</table>
		</td>		
	</tr>
</table>
<br />
Darabszám 10 000, vagy felette <span class="cim_cella_kisbetu">kiemelt cégek nélkül</span><br />
<table class="statisztika_tablazat">
	<tr>
		<td class="szegely_alul" style="width: 85px;">bevétel-beszerzés</td>
		<td class="cim_cella szegely_alul szegely_jobb">Elkészített ajánlatok</td>
		<td class="cim_cella szegely_alul szegely_jobb">Megrendelések száma</td>
		<td class="kozepre szegely_alul" style="width:100px;">% cég / % db</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_jobb" colspan="2">
			<table class="statisztika_belso_tablazat_fel_szelesseg">
				<tr>
					<td class="szegely_jobb" style="width: 85px;">
						Termék eladás
					</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul_10000_felett"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatStatisztika_kiemeltek_nelkul_10000_felett"];?> db</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo Utils::OsszegFormazas($stat_adatok["arajanlatOsszegEladas_kiemeltek_nelkul_10000_felett"] + $stat_adatok["arajanlatOsszegLegparnas_kiemeltek_nelkul_10000_felett"],0);?> Ft</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_eladas_kiemeltek_nelkul_10000_felett"],0);?> Ft</td>
					<td colspan="2" class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_felett"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="szegely_jobb">Nyomás</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul_10000_felett"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul_10000_felett"];?> db</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo Utils::OsszegFormazas($stat_adatok["arajanlatOsszegNyomas_kiemeltek_nelkul_10000_felett"],0);?> Ft</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_nyomas_kiemeltek_nelkul_10000_felett"],0);?> Ft</td>
					<td colspan="2" class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul_10000_felett"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>				
				<tr class="osszesen_sor">
					<td class="szegely_jobb">Összesen</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul_10000_felett"] + $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul_10000_felett"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["arajanlatStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul_10000_felett"];?> db</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo Utils::OsszegFormazas($stat_adatok["arajanlatOsszegEladas_kiemeltek_nelkul_10000_felett"] + $stat_adatok["arajanlatOsszegLegparnas_kiemeltek_nelkul_10000_felett"] + $stat_adatok["arajanlatOsszegNyomas_kiemeltek_nelkul_10000_felett"],0);?> Ft</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_jobb szegely_alul"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_eladas_kiemeltek_nelkul_10000_felett"] + $stat_adatok["haszon_nyomas_kiemeltek_nelkul_10000_felett"],0);?> Ft</td>
					<td colspan="2" class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul_10000_felett"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>	
				
				<tr>
					<td class="szegely_nincs" colspan="4">
						Termék eladás ajánlat nélkül
					</td>					
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_eladas_kiemeltek_nelkulAjanlatNelkul_10000_felett"],0);?> Ft</td>
					<td colspan="3" class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="nincs_szegely" colspan="4">Nyomás ajánlat nélkül</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_nyomas_kiemeltek_nelkulAjanlatNelkul_10000_felett"],0);?> Ft</td>
					<td colspan="3" class="adat_cella jobbra szegely_alul">&nbsp;</td>
				</tr>				
				<tr class="osszesen_sor">
					<td class="nincs_szegely" colspan="4">Összesen ajánlat nélkül</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra nincs_szegely"><?php echo Utils::OsszegFormazas($stat_adatok["haszon_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett"],0);?> Ft</td>
					<td colspan="3" class="adat_cella jobbra nincs_szegely">&nbsp;</td>
				</tr>					
				
			</table>
		</td>
		<td colspan="2">
			<table class="statisztika_belso_tablazat_fel_szelesseg">
				<tr>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekEladas_kiemeltek_nelkul_10000_felett"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesStatisztika_kiemeltek_nelkul_10000_felett"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul_10000_felett"],0);?> Ft</td>
					<td class="adat_cella jobbra" style="width:100px;"><?php echo $stat_adatok["eladas_arajanlatcegek_megrendelescegek_szazalek_10000_felett"];?> &nbsp;&nbsp;&nbsp;<?php echo $stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalek_10000_felett"];?></td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_felett"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb">&nbsp;</td>
					<td class="szegely_alul">&nbsp;</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkul_10000_felett"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul_10000_felett"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul_10000_felett"],0);?> Ft</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["nyomas_arajanlatcegek_megrendelescegek_szazalek_10000_felett"];?> &nbsp;&nbsp;&nbsp;<?php echo $stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalek_10000_felett"];?></td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul_10000_felett"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb">&nbsp;</td>
					<td class="szegely_alul">&nbsp;</td>
				</tr>
				<tr class="osszesen_sor">
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekEladas_kiemeltek_nelkul_10000_felett"] + $stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkul_10000_felett"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul_10000_felett"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul_10000_felett"] + $stat_adatok["megrendelesOsszegLegparnas_kiemeltek_nelkul_10000_felett"] + $stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul_10000_felett"],0);?> Ft</td>
					<td class="adat_cella jobbra"><?php echo $stat_adatok["osszesen_arajanlatcegek_megrendelescegek_szazalek_10000_felett"];?> &nbsp;&nbsp;&nbsp;<?php echo $stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalek_10000_felett"];?></td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul_10000_felett"] ;?> tétel</td>
					<td class="adat_cella jobbra szegely_jobb szegely_alul">&nbsp;</td>
					<td class="szegely_alul">&nbsp;</td>
				</tr>
				
				<tr>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_felett"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkulAjanlatNelkul_10000_felett"],0);?> Ft</td>
					<td class="adat_cella jobbra" style="width:100px;">&nbsp;</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb">&nbsp;</td>
					<td class="szegely_alul">&nbsp;</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_felett"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkulAjanlatNelkul_10000_felett"],0);?> Ft</td>
					<td class="adat_cella jobbra nincs_szegely">&nbsp;</td>
				</tr>
				<tr style="border-bottom:solid 2px black">
					<td class="adat_cella jobbra szegely_alul">&nbsp;</td>
					<td class="adat_cella jobbra szegely_alul"><?php echo $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"];?> tétel</td>
					<td class="adat_cella jobbra szegely_alul szegely_jobb">&nbsp;</td>
					<td class="szegely_alul">&nbsp;</td>
				</tr>
				<tr class="osszesen_sor">
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_felett"];?> cég</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"];?> db</td>
					<td class="adat_cella jobbra szegely_jobb"><?php echo Utils::OsszegFormazas($stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkulAjanlatNelkul_10000_felett"],0);?> Ft</td>
					<td class="adat_cella jobbra">&nbsp;</td>
				</tr>
				<tr>
					<td class="adat_cella jobbra nincs_szegely">&nbsp;</td>
					<td class="adat_cella jobbra nincs_szegely"><?php echo $stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"];?> tétel</td>
					<td class="adat_cella jobbra szegely_jobb">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>				
				
			</table>
		</td>		
	</tr>
</table>
<span class="cim_cella_kisbetu">Lehet olyan ajánlat / megrendelés, amely tartalmaz 10 000 alatti és 10 000 feletti tételt is!<br />
Az ilyen ajánlatok / megrendelések mind a két feltételnek megfelelnek, tehát mindkét táblázatban megjelennek.</span><br />
<br />
<hr>
	<strong>Gépmester statisztika</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cim_cella_kisbetu">Csak szabályosan lezárt rögzítések 2014.09.24 05:30-tól 2014.09.25 06:30-ig</span>
<hr>
<table class="statisztika_tablazat nincs_szegely" style="border: none;">
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><span class="cim_cella_kisbetu">műszak 12 ó</span></td>
		<td><span class="cim_cella_kisbetu">műszak 12 ó</span></td>
	</tr>
	<tr>
		<td style="width:90px;border-bottom:solid 2px black;" class="cim_cella">Gépmester</td>
		<td style="width:60px;border-bottom:solid 2px black;" class="cim_cella szegely_jobb jobbra">Műszakok száma</td>
		<td style="width:60px;border-bottom:solid 2px black;" class="cim_cella szegely_jobb jobbra">Munkák száma rész / össz</td>
		<td style="width:70px;border-bottom:solid 2px black;" class="cim_cella szegely_jobb jobbra">Boríték / levélpapír darabszám</td>
		<td style="width:60px;border-bottom:solid 2px black;" class="cim_cella szegely_jobb jobbra">Színek száma átlagos / súlyozott</td>
		<td style="width:70px;border-bottom:solid 2px black;" class="cim_cella szegely_jobb">Levezetés</td>
		<td style="width:40px;border-bottom:solid 2px black;" class="cim_cella nincs_szegely jobbra">Kifutó</td>
		<td style="width:70px;border-bottom:solid 2px black;" class="cim_cella nincs_szegely jobbra"><strong>Átlagos munkán- kénti teljesítés</strong></td>
		<td style="width:70px;border-bottom:solid 2px black;" class="cim_cella nincs_szegely jobbra"><strong>Átlagos tényleges műszak teljesítés</strong></td>
		<td style="width:70px;border-bottom:solid 2px black;" class="cim_cella szegely_jobb jobbra"><strong>Átlagos tervezett műszak teljesítés</strong></td>
	</tr>
<!-- Egy gépmester rekord egy kétsoros táblázatsorból áll! -->	
	<tr>
		<td class="adat_cella">Kulik Iosif Attila</td>
		<td class="adat_cella szegely_jobb jobbra">1</td>
		<td class="adat_cella szegely_jobb jobbra">5,0</td>
		<td class="adat_cella szegely_jobb jobbra">18 000</td>
		<td class="adat_cella szegely_jobb jobbra">3,00<br />3.05</td>
		<td class="adat_cella szegely_jobb jobbra">Fordított&nbsp;&nbsp;&nbsp;0</td>
		<td class="adat_cella nincs_szegely jobbra">1</td>
		<td class="adat_cella szegely_jobb" colspan="3">->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1x=0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2x=1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3x=0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4x=0</td>
	</tr>
	<tr>
		<td class="adat_cella szegely_alul">&nbsp;</td>
		<td class="adat_cella szegely_jobb szegely_alul jobbra">&nbsp;</td>
		<td class="adat_cella szegely_jobb szegely_alul jobbra">5</td>
		<td class="adat_cella szegely_jobb szegely_alul jobbra">&nbsp;</td>
		<td class="adat_cella szegely_jobb szegely_alul jobbra">3.05</td>
		<td class="adat_cella szegely_jobb szegely_alul jobbra">Hosszi.&nbsp;&nbsp;&nbsp;0</td>
		<td class="adat_cella szegely_alul jobbra">&nbsp;</td>
		<td class="adat_cella szegely_alul jobbra"><strong>86,83 %</strong></td>
		<td class="adat_cella szegely_alul jobbra"><strong>59,16 %</strong></td>
		<td class="adat_cella szegely_alul szegely_jobb jobbra"><strong>48,88 %</strong></td>
	</tr>
<!-- Gépmester rekord eddig -->	
</table>
</div>

<pagebreak />
<!-- Statisztika 3. oldal -->
<div class='wide form'>
<table class='fejlec1'>
	<tr>
		<td class="statisztika_fejlec_cim"> <strong> Időszaktól független tartozás statisztika </strong> </td>
	</tr>
</table>

<table class="statisztika_tablazat nincs_szegely">
	<tr>
		<td class="cim_cella szegely_alul" style="width: 500px;" colspan="3">Kiemelt cégek nélkül</td>
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
<table class="statisztika_tablazat nincs_szegely">
	<tr>
		<td class="cim_cella szegely_alul" style="width: 500px;" colspan="3">Kiemelt cégek</td>
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
		<td class="adat_cella szegely_alul szegely_jobb jobb ra"><?php echo Utils::OsszegFormazas($stat_adatok["behajto_cegnek_atadva"]["brutto"],0);?> Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_bal szegely_alul szegely_jobb">Ügyvédnek átadva</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::DarabszamFormazas($stat_adatok["ugyvednek_atadva"]["db"]);?> db</td>
		<td class="adat_cella szegely_alul jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["ugyvednek_atadva"]["netto"],0);?> Ft</td>
		<td class="adat_cella szegely_alul szegely_jobb jobbra"><?php echo Utils::OsszegFormazas($stat_adatok["ugyvednek_atadva"]["brutto"],0);?> Ft</td>
	</tr>
</table>
<br />
<table class="statisztika_tablazat nincs_szegely" style="border:none;">
	<tr>
		<td class="cim_cella nincs_szegely">DMS Dialogmarketing Szolgáltató Kft.</td>
		<td class="adat_cella nincs_szegely">Összes</td>
		<td class="adat_cella nincs_szegely jobbra">11 db</td>
		<td class="adat_cella nincs_szegely jobbra">2 279 093 Ft</td>
		<td class="adat_cella nincs_szegely jobbra">2 894 448 Ft</td>
	</tr>
	<tr>
		<td class="cim_cella nincs_szegely">&nbsp;</td>
		<td class="adat_cella nincs_szegely">Lejárt</td>
		<td class="adat_cella nincs_szegely jobbra">6 db</td>
		<td class="adat_cella nincs_szegely jobbra">1 733 285 Ft</td>
		<td class="adat_cella nincs_szegely jobbra">2 201 271 Ft</td>
	</tr>
	<tr>
		<td class="cim_cella szegely_alul">Legrégebbi fiz. határidő: 2014.09.05</td>
		<td class="adat_cella szegely_alul">Nem lejárt</td>
		<td class="adat_cella szegely_alul jobbra">5 db</td>
		<td class="adat_cella szegely_alul jobbra">545 808 Ft</td>
		<td class="adat_cella szegely_alul jobbra">693 176 Ft</td>
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
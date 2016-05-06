<html>
<head></head>

<?php
	$nyomdakonyv = Nyomdakonyv::model()->findByPk($model -> nyomdakonyv_id);
	if ($nyomdakonyv == null)
		die("Hiba!");
	
	$megrendeles = $nyomdakonyv->megrendeles_tetel->megrendeles;
	if ($megrendeles == null)
		die("Hiba!");
	
	$ugyfel = Ugyfelek::model()->findByPk($megrendeles -> ugyfel_id);
	if ($ugyfel == null)
		$ugyfel = new Ugyfelek();
		
	$arkategoria = Arkategoriak::model()->findByPk($megrendeles -> arkategoria_id);
	if ($arkategoria == null)
		$arkategoria = new Arkategoriak();
	
	$afakulcs = AfaKulcsok::model()->findByPk($megrendeles -> afakulcs_id);
	if ($afakulcs == null)
		$afakulcs = new AfaKulcsok();
	
	$megrendeles_tetel = $nyomdakonyv->megrendeles_tetel;
	if ($megrendeles_tetel == null)
		die("Hiba!");
	
	$user = User::model()->findByPk($nyomdakonyv->taskat_rogzito_user_id);
	$taskat_rogzito_user_fullname = $user != null ? $user->fullname : '';
?>

<style>
	div {
		font-family: arial;
		font-size: 8pt;
	}
	.under {
		border-bottom: 4px double #000000;
	}
	table {
		border: 1px solid #000000;
		padding: 2px;
		font-family: arial;
		font-size: 8pt;
		width: 100%;
	}
	.sub_table {
		border: 0px;
		padding: 2px;
		font-family: arial;
		font-size: 8pt;
		width: 100%;
	}
	.sub_table td {
		border : 0px;
	}
	.table_footer {
		border: 0px;
	}
	.table_tetelek {
		border-collapse: collapse;
		margin-top: 10px;
		margin-bottom: 10px;
	}
	.table_tetelek td {
		border: 1px solid #000000;
		padding: 2px;
	}
	.no_border {
		border: 0px solid #000000!important;
		padding: 2px;
		font-family: arial;
		font-size: 8pt;
		width: 100%;
	}
	.bigger_font_size {
		font-family: arial;
		font-size: 10pt;
		font-weight: bold;
	}
	.alahuzas {
		border-bottom: 1px solid #000000;
	}
	fieldset{
		border: 1px solid #000000;
		color: #000000;
		padding: 15px;
	}
	legend {
		font-family: arial;
	}
	@page {
	  size: auto;
	  odd-footer-name: html_myFooter2;
	  even-footer-name: html_myFooter2;
	}
</style>

<div class='wide form'>

<div style='text-align:center'>
	<h1> <span class='under'>SELEJTJEGYZŐKÖNYV</span> </h1>
</div>

<table class='no_border'>
	<tr>
		<td align='left'> TÁSKASZÁM <strong> <?php echo $nyomdakonyv->taskaszam; ?> </strong> </td>
		<td align='right'> Dátum: <strong> <?php echo date("Y-m-d"); ?> </strong> </td>
	<tr>
</table>

<div style='clear:both'></div>

<!-- Megrendelés tétel táblázat -->
<table class = "table_tetelek">
	<tr>
		<td colspan='3'><strong>MUNKA NEVE: <span class='bigger_font_size'> <?php echo $megrendeles_tetel -> munka_neve; ?> </span> </strong></td>
	</tr>

	<tr>
		<td>Boríték típusa, ragasztási módja, mérete, ablak</td>
		<td align=center>Példányszám</td>
		<td align=center>Színek száma</td>
	</tr>

	<tr>
		<td colspan=5></td>
	</tr>

	<?php
		// tétel kiírása
		echo "
			<tr>
				<td> <span class='bigger_font_size'> " . $megrendeles_tetel->megrendelt_termek_nev . " <br /> $megrendeles_tetel->munka_neve </td>
				<td align=center><span class='bigger_font_size'> $megrendeles_tetel->darabszam </span></td>
				<td align=center><span class='bigger_font_size'> $megrendeles_tetel->displayTermekSzinekSzama </span></td>
			</tr>
		";
	?>
</table>

<table class = "no_border">
	<tr>
		<td width='100'> <strong> Selejt leírása: </strong> </td>
		<td> <?php echo $model -> selejt_leiras; ?> </td>
	</tr>

	<tr>
		<td colspan='2'>&nbsp;</td>
	</tr>

	<tr>
		<td> <strong> Táska kiállító: </strong> </td>
		<td> <?php echo $taskat_rogzito_user_fullname; ?> </td>
	</tr>
	
	<tr>
		<td> <strong> Áru kiadó: </strong> </td>
		<td> <?php echo $model -> aru_kiado; ?> </td>
	</tr>
	
	<tr>
		<td> <strong> Gépmester: </strong> </td>
		<td> <?php echo $model -> gepmester; ?> </td>
	</tr>
	
	<tr>
		<td> <strong> Kereszt ellenőr: </strong> </td>
		<td> <?php echo $model -> kereszt_ellenor; ?> </td>
	</tr>
	
	<tr>
		<td colspan='2'>&nbsp;</td>
	</tr>
</table>

<div style='float:left; width:250px'>

	<!-- Selejt oka szekció -->
	<fieldset style='width:230px'>
	<legend>SELEJT OKA</legend>
		<table class='no_border' style='font-weight:bold'>
		
			<tr>
				<td align='right'>rossz munkakiadás</td>
				<td align='center' width='50'> <?php if ($model -> selejt_oka_rossz_munka_kiadas == 1) { echo '+';  } ?> </td>
			</tr>
		
			<tr>
				<td align='right'>szín hiba</td>
				<td align='center'> <?php if ($model -> selejt_oka_szin_hiba == 1) { echo '+';  } ?> </td>
			</tr>
		
			<tr>
				<td align='right'>passzer hiba</td>
				<td align='center'> <?php if ($model -> selejt_oka_passzer_hiba == 1) { echo '+';  } ?> </td>
			</tr>
		
			<tr>
				<td align='right'>határidő csúszás</td>
				<td align='center'> <?php if ($model -> selejt_oka_hatarido_csuszas == 1) { echo '+';  } ?> </td>
			</tr>
		
			<tr>
				<td align='right'>példányszám eltérés</td>
				<td align='center'> <?php if ($model -> selejt_oka_peldanyszam_elteres == 1) { echo '+';  } ?> </td>
			</tr>
		
			<tr>
				<td align='right'>elhelyezés hiba</td>
				<td align='center'> <?php if ($model -> selejt_oka_elhelyezes_hiba == 1) { echo '+';  } ?> </td>
			</tr>
		
			<tr>
				<td align='right'>hibás boríték választás</td>
				<td align='center'> <?php if ($model -> selejt_oka_hibas_boritek_valasztas == 1) { echo '+';  } ?> </td>
			</tr>
		
			<tr>
				<td align='right'>rossz méret</td>
				<td align='center'> <?php if ($model -> selejt_oka_rossz_meret == 1) { echo '+';  } ?> </td>
			</tr>
		
			<tr>
				<td align='right'>rossz ablak</td>
				<td align='center'> <?php if ($model -> selejt_oka_rossz_ablak == 1) { echo '+';  } ?> </td>
			</tr>
		
			<tr>
				<td align='right'>rossz rag. mód</td>
				<td align='center'>  <?php if ($model -> selejt_oka_rossz_rag_mod == 1) { echo '+';  } ?> </td>
			</tr>
		
		</table>
	</fieldset>
	
	<!-- javítási mód szekció -->
	<fieldset style='margin-top:18px;width:230px'>
	<legend>SELEJT OKA</legend>
		<table class='no_border' style='font-weight:bold'>
		
			<tr>
				<td align='right'>újra nyomás</td>
				<td align='center' width='50'> <?php if ($model -> javitasi_mod_ujra_nyomas == 1) { echo '+';  } ?> </td>
			</tr>
		
			<tr>
				<td align='right'>felül nyomás</td>
				<td align='center'> <?php if ($model -> javitasi_mod_felul_nyomas == 1) { echo '+';  } ?> </td>
			</tr>
		
			<tr>
				<td align='right'>árcsökkentés</td>
				<td align='center'> <?php if ($model -> javitasi_mod_arcsokkentes == 1) { echo '+';  } ?> </td>
			</tr>
		
			<tr>
				<td align='right'>részleges újranyomás</td>
				<td align='center'> <?php if ($model -> javitasi_mod_reszleges_ujranyomas == 1) { echo '+';  } ?> </td>
			</tr>
		
			<tr>
				<td align='right'>kompenzáció</td>
				<td align='center'> <?php if ($model -> javitasi_mod_kompenzacio == 1) { echo '+';  } ?> </td>
			</tr>

			<tr>
				<td align='left'>Egyéb:</td>
				<td></td>
			</tr>

			<tr>
				<td colspan='2' align='left'> <?php echo $model -> egyeb; ?> </td>
			</tr>

		</table>
	</fieldset>
</div>

<div style='float:left;'>
	<!-- Selejt észrevétel helye -->
	<fieldset style='margin-left:20px;width:320px'>
	<legend>SELEJT ÉSZREVÉTEL HELYE</legend>
		<table class='no_border' style='font-weight:bold'>
		
			<tr>
				<td align='right'>Cégen belül <?php if ($model -> eszrevetel_helye_cegen_belul == 1) { echo '+';  } ?> </td>
				<td colspan='2' align='center' > Cégen belül <?php if ($model -> eszrevetel_helye_cegen_kivul == 1) { echo '+';  } ?> </td>
			</tr>

			<tr>
				<td colspan='3'> &nbsp; </td>
			</tr>

			<tr>
				<td></td>
				<td align='center'> Ellenőrzés </td>
				<td align='center'> Hiba észlelés </td>
			</tr>

			<tr>
				<td align='right'>iroda munka felvétel</td>
				<td align='center'> <?php if ($model -> ellenorzesi_pontok_iroda_munka_felvetel == 1) { echo '+';  } ?> </td>
				<td align='center'> <?php if ($model -> hiba_eszlelese_iroda_munka_felvetel == 1) { echo '+';  } ?> </td>
			</tr>

			<tr>
				<td align='right'>iroda munka kiadás</td>
				<td align='center'> <?php if ($model -> ellenorzesi_pontok_iroda_munka_kiadas == 1) { echo '+';  } ?> </td>
				<td align='center'> <?php if ($model -> hiba_eszlelese_iroda_munka_kiadas == 1) { echo '+';  } ?> </td>
			</tr>

			<tr>
				<td align='right'>raktár kiadás</td>
				<td align='center'> <?php if ($model -> ellenorzesi_pontok_raktari_kiadas == 1) { echo '+';  } ?> </td>
				<td align='center'> <?php if ($model -> hiba_eszlelese_raktari_kiadas == 1) { echo '+';  } ?> </td>
			</tr>

			<tr>
				<td align='right'>gépmester átvétel</td>
				<td align='center'> <?php if ($model -> ellenorzesi_pontok_gepmester_atvetel == 1) { echo '+';  } ?> </td>
				<td align='center'> <?php if ($model -> hiba_eszlelese_gepmester_atvetel == 1) { echo '+';  } ?> </td>
			</tr>

			<tr>
				<td align='right'>kereszt ellenőr</td>
				<td align='center'> <?php if ($model -> ellenorzesi_pontok_keresztellenor == 1) { echo '+';  } ?> </td>
				<td align='center'> <?php if ($model -> hiba_eszlelese_keresztellenor == 1) { echo '+';  } ?> </td>
			</tr>

			<tr>
				<td align='right'>készre jelentés gépmester</td>
				<td align='center'> <?php if ($model -> ellenorzesi_pontok_keszre_jelentes_gepmester == 1) { echo '+';  } ?> </td>
				<td align='center'> <?php if ($model -> hiba_eszlelese_keszre_jelentes_gepmester == 1) { echo '+';  } ?> </td>
			</tr>

			<tr>
				<td align='right'>készre jelentés ellenőr</td>
				<td align='center'> <?php if ($model -> ellenorzesi_pontok_keszre_jelentes_ellenor == 1) { echo '+';  } ?> </td>
				<td align='center'> <?php if ($model -> hiba_eszlelese_keszre_jelentes_ellenor == 1) { echo '+';  } ?> </td>
			</tr>

			<tr>
				<td align='right'>raktári visszavét</td>
				<td align='center'> <?php if ($model -> ellenorzesi_pontok_raktari_visszavet == 1) { echo '+';  } ?> </td>
				<td align='center'> <?php if ($model -> hiba_eszlelese_raktari_visszavet == 1) { echo '+';  } ?> </td>
			</tr>

			<tr>
				<td align='right'>iroda munka átvétel</td>
				<td align='center'> <?php if ($model -> ellenorzesi_pontok_iroda_munka_atvetel == 1) { echo '+';  } ?> </td>
				<td align='center'> <?php if ($model -> hiba_eszlelese_iroda_munka_atvetel == 1) { echo '+';  } ?> </td>
			</tr>

			<tr>
				<td align='right'>ügyfél</td>
				<td align='center'> <?php if ($model -> ellenorzesi_pontok_ugyfel == 1) { echo '+';  } ?> </td>
				<td align='center'> <?php if ($model -> hiba_eszlelese_ugyfel == 1) { echo '+';  } ?> </td>
			</tr>

		
		</table>
	</fieldset>
	
	<!-- Feelelősök -->
	<fieldset style='margin-left:20px;margin-top:18px;width:320px'>
	<legend>FELELŐSÖK</legend>
		<?php echo $model ->felelosok; ?>
	</fieldset>
	
	<table class='no_border' style='margin-left: 16px;margin-top: 16px;width:350px'>
		<tr>
			<td align='left'>Kárérték (nettó)</td>
			<td align='right'> <strong> <?php echo Utils::OsszegFormazas($model -> netto_kar); ?> Ft </strong> </td>
		</tr>
		
		<tr>
			<td align='left'>Kárérték (bruttó)</td>
			<td align='right'> <strong> <?php echo Utils::OsszegFormazas($model -> netto_kar * ( 1 + $afakulcs -> afa_szazalek / 100)); ?> Ft </strong> </td>
		</tr>
	</table>
	
</div>

<div style='clear:both;'></div>

<!-- Aláírás szekció kiírása -->
<p style='margin-top:100px;font-size:8pt'>
	<table style='border:0px'>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td width='300' class='alahuzas'></td>
		</tr>
		<tr>
			<td></td>
			<td align=center> Domaniczky Ákos </td>
		</tr>
	</table>
</p>

<htmlpagefooter name="myFooter2" style="display:none">
<table width="100%" class = "table_footer" style="vertical-align: bottom; font-family: arial; font-size: 8pt; color: #000000;">
	<tr>
		<td align='center' colspan='2'>
		</td>
	</tr>
	
	<tr>
		<td colspan='2' align='center' style='font-weight:bold;font-size:14pt'>  </td>
	</tr>
	
	<tr>
		<td width="50%"> <span> <?php echo "Nyomtatva: " . date('Y-m-d h:m:s'); ?> </span> </td>
		<td width="50%" style="text-align: right; "> {PAGENO} .oldal </td>
    </tr>
</table>
</htmlpagefooter>

</html>
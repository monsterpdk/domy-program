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
	.alahuzas {
		border-bottom: 1px solid #000000;
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

<!-- Visszaigazolás fejléce -->
<table>
<tr>
		<td class = 'col1'><strong>Megrendelő</strong></td>
		<td class = 'col2'> <?php echo $ugyfel -> display_ugyfel_ugyintezok; ?> </td>
		<td class = 'col3'><strong>Szállító</strong></td>
		<td class = 'col4'>DomyPack & Press Kft. <br /> 1117 Bp. Budafoki út 111-113. 20-as épület</td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Cég</strong></td>
		<td class = 'col2'> <?php echo $ugyfel -> cegnev . "<br />" . $ugyfel -> display_ugyfel_cim; ?> </td>
		<td class = 'col3'><strong>Ügyintéző</strong></td>
		<td class = 'col4'> <?php echo "";//$model -> ugyintezo -> nev; ?> </td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Telefon</strong></td>
		<td class = 'col2'> <?php echo $ugyfel -> ceg_telefon; ?> </td>
		<td class = 'col3'><strong>Telefon</strong></td>
		<td class = 'col4'>265-0692; 262-9935; 260-7144</td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Fax</strong></td>
		<td class = 'col2'>  <?php echo $ugyfel -> ceg_fax; ?> </td>
		<td class = 'col3'><strong>Fax</strong></td>
		<td class = 'col4'>265-0629</td>
	<tr>	
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>

<?php
	if ($arajanlat != null) {
		echo '<div align = "right"> Ajánlat száma <strong>' . $arajanlat->sorszam . '</strong> </div>';
	}
?>

<!-- Megrendelés tételek táblázat -->
<table class = "table_tetelek">
	<tr>
		<td><strong>Boríték mérete, ragasztási módja, ablak <br /> Munka neve <br /> Szín megnevezés</strong></td>
		<td align=center><strong>Példányszám</strong></td>
		<td align=center><strong>Színek száma</strong></td>
		<td align=center><strong>Nettó ár/db</strong></td>
		<td align=center><strong>Nettó ár (Ft)</strong></td>
	</tr>

	<tr>
		<td colspan=5></td>
	</tr>

	<?php
			$ossz_netto = 0;
			$ossz_afa = 0;

				
			$termek_meret = TermekMeretek::model()->findByPk($nyomdakonyv->megrendeles_tetel->termek -> meret_id);
			if ($termek_meret == null)
				$termek_meret = new TermekMeretek();
				
			$zarasmod = TermekZarasiModok::model()->findByPk($nyomdakonyv->megrendeles_tetel->termek -> zaras_id);
			if ($zarasmod == null)
				$zarasmod = new TermekZarasiModok();
						
			$ablakmeret = TermekAblakMeretek::model()->findByPk($nyomdakonyv->megrendeles_tetel->termek -> ablakmeret_id);
			if ($ablakmeret == null)
				$ablakmeret = new TermekAblakMeretek();
						
			$ablakhely = TermekAblakhelyek::model()->findByPk($nyomdakonyv->megrendeles_tetel->termek -> ablakhely_id);
			if ($ablakhely == null)
				$ablakhely = new TermekAblakhelyek();
						
			$papirtipus = PapirTipusok::model()->findByPk($nyomdakonyv->megrendeles_tetel->termek -> papir_id);
			if ($papirtipus == null)
				$papirtipus = new PapirTipusok();
			
			$afakulcs = AfaKulcsok::model()->findByPk($nyomdakonyv->megrendeles_tetel->termek -> afakulcs_id);
			if ($afakulcs == null) {
				$afakulcs = new AfaKulcsok();
				$afakulcs->afa_szazalek = 27;
			}
			
			$nyomdakonyvi_munka = Nyomdakonyv::model() -> findByAttributes( array('megrendeles_tetel_id' => $tetel -> id,) );
			if ($nyomdakonyvi_munka == null)
				$nyomdakonyvi_munka = new Nyomdakonyv();
			
			// összesíteni kell a végén az adóalapot, tehát az egyes tételek nettó árának összegét kell tárolnunk
			$ossz_netto += number_format((float)$nyomdakonyv->megrendeles_tetel->netto_darabar * $nyomdakonyv->megrendeles_tetel->darabszam, 2, '.', '');
			$ossz_afa += number_format(round((round($nyomdakonyv->megrendeles_tetel->netto_darabar, 2) * $nyomdakonyv->megrendeles_tetel->darabszam * ($afakulcs->afa_szazalek)) / 100, 0), 2, '.', '');
			
			// tételek kiírása
			echo "
				<tr>
					<td> " . $nyomdakonyv->megrendeles_tetel->megrendelt_termek_nev . " <br /> " . $nyomdakonyv->megrendeles_tetel->munka_neve . "</td>
					<td align=right>" .$nyomdakonyv->megrendeles_tetel->darabszam. "</td>
					<td align=right>" .$nyomdakonyv->megrendeles_tetel->displayTermekSzinekSzama. "</td>
					<td align=right>" . number_format((float)$nyomdakonyv->megrendeles_tetel->netto_darabar, 2) . "</td>
					<td align=right>" .  number_format((float)$nyomdakonyv->megrendeles_tetel->netto_darabar * $nyomdakonyv->megrendeles_tetel->darabszam, 2, '.', '') . "</td>
				</tr>
			";

			
			// adó szekció (ÁFA) kiírása
			echo "
				</table>
				
				<table class='table_afa_osszegzo'>
					<tr>
						<td align=left><strong>$afakulcs->afa_szazalek%-os adóalap: <br /> $afakulcs->afa_szazalek%-os ÁFA: </strong></td>
						<td align=right>" . number_format($ossz_netto, 2) . " Ft<br />" . number_format($ossz_afa, 2) . " Ft</td>
					</tr>
				</table>
			";
			
			// összesítő szekció kiírása
			echo "
				<table class='table_osszegzo'>
					<tr>
						<td align=left><strong>Rendelés értéke összesen bruttó: <br /> azaz:</strong></td>
						<td align=right><strong>" . number_format(round($ossz_netto + $ossz_afa), 2) . " Ft</strong><br /> - " . mb_strtoupper (Utils::num2text(round($ossz_netto + $ossz_afa)), "UTF-8") . " Forint - </td>
					</tr>
				</table>
			";
	?>
	<table>
		<tr>
			<td>Selejt leírás:</td>
			<td><?php echo $model->selejt_leiras;?></td>
		</tr>
		<tr>
			<td>Felelősök:</td>
			<td><?php echo $model->felelosok;?></td>
		</tr>
		<tr>
			<td>Nettó kár:</td>
			<td><?php echo Utils::OsszegFormazas($model->netto_kar, 0);?> Ft</td>
		</tr>
	</table>
	
</table>

	<!-- Aláírás szekció kiírása -->
	<p style='margin-top:100px;font-size:8pt'>
		<table style='border:0px'>
			<tr>
				<td>Szállító:</td>
				<td></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td class='alahuzas'></td>
			</tr>
			<tr>
				<td></td>
				<td align=center> DomyPack & Press Kft. </td>
			</tr>
		</table>
	</p>
</div>
<htmlpagefooter name="myFooter2" style="display:none">
<table width="100%" class = "table_footer" style="vertical-align: bottom; font-family: arial; font-size: 8pt; color: #000000;">
	<tr>
		<td align='center' colspan='2'>
			<h2><?php echo nl2br(Yii::app()->config->get('MegrendelesekVisszaigazolas')); ?></h2>
		</td>
	</tr>
	
	<tr>
		<td colspan='2' align='center' style='font-weight:bold;font-size:14pt'> ALMA </td>
	</tr>
	
	<tr>
		<td width="50%"> <span> <?php echo "Nyomtatva: " . date('Y-m-d h:m:s'); ?> </span> </td>
		<td width="50%" style="text-align: right; "> {PAGENO} .oldal </td>
    </tr>
</table>
</htmlpagefooter>

</html>
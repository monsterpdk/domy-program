<html>
<head></head>

<?php
	$ugyfel = Ugyfelek::model()->findByPk($model -> ugyfel_id);
	if ($ugyfel == null)
		$ugyfel = new Ugyfelek();
		
	$arkategoria = Arkategoriak::model()->findByPk($model -> arkategoria_id);
	if ($arkategoria == null)
		$arkategoria = new Arkategoriak();
	
	$afakulcs = AfaKulcsok::model()->findByPk($model -> afakulcs_id);
	if ($afakulcs == null)
		$afakulcs = new AfaKulcsok();
	
	$fizetesiMod = FizetesiModok::model()->findByPk($model -> proforma_fizetesi_mod);
	if ($fizetesiMod == null)
		$fizetesiMod = new FizetesiModok();
	
	$megrendeles_tetelek = $model->tetelek;
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

<div align = "right"> Számlaszám <strong> <?php echo $model->proforma_szamla_sorszam; ?> </strong> </div>

<div style='text-align:center'>
	<h1> <span class='under'>PROFORMA SZÁMLA</span> </h1>
</div>

<!-- Proforma számla fejléce -->
<table>
	<tr>
		<td class = 'col1'><strong>Szállító</strong></td>
		<td class = 'col2'><strong>Vevő</strong></td>
	<tr>
	<tr>
		<td class = 'col1'>DomyPack & Press Kft. <br /> 1139 Budapest, Lomb utca 37-39.</td>
		<td class = 'col2'> <?php echo $ugyfel -> cegnev . "<br />" . $ugyfel -> display_ugyfel_cim; ?> </td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Adóig. szám:</strong> 23062904-2-13</td>
		<td class = 'col2'></td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Számlaszám:</strong> Unicredit 10918001-00000006-23320004</td>
		<td class = 'col2'></td>
	<tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
</table>

<div align = "right"> Megrendelés száma <strong> <?php echo $model->sorszam; ?> </strong> </div>

<table>
	<tr>
		<td><strong>Teljesítés</strong></td>
		<td><strong>Kiállítás dátuma</strong></td>
		<td><strong>Fizetési határidő</strong></td>
		<td><strong>Fizetési mód</strong></td>
	</tr>
	<tr>
		<td> <?php echo strftime("%Y.%m.%d.", strtotime($model->proforma_teljesites_datum)); ?> </td>
		<td> <?php echo strftime("%Y.%m.%d.", strtotime($model->proforma_kiallitas_datum)); ?> </td>
		<td> <?php echo strftime("%Y.%m.%d.", strtotime($model->proforma_fizetesi_hatarido)); ?> </td>
		<td> <?php echo $fizetesiMod->nev; ?> </td>
	</tr>
</table>

<!-- Megrendelés tételek táblázat -->
<table class = "table_tetelek">
	<tr>
		<td><strong>VTSZ/SZJ</strong></td>
		<td align=center><strong>Táska száma</strong></td>
		<td align=center><strong>Szín</strong></td>
		<td colspan='5' align=center><strong>Megnevezés/cikkszám</strong></td>
	</tr>
	<tr>
		<td colspan='8'><strong>Munka neve</strong></td>
	</tr>
	<tr>
		<td colspan='2'><strong>Rendelve</strong></td>
		<td align=center><strong>ÁFA (%)</strong></td>
		<td align=center><strong>Mennyiség</strong></td>
		<td align=center><strong>Egységár</strong></td>
		<td align=center><strong>Adóalap</strong></td>
		<td align=center><strong>ÁFA (Ft)</strong></td>
		<td align=center><strong>Bruttó (Ft)</strong></td>
	</tr>
	
	<tr>
		<td colspan='5' style='border:0px!important;padding:4px;'></td>
	</tr>

	<?php
		if (is_array($megrendeles_tetelek)) {
			$ossz_netto = 0 ;
			$ossz_afa = 0 ;
			foreach ($megrendeles_tetelek as $tetel) {
				$termek = Termekek::model()->findByPk($tetel -> termek_id);
				if ($termek == null)
					$termek = new Termekek();
				$termek_teljes_nev = $tetel->getTetelnevHozottNemHozott() . $termek->getDisplayTermekTeljesNev() ;
				
				$nyomdakonyvi_munka = Nyomdakonyv::model() -> findByAttributes( array('megrendeles_tetel_id' => $tetel -> id,) );
				if ($nyomdakonyvi_munka == null)
					$nyomdakonyvi_munka = new Nyomdakonyv();

				$tetel_netto_ara = $tetel->NettoAr;
				$tetel_afaja = $tetel->AfaOsszeg;
				$tetel_brutto_ara = $tetel->BruttoAr;
				// tételek kiírása
				echo "
					<tr>
						<td>$termek->ksh_kod</td>
						<td align=center>$nyomdakonyvi_munka->taskaszam</td>
						<td align=center>$tetel->displayTermekSzinekSzama</td>
						<td colspan='5'>$termek_teljes_nev / $termek->cikkszam</td>
					</tr>
					<tr>
						<td colspan='8'>$tetel->munka_neve</td>
					</tr>
					<tr>
						<td colspan='2'>$model->rendeles_idopont</td>
						<td align=center>$afakulcs->afa_szazalek</td>
						<td align=center>$tetel->DarabszamFormazott</td>
						<td align=right>$tetel->netto_darabar</td>
						<td align=right>$tetel->NettoArFormazott</td>
						<td align=right>$tetel->AfaOsszegFormazott</td>
						<td align=right>$tetel->BruttoArFormazott</td>
					</tr>
				";

				$ossz_netto += $tetel_netto_ara;
				$ossz_afa += $tetel_afaja;
			}
			
			// adó szekció (ÁFA) kiírása
			echo "
				</table>
				
				<table class='table_afa_osszegzo'>
					<tr>
						<td align=left><strong>$afakulcs->afa_szazalek%-os adóalap: <br /> $afakulcs->afa_szazalek%-os ÁFA: </strong></td>
						<td align=right>" . Utils::OsszegFormazas($ossz_netto) . "<br />" . Utils::OsszegFormazas($ossz_afa) . "</td>
					</tr>
				</table>
			";
			
			// összesítő szekció kiírása
			echo "
				<table class='table_osszegzo'>
					<tr>
						<td align=left><strong>Fizetendő: <br /> azaz:</strong></td>
						<td align=right><strong>" . Utils::OsszegFormazas(round($ossz_netto + $ossz_afa)) . "</strong><br /> - " . mb_strtoupper (Utils::num2text(round($ossz_netto + $ossz_afa)), "UTF-8") . " Forint - </td>
					</tr>
				</table>
			";
			
		}
	?>
	
</table>

<htmlpagefooter name="myFooter2" style="display:none">
<table width="100%" class = "table_footer" style="vertical-align: bottom; font-family: arial; font-size: 8pt; color: #000000;">
	<tr>
		<td colspan='2'>
			Aláírás nélkül érvényes. <br />
			<strong>ÁFA visszaigénylésére nem használható.<br />
			A végösszeg beérkezését követően ÁFA - visszaigénylésre alkalmas számlát állítunk ki.</strong>
		</td>
	</tr>
	
	<tr>
		<td colspan='2' align='center' style='font-weight:bold;font-size:14pt'> <?php echo $model->reklamszoveg; ?> </td>
	</tr>
	
	<tr>
		<td width="50%"> <span> <?php echo "Nyomtatva: " . date('Y-m-d h:m:s'); ?> </span> </td>
		<td width="50%" style="text-align: right; "> {PAGENO} .oldal </td>
    </tr>
</table>
</htmlpagefooter>

</html>
<html>
<head></head>

<?php
	$ugyintezo = User::model()->findByPk($model -> user_id);
	if ($ugyintezo == null)
		$ugyintezo = new User();
		
	$szallito = Gyartok::model()->findByPk($model -> gyarto_id);
	if ($szallito == null)
		$szallito = new Gyartok();
	
	$anyagrendeles_tetelek = AnyagrendelesTermekek::model()->findAll(array("condition"=>"anyagrendeles_id = $model->id"));
?>

<style>
	div {
		font-family: arial;
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
	.table_afa_osszegzo {
		border: 0px;
		border-bottom: 1px solid #000000;
		margin-top: 10px;
		width: 100%;
	}
	.table_osszegzo {
		border: 0px;
	}
	.table_engedelyezo{
		border: 0px;
		margin-top: 50px;
		width: 300px;
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
	<h1>CSAK BELSŐ HASZNÁLATRA</h1>
	<h3><span class='under'>Termék megrendelés</span></h3>
</div>

<!-- Számla fejléce -->
<table>
	<tr>
		<td class = 'col1'><strong>Megrendelő</strong></td>
		<td class = 'col2'>DomyPack & Press Kft.</td>
		<td class = 'col3'><strong>Rendelés száma</strong></td>
		<td class = 'col4'><?php echo $model -> bizonylatszam; ?></td>
	<tr>
	<tr>
		<td class = 'col1'></td>
		<td class = 'col2'>1139 Budapest, Lomb utca 37-39.</td>
		<td class = 'col3'><strong>Szállító</strong></td>
		<td class = 'col4'>
			<?php echo $szallito -> cegnev; ?><br />
			<?php echo $szallito -> kapcsolattarto . " (Tel.:" . $szallito -> telefon . ")" ;?>
		</td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Ügyintéző</strong></td>
		<td class = 'col2'><?php echo $ugyintezo -> fullname; ?></td>
		<td class = 'col3'><strong>Megjegyzés</strong></td>
		<td class = 'col4'><?php echo $model -> megjegyzes; ?></td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Telefon</strong></td>
		<td class = 'col2'>265-0693; 262-9935; 260-7144</td>
		<td class = 'col3'></td>
		<td class = 'col4'></td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Fax</strong></td>
		<td class = 'col2'>265-0629</td>
		<td class = 'col3'></td>
		<td class = 'col4'></td>
	<tr>	
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>

<!-- Számla tételek táblázat -->
<table class = "table_tetelek">
	<tr>
		<td colspan=3><strong>Boríték megnevezése <br/> ragasztási módja, ablak, méret, papír, gr</strong></td>
		<td align=center><strong>Gyári kód</strong></td>
		<td align=center><strong>Darabszám</strong></td>
		<td align=center><strong>Nettó ár/db</strong></td>
		<td align=center><strong>Nettó ár (Ft)</strong></td>
		<td align=center><strong>Bruttó ár (Ft)</strong></td>
	</tr>

	<tr>
		<td colspan=3></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	
	<?php
		if (is_array($anyagrendeles_tetelek)) {
			$ossz_netto = 0;
			$ossz_afa = 0;
			
			foreach ($anyagrendeles_tetelek as $tetel) {
				$termek = Termekek::model()->findByPk($tetel -> termek_id);
				if ($termek == null)
					$termek = new Termekek();
					
				$termek_meret = TermekMeretek::model()->findByPk($termek -> meret_id);
				if ($termek_meret == null)
					$termek_meret = new TermekMeretek();
					
				$zarasmod = TermekZarasiModok::model()->findByPk($termek -> zaras_id);
				if ($zarasmod == null)
					$zarasmod = new TermekZarasiModok();
							
				$ablakmeret = TermekAblakMeretek::model()->findByPk($termek -> ablakmeret_id);
				if ($ablakmeret == null)
					$ablakmeret = new TermekAblakMeretek();
							
				$ablakhely = TermekAblakhelyek::model()->findByPk($termek -> ablakhely_id);
				if ($ablakhely == null)
					$ablakhely = new TermekAblakhelyek();
							
				$papirtipus = PapirTipusok::model()->findByPk($termek -> papir_id);
				if ($papirtipus == null)
					$papirtipus = new PapirTipusok();
				
				$afakulcs = AfaKulcsok::model()->findByPk($termek -> afakulcs_id);
				if ($afakulcs == null) {
					$afakulcs = new AfaKulcsok();
					$afakulcs->afa_szazalek = 27;
				}
				
				// összesíteni kell a végén az adóalapot, tehát az egyes tételek nettó árának összegét kell tárolnunk
				$ossz_netto += number_format((float)$tetel->rendeleskor_netto_darabar * $tetel->rendelt_darabszam, 2, '.', '');
				$ossz_afa += number_format(round((round($tetel->rendeleskor_netto_darabar, 2) * $tetel->rendelt_darabszam * ($afakulcs->afa_szazalek)) / 100, 0), 2, '.', '');
				
				// tételek kiírása
				$ablakhely_szoveg = "" ;
				if ($ablakhely->hely != "") {
					$ablakhely_szoveg = "$ablakhely->hely $ablakhely->x_pozicio_honnan$ablakhely->x_pozicio_mm$ablakhely->y_pozicio_honnan$ablakhely->y_pozicio_mm" ;
				}				
				echo "
					<tr>
						<td>$termek->nev <br /> $zarasmod->nev <br /> $termek_meret->magassag x $termek_meret->szelesseg x $termek_meret->vastagsag mm</td>
						<td>$ablakmeret->magassag x $ablakmeret->szelesseg mm <br /> $papirtipus->nev</td>
						<td align=right>$ablakhely_szoveg <br /> $papirtipus->suly gr</td>
						<td align=right>$termek->kodszam</td>
						<td align=right>" . Utils::DarabszamFormazas($tetel->rendelt_darabszam) . "</td>
						<td align=right>" . Utils::OsszegFormazas((float)$tetel->rendeleskor_netto_darabar, 2) . "</td>
						<td align=right>" .  Utils::OsszegFormazas((float)$tetel->rendeleskor_netto_darabar * $tetel->rendelt_darabszam, 2) . "</td>
						<td align=right>". Utils::OsszegFormazas(round((round($tetel->rendeleskor_netto_darabar, 2) * $tetel->rendelt_darabszam * ($afakulcs->afa_szazalek + 100)) / 100, 0), 2) . "</td>
					</tr>
				";
			}
			
			// adó szekció (ÁFA) kiírása
			echo "
				</table>
				
				<table class='table_afa_osszegzo'>
					<tr>
						<td align=left><strong>$afakulcs->afa_szazalek%-os adóalap: <br /> $afakulcs->afa_szazalek%-os ÁFA: </strong></td>
						<td align=right>" . Utils::OsszegFormazas($ossz_netto, 2) . "<br />" . Utils::OsszegFormazas($ossz_afa, 2) . "</td>
					</tr>
				</table>
			";
			
			// összesítő szekció kiírása
			echo "
				<table class='table_osszegzo'>
					<tr>
						<td align=left><strong>Fizetendő: <br /> azaz:</strong></td>
						<td align=right><strong>" . Utils::OsszegFormazas(round($ossz_netto + $ossz_afa), 2) . "</strong><br /> - " . mb_strtoupper (Utils::num2text(round($ossz_netto + $ossz_afa)), "UTF-8") . " Forint - </td>
					</tr>
				</table>
			";
		}
	?>

	<!-- Aláírás szekció kiírása -->
	<table align=right class='table_engedelyezo'>
		<tr>
			<td width=100>Engedélyező:</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td class='alahuzas'></td>
		</tr>
	</table>
</div>

<htmlpagefooter name="myFooter2" style="display:none">
<p style='font-family:arial; font-size: 10pt'>
	<?php echo nl2br((Yii::app()->config->get('AnyagrendelesekArral'))); ?>
</p>

<table width="100%" class = "table_footer" style="vertical-align: bottom; font-family: arial; font-size: 8pt; color: #000000;">
	<tr>
		<td width="50%"> <span> <?php echo "Nyomtatva: " . date('Y-m-d h:m:s'); ?> </span> </td>
		<td width="50%" style="text-align: right; "> {PAGENO} .oldal </td>
    </tr>
</table>
</htmlpagefooter>

</html>
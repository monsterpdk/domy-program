<html>
<head></head>

<?php
	$ugyintezo = User::model()->findByPk($model -> user_id);
	if ($ugyintezo == null)
		$ugyintezo = new User();
	
	$szallito = Gyartok::model()->findByPk($model -> gyarto_id);
	if ($szallito == null)
		$szallito = new Gyartok();

	$anyagbeszallitas_tetelek = AnyagbeszallitasTermekek::model()->findAll(array("condition"=>"anyagbeszallitas_id = $model->id"));
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
		margin: 10px 0px 10px 0px;
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
		border-bottom: 1px dashed #000000;
		width : 200px;
	}
	.alahuzas_szovegben {
		border-bottom: 2px solid #000000;
		float: left;
		height: 15px;
		width: 300px;
	}
	@page {
	  size: auto;
	  odd-footer-name: html_myFooter2;
	  even-footer-name: html_myFooter2;
	}
</style>

<div class='wide form'>

<div style='text-align:left'>
	<h2><span class='under'>Bevételezéshez</span></h2>
</div>

<!-- Számla fejléce -->
<table style='border: 0px'>
	<tr>
		<td style='width: 120px;'>DomyPack & Press Kft.</td>
		<td class = 'col2'></td>
		<td class = 'col3' style='font-size:30pt;font-weight:bold;text-align:right'>6AKKK</td>
	<tr>
	<tr>
		<td class = 'col1'>Rendelés száma:</td>
		<td class = 'col2'><strong><?php echo $model -> bizonylatszam; ?></strong></td>
		<td class = 'col3'></td>
	<tr>
	<tr>
		<td class = 'col1'>Rendelés dátuma:</td>
		<td class = 'col2'><?php echo date("Y.m.d", strtotime($model -> beszallitas_datum)); ?></td>
		<td class = 'col3'></td>
	<tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>

<!-- Számla tételek táblázat -->
<table class = "table_tetelek">
	<tr>
		<td colspan=4><strong>Boríték megnevezése, ablak <br/> ragasztási módja, méret, papír, gr</strong></td>
		<td align=center><strong>Darabszám</strong></td>
		<td align=center><strong></strong></td>
	</tr>

	<tr>
		<td colspan=4></td>
		<td></td>
		<td></td>
	</tr>
	
	<?php
		if (is_array($anyagbeszallitas_tetelek)) {
			$ossz_netto = 0;
			$ossz_afa = 0;
			
			foreach ($anyagbeszallitas_tetelek as $tetel) {
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
				$ossz_netto += (float)$tetel->netto_darabar * $tetel->darabszam;
				$ossz_afa += $tetel->netto_darabar * $tetel->darabszam * ($afakulcs->afa_szazalek) / 100;
				
				// tételek kiírása
				echo "
					<tr>
						<td style='border-left:0px;border-right:0px'><strong>$termek->nev</strong> <br /> $zarasmod->nev</td>
						<td style='border-left:0px;border-right:0px'><br /> $termek_meret->magassag x $termek_meret->szelesseg x $termek_meret->vastagsag mm</td>
						<td align=right style='border-left:0px;border-right:0px'>$ablakhely->nev <br /> " . $papirtipus->FullName . "</td>
						<td align=right style='border-left:0px;border-right:0px'><br />$termek->suly gr</td>
						<td align=right><strong>$tetel->darabszam</strong></td>
						<td align=right style='font-size:20pt'><strong>6AKKK</strong></td>
					</tr>
				";
			}
			
			// adó szekció (ÁFA) kiírása
			echo "
				</table>

			";

		}
	?>

	<!-- Aláírás szekció kiírása -->
	<p style='margin-top:30px;font-size:8pt'>
		<table style='border:0px'>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td class='alahuzas'></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td align=center>átvevő</td>
			</tr>
		</table>
	</p>
	
</div>

<htmlpagefooter name="myFooter2" style="display:none">
<p style='font-family:arial; font-size: 10pt'>
	<?php echo nl2br(Yii::app()->config->get('AnyagBeszallitasokRaktar')); ?>
</p>

<table width="100%" class = "table_footer" style="vertical-align: bottom; font-family: arial; font-size: 8pt; color: #000000;">
	<tr>
		<td width="50%"> <span> <?php echo "Nyomtatva: " . date('Y.m.d h:m:s'); ?> </span> </td>
		<td width="50%" style="text-align: right; "> {PAGENO} .oldal </td>
    </tr>
</table>
</htmlpagefooter>

</html>
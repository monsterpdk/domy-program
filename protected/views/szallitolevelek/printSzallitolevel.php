<html>
<head></head>

<?php
	$actualUser = User::model() -> findByPk ( Yii::app() -> user -> getId() );
	
	$megrendeles = Megrendelesek::model()->findByPk($model -> megrendeles_id);
	if ($megrendeles == null)
		$megrendeles = new Megrendelesek();
	else {
		$ugyfel = Ugyfelek::model()->findByPk($megrendeles -> ugyfel_id);
		$afakulcs = AfaKulcsok::model()->findByPk($megrendeles -> afakulcs_id);
		$arkategoria = Arkategoriak::model()->findByPk($megrendeles -> arkategoria_id);
	}
	
	$arajanlat_ugyintezo_id = 0 ;
	if ($megrendeles->arajanlat_id > 0) {
		$arajanlat = Arajanlatok::model()->findByPk($megrendeles->arajanlat_id) ;
		$arajanlat_ugyintezo_id = $arajanlat->ugyintezo_id ;
	}
		
	if ($ugyfel == null)
		$ugyfel = new Ugyfelek();
		
	if ($arkategoria == null)
		$arkategoria = new Arkategoriak();
	
	if ($afakulcs == null)
		$afakulcs = new AfaKulcsok();
	
	$szallitolevel_tetelek = SzallitolevelTetelek::model()->findAll(array("condition"=>"szallitolevel_id = $model->id"));
	if ($ugyfel->szallitasi_cim != "") {
		$szallitasi_cim = $ugyfel->getDisplay_ugyfel_szallitasi_cim() ;
	}
	else
	{
		$szallitasi_cim = $ugyfel -> display_ugyfel_cim ;
	}
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

<div style='text-align:center'>
	<h1> <span class='under'>Szállítólevél</span> </h1>
</div>

<!-- Szállítólevél fejléce -->
<table>
	<tr>
		<td class = 'col1'><strong>Sorszám</strong></td>
		<td class = 'col2'><?php echo $model -> sorszam; ?></td>
		<td class = 'col3'></td>
		<td class = 'col4'>Vevő példánya</td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Szállító</strong></td>
		<td class = 'col2'>DomyPack & Press Kft. <br /> 1139 Budapest, Lomb utca 37-39.</td>
		<td class = 'col3'><strong>Megrendelő</strong></td>
		<td class = 'col4'> <?php echo $ugyfel -> getDisplay_ugyfel_ugyintezok($arajanlat_ugyintezo_id); ?> </td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Ügyintéző</strong></td>
		<td class = 'col2'> <?php echo $actualUser -> fullname; ?> </td>
		<td class = 'col3'><strong>Cég <br /> Szállítási cím</strong></td>
		<td class = 'col4'> <?php echo $ugyfel -> cegnev . "<br />" . $szallitasi_cim; ?> </td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Telefon</strong></td>
		<td class = 'col2'>265-0692; 262-9935; 260-7144</td>
		<td class = 'col3'><strong>Telefon</strong></td>
		<td class = 'col4'> <?php echo $ugyfel -> ceg_telefon; ?> </td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Fax</strong></td>
		<td class = 'col2'>265-0629</td>
		<td class = 'col3'><strong>Fax</strong></td>
		<td class = 'col4'>  <?php echo $ugyfel -> ceg_fax; ?> </td>
	<tr>	
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>

<div align = "right"> A szállítólevél dátuma: <strong> <?php echo $model -> datum; ?> </strong> </div>











<!-- Ajánlat tételek táblázat -->
<table class = "table_tetelek">
	<tr>
		<td><strong>Boríték mérete, ragasztási módja, ablak</strong></td>
		<td align=center><strong>Színek száma</strong></td>
		<td align=center><strong>Példányszám</strong></td>
		<td align=center><strong>Munka neve</strong></td>
	</tr>
	
	<tr>
		<td colspan='5' style='border:0px!important;padding:4px;'></td>
	</tr>

	<?php
		if (is_array($szallitolevel_tetelek)) {
			$osszsuly = 0;
			foreach ($szallitolevel_tetelek as $tetel) {
				$megrendelesTetel = MegrendelesTetelek::model()->findByPk($tetel -> megrendeles_tetel_id);
				
				$termek = Termekek::model()->findByPk($megrendelesTetel -> termek_id);
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
				
				
				// tétel kiírása
				echo "
					<tr>
						<td> " . $termek->getDisplayTermekTeljesNev() . " </td>
						<td align=right> $megrendelesTetel->szinek_szama1+$megrendelesTetel->szinek_szama2 </td>
						<td align=right> " . $tetel->DarabszamFormazott . " </td>
						<td align=right> $megrendelesTetel->munka_neve </td>
					</tr>
				";
				
				// összsúly frissítése
				$osszsuly += $papirtipus->suly * $tetel->darabszam;
			}
			
			echo "
				</table>
			";
			
			// tétel alatti összsúly és megyjegyzés rész kiírása
			echo "
				<p> <strong>Összsúly:</strong></p>
				" . Utils::SulyFormazas($osszsuly) . " kg
				
				<p> <strong>Megyjegyzés:</strong></p>
				
				<p style='line-height:20px'>
					$model->megjegyzes
				</p>
			";
		}
	?>
	
</table>

<p>
	Termékeinkre <?php echo $afakulcs->afa_szazalek; ?>% ÁFA vonatkozik.
</p>

<!-- Aláírás szekció kiírása -->
	<p style='margin-top:30px;font-size:8pt'>
		<table style='border:0px'>
			<tr>
				<td>Budapest, <?php echo date('Y.m.d'); ?></td>
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
				<td class='alahuzas'></td>
				<td></td>
				<td class='alahuzas'></td>
			</tr>
			<tr>
				<td></td>
				<td align=center>Szállító <br /> <br /> DomyPack & Press Kft.</td>
				<td></td>
				<td align=center>Megrendelő <br /> <br /> <?php echo $ugyfel -> getDisplay_ugyfel_ugyintezok($arajanlat_ugyintezo_id); ?> <br/> <?php echo $ugyfel -> cegnev; ?></td>
			</tr>
		</table>
	</p>






	
	
	
</div>

</html>
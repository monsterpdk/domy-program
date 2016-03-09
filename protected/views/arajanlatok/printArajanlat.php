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
	
	$admin = User::model()->findByPk($model -> admin_id) ;
	if ($admin == null) 
		$admin = Yii::app()->user ;
	
	$arajanlat_tetelek = ArajanlatTetelek::model()->findAll(array("condition"=>"arajanlat_id = $model->id"));
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
	<h1> <span class='under'>Ajánlat / megrendelés</span> </h1>
</div>

<!-- Árajánlat fejléce -->
<table>
	<tr>
		<td class = 'col1'><strong>Feladó</strong></td>
		<td class = 'col2'> <?php echo $ugyfel -> display_ugyfel_ugyintezok; ?> </td>
		<td class = 'col3'><strong>Sorszám</strong></td>
		<td class = 'col4'><?php echo $model -> sorszam; ?></td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Cég</strong></td>
		<td class = 'col2'> <?php echo $ugyfel -> cegnev . "<br />" . $ugyfel -> display_ugyfel_cim; ?> </td>
		<td class = 'col3'><strong>Címzett</strong></td>
		<td class = 'col4'>DomyPack & Press Kft. <br /> 1139 Budapest, Lomb utca 37-39.</td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Email</strong></td>
		<td class = 'col2'> <?php echo $ugyfel -> ceg_email; ?> </td>
		<td class = 'col3'><strong>Ügyintéző</strong></td>
		<td class = 'col4'> <?php echo $admin -> fullname; ?> </td>
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

<div align = "right"> Az ajánlat érvényes: <strong> <?php echo $model -> ervenyesseg_datum; ?> </strong> </div>

<p style = "font-size : 12pt;"> <strong> <I>Tisztelt <?php echo $ugyfel -> display_ugyfel_ugyintezok; ?> !</I> </strong> </p>
<p> Megbeszélésünkre hivatkozva megadom az árat a kért munkára. </p>

<!-- Ajánlat tételek táblázat -->
<table class = "table_tetelek">
	<tr>
		<td><strong>Boríték típusa, ragasztási módja, mérete, ablak, <br /> grafika</strong></td>
		<td align=center><strong>Példányszám</strong></td>
		<td align=center><strong>Színek száma</strong></td>
		<td align=center><strong>Nettó ár/db</strong></td>
		<td align=center><strong>Nettó ár (Ft)</strong></td>
	</tr>
	
	<tr>
		<td colspan='5' style='border:0px!important;padding:4px;'></td>
	</tr>

	<?php
		if (is_array($arajanlat_tetelek)) {
			
			foreach ($arajanlat_tetelek as $tetel) {
				$termek = Termekek::model()->findByPk($tetel -> termek_id);
				if ($termek == null)
					$termek = new Termekek();
					
/*				$termek_meret = TermekMeretek::model()->findByPk($termek -> meret_id);
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
*/		
				
				// tételek kiírása
				echo "
					<tr>
						<td> <strong> " . $tetel->getTetelnevHozottNemHozott() .  $termek->getDisplayTermekTeljesNev() . "</strong> </td>
						<td align=right> " . $tetel->getDarabszamFormazott() . " db</td>
						<td align=right> $tetel->szinek_szama1+$tetel->szinek_szama2 </td>
						<td align=right>" . Utils::OsszegFormazas((float)$tetel -> netto_darabar) . "</td>
						<td align=right>" .  $tetel->getNettoArFormazott() . "</td>
					</tr>
				";

				// tételek alatti egyedi megrendelő rész kiírása
				echo "
					<tr>
						<td colspan='5'>
							<table class='sub_table'>
								<tr>
									<td>Súly:</td>
									<td></td>
									<td>kg</td>
									<td></td>
								</tr>
								
								<tr>
									<td colspan='2'>Színek (Pantone,stb.):</td>
									<td> <div class='alahuzas'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div> </td>
									<td></td>
								</tr>

								<tr>
									<td colspan='2'>Céglogó, grafika elhelyezése:</td>
									<td width='270'>  </td>
									<td width='250'>átadott minta szerint&nbsp;<input type='checkbox' /> &nbsp;&nbsp;&nbsp; vágójel szerint&nbsp;<input type='checkbox' /></td>
								</tr>

								<tr>
									<td colspan='3'>LC6, LA/4, C6/C5 10-10 mm; LC/5, TC/5, TB/5 13-13 mm; TC/4, TB/4 15-15 mm&nbsp;<input type='checkbox' /></td>
									<td> Kért határidő: <span class='alahuzas'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></td>
								</tr>

								<tr>
									<td colspan='3'>Egyéb kívánság: <span class='alahuzas'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></td>
									<td> Ezt a tételt megrendelem&nbsp;<input type='checkbox' /></td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td colspan='5' style='border:0px!important;padding:4px;'></td>
					</tr>
				";
			}
			
			echo "
				</table>
			";
			
			// alsó megrendelő szöveg
			echo "
				<p> <strong>Tisztelt! </strong></p>
				
				<p style='line-height:20px'>
				Árajánlat alapján megrendelem a fenti munká(ka)t.
				<br />
				Értesítési telefonszám:
				
				<span class='alahuzas'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</span>.
				
				Az adatok pontosítása végett visszahívást kérek: &nbsp;<input type='checkbox' />
				
				<br />
				
				Megjegyzés: 
				<span class='alahuzas'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</span>.
				
				Fizetési mód: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				készpénz: &nbsp;<input type='checkbox' /> &nbsp;&nbsp;&nbsp;átutalás <input type='checkbox' />
				</p>
			";
		}
	?>
	
</table>

	<!-- Aláírás szekció kiírása -->
	<p style='margin-top:30px;font-size:8pt'>
		<table style='border:0px'>
			<tr>
				<td>Üdvözlettel:</td>
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
				<td align=center> <?php echo $ugyfel -> display_ugyfel_ugyintezok . ', ' . $ugyfel -> cegnev; ?> </td>
			</tr>
		</table>
	</p>
	
</div>

<htmlpagefooter name="myFooter2" style="display:none">
<table width="100%" class = "table_footer" style="vertical-align: bottom; font-family: arial; font-size: 8pt; color: #000000;">
	<tr>
		<td colspan='2'>
			<?php echo nl2br(Yii::app()->config->get('Arajanlat')); ?>
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
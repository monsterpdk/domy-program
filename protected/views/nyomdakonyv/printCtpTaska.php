<html>
<head></head>

<?php
	$megrendeles_tetel = $model->megrendeles_tetel;
	$gep = $model->gep;
	$gepTipusNev = "";
	
	$sql = "
				SELECT gep_tipusok.tipusnev FROM dom_nyomdagepek AS gepek
				INNER JOIN dom_nyomdagep_tipusok AS gep_tipusok ON
				gepek.id = gep_tipusok.gep_id

				WHERE (:szinszam >= szinszam_tol AND :szinszam <= szinszam_ig) AND (gep_tipusok.gep_id = :gep_id)
			";

	$osszSzin = $megrendeles_tetel->szinek_szama1 + $megrendeles_tetel->szinek_szama2;
	$command = Yii::app()->db->createCommand($sql);
	$command->bindParam(':szinszam', $osszSzin);
	$command->bindParam(':gep_id', $gep->id);
	
	$result = $command->queryRow();
	
	if ($result) {
		$gepTipusNev = $result['tipusnev'];
	}

	$termek = Termekek::model()->findbyPk($megrendeles_tetel->termek_id);
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
				
	// ez csak egy évszám, ami nem tudom pontosan honnan jön, de kb. ez jó lehet ide, még pontosítani kell
	$fejlecDatum = date('Y', strtotime(str_replace("-", "", $model->hatarido)));
	
	$actualUserName = '';
	$actualUser = User::model()->findByPk(Yii::app()->user->getId());
	if ($actualUser != null) {
		$actualUserName	= $actualUser->fullname;
	}
	
	$gyartasIdeje = '';
	$normaAdat = Utils::getNormaadat($megrendeles_tetel->id, $gep->id, $model->munkatipus_id, $model->max_fordulat);
	if ($normaAdat != null) {
		$gyartasIdeje = $normaAdat['normaido'];
	}
	
?>

<style>
	div {
		font-family: arial;
		font-size: 10pt;
	}
	.under {
		border-bottom: 4px double #000000;
	}
	table {
		border: 1px solid #000000;
		padding: 2px;
		font-family: arial;
		font-size: 10pt;
		width: 100%;
	}
	img {
		margin: 0px;
		padding: 0px;
	}
	.fejlec1 {
		border: 0px;
	}
	.fejlec1 td {
		font-size:9pt!important;
		height: 10px;
		padding: 3px;
		vertical-align: center;
	}
	.fejlec2 {
		border-collapse: collapse;
		border: 2px solid #000000;
	}
	.fejlec2 td {
		border: 1px solid #000000;
		padding: 5px;
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
		border-bottom:1px solid #000000;
		width:150px;
	}
	.boritekok {
		padding: 5px 5px 5px 0px;
	}
	.boritek_bal_fekvo {
		float: left;
		height: 103px;
		width: 170px;
	}
	.boritek_jobb_fekvo {
		float: left;
		margin-left:4px;
		height: 103px;
		width: 170px;
	}
	.elhelyezes {
		border: 0px!important;
		float: left;
		margin-left:5px;
	}
	.ctp {
		border: 0px;
		margin-top: 10px;
		font-size: 9pt;
	}
	.ctp td {
		height: 150px;
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
		<td></td>
		<td></td>
		<td style='font-size:15pt'> <strong> <?php //echo $fejlecDatum; ?> </strong> </td>
		<td style='font-size:12pt'>TÁSKASZÁM:</td>
		<td style='font-size:15pt'>  <strong> <?php echo $model->taskaszam; ?> </strong> </td>
	</tr>
	<tr>
		<td width='110'>Nyomógép típusa:</td>
		<td> <strong> <?php echo $gepTipusNev; ?> </strong> </td>
		<td style='font-weight: bold;font-size:30pt'> <?php if ($model->sos == '1') echo 'SOS'; ?> </td>
		<td colspan="2" align='right'> <h1> <span class='under'>MUNKATÁSKA</span> </h1> </td>
	</tr>
	<tr>
		<td valign='center'>Dolgozó(k) neve: </td>
		<td> <span class='alahuzas'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> </td>
		<td></td>
		<td style='font-size:11pt'>HATÁRIDŐ:</td>
		<td style='font-size:11pt'> <strong> <?php echo $model->hatarido; ?> </strong> </td>		
	</tr>
	<tr>
		<td>Gyártás ideje: </td>
		<td> <span class='alahuzas'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $gyartasIdeje; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span> perc</td>
		<td>Lemez:</td>
		<td><?php echo $osszSzin; ?> db</td>
		<td></td>
	</tr>
</table>

<table class='fejlec2'>
	<tr>
		<td style='padding:10px 0px 10px 5px' colspan='5'> <strong>MUNKA NEVE: <span style='font-size:12pt'> <?php echo $megrendeles_tetel->munka_neve; ?> </span> </strong> </td>
	</tr>
	<tr>
		<td colspan='3'> <strong> Boríték típusa, ragasztási módja, mérete, ablak <br /> Megjegyzés </strong> </td>
		<td align='center'> <strong> Példányszám </strong> </td>
		<td align='center'> <strong> Színek száma </strong> </td>
	</tr>
	<tr>
		<td colspan='3'> <?php print $termek->getDisplayTermekTeljesNev(); ?> </td>
		<td align='center' width='80'> <?php echo $megrendeles_tetel->darabszam; ?> </td>
		<td align='center' width='110'> <?php echo $megrendeles_tetel->displayTermekSzinekSzama; ?> </td>
	</tr>
	<tr>
		<td colspan='3' align='right'> <strong> PANTONE (szín):</strong> </td>
		<td colspan='2'>  </td>
	</tr>
</table>

<div class='boritekok'>
	<div style='float:left; width:400px'>
		<div class='boritek_bal_fekvo'>
			<img src='images/level_bal_fekvo.png' height='103' width='170' />
		</div>

		<div style='float:left; padding:88px 0px 0px 8px; width:45px;'>
			Tasak
		</div>
		
		<div class='boritek_jobb_fekvo'>
			<img src='images/level_jobb_fekvo.png' height='103' width='170' />		
		</div>
		
	</div>
	
	<div>
		<table class='elhelyezes'>
			<tr>
				<td colspan='2'> <strong> Választott boríték, elhelyezés: </strong></td>
			</tr>
			<tr>
				<td>átadott minta szerint</td>
				<td> <img src='images/<?php echo $model->nyomas_minta_szerint == 1 ? 'checkbox_checked.jpg' : 'checkbox_unchecked.jpg'; ?>' /> </td>
			</tr>
			<tr>
				<td>vágójel szerint</td>
				<td> <img src='images/<?php echo $model->nyomas_vagojel_szerint == 1 ? 'checkbox_checked.jpg' : 'checkbox_unchecked.jpg'; ?>' /> </td>
			</tr>
			<tr>
				<td>Domy ajánlás szerint</td>
				<td> <img src='images/<?php echo $model->nyomas_domy_szerint == 1 ? 'checkbox_checked.jpg' : 'checkbox_unchecked.jpg'; ?>' /> </td>
			</tr>
			<tr>
				<td>speciális</td>
				<td> <img src='images/<?php echo trim($model->nyomas_specialis) != '' ? 'checkbox_checked.jpg' : 'checkbox_unchecked.jpg'; ?>' /> </td>
			</tr>
		</table>
	</div>

</div>

<table style='border: 0px!important;'>
	<tr>
		<td width='50%'>
			<table style='border:0px; font-size:9pt'>
				<tr>
					<td>Megrendelés kelte:</td>
					<td> <?php echo $megrendeles_tetel->megrendeles->rendeles_idopont; ?> </td>
				</tr>
				<tr>
					<td>Munka beérkezett:</td>
					<td> <?php echo $model->munka_beerkezes_datum; ?> </td>
				</tr>
				<tr>
					<td>Táska kiállítva:</td>
					<td> <?php echo $model->taska_kiadasi_datum; ?> </td>
				</tr>
				<tr>
					<td>Ctp kezdés:</td>
					<td> <?php echo $model->ctp_kezdes_datum; ?> </td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table class='ctp'>
	<tr>
		<td>Ctp belenyúlások:</td>
		<td colspan='2'> <?php echo $model->ctp_belenyulasok; ?> </td>
	</tr>
	<tr>
		<td>Ctp hibalista:</td>
		<td colspan='2'> <?php echo $model->ctp_hibalista; ?> </td>
	</tr>
	<tr>
		<td>Ctp kész:</td>
		<td align='center'> <?php echo $model->ctp_kesz_datum; ?> </td>
		<td align='right'> Lemezek(ek) elkészültek: <span class='alahuzas'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span> <br /> <span style='font-size: 9pt;'>dátum, idő, aláírás</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
</table>

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
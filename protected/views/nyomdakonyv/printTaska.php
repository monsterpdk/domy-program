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
	$fejlecDatum = "" ;
	if ($model->hatarido != "0000-00-00 00:00:00") {
		$fejlecDatum = date('Y', strtotime(str_replace("-", "", $model->hatarido)));
	}	
	
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
	
	$elooldal_szinek = "" ;
	if ($model->szin_c_elo == 1) {
		$elooldal_szinek .= "C," ;	
	}
	if ($model->szin_m_elo == 1) {
		$elooldal_szinek .= "M," ;	
	}
	if ($model->szin_y_elo == 1) {
		$elooldal_szinek .= "Y," ;	
	}
	if ($model->szin_k_elo == 1) {
		$elooldal_szinek .= "K," ;	
	}
	$elooldali_szinek = rtrim($elooldali_szinek, ",") ;

	$hatoldal_szinek = "" ;
	if ($model->szin_c_hat == 1) {
		$hatoldal_szinek .= "C," ;	
	}
	if ($model->szin_m_hat == 1) {
		$hatoldal_szinek .= "M," ;	
	}
	if ($model->szin_y_hat == 1) {
		$hatoldal_szinek .= "Y," ;	
	}
	if ($model->szin_k_hat == 1) {
		$hatoldal_szinek .= "K," ;	
	}
	$hatoldal_szinek = rtrim($hatoldal_szinek, ",") ;
	
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
	.boritek_allo {
		float: left;
		height: 170px;
		margin-left:4px;
		width: 103px;
	}
	.elhelyezes {
		border: 0px!important;
		float: left;
		margin-left:5px;
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
		<td style='font-size:15pt'> <strong> <?php echo $fejlecDatum; ?> </strong> </td>
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
		<td align='center'> <strong> Színek száma</strong> </td>
	</tr>
	<tr>
		<td colspan='3'> <?php print $termek->getDisplayTermekTeljesNev(); ?> </td>
		<td align='center' width='80'> <?php echo $megrendeles_tetel->darabszam; ?> </td>
		<td align='center' width='110'> <?php echo $megrendeles_tetel->displayTermekSzinekSzama; ?> </td>
	</tr>
	<tr>
		<td width='115'> <strong> PANTONE (szín): <?php echo $model->szin_pantone;?></strong> </td>
		<td colspan='4'> <strong> ELŐOLDAL: <?php echo $elooldal_szinek;?> <br /> HÁTOLDAL: <?php echo $hatoldal_szinek;?></strong> </td>
	</tr>
	<tr>
		<td> <strong> UTASÍTÁS GÉP- <br/> MESTER-nek</strong> </td>
		<td colspan='4'> <?php echo $model->utasitas_gepmesternek; ?> </td>
	</tr>
	<tr>
		<td> <strong> UTASÍTÁS <br/> CTP-nek</strong> </td>
		<td colspan='4'> <?php echo $model->utasitas_ctp_nek; ?> </td>
	</tr>
</table>

<div class='boritekok'>
	<div style='float:left; width:345px'>
		<div class='boritek_bal_fekvo'>
			<img src='images/level_bal_fekvo.png' height='103' width='170' />
		</div>
		
		<div class='boritek_jobb_fekvo'>
			<img src='images/level_jobb_fekvo.png' height='103' width='170' />		
		</div>
		
		<div style='margin-top:5px'>
			<table>
				<tr>
					<td> <img src='images/<?php echo $model->magas_szinterheles_nagy_feluleten == 1 ? 'checkbox_checked.jpg' : 'checkbox_unchecked.jpg'; ?>' /> </td>
					<td> Magas színterhelés nagy felületen</td>
				</tr>
				
				<tr>
					<td> <img src='images/<?php echo $model->magas_szinterheles_szovegben == 1 ? 'checkbox_checked.jpg' : 'checkbox_unchecked.jpg'; ?>' /> </td>
					<td style='border-bottom:1px solid #000000'> Magas színterhelés szövegben</td>
				</tr>
				
				<tr>
					<td> <img src='images/<?php echo $model->nyomas_tipus == 'Új nyomás' ? 'checkbox_checked.jpg' : 'checkbox_unchecked.jpg'; ?>' /> </td>
					<td> Új nyomás </td>
				</tr>
				
				<tr>
					<td> <img src='images/<?php echo $model->nyomas_tipus == 'változatlan utánnyomás' ? 'checkbox_checked.jpg' : 'checkbox_unchecked.jpg'; ?>' /> </td>
					<td> Változatlan utánnyomás </td>
				</tr>
				
				<tr>
					<td> <img src='images/<?php echo $model->nyomas_tipus == 'utánnyomás változtatással' ? 'checkbox_checked.jpg' : 'checkbox_unchecked.jpg'; ?>' /> </td>
					<td> Utánnyomás változtatással </td>
				</tr>
			</table>
		</div>
		
		<?php if ($model->nyomas_tipus == 'utánnyomás változtatással') {
			echo "
				<div style='border:1px solid #000000; margin-top:5px; padding:5px'>
					$model->utannyomas_valtoztatassal
				</div>
			";
		} ?>
	</div>
	
	<div class='boritek_allo'>
		<img src='images/level_allo.png' height='170' width='103' />
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

	<div style='float:right; margin-left:50px; margin-top:10px'>
		<strong> Kifutás iránya </strong>
		<img src='images/kifutas_iranya.jpg' />
	</div>
</div>

<table>
	<tr>
		<td width='50%'>
			<table style='border:0px;border-bottom:1px solid #000000; font-size:9pt'>
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
					<td>A munka elvégezhető:</td>
					<td> <span class='alahuzas'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> </td>
				</tr>
				<tr>
					<td></td>
					<td align='center'> <span style='font-size: 9pt;'>dátum, idő, aláírás</span> </td>
				</tr>
			</table>
			
			<table style='border: 0px; margin-top: 10px; font-size:9pt'>
				<tr>
					<td colspan='2'></td>
					<td align='center' width='50'>IGEN</td>
					<td align='center' width='50'>MÉG KIADHATÓ</td>
				</tr>
				<tr>
					<td colspan='2'>Beállás előírásnak megfelelő</td>
					<td align='center'> <img src='images/checkbox_unchecked.jpg' /> </td>
					<td align='center'> <img src='images/checkbox_unchecked.jpg' /> </td>
				</tr>
				<tr>
					<td colspan='2'>Színhelyes</td>
					<td align='center'> <img src='images/checkbox_unchecked.jpg' /> </td>
					<td align='center'> <img src='images/checkbox_unchecked.jpg' /> </td>
				</tr>
				<tr>
					<td colspan='2'>Passzerhelyes</td>
					<td align='center'> <img src='images/checkbox_unchecked.jpg' /> </td>
					<td align='center'> <img src='images/checkbox_unchecked.jpg' /> </td>
				</tr>
				<tr>
					<td style='border-bottom: 1px solid #000000!important;' colspan='3'>Nem javaslom a munka kiadását</td>
					<td align='center' style='border-bottom: 1px solid #000000!important;'> <img src='images/checkbox_unchecked.jpg' /> </td>
				</tr>
				<tr>
					<td width='50'>Talált hibák:</td>
					<td colspan='3' align='right'> <span class='alahuzas'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> </td>
				</tr>
				<tr>
					<td colspan='2'>Megrendelő értesíthető</td>
					<td align='center'> <img src='images/checkbox_unchecked.jpg' /> </td>
					<td align='center'> <span style='font-size: 9pt;'>dátum, idő, aláírás</span> </td>
				</tr>
				
			</table>
		</td>

		<td width='50%'>
		</td>
	</tr>
</table>

<table style='font-size:9pt!important; border:0px!important;'>
	<tr>
		<td align='left' style='letter-spacing: 2px;'>Egyéb információk a táskában!</td>
		<td align='right'>Kapcsolattartó: <?php echo $megrendeles_tetel->megrendeles->ugyfel->kapcsolattarto_nev; ?></td>
	</tr>
	<tr>
		<td align='left'> <strong>KISZÁLLÍTÁS INFORMÁCIÓK</strong></td>
		<td align='right'>Telefon: <?php echo $megrendeles_tetel->megrendeles->ugyfel->kapcsolattarto_telefon; ?></td>
	</tr>
	<tr>
		<td align='left' colspan='2'> <?php echo $model->kiszallitasi_informaciok; ?> </td>
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
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
	
	$pantone_elol_hatul = array() ;
	if ($model->szin_pantone != "") {
		$pantone_elol_hatul = explode("+", $model->szin_pantone) ;
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
	.alahuzas_strong {
		border-bottom:2px solid #000000;
		width:150px;
	}
	.boritekok {
		margin-left: 0px;
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
		position: fixed;
		top: 330px;
		right: 0px;
		height: 170px;
		margin-left:4px;
		width: 103px;
	}
	.levezetes_bal {
		float: left;
		padding-right: 10px;
		height: 103px;
		width: 85px;
	}
	.levezetes_jobb {
		float: left;
		padding-right: 10px;
		height: 103px;
		width: 85px;
	}
	.levezetes_fullel_elore {
		float: left;
		padding-right: 10px;
		padding-top: 18px;
		height: 85px;
		width: 112px;
	}
	.levezetes_nyitott_fullel {
		float: left;
		padding-right: 10px;
		padding-top: 3px;
		height: 100px;
		width: 112px;
	}
	.elhelyezes {
		border: 0px!important;
		float: left;
		margin-left:0px!important;
		padding-left:0px!important;
	}
	.elhelyezes td, tr{
		margin-left: 0px!important;
		padding-left: 0px!important;
	}	
	.table_nyomtato_tipusa {
		border-top: 0px!important;
		border-right: 2px solid #000000;
		border-bottom: 0px!important;
		border-left: 0px!important;
		font-size:8pt;
		font-weight: bold!important;
		margin: 0px!important;
		padding: 0px!important;
	}
	.table_nyomtato_tipusa td, .table_nyomtato_tipusa tr {
		margin-left: 0px!important;
		padding-left: 0px!important;
	}
	.table_szinbeallitas {
		border-top: 0px!important;
		border-right: 0px!important;
		border-bottom: 0px!important;
		border-left: 0px!important;
		font-size:9pt;
		font-weight: bold!important;
		margin: 0px!important;
		padding: 0px!important;
	}
	.table_szinbeallitas td, .table_szinbeallitas tr {
		border: 0px;
		margin-left: 0px!important;
		margin-right: 0px!important;
		padding-left: 0px!important;
		padding-right: 0px!important;
	}
	.szinbeallitas_col_1 {
		width: 90px;
	}
	.szinbeallitas_col_2 {
		width: 50px;
	}
	.szinbeallitas_col_3 {
		width: 116px;
	}
	.szinbeallitas_col_4 {
		width: 50px;
	}
	@page {
		margin-top: 10px;
		size: auto;
		odd-footer-name: html_myFooter2;
		even-footer-name: html_myFooter2;
	}
</style>

<div class='boritek_allo'>
	<img src='images/level_allo.png' height='170' width='103' />
</div>

<div class='wide form'>

<table class='fejlec1'>
	<tr>
		<td colspan="2"><strong><?php if ($model->gepindulasra_jon_ugyfel == 1) echo  'Gépindulásra jön az ügyfél';?></strong></td>
		<td style='font-size:15pt'> <strong> <?php echo $fejlecDatum; ?> </strong> </td>
		<td style='font-size:12pt'>TÁSKASZÁM:</td>
		<td style='font-size:15pt' colspan="2">  <strong> <?php echo $model->taskaszam; ?> </strong> </td>
	</tr>
	<tr>
		<td width='110'>Nyomógép típusa:</td>
		<td> <strong> <?php echo $gepTipusNev; ?> </strong> </td>
		<td style='font-weight: bold;font-size:30pt'> <?php if ($model->sos == '1') echo 'SOS'; ?> </td>
		<td colspan="3" align='right'> <h1> <span class='under'>MUNKATÁSKA</span> </h1> </td>
	</tr>
	<tr>
		<td valign='center'>Dolgozó(k) neve: </td>
		<td> <span class='alahuzas'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> </td>
		<td></td>
		<td style='font-size:11pt'>HATÁRIDŐ:</td>
		<td style='font-size:11pt' colspan="2"> <strong> <?php echo $model->hatarido; ?> </strong> </td>
	</tr>
	<tr>
		<td>Gyártás ideje: </td>
		<td colspan='5'> <span class='alahuzas'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $gyartasIdeje; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span> Sebesség:
		<span class='alahuzas'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> perc /10 darab
		</td>
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
		<td colspan='3'> <?php print $megrendeles_tetel->megrendelt_termek_nev; ?> </td>
		<td align='center' width='80'> <?php echo $megrendeles_tetel->getDarabszamFormazott(); ?> </td>
		<td align='center' width='110'> <?php echo $megrendeles_tetel->displayTermekSzinekSzama; ?> </td>
	</tr>
	<tr>
		<td width='115'> <strong> SZÍN </strong> <br /> &nbsp; </td>
		<td colspan='4'> <strong> ELŐOLDAL: <?php echo $elooldal_szinek . $pantone_elol_hatul[0];?> <br /> HÁTOLDAL: <?php echo $hatoldal_szinek . $pantone_elol_hatul[1];?></strong> </td>
	</tr>
	<tr>
		<td> <strong> UTASÍTÁS </strong> <br /> &nbsp; </td>
		<td colspan='4'> <?php echo $model->utasitas_gepmesternek; ?> </td>
	</tr>
</table>

<div class='boritekok'>
	<div>
		<div style='float:left; width:225px'>
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
	
		<div class='boritek_bal_fekvo'>
			<img src='images/level_bal_fekvo.png' height='103' width='170' />
		</div>
		
		<div class='boritek_jobb_fekvo'>
			<img src='images/level_jobb_fekvo.png' height='103' width='170' />		
		</div>

		<div style='border-top: 2px solid #000000;border-bottom: 2px solid #000000;clear:both'>
			<div style = "float: left;font-size:9pt;font-weight: bold!important;">
				<div style="float:left; width: 220px;">
					<table class='table_nyomtato_tipusa'>
						<tr>
							<td colspan='6' style='font-size:9pt'> NYOMTATÓ TÍPUSA: </td>
						</tr>
						<tr>
							<td>P600 (1)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
							<td>(6)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
							<td>L310</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
						</tr>
						
						<tr>
							<td>P600 (2)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
							<td>(7)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
							<td>L805</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
						</tr>
						
						<tr>
							<td>P600 (3)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
							<td>(8)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
							<td>L1800 (1)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
						</tr>
						
						<tr>
							<td>P600 (4)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
							<td>(9)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
							<td>L1800 (2)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
						</tr>
						
						<tr>
							<td>P600 (5)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
							<td>(10)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
							<td>WF-8510 (1)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
						</tr>
						
						<tr>
							<td>P800 (1)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
							<td>(2)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
							<td>WF-8510 (2)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
						</tr>
						
						<tr>
							<td>P5000 (1)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
							<td>(2)</td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
							<td></td>
							<td> <img src='images/checkbox_unchecked.jpg' /> </td>
						</tr>
						
					</table>
				</div>
				
				<div style="float:left;">
					<table class='table_szinbeallitas'>
						<tr>
							<td colspan='6'>SZÍNBEÁLLÍTÁS:</td>
						</tr>
						<tr>
							<td align="right" class='szinbeallitas_col_1'>SZÍNES</td>
							<td class='szinbeallitas_col_2'> <img src='images/checkbox_unchecked.jpg' /> </td>
							<td align="right" class='szinbeallitas_col_3'>CSAK FEKETE</td>
							<td class='szinbeallitas_col_4'> <img src='images/checkbox_unchecked.jpg' /> </td>
							<td colspan='2'></td>
						</tr>
						<tr>
							<td align="right">FÉNYERŐ</td>
							<td> <img src='images/checkbox_unchecked_double.jpg' /> </td>
							<td align="right">CIÁN</td>
							<td> <img src='images/checkbox_unchecked_double.jpg' /> </td>
							<td colspan='2'></td>
						</tr>
						<tr>
							<td align="right">KONTRASZT</td>
							<td> <img src='images/checkbox_unchecked_double.jpg' /> </td>
							<td align="right">BÍBOR</td>
							<td> <img src='images/checkbox_unchecked_double.jpg' /> </td>
							<td colspan='2'></td>
						</tr>
						<tr>
							<td align="right">TELÍTETTSÉG</td>
							<td> <img src='images/checkbox_unchecked_double.jpg' /> </td>
							<td align="right">SÁRGA</td>
							<td> <img src='images/checkbox_unchecked_double.jpg' /> </td>
							<td colspan='2' align="right"></td>
						</tr>
					</table>
						
					<table class='table_szinbeallitas' style='border-top: 1px solid #000000'>
						<tr>
							<td align="right" class='szinbeallitas_col_1'>ERŐSSÉG</td>
							<td class='szinbeallitas_col_2'> <img src='images/checkbox_unchecked_double.jpg' /> </td>
							<td align="right" class='szinbeallitas_col_3'>VÍZSZINTES</td>
							<td class='szinbeallitas_col_4'> <img src='images/checkbox_unchecked_double.jpg' /> </td>
							<td align="right">FÜGGŐLEGES</td>
							<td> <img src='images/checkbox_unchecked_double.jpg' /> </td>
						</tr>
						<tr>
							<td colspan='6'>EGYÉB: <span class='alahuzas_strong'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
						</tr>
						<tr>
							<td colspan='6'>&nbsp;</td>
						</tr>						
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<p style='margin-top:0px;font-size:9pt; font-weight: bold'> LEVEZETÉS: </p>
	
	<div>
		<div class='levezetes_bal'>
			<img src='images/levezetes_bal.png' height='103' width='85' />
		</div>

		<div class='levezetes_jobb'>
			<img src='images/levezetes_jobb.png' height='103' width='85' />
		</div>

		<div class='levezetes_fullel_elore'>
			<img src='images/levezetes_fullel_elore.png' height='85' width='112' />
		</div>
		
		<div class='levezetes_nyitott_fullel'>
			<img src='images/levezetes_nyitott_fullel.png' height='100' width='112' />
		</div>
		
		<div style='padding-top:84px'>
			<strong> EGYÉB: </strong> <span class='alahuzas'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
		</div>
	</div>
	
	<div>
		<div style='float:left;padding-top: 40px;width: 180px'>
			<strong> Kifutás iránya </strong>
			<table>
				<tr>
					<td>&nbsp;</td>
					<td style="margin: auto; text-align:center;"><?php echo (($model->kifuto_fent == 1) ? "<img src='images/checkbox_checked.jpg' />" : "<img style='margin: auto;' src='images/checkbox_unchecked.jpg' />")?></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><?php echo (($model->kifuto_bal == 1) ? "<img src='images/checkbox_checked.jpg' />" : "<img src='images/checkbox_unchecked.jpg' />")?></td>
					<td><img src='images/boritek_kifuto.jpg' /></td>
					<td align="center"><?php echo (($model->kifuto_jobb == 1) ? "<img src='images/checkbox_checked.jpg' />" : "<img src='images/checkbox_unchecked.jpg' />")?></td>
					</tr>		
				<tr>
					<td>&nbsp;</td>
					<td style="margin: auto; text-align:center;"><?php echo (($model->kifuto_lent == 1) ? "<img src='images/checkbox_checked.jpg' />" : "<img src='images/checkbox_unchecked.jpg' />")?></td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</div>
		
		<div style='float:right; margin-top:5px;'>
			<div style='float:right;width: 360px'>
				<table>
					<tr>
						<td width='30'> &nbsp; </td>
						<td width='200'> &nbsp; </td>
						<td width='30' align='center'> <strong> IGEN </strong> </td>
						<td width='30' align='center'> <strong> NEM </strong> </td>
					</tr>
				
					<tr>
						<td colspan='2'> <strong> TARTOZIK HOZZÁ OFSZET NYOMÁS? </strong> </td>
						<td align='center'> <img src='images/checkbox_unchecked.jpg' /> </td>
						<td align='center'> <img src='images/checkbox_unchecked.jpg' /> </td>
					</tr>
				</table>
				
				<table>
					<tr>
						<td> <img src='images/<?php echo $model->nyomas_tipus == 'Új nyomás' ? 'checkbox_checked.jpg' : 'checkbox_unchecked.jpg'; ?>' /> </td>
						<td colspan='3'> Új nyomás </td>
					</tr>
					
					<tr>
						<td> <img src='images/<?php echo $model->nyomas_tipus == 'változatlan utánnyomás' ? 'checkbox_checked.jpg' : 'checkbox_unchecked.jpg'; ?>' /> </td>
						<td colspan='3'> Változatlan utánnyomás </td>
					</tr>
					
					<tr>
						<td> <img src='images/<?php echo $model->nyomas_tipus == 'utánnyomás változtatással' ? 'checkbox_checked.jpg' : 'checkbox_unchecked.jpg'; ?>' /> </td>
						<td colspan='3'> Utánnyomás változtatással </td>
					</tr>
				</table>
				
				<?php if ($model->nyomas_tipus == 'utánnyomás változtatással') {
					echo "
						<div style='border:1px solid #000000; margin-top:5px; padding:5px'>
							$model->utannyomas_valtoztatassal
						</div>
					";
				} ?>
			</div>
			<div style='clear:both'></div>
			
			<div style='border-bottom: 2px solid #000000;float:right;margin: 5px'></div>
			<div style='clear:both'></div>
			
			<div style='float:right; width:233px'>
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
			</div>
		</div>
		
	</div>

</div>

<div style='border-top: 1px solid #000000;'>
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
</div>

<htmlpagefooter name="myFooter2">
<p style='font-family:arial; font-size: 10pt'>
	<?php echo nl2br(Yii::app()->config->get('NyomdakonyvMunkataska')); ?>
</p>

<table width="100%" class = "table_footer" style="vertical-align: bottom; font-family: arial; font-size: 8pt; color: #000000;">
	<tr>
		<td width="40%"> <span> <?php echo "Táska nyomtatva: " . date('Y-m-d h:m:s'); ?> </span> </td>
		<td width='20%'> <?php echo $actualUserName; ?> </td>
		<td width="40%" style="text-align: right; "> {PAGENO} .oldal </td>
    </tr>
</table>
</htmlpagefooter>

</html>
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
	p {
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
	.engedelyezo {
		height : 100px;
	}
	@page {
	  size: auto;
	  odd-footer-name: html_myFooter2;
	  even-footer-name: html_myFooter2;
	}
</style>

<div class='wide form'>

<div style='text-align:center'>
	<h3><span class='under'>Termék megrendelés</span></h3>
</div>

<!-- Számla fejléce -->
<table>
	<tr>
		<td class = 'col1'><strong>Megrendelő</strong></td>
		<td class = 'col2'>DomyPack & Press Kft.</td>
		<td class = 'col3'><strong>Rendelés száma:</strong></td>
		<td class = 'col4'><?php echo $model -> bizonylatszam; ?></td>
	<tr>
	<tr>
		<td class = 'col1'></td>
		<td class = 'col2'>1117 Bp. Budafoki út 111-113. 20-as épület</td>
		<td class = 'col3'><strong>Szállító</strong></td>
		<td class = 'col4'><strong><?php echo $szallito -> cegnev; ?></strong></td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Ügyintéző</strong></td>
		<td class = 'col2'><?php echo $ugyintezo -> fullname; ?></td>
		<td class = 'col3'><strong>Név: <br /> Cím:</strong></td>
		<td class = 'col4'><?php echo $szallito -> kapcsolattarto . '<br />' . $szallito -> cim ?></td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Telefon</strong></td>
		<td class = 'col2'>265-0693; 262-9935; 260-7144</td>
		<td class = 'col3'><strong>Telefon:</strong></td>
		<td class = 'col4'><?php echo $szallito -> telefon; ?></td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Fax</strong></td>
		<td class = 'col2'>265-0629</td>
		<td class = 'col3'><strong>Fax:</strong></td>
		<td class = 'col4'><?php echo $szallito -> fax; ?></td>
	<tr>	
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>

<h4> Tisztelt Partnerünk! </h4>
<p>
Az alábbi tételeket szeretném megrendelni Önöktől. Kérjük, hogy a borítékok tekercses gyártásúak legyenek.<br />
Ha ez bizonyos tételeknél nem lehetséges, jelezzék felénk.
</p>

<!-- Számla tételek táblázat -->
<table class = "table_tetelek">
	<tr>
		<td style='border-left:0px;border-right:0px'><strong>Boríték megnevezése <br/> Záródás</strong></td>
		<td style='border-left:0px;border-right:0px' align=center><strong>Méret</strong></td>
		<td style='border-left:0px;border-right:0px' align=center><strong>Ablakméret <br /> Papír</strong></td>
		<td style='border-left:0px;border-right:0px' align=center><strong>Ablakhely <br /> súly(gr/m2)</strong></td>
		<td align=center><strong>Gyári kód</strong></td>
		<td align=center><strong>Darabszám</strong></td>
	</tr>

	<tr>
		<td style='border-left:0px;border-right:0px'></td>
		<td style='border-left:0px;border-right:0px'></td>
		<td style='border-left:0px;border-right:0px'></td>
		<td style='border-left:0px;border-right:0px'></td>
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
					
				// tételek kiírása
				$ablakhely_szoveg = "" ;
				if ($ablakhely->hely != "") {
					$ablakhely_szoveg = "$ablakhely->hely $ablakhely->x_pozicio_honnan$ablakhely->x_pozicio_mm$ablakhely->y_pozicio_honnan$ablakhely->y_pozicio_mm" ;
				}
				echo "
					<tr>
						<td style='border-left:0px;border-right:0px'>$termek->nev <br /> $zarasmod->nev </td>
						<td style='border-left:0px;border-right:0px'>$termek_meret->magassag x $termek_meret->szelesseg x $termek_meret->vastagsag mm</td>
						<td style='border-left:0px;border-right:0px'>$ablakmeret->magassag x $ablakmeret->szelesseg mm <br /> $papirtipus->nev</td>
						<td  style='border-left:0px;border-right:0px' align=right>$ablakhely_szoveg <br /> $papirtipus->suly gr</td>
						<td align=right>$termek->kodszam</td>
						<td align=right>" . Utils::DarabszamFormazas($tetel->rendelt_darabszam) . "</td>
					</tr>
				";
			}

		}
	?>
	
	</table>
	
	<p style='margin-top:100px'>
		<strong>Budapest, <?php echo date('Y.m.d'); ?></strong>
	</p>
	
	<!-- Aláírás szekció kiírása -->
	<table align=right class='table_engedelyezo'>
		<tr>
			<td width=100>Készítette:</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td class='alahuzas'></td>
		</tr>
	</table>	
	
	<table align=right class='table_engedelyezo'>
		<tr>
			<td width=100>Engedélyező:</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td class='alahuzas'></td>
		</tr>
		<tr>
			<td></td>
			<td align=center>Domaniczky Ákos</td>
		</tr>
	</table>
	
</div>

<htmlpagefooter name="myFooter2" style="display:none">
<p style='font-family:arial; font-size: 10pt'>
	<?php echo nl2br(Yii::app()->config->get('AnyagrendelesekArNelkul')); ?>
</p>

<table width="100%" class = "table_footer" style="vertical-align: bottom; font-family: arial; font-size: 8pt; color: #000000;">
	<tr>
		<td width="50%"> <span> <?php echo "Nyomtatva: " . date('Y.m.d h:m:s'); ?> </span> </td>
		<td width="50%" style="text-align: right; "> {PAGENO} .oldal </td>
    </tr>
</table>
</htmlpagefooter>

</html>
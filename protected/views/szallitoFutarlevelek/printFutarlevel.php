<html>
<head></head>

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

<div style='text-align:center'>
	<h2><span class='under'>SZÁLLÍTÁS</span></h2>
</div>

<!-- Számla fejléce -->
<table style='border: 0px'>
	<tr>
		<td style='width: 120px;'><strong>Számla sorszáma: </strong></td>
		<td class = 'col2'><?php echo $model -> szamla_sorszam; ?></td>
		<td class = 'col3'>&nbsp;</td>
		<td class = 'col4'>&nbsp;</td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Szállító cég:</strong></td>
		<td class = 'col2'><?php echo $model -> szallito_ceg_rel -> nev; ?></td>
		<td class = 'col3'><strong>Rendszáma:</strong></td>
		<td class = 'col4'><?php echo $model -> szallito_futar_rel -> rendszam; ?></td>
	<tr>
	<tr>
		<td class = 'col1'><strong>Futár neve:</strong></td>
		<td class = 'col2'><?php echo $model -> szallito_futar_rel -> nev; ?></td>
		<td class = 'col3'><strong>Telefonszáma:</strong></td>
		<td class = 'col4'><?php echo $model -> szallito_futar_rel -> telefon; ?></td>
	<tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td class = 'col1'><strong>Felvét helye:</strong></td>
		<td class = 'col2'><?php echo $model -> felvetel_helye; ?></td>
		<td class = 'col3'><strong>Ideje:</strong></td>
		<td class = 'col4'><?php echo $model -> felvetel_ideje; ?></td>
	<tr>
	<tr>
		<td style='width: 120px;'><strong>Cég neve: </strong></td>
		<td class = 'col2'><?php echo $model -> szallitas_cegnev; ?></td>
		<td class = 'col3'>&nbsp;</td>
		<td class = 'col4'>&nbsp;</td>
	<tr>
	<tr>
		<td style='width: 120px;'><strong>Szállítási cím: </strong></td>
		<td colspan="3" class = 'col2'><?php echo $model -> szallitas_cim; ?></td>
	<tr>
	<tr>
		<td style='width: 120px;'><strong>Telefonszám: </strong></td>
		<td class = 'col2'><?php echo $model -> szallitas_telefonszam; ?></td>
		<td class = 'col3'>&nbsp;</td>
		<td class = 'col4'>&nbsp;</td>
	<tr>
</table>

<!-- Számla tételek táblázat -->
<table class = "table_tetelek">
	<tr>
		<td class = 'col1'><strong>Áru megnevezése</strong></td>
		<td class = 'col2' style="border-left:0px;"><strong>Mennyisége</strong></td>
	<tr>

	<?php
	foreach ($model->tetelek as $tetel) {
		echo "
				<tr>
					<td style='border-left:0px;border-right:0px'>$tetel->megnevezes</td>
					<td style='border-left:0px;border-right:0px'><br /> $tetel->darab</td>
				</tr>
			";
	}
	?>
</table>

<table style='border: 0px'>
	<tr>
		<td colspan="4"><strong>Ügyfél fizetési módja</strong></td>
	</tr>

	<tr>
		<td class = 'col1'><strong><img src='images/<?php echo $model->fizetesi_mod == 3 ? 'checkbox_checked.jpg' : 'checkbox_unchecked.jpg'; ?>' /> Átutalás</strong></td>
		<td class = 'col2'>&nbsp;</td>
		<td class = 'col3'><strong><img src='images/<?php echo $model->fizetesi_mod == 5 ? 'checkbox_checked.jpg' : 'checkbox_unchecked.jpg'; ?>' /> Utánvét</strong></td>
		<td class = 'col4'>&nbsp;</td>
	<tr>
	<tr>
		<td class = 'col1'>&nbsp;</td>
		<td class = 'col2'>&nbsp;</td>
		<td class = 'col3'><strong>Utánvétösszeg: </strong></td>
		<td class = 'col4'><?php echo number_format($model -> utanvet_osszeg , 2) ; ?> Ft</td>
	<tr>
	<tr>
		<td class = 'col1'>&nbsp;</td>
		<td class = 'col2'>&nbsp;</td>
		<td class = 'col3'><strong>Visszahozás dátuma: </strong></td>
		<td class = 'col4'><?php echo $model->utanvet_visszahozas_datum != '0000-00-00 00:00:00' ? $model -> utanvet_visszahozas_datum : '';?></td>
	<tr>
	<tr>
		<td class = 'col1'>&nbsp;</td>
		<td class = 'col2'>&nbsp;</td>
		<td class = 'col3'><strong>Bizonylat száma: </strong></td>
		<td class = 'col4'><?php echo $model -> bizonylatszam;?></td>
	<tr>
	<tr>
		<td class = 'col1'>&nbsp;</td>
		<td class = 'col2'>&nbsp;</td>
		<td class = 'col3'><strong>Aláírás: </strong></td>
		<td class = 'col4'>............................</td>
	<tr>

	<tr>
		<td colspan="4"><strong>Egyéb információk:</strong></td>
	</tr>
	<tr>
		<td colspan="4"><?php echo $model -> egyeb_info;?></td>
	</tr>
	<tr>
		<td colspan="4"><strong>Szállítás díja: </strong> <?php echo number_format($model -> szallitas_dij , 2) ; ?> Ft</td>
	</tr>
</table>


	<!-- Aláírás szekció kiírása -->
	<p style='margin-top:30px;font-size:8pt'>
	<table style='border:0px'>
		<tr>
			<td>Dátum: <?php echo date('Y.m.d'); ?></td>
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
			<td align=center>Futár aláírása</td>
			<td></td>
			<td align=center>Ügyintéző aláírása</td>
		</tr>
	</table>
	</p>
	
</div>

<htmlpagefooter name="myFooter2" style="display:none">
<p style='font-family:arial; font-size: 10pt'>
	<?php echo nl2br(Yii::app()->config->get('SzallitoFutarlevel')); ?>
</p>

<table width="100%" class = "table_footer" style="vertical-align: bottom; font-family: arial; font-size: 8pt; color: #000000;">
	<tr>
		<td width="50%"> <span> <?php echo "Nyomtatva: " . date('Y.m.d h:m:s'); ?> </span> </td>
		<td width="50%" style="text-align: right; "> {PAGENO} .oldal </td>
    </tr>
</table>
</htmlpagefooter>

</html>
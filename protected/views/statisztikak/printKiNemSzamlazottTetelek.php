<?php
	$actualUserName = '';
	$actualUser = User::model()->findByPk(Yii::app()->user->getId());
	
	if ($actualUser != null) {
		$actualUserName	= $actualUser->fullname;
	}
	
	$ugyfel = null;
	if ($model->ugyfel_id != null) {
		$ugyfel = Ugyfelek::model()->findByPk($model->ugyfel_id);
	}
	
	$stat_type = $model->stat_type_filter == 'nem_kerult_szallitora' ? 'tételek, melyek még nem kerültek szállítólevélre (de megrendeléseikhez akár készülhetett már számla)' : 'tételek, melyek megrendeléseihez egyáltalán nem készült még szállítólevél';
?>

<html>
<head></head>

<style>
	div {
		font-family: arial;
		font-size: 9pt;
	}
	.under {
		border-bottom: 4px double #000000;
	}
	table {
/*		border: 1px solid #000000;*/
		padding: 0px;
		font-family: arial;
		font-size: 8pt;
		border-spacing: 0px;
	}
	.fejlec1 {
		border: 0px;
		width: 700px;
	}
	td.statisztika_fejlec_cim {
		font-size: 12pt;
		text-align: left ;
	}
	td.statisztika_fejlec_idoszak {
		font-size: 10pt;
		text-align: right;
	}
	table.statisztika_tablazat {
/*		border: solid 2px black;*/
		padding: 0px;
		margin: 3px 0px 0px 0px ;
		width: 700px;
	}
	td.cim_cella {
		font-weight: bold;
	}
	.cim_cella_kisbetu {
		font-size:8px;
	}
	.adat_cella_kisbetu {
		font-size:8px;
	}
	.cim_cella_kozepesbetu {
		font-size:10px;
	}
	.adat_cella_kozepesbetu {
		font-size:10px;
	}
	table.statisztika_belso_tablazat_fel_szelesseg {
		width: 350px;
		padding: 0px;
		margin: 0px ;
		border: none;
	}
	table.statisztika_belso_tablazat_teljes_szelesseg {
		width: 700px;
		padding: 0px;
		margin: 0px ;
		border: none;
	}
	.szegely_fent {
		border-top: solid 1px black ;
	}
	.szegely_jobb {
		border-right: solid 1px black ;
	}
	.szegely_alul {
		border-bottom: solid 1px black ;
	}
	.szegely_bal {
		border-left: solid 1px black ;
	}
	.nincs_szegely {
		border: none ;
	}
	.kozepre {
		text-align: center ;
	}
	.jobbra {
		text-align: right ;
	}
	.dolt {
		font-style: italic ;
	}


	.table_footer {
		border: 0px;
	}
	@page {
		margin-top: 10px;
		size: auto;
		odd-footer-name: html_myFooter2;
		even-footer-name: html_myFooter2;
	}
</style>

<div style='text-align:center'>
	<h1> <span class='under'>Ki nem számlázott tételek</span> </h1>
</div>

<p style='text-align:center'>
	<strong> Lekért időszak: <?php echo $model -> statisztika_mettol . ' - ' . $model -> statisztika_meddig; ?> </strong>
</p>

<?php if ($ugyfel != null): ?>
	<p style='text-align:center'>
		<strong> Vásárló neve: <?php echo $ugyfel -> cegnev; ?> </strong>
	</p>
<?php endif; ?>

<p style='text-align:center'>
	<strong> Statisztika típusa: <?php echo $stat_type; ?> </strong>
</p>

<table class="statisztika_tablazat">
	<tr>
		<td class="cim_cella" style="width: 55px;">Megrendelő neve</td>
		<td class="cim_cella" style="width: 100px;">Rendelés azonosító</td>
		<td class="cim_cella" style="width: 130px;">Rendelés időpontja</td>
		<td class="cim_cella" style="width: 75px;">Termék neve</td>
		<td class="cim_cella" style="width: 75px;">Cikkszám</td>
		<td class="cim_cella" style="width: 75px;">Darabszám</td>
		<td class="cim_cella" style="width: 75px;">Munka neve</td>
		<td class="cim_cella" style="width: 75px;" align='right'>Érték (Ft)</td>
	</tr>

	<?php
		if (count($megrendelesTetelek) > 0) {
			foreach ($megrendelesTetelek as $tetel) {
	?>
				<tr>
					<td class="cim_cella szegely_felul szegely_alul"><?php echo $tetel["megrendelo_neve"];?></td>
					<td class="cim_cella szegely_felul szegely_alul"><?php echo $tetel["megrendeles_azonosito"];?></td>
					<td class="cim_cella szegely_felul szegely_alul"><?php echo $tetel["megrendeles_idopontja"];?></td>
					<td class="cim_cella szegely_felul szegely_alul"><?php echo $tetel["termek_neve"];?></td>
					<td class="cim_cella szegely_felul szegely_alul"><?php echo $tetel["cikkszam"];?></td>
					<td class="cim_cella szegely_felul szegely_alul"><?php echo $tetel["darabszam"];?></td>
					<td class="cim_cella szegely_felul szegely_alul"><?php echo $tetel["munka_neve"];?></td>
					<td class="cim_cella szegely_felul szegely_alul" align='right'><?php echo $tetel["ertek"];?></td>
				</tr>
	<?php
		}}
	?>

</table>
<htmlpagefooter name="myFooter2" style="display:none">

<table width="100%" class = "table_footer" style="vertical-align: bottom; font-family: arial; font-size: 8pt; color: #000000;">
	<tr>
		<td width="40%"> <span> <?php echo "Lista nyomtatva: " . date('Y-m-d H:i:s'); ?> </span> </td>
		<td width='20%'> <?php echo $actualUserName; ?> </td>
		<td width="40%" style="text-align: right; "> {PAGENO} .oldal </td>
    </tr>
</table>
</htmlpagefooter>

</html>
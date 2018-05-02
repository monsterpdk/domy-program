<?php
$actualUserName = '';
$actualUser = User::model()->findByPk(Yii::app()->user->getId());
if ($actualUser != null) {
	$actualUserName	= $actualUser->fullname;
}

?>

<html>
<head></head>

<style>
	div {
		font-family: arial;
		font-size: 10pt;
	}
	.under {
		border-bottom: 4px double #000000;
	}
	table.items {
		border-bottom: 1px solid #000000;
		border-left-style: none ;
		border-right-style: none ;
		border-top-style: none ;
		font-family: arial;
		font-size: 11pt;
		width: 100%;
		padding: 4px ;
		border-spacing: 0px;
		border-collapse: separate;
		box-decoration-break: clone;
	}
	img {
		margin: 0px;
		padding: 0px;
	}

	#utemezes_grid1 table.items th, #utemezes_grid1 table.items td {
		border-bottom: 1px solid gray;
	}
	#utemezes_grid1 table.group-grid-view th {
		background-color: silver ;
		text-align: center;
	}

	.blokk_table {
		width: 100% ;
		border-style: none ;
		page-break-inside:avoid;
	}

	.blokk_table td {
		border-style: none ;
		font-size: 9pt;
	}

	.keretes_CTP_input {
		border: 1px solid #000000;
	}

	.taska_kisbetu {
		font-size: 11pt;
	}

	.kisbetu {
		font-size: 11pt;
	}

	.utemezes_elso_oszlop {
		width:100px;
		text-align:left;
	}

	.utemezes_cegnev {
		text-align: left;
	}

	.utemezes_ctp_film {
		text-align: right;
	}

	.utemezes_ctp_input_td {
		/*		border: 1px solid #000000;
                width:50px;*/
	}

	@page {
		margin-top: 10px;
		size: auto;
		odd-footer-name: html_myFooter2;
		even-footer-name: html_myFooter2;
		margin: 5%;
	}
</style>

<div style='text-align:center'>
	<h1> <span class='under'>Rendelés ajánlás</span> </h1>
</div>

<?php
$this->widget('ext.groupgridview.BootGroupGridView', array(
	'id' => 'rendeles_ajanlas_grid1',
	'itemsCssClass'=>'items group-grid-view',
	'dataProvider' => $dataProvider,
//      'maxMergedRows' => 5,
	'columns' => array(
		array(
			'name'=>'megrendeles_tetel.termek.gyarto.cegnev',
			'header'=>$nyomdakonyv_model->getAttributeLabel('megrendeles_tetel.termek.gyarto.cegnev'),
			'headerHtmlOptions'=>array('style'=>'width:90px;text-align:left;'),
			'htmlOptions'=>array('style'=>'text-align:left;'),
		),
		array(
			'name'=>'megrendeles_tetel.megrendelt_termek_nev',
			'header'=>$nyomdakonyv_model->getAttributeLabel('megrendeles_tetel.megrendelt_termek_nev'),
			'headerHtmlOptions'=>array('style'=>'width:250px;text-align:left;'),
			'htmlOptions'=>array('style'=>'text-align:left;'),
		),
		array(
			'name'=>'megrendeles_tetel.DarabszamFormazott',
			'header'=>$nyomdakonyv_model->getAttributeLabel('megrendeles_tetel.DarabszamFormazott'),
			'headerHtmlOptions'=>array('style'=>'width:60px;text-align:center;'),
			'htmlOptions'=>array('style'=>'text-align:right;'),
		),
		array(
			'name'=>'hianyzoDarabszamFormazott',
			'header'=>$nyomdakonyv_model->getAttributeLabel('hianyzoDarabszamFormazott'),
			'headerHtmlOptions'=>array('style'=>'width:60px;text-align:center;'),
			'htmlOptions'=>array('style'=>'text-align:right;'),
		),
		array(
			'name'=>'taskaszam',
			'header'=>$nyomdakonyv_model->getAttributeLabel('taskaszam'),
			'headerHtmlOptions'=>array('style'=>'width:110px;text-align:center;'),
			'htmlOptions'=>array('style'=>'text-align:center;'),
		),
		array(
			'name'=>'megrendeles_tetel.munka_neve',
			'header'=>$nyomdakonyv_model->getAttributeLabel('megrendeles_tetel.munka_neve'),
			'headerHtmlOptions'=>array('style'=>'width:110px;text-align:left;'),
			'htmlOptions'=>array('style'=>'text-align:left;'),
		),
		array(
			'name'=>'megrendeles_tetel.megrendeles.ugyfel.cegnev',
			'header'=>$nyomdakonyv_model->getAttributeLabel('megrendeles_tetel.megrendeles.ugyfel.cegnev'),
			'headerHtmlOptions'=>array('style'=>'width:170px;text-align:left;'),
			'htmlOptions'=>array('style'=>'text-align:left;'),
		),
		array(
			'name'=>'HataridoFormazott',
			'header'=>$nyomdakonyv_model->getAttributeLabel('HataridoFormazott'),
			'htmlOptions'=>array('style'=>'text-align:left;'),
		),
	),
));
?>

<htmlpagefooter name="myFooter2" style="display:none">
	<p style='font-family:arial; font-size: 10pt'>
		<?php echo nl2br(Yii::app()->config->get('RendelesAjanlas')); ?>
	</p>

	<table width="100%" class = "table_footer" style="vertical-align: bottom; font-family: arial; font-size: 8pt; color: #000000;">
		<tr>
			<td width="40%"> <span> <?php echo "Lista nyomtatva: " . date('Y-m-d H:i:s'); ?> </span> </td>
			<td width='20%'> <?php echo $actualUserName; ?> </td>
			<td width="40%" style="text-align: right; "> {PAGENO} .oldal </td>
		</tr>
	</table>
</htmlpagefooter>

</html>
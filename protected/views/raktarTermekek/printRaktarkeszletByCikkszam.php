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
		border: solid thin gray;
		font-family: arial;
		font-size: 10pt;
		width: 100%;
		padding: 2px ;
		border-spacing: 1px;
		border-collapse: separate;	
		box-decoration-break: clone;
		background-color: silver ;
	}
	
	table.items th {
		color: black ;
	}
	
	table.items td {
		border-right: 2px solid #000000;
		padding: 2px ;
		background-color: white ;
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
	<h1> <span class='under'>Raktárkészlet cikkszám szerint</span> </h1>
</div>

<?php
	$cikkszamok = $_GET['cikkszamok'];
	// minden szóköz, tab, új sor karakter törlése
	if (isset($cikkszamok)) {
		$cikkszamok = preg_replace('/\s+/S', '', $cikkszamok);
	}
	$cikkszamokLista = (isset($cikkszamok)) ? explode(",", $cikkszamok) : array();
	
	$tisztitottCikkszamokList = "";
	foreach ($cikkszamokLista as $cikkszam) {
		if (strlen(trim($cikkszam)) > 0) {
			$tisztitottCikkszamokList .= ((strlen($tisztitottCikkszamokList) > 0) ? ", " : "") . $cikkszam;
		}
	}

	$gyarto = $_GET['gyarto_id'];
		
	// kiválasztott cikkszámok kiírása a riportra
	if (isset($tisztitottCikkszamokList) && strlen($tisztitottCikkszamokList) > 0) {
		echo "<div style='padding-bottom:15px'><strong>Kiválasztott cikkszámok: </strong> " . $tisztitottCikkszamokList . "</div>";
	}
	
	// kiválasztott gyártó kiírása a riportra
	if (isset($gyarto) && strlen($gyarto) > 0) {
		$gyartoRekord = Gyartok::model()->findByPk($gyarto);
		
		if ($gyartoRekord != null) {
			echo "<div style='padding-bottom:15px'><strong>Kiválasztott gyártó: </strong> " . $gyartoRekord ->cegnev . "</div>";
		}
	}	
?>

<?php
    $this->widget('ext.groupgridview.BootGroupGridView', array(
      'id' => 'raktar_termekek_grid',
      'itemsCssClass'=>'items group-grid-view',
      'dataProvider' => $dataProvider,
      'enablePagination' => false,
      'enableSorting' => false,
      'summaryText' => '',
      'extraRowPos' => 'above',
      'columns' => array(
						array(
							'name' => 'Cikkszám',
							'type' => 'raw',
							'value' => 'CHtml::encode($data["cikkszam"])'
                        ),
						array(
							'name' => 'Termék neve',
							'type' => 'raw',
							'value' => 'CHtml::encode($data["termek_neve"])'
                        ),
						array(
							'name' => 'Cégnév',
							'type' => 'raw',
							'value' => 'CHtml::encode($data["cegnev"])'
                        ),
						array('name' => 'Összes db', 'value' => 'Utils::DarabszamFormazas($data["osszes_db"])', 'htmlOptions' => array('style' => 'text-align: right;')),
						array('name' => 'Foglalt db', 'value' => 'Utils::DarabszamFormazas($data["foglalt_db"])', 'htmlOptions' => array('style' => 'text-align: right;')),
						array('name' => 'Elérhető db', 'value' => 'Utils::DarabszamFormazas($data["elerheto_db"])', 'htmlOptions' => array('style' => 'text-align: right;')),
						array('name' => 'Nettó darabár (átlag) Ft', 'value' => 'Utils::OsszegFormazas($data["netto_darabar"])', 'htmlOptions' => array('style' => 'text-align: right;')),
						array('name' => 'Érték (Ft)', 'value' => 'Utils::DarabszamFormazas($data["ertek"])', 'htmlOptions' => array('style' => 'text-align: right;')),
      ),
	  
    ));
?>	

<?php
	// összesítés kiírása a riport aljára
	echo "<div align='right' style='padding-top:15px'><strong>Összesen db: </strong> " . Utils::DarabszamFormazas($osszesen_db) . "</div>";
	echo "<div align='right' style='padding-top:15px'><strong>Összesen ft: </strong> " . Utils::DarabszamFormazas($osszesen_ft) . "</div>";
?>

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
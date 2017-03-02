<?php
	$actualUserName = '';
	$actualUser = User::model()->findByPk(Yii::app()->user->getId());
	
	if ($actualUser != null) {
		$actualUserName	= $actualUser->fullname;
	}
	
	$gyarto = null;
	if ($model -> gyarto_id != null && $model -> gyarto_id != "") {
		$gyarto = Gyartok::model()->findByPk ($model -> gyarto_id);
	}
?>

<html>
<head></head>

<style>
	p, div {
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
	<h1> <span class='under'>Beszállítói statisztika</span> </h1>
</div>

<p style='text-align:center'>
	<strong> Lekért időszak: <?php echo $model -> statisztika_mettol . ' - ' . $model -> statisztika_meddig; ?> </strong>
</p>

<?php if ($gyarto != null): ?>
	<p style='text-align:center'>
		<strong> Gyártó: <?php echo $gyarto -> cegnev; ?> </strong>
	</p>
<?php endif; ?>

<?php
    $this->widget('ext.groupgridview.BootGroupGridView', array(
      'id' => 'beszallitoi_statisztika_grid',
      'itemsCssClass'=>'items group-grid-view',
      'dataProvider' => $dataProvider,
      //'mergeColumns' => array('ev', 'ho', 'gyarto'),
      'maxMergedRows' => 15,
	  'mergeType' => 'simple',
      'enablePagination' => false,
      'enableSorting' => false,
      'columns' => array(
						array(
						   'header'=>'Év',
						   'name'=>'ev',
						),
						array(
						   'header'=>'Hónap',
						   'name'=>'ho',
						),
						array(
						   'header'=>'Gyártó',
						   'name'=>'gyarto',
						),
						array(
						   'header'=>'Terméknév',
						   'name'=>'termek_nev',
						),
						array(
						   'header'=>'Beszerzési érték (Ft)',
						   'name'=>'osszeg',
						   'htmlOptions'=>array('style' => 'text-align: right;'),
						),
						array(
						   'header'=>'Beszerzési darabszám',
						   'name'=>'darabszam',
						   'htmlOptions'=>array('style' => 'text-align: right;'),
						),
						array(
						   'header'=>'Eladási érték (Ft)',
						   'name'=>'eladas_osszeg',
						   'htmlOptions'=>array('style' => 'text-align: right;'),
						),
						array(
						   'header'=>'Eladott darabszám',
						   'name'=>'eladas_darabszam',
						   'htmlOptions'=>array('style' => 'text-align: right;'),
						),
						array(
						   'header'=>'Haszon (ft)',
						   'name'=>'haszon',
						   'htmlOptions'=>array('style' => 'text-align: right;'),
						),
					),
    ));

?>	

<p align='right'>
	<strong>Összes beszerzési érték: <?php echo $osszesBeszerzesiErtek; ?> Ft</strong>
</p>

<p align='right'>
	<strong>Összes eladási érték: <?php echo $osszesEladasiErtek; ?> Ft</strong>
</p>

<p align='right'>
	<strong>Összes haszon: <?php echo $osszesHaszon; ?> Ft</strong>
</p>

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
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
	<h1> <span class='under'>Raktárkészlet</span> </h1>
</div>

<?php
    $this->widget('ext.groupgridview.BootGroupGridView', array(
      'id' => 'raktar_termekek_grid',
      'itemsCssClass'=>'items group-grid-view',
      'dataProvider' => $dataProvider,
      'enablePagination' => false,
      'enableSorting' => false,
      'summaryText' => '',
      'extraRowColumns' => array('raktarHelyek.raktar.nev'),
      'mergeColumns' => array('raktarHelyek.raktar.nev', 'raktarHelyek.nev'),
      'extraRowPos' => 'above',
      'maxMergedRows' => 12,
      'columns' => array(
						array(
							'class' => 'bootstrap.widgets.TbButtonColumn',
							'htmlOptions'=>array('style'=>'width: 30px; text-align: left;'),
						),
      	  				'raktarHelyek.raktar.nev',
						'raktarHelyek.nev',
						'anyagbeszallitas.bizonylatszam',
						'anyagbeszallitas.beszallitas_datum',
						'termek.DisplayTermekTeljesNev',
						'osszes_db:number',
						'foglalt_db:number',
						'elerheto_db:number',
      ),
	  
    ));
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
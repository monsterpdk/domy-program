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
		padding: 2px ;
		border-spacing: 0px;
		border-collapse: separate;	
		box-decoration-break: clone;
	}
	img {
		margin: 0px;
		padding: 0px;
	}
	
	.utemezes-grid table.items th, .utemezes-grid table.items td {
		border-bottom: 1px solid gray;
    }
	.utemezes-grid table.group-grid-view th {
		background-color: silver ;
		text-align: center;
	}

	p.utemezes_munkatipus_nev {
		margin-bottom: 0px;
		font-size: 1.2em;
		background-color: #c4e3f3;
		padding: 2px 2px 2px 5px;
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
	<h1> <span class='under'>Nyomdakönyv ütemezés</span> </h1>
</div>

<?php
	if (count($eredmenyek) > 0) {
		$i = -1;
		foreach ($eredmenyek as $munkatipus_nev => $dataProvider) {
			$i++;
			echo '<p class="utemezes_munkatipus_nev">Munkatípus: ' . $munkatipus_nev . '</p>';
			$this->widget('ext.groupgridview.BootGroupGridView', array(
				'id' => 'utemezes_grid' . $i,
				'htmlOptions' => array('class' => 'grid-view utemezes-grid'),
				'itemsCssClass' => 'items group-grid-view',
				'dataProvider' => $dataProvider,
				'extraRowColumns' => array('HataridoFormazott'),
				'mergeColumns' => array('HataridoFormazott'),
				'extraRowPos' => 'above',
				'maxMergedRows' => 10,
				'columns' => array(
					array(
						'name' => 'HataridoFormazott',
						'headerHtmlOptions' => array('style' => 'width:170px;'),
					),
					array(
						'name' => 'UtemezesBejegyzesPrint',
						'type' => 'raw',
						/*							'headerHtmlOptions'=>array('style'=>'width: 800px;'),*/
					),
				),
			));
		}
	}
?>

<htmlpagefooter name="myFooter2" style="display:none">
<p style='font-family:arial; font-size: 10pt'>
	<?php echo nl2br(Yii::app()->config->get('NyomdakonyvUtemezes')); ?>
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
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

<?php $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template' => '{items}',
	'columns'=>array(
					'raktar.nev',
					'raktar.tipus',
					'termek.DisplayTermekTeljesNev',
					array (
                        'name' => 'osszes_db',
                        'value'=>function($data){
							return Utils::DarabszamFormazas($data->osszes_db);
						},
                        'htmlOptions' => array ('style' => 'text-align: right;' ),
                    ),
					array (
                        'name' => 'foglalt_db',
                        'value'=>function($data){
							return Utils::DarabszamFormazas($data->foglalt_db);
						},
                        'htmlOptions' => array ('style' => 'text-align: right;' ),
                    ),
					array (
                        'name' => 'elerheto_db',
                        'value'=>function($data){
							return Utils::DarabszamFormazas($data->elerheto_db);
						},
                        'htmlOptions' => array ('style' => 'text-align: right;' ),
                    ),
				),
	'enableSorting' => false,
)); ?>

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
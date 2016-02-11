<?php
/* @var $this StatisztikaController */

$this->breadcrumbs=array(
	'Napi kombinált statisztika',
);

$this->menu=array(
	array('label'=>'Statisztika', 'url'=>array('admin')),
);
?>

<h1>Napi kombinált statisztika</h1>

<?php	
	$this->widget('zii.widgets.jui.CJuiButton', array(
		'name'=>'button_print_statisztika',
		'caption'=>'Statisztika nyomtatás',
		'buttonType'=>'link',
//		'onclick'=>'openPrintDialog()',
		'url'=>Yii::app()->createUrl("statisztika/printNapiKombinaltStatisztika"),
		'htmlOptions'=>array('class'=>'btn btn-success','target'=>'_blank'),
	));
?>

<?php
   echo "aaaa" ;
?>
    
<?php	
	$this->widget('zii.widgets.jui.CJuiButton', array(
		'name'=>'button_print_statisztika',
		'caption'=>'Statisztika nyomtatás',
		'buttonType'=>'link',
//		'onclick'=>'openPrintDialog()',
		'url'=>Yii::app()->createUrl("statisztika/printNapiKombinaltStatisztika"),
		'htmlOptions'=>array('class'=>'btn btn-success','target'=>'_blank'),
	));
?>


<script type="text/javascript">
		function openPrintDialog () {		
			window.open("/index.php/statisztika/printNapiKombinaltStatisztika","_blank") ;
		}
</script>
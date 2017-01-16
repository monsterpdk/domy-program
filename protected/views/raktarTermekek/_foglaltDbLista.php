<?php
	$cs = Yii::app()->clientScript;
	$cs -> scriptMap=array(
		'jquery.js'=>false
	);
?>

<div class="form">

<?php

	/* CGRIDVIEW */
	$this->widget('zii.widgets.grid.CGridView', 
	   array( 'id'=>'foglalt-db-lista-grid' . $grid_id,
			  'dataProvider'=>$dataProvider,
			  'selectableRows'=>1,
			  'columns'=>array(
						array(
							'class'=>'CLinkColumnEval',
							'header'=>'Megrendelés sorszáma',
							'labelExpression'  => '$data["sorszam"]',
							'urlExpression' => 'Yii::app()->createUrl("megrendelesek/index",array("id"=>$data["megrendelesek_id"]))',
							'linkHtmlOptions' => array('style'=>'"text-decoration:underline"', 'target'=>"'_blank'"),
						),						
						array(
							'name' => 'nev',
							'header' => 'Termék neve',
						),
						array(
							'name' => 'munka_neve',
							'header' => 'Munka neve',
						),
						array(
							'name' => 'taskaszam',
							'header' => 'Táskaszám',
						),
						array(
							'name' => 'darabszam',
							'header' => 'Foglalt darabszám',
						),
					  ),
			));

?>

</div><!-- form -->
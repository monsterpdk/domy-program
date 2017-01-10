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
							'termek.DisplayTermekTeljesNev',
							'anyagbeszallitas.bizonylatszam',
							'anyagbeszallitas.beszallitas_datum',
							'foglalt_db:number',
							  ),
			));

?>

</div><!-- form -->
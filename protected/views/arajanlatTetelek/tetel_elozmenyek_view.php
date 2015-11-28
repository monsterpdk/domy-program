<?php
/* @var $this ArajanlatTetelekController */
/* @var $model ArajanlatTetelek */

?>

<h1>Árajánlat előzmények</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_tetel_elozmenyek_view',
)); ?> 

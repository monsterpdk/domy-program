<?php
/* @var $this FizetesiModokController */
/* @var $model FizetesiModok */

$this->breadcrumbs=array(
	'Fizetési módok'=>array('index'),
	$model->id,
);

?>

<h1>'<?php echo $model->nev; ?>' fizetési mód adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'nev',
			'szamlazo_azonosito',
			'fizetesi_hatarido',
			array(
				'name' => 'torolt',
				'type'=>'boolean',
				'value' => $model->torolt,
				'visible' => Yii::app()->user->checkAccess('Admin'),
			),
		),
	)); ?>
</p>

<p>
	<?php echo CHtml::button('Vissza', array('submit' => Yii::app()->request->urlReferrer)); ?>
</p>

<?php
	$this->widget( 'application.modules.auditTrail.widgets.portlets.ShowAuditTrail', array( 'model' => $model, ) );
?>
<?php
/* @var $this GyartokController */
/* @var $model Gyartok */

$this->breadcrumbs=array(
	'Gyartók'=>array('index'),
	$model->id,
);

?>

<h1>'<?php echo $model->cegnev; ?>' gyártó adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'cegnev',
			'kapcsolattarto',
			'cim',
			'telefon',
			'fax',
			'netto_ar:boolean',
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
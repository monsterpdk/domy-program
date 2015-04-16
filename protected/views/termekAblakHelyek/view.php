<?php
/* @var $this TermekAblakHelyekController */
/* @var $model TermekAblakHelyek */

$this->breadcrumbs=array(
	'Ablakhelyek'=>array('index'),
	$model->id,
);
?>

<h1>'<?php echo $model->nev; ?>' ablakhely adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'nev',
			'hely',
			'x_pozicio_honnan',
			'x_pozicio_mm:number',
			'y_pozicio_honnan',
			'y_pozicio_mm:number',
			'aktiv:boolean',
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
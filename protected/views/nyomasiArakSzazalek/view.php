<?php
/* @var $this NyomasiArakSzazalekController */
/* @var $model NyomasiArakSzazalek */

$this->breadcrumbs=array(
	'Nyomási árak %'=>array('index'),
	$model->id,
);

?>

<h1>'<?php echo $model->id; ?>' nyomási termékár adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'peldanyszam_tol',
			'peldanyszam_ig',
			'alap:number',
			'kp:number',
			'utal:number',
			'kis_tetel:number',
			'nagy_tetel:number',
			'user.username',
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
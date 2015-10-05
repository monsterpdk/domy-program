<?php
/* @var $this NyomdagepTipusokController */
/* @var $model NyomdagepTipusok */
?>

<h1>'<?php echo $model->tipusnev; ?>' nyomdagép típus adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'gep.gepnev',
			'tipusnev',
			'fordulat_kis_boritek',
			'fordulat_nagy_boritek',
			'fordulat_egyeb',
			'szinszam_tol',
			'szinszam_ig',
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
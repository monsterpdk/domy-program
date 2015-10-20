<?php
/* @var $this NyomdaMuveletNormaarakController */
/* @var $model NyomdaMuveletNormaarak */
?>

<h1>'<?php echo $model->id; ?>' művelet ár adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'muvelet.muvelet_nev',
			'gep.gepnev',
			'oradij',
			'szazalek_tol',
			'szazalek_ig',
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
<?php
/* @var $this NyomdaMuveletekController */
/* @var $model NyomdaMuveletek */
?>

<h1>'<?php echo $model->muvelet_nev; ?>' művelet adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'gep.gepnev',
			'muvelet_nev',
			'elokeszites_ido',
			'muvelet_ido',
			'szinszam_tol',
			'szinszam_ig',
			'megjegyzes',
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
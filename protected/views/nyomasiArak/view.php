<?php
/* @var $this NyomasiArakController */
/* @var $model NyomasiArak */

$this->breadcrumbs=array(
	'Nyomási árak'=>array('index'),
	$model->id,
);

?>

<h1>'<?php echo $model->id; ?>' nyomási ár adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'kategoria_tipus',
			'boritek_fajtak',
			'lehetseges_szinek',
			'peldanyszam_tol',
			'peldanyszam_ig',
			'szin_egy:number',
			'szin_ketto:number',
			'szin_harom:number',
			'szin_tobb:number',
			'grafika',
			'grafika_roviden',
			'megjegyzes',
			'ervenyesseg_tol',
			'ervenyesseg_ig',
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
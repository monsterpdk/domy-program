<?php
/* @var $this AfaKulcsokController */
/* @var $model AfaKulcsok */

$this->breadcrumbs=array(
	'ÁFA kulcsok'=>array('index'),
	$model->id,
);

?>

<h1>'<?php echo $model->nev; ?>' ÁFA kulcs adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'nev',
			'afa_szazalek',
			'alapertelmezett:boolean',
			array(
				'name' => 'torolt',
				'type'=>'boolean',
				'value' => $model->torolt,
				'visible' => Yii::app()->user->checkAccess('Admin'),
			),
		),
	)); ?>

<p>
	<?php echo CHtml::button('Vissza', array('submit' => Yii::app()->request->urlReferrer)); ?>
</p>

<?php
	$this->widget( 'application.modules.auditTrail.widgets.portlets.ShowAuditTrail', array( 'model' => $model, ) );
?>
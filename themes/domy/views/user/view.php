<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Felhasználók'=>array('index'),
	$model->id,
);
?>

<h1><?php echo $model->username; ?> felhasználó adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'fullname',
			'username',
			'email',
		),
	)); ?>
</p>

<p>
	<?php echo CHtml::button('Vissza', array('submit' => Yii::app()->request->urlReferrer)); ?>
</p>

<?php
	$this->widget( 'application.modules.auditTrail.widgets.portlets.ShowAuditTrail', array( 'model' => $model, ) );
?>

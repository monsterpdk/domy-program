<?php
/* @var $this AruhazakController */
/* @var $model Aruhazak */

$this->breadcrumbs=array(
	'Áruházak'=>array('index'),
	$model->id,
);

?>

<h1>'<?php echo $model->aruhaz_nev; ?>' áruház adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'kod',
			'aruhaz_nev',
			'aruhaz_url',
			'arkategoria.nev',
			'ingyen_szallitas:boolean',
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
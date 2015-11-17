<?php
/* @var $this UgyfelUgyintezokController */
/* @var $model UgyfelUgyintezok */

$this->breadcrumbs=array(
	'Ügyfélügyintézők'=>array('index'),
	$model->id,
);

?>

<h1><?php echo $model->nev; ?> ügyfélügyintéző adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'ugyfel.cegnev',
			'nev',
			'telefon',
			'email',
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
	<?php $this->widget('zii.widgets.jui.CJuiButton', 
			 array(
				'name'=>'back',
				'caption'=>'Vissza',
				'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => Yii::app()->request->urlReferrer),
			 )); ?>
</p>

<?php
	$this->widget( 'application.modules.auditTrail.widgets.portlets.ShowAuditTrail', array( 'model' => $model, ) );
?>
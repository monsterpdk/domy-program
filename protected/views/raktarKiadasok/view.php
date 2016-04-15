<?php
/* @var $this RaktarKiadasokController */
/* @var $model RaktarKiadasok */
?>

<h1>'<?php echo $model->id; ?>' raktár kiadás adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'termek.DisplayTermekTeljesNev',
			'darabszam',
			'nyomdakonyv.taskaszam',
			array(
				'name' => 'sztornozva',
				'type'=>'boolean',
				'value' => $model->sztornozva,
				'visible' => Yii::app()->user->checkAccess('Admin'),
			),
		),
	)); ?>

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
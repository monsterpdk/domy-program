<?php
/* @var $this TermekArakController */
/* @var $model TermekArak */

$this->breadcrumbs=array(
	'Termékárak'=>array('index'),
	$model->id,
);

?>

<h1>'<?php echo $model->id; ?>' termékár adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'termek_id',
			'db_beszerzesi_ar:number',
			'csomag_ar_szamolashoz:number',
			'csomag_ar_nyomashoz:number',
			'db_ar_nyomashoz:number',
			'csomag_eladasi_ar:number',
			'db_eladasi_ar:number',
			'datum_mettol',
			'datum_meddig',
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
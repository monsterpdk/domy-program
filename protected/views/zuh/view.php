<?php
/* @var $this ZuhController */
/* @var $model Zuh */
?>

<h1>'<?php echo $model->id; ?>' zuh adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'nyomasi_kategoria',
			'db_tol',
			'db_ig',
			'szin_1_db',
			'szin_2_db',
			'szin_3_db',
			'tobb_szin_db',
			'szin_1_szazalek',
			'szin_2_szazalek',
			'szin_3_szazalek',
			'tobb_szin_szazalek',
			'aruhaz.display_aruhazkod_nev',
			'megjegyzes',
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
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
				array(
						'name'=>'szin_egy',
						'value'=>function($data){
							return number_format($data->szin_egy, 2);
						},					
				),
				array(
						'name'=>'szin_ketto',
						'value'=>function($data){
							return number_format($data->szin_ketto, 2);
						},					
				),
				array(
						'name'=>'szin_harom',
						'value'=>function($data){
							return number_format($data->szin_harom, 2);
						},					
				),
				array(
						'name'=>'szin_tobb',
						'value'=>function($data){
							return number_format($data->szin_tobb, 2);
						},					
				),
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
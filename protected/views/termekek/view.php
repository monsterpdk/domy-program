<?php
/* @var $this TermekekController */
/* @var $model Termekek */

$this->breadcrumbs=array(
	'Termékek'=>array('index'),
	$model->id,
);

?>

<h1>'<?php echo $model->nev; ?>' termék adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'nev',
			'tipus',
			'kodszam',
			'cikkszam',
			'meret.nev',
			'suly:number',
			'zaras.nev',
			'ablakmeret.nev',
			'ablakhely.nev',
			'papirtipus.FullName',
			'afakulcs.afa_szazalek',
			'redotalp',
			'belesnyomott',
			'kategoria_tipus',
			'gyarto.cegnev',
			'ksh_kod',
			'csom_egys:number',
			'minimum_raktarkeszlet:number',
			'maximum_raktarkeszlet:number',
			'doboz_suly:number',
			'raklap_db:number',
			'doboz_hossz:number',
			'doboz_szelesseg:number',
			'doboz_magassag:number',
			'megjegyzes',
			'felveteli_datum',
			'datum',
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
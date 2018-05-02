<?php
/* @var $this SzallitoFutarlevelekController */
/* @var $model SzallitoFutarlevelek */

$this->breadcrumbs=array(
	'Futárlevelek'=>array('index'),
	$model->id,
);

?>

<h1><?php echo $model->szamla_sorszam; ?> számla számú futárlevél adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'szallitolevel_szam',
			array(
				'label'=>'Szállító',
				'name'=>'szallito_ceg.nev',
				'value'=>$model->szallito_ceg_rel->nev,
			),
			array(
				'label'=>'Futár',
				'name'=>'szallito_futar_rel.nev',
			),
			'felvetel_helye',
			'felvetel_ideje',
			'szallitas_cegnev',
			'szallitas_cim',
			'szallitas_telefonszam',
			array(
				'label'=>'Fizetési mód',
				'name'=>'fizetesi_mod_rel.nev',
			),
			'utanvet_osszeg',
			'utanvet_visszahozas_datum',
			'szallitas_dij',
			'egyeb_info',
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
	if (Yii::app()->user->checkAccess('SzallitoFutarlevelTetelek.View')) {
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Szállított termékek</strong>",
		));
		
			$config = array();
			$dataProvider=new CActiveDataProvider('SzallitoFutarlevelTetelek',
				array( 'data' => $model->tetelek,
					   'criteria'=>array('order' => ' megnevezes DESC',),
				)
			);

			$this->widget('zii.widgets.grid.CGridView', array(
				'id' => 'szallitott-tetelek-grid',
				'enablePagination' => false,
				'dataProvider'=>$dataProvider,
				'columns'=>array(
					'megnevezes',
					'darab',
					'megjegyzes',
				)
			));
		$this->endWidget();
	}
?>

<?php
	$this->widget( 'application.modules.auditTrail.widgets.portlets.ShowAuditTrail', array( 'model' => $model, ) );
?>
<?php
/* @var $this MegrendelesekController */
/* @var $model Megrendelesek */
?>

<h1>'<?php echo $model->sorszam; ?>' adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'sorszam',
			'ugyfel.cegnev',
			'autocomplete_ugyfel_cim',
			'cimzett',
			'autocomplete_ugyfel_adoszam',
			'autocomplete_ugyfel_fizetesi_moral',
			'autocomplete_ugyfel_atlagos_fizetesi_keses',
			'arkategoria.nev',
			'egyedi_ar:boolean',
			'rendeles_idopont',
			'rendelest_rogzito_user_id',
			'rendelest_lezaro_user_id',
			'afakulcs.nev',
			'arajanlat.sorszam',
			'proforma_szamla_sorszam',
			'proforma_szamla_fizetve:boolean',
			'szamla_sorszam',
			'ugyfel_tel',
			'ugyfel_fax',
			'visszahivas_jegyzet',
			'jegyzet',
			'reklamszoveg',
			'egyeb_megjegyzes',
			'sztornozas_oka',
			'megrendeles_forras.aruhaz_nev',
			'nyomdakonyv_munka_id',
			'sztornozva:boolean',
			array(
				'name' => 'torolt',
				'type'=>'boolean',
				'value' => $model->torolt,
				'visible' => Yii::app()->user->checkAccess('Admin'),
			),	),
	)); ?>
</p>

<p>
	<?php echo CHtml::button('Vissza', array('submit' => Yii::app()->request->urlReferrer)); ?>
</p>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Megrendelt termékek</strong>",
	));
	
		$config = array();
		$dataProvider=new CActiveDataProvider('MegrendelesTetelek',
			array( 'data' => $model->tetelek,
				   'criteria'=>array('order' => ' id DESC',),
			)
		);

		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'megrendelesTermekek-grid',
			'enablePagination' => false,
			'dataProvider'=>$dataProvider,
			'columns'=>array(
					'termek.nev',
					'szinek_szama1',
					'szinek_szama2',
					'darabszam',
					'hozott_boritek:boolean',
					'egyedi_ar:boolean',
					'netto_darabar',
				array(
							'class' => 'bootstrap.widgets.TbButtonColumn',
							'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
							'template' => '',
					),
			)
		));
	$this->endWidget();
?>

<?php
	$this->widget( 'application.modules.auditTrail.widgets.portlets.ShowAuditTrail', array( 'model' => $model, ) );
?>
<?php
/* @var $this MegrendelesekController */
/* @var $model Megrendelesek */
?>

<h1>'<?php echo $model->sorszam; ?>' adatai</h1>

<p>
	<?php
		if ($model->ugyfel_id > 0 && $model->rendelest_rogzito_user_id > 0 && count($model->tetelek) > 0) {
			if (Yii::app()->user->checkAccess('MegrendelesSzallitolevelek.Create')) {
				
				$this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'button_create_szallitolevel',
					'caption'=>'Szállítólevél készítése',
					'buttonType'=>'link',
					'onclick'=>new CJavaScriptExpression('function() {szallitolevelek("create");}'),
					'htmlOptions'=>array('class'=>'btn btn-primary'),
				));
				
				$this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'button_list_szallitolevel',
					'caption'=>'Elkészült szállítólevelek',
					'buttonType'=>'link',
					'onclick'=>new CJavaScriptExpression('function() {szallitolevelek("list");}'),
					'htmlOptions'=>array('class'=>'btn btn-info'),
				));
				
			}
		}
	?>
</p>

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
			'proforma_kiallitas_datum',
			'proforma_teljesites_datum',
			'proforma_fizetesi_hatarido',
			'fizetesi_mod.nev',
			'szamla_sorszam',
			'szamla_kiallitas_datum',
			'szamla_fizetve',
			'szamla_fizetesi_hatarido',
			'szamla_kiegyenlites_datum',
			'ugyvednek_atadva',
			'behajto_cegnek_atadva',
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
	<?php $this->widget('zii.widgets.jui.CJuiButton', 
			 array(
				'name'=>'back',
				'caption'=>'Vissza',
				'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => Yii::app()->request->urlReferrer),
			 )); ?>
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
					'megrendelt_termek_nev',
					'szinek_szama1',
					'szinek_szama2',
					array(
							'name' => 'DarabszamFormazott',
							'htmlOptions' => array('style' => 'width: 80px;'),
						),
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

<script type="text/javascript">

	function szallitolevelek(createOrList) {
		var redirectUrl = "" ;
		var megrendelesId = <?php echo $model->id; ?>;
		if (createOrList == "create") {
			redirectUrl = "/index.php/szallitolevelek/create/" + megrendelesId ;
		}
		else
		{
			redirectUrl = "/index.php/szallitolevelek/index/" + megrendelesId ;	
		}
		window.open (redirectUrl);
	}

</script>
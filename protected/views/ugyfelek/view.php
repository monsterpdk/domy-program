<?php
/* @var $this UgyfelekController */
/* @var $model Ugyfelek */

$this->breadcrumbs=array(
	'Ügyfelek'=>array('index'),
	$model->id,
);

?>

<h1><?php echo $model->cegnev; ?> ügyfél adatai</h1>

<p>

	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'ugyfel_tipus',
			'cegnev',
			'cegnev_teljes',
			'szekhely_irsz',
			'szekhely_orszag_dsp.nev',
			'szekhely_varos_dsp.varosnev',
			'szekhely_cim',
			'posta_irsz',
			'posta_orszag_dsp.nev',
			'posta_varos_dsp.varosnev',
			'posta_cim',
			'szallitasi_irsz',
			'szallitasi_orszag_dsp.nev',
			'szallitasi_varos_dsp.varosnev',
			'szallitasi_cim',
			'ugyvezeto_nev',
			'ugyvezeto_telefon',
			'ugyvezeto_email',
			'kapcsolattarto_nev',
			'kapcsolattarto_telefon',
			'kapcsolattarto_email',
			'ceg_telefon',
			'ceg_fax',
			'ceg_email',
			'ceg_honlap',
			'cegforma_dsp.cegforma',
			'szamlaszam1',
			'szamlaszam2',
			'display_ugyfel_ugyintezok',
			'adoszam',
			'eu_adoszam',
			'teaor',
			'tevekenysegi_kor',
			'arbevetel',
			'foglalkoztatottak_szama',
			'adatforras_dsp.adatforras',
			'besorolas_dsp.besorolas',
			'megjegyzes',
			'fontos_megjegyzes',
			'fizetesi_felszolitas_volt:boolean',
			'ugyvedi_felszolitas_volt:boolean',
			'levelezes_engedelyezett:boolean',
			'email_engedelyezett:boolean',
			'kupon_engedelyezett:boolean',
			'egyedi_kuponkedvezmeny:boolean',
			'elso_vasarlas_datum',
			'utolso_vasarlas_datum',
			'fizetesi_hatarido',
			'max_fizetesi_keses',
			'atlagos_fizetesi_keses',
			'rendelesi_tartozasi_limit',
			'fizetesi_moral',
			'adatok_egyeztetve_datum',
			'archiv:boolean',
			'archivbol_vissza_datum',
			'felvetel_idopont',
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
	$this->widget( 'application.modules.auditTrail.widgets.portlets.ShowAuditTrail', array( 'model' => $model, ) );
?>

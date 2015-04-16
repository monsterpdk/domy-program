<?php
/* @var $this UgyfelekController */
/* @var $data Ugyfelek */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ugyfel_tipus')); ?>:</b>
	<?php echo CHtml::encode($data->ugyfel_tipus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cegnev')); ?>:</b>
	<?php echo CHtml::encode($data->cegnev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cegnev_teljes')); ?>:</b>
	<?php echo CHtml::encode($data->cegnev_teljes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szekhely_irsz')); ?>:</b>
	<?php echo CHtml::encode($data->szekhely_irsz); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szekhely_orszag')); ?>:</b>
	<?php echo CHtml::encode($data->szekhely_orszag); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szekhely_varos')); ?>:</b>
	<?php echo CHtml::encode($data->szekhely_varos); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('szekhely_cim')); ?>:</b>
	<?php echo CHtml::encode($data->szekhely_cim); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('posta_irsz')); ?>:</b>
	<?php echo CHtml::encode($data->posta_irsz); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('posta_orszag')); ?>:</b>
	<?php echo CHtml::encode($data->posta_orszag); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('posta_varos')); ?>:</b>
	<?php echo CHtml::encode($data->posta_varos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ugyvezeto_nev')); ?>:</b>
	<?php echo CHtml::encode($data->ugyvezeto_nev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ugyvezeto_telefon')); ?>:</b>
	<?php echo CHtml::encode($data->ugyvezeto_telefon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ugyvezeto_email')); ?>:</b>
	<?php echo CHtml::encode($data->ugyvezeto_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kapcsolattarto_nev')); ?>:</b>
	<?php echo CHtml::encode($data->kapcsolattarto_nev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kapcsolattarto_telefon')); ?>:</b>
	<?php echo CHtml::encode($data->kapcsolattarto_telefon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kapcsolattarto_email')); ?>:</b>
	<?php echo CHtml::encode($data->kapcsolattarto_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ceg_telefon')); ?>:</b>
	<?php echo CHtml::encode($data->ceg_telefon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ceg_fax')); ?>:</b>
	<?php echo CHtml::encode($data->ceg_fax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ceg_email')); ?>:</b>
	<?php echo CHtml::encode($data->ceg_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ceg_honlap')); ?>:</b>
	<?php echo CHtml::encode($data->ceg_honlap); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cegforma')); ?>:</b>
	<?php echo CHtml::encode($data->cegforma); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szamlaszam1')); ?>:</b>
	<?php echo CHtml::encode($data->szamlaszam1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szamlaszam2')); ?>:</b>
	<?php echo CHtml::encode($data->szamlaszam2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('adoszam')); ?>:</b>
	<?php echo CHtml::encode($data->adoszam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eu_adoszam')); ?>:</b>
	<?php echo CHtml::encode($data->eu_adoszam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('teaor')); ?>:</b>
	<?php echo CHtml::encode($data->teaor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tevekenysegi_kor')); ?>:</b>
	<?php echo CHtml::encode($data->tevekenysegi_kor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('arbevetel')); ?>:</b>
	<?php echo CHtml::encode($data->arbevetel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('foglalkoztatottak_szama')); ?>:</b>
	<?php echo CHtml::encode($data->foglalkoztatottak_szama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('adatforras')); ?>:</b>
	<?php echo CHtml::encode($data->adatforras); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('besorolas')); ?>:</b>
	<?php echo CHtml::encode($data->besorolas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('megjegyzes')); ?>:</b>
	<?php echo CHtml::encode($data->megjegyzes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fontos_megjegyzes')); ?>:</b>
	<?php echo CHtml::encode($data->fontos_megjegyzes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fizetesi_felszolitas_volt')); ?>:</b>
	<?php echo CHtml::encode($data->fizetesi_felszolitas_volt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ugyvedi_felszolitas_volt')); ?>:</b>
	<?php echo CHtml::encode($data->ugyvedi_felszolitas_volt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('levelezes_engedelyezett')); ?>:</b>
	<?php echo CHtml::encode($data->levelezes_engedelyezett); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email_engedelyezett')); ?>:</b>
	<?php echo CHtml::encode($data->email_engedelyezett); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kupon_engedelyezett')); ?>:</b>
	<?php echo CHtml::encode($data->kupon_engedelyezett); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('egyedi_kuponkedvezmeny')); ?>:</b>
	<?php echo CHtml::encode($data->egyedi_kuponkedvezmeny); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('elso_vasarlas_datum')); ?>:</b>
	<?php echo CHtml::encode($data->elso_vasarlas_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('utolso_vasarlas_datum')); ?>:</b>
	<?php echo CHtml::encode($data->utolso_vasarlas_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_fizetesi_keses')); ?>:</b>
	<?php echo CHtml::encode($data->max_fizetesi_keses); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('atlagos_fizetesi_keses')); ?>:</b>
	<?php echo CHtml::encode($data->atlagos_fizetesi_keses); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rendelesi_tartozasi_limit')); ?>:</b>
	<?php echo CHtml::encode($data->rendelesi_tartozasi_limit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fizetesi_moral')); ?>:</b>
	<?php echo CHtml::encode($data->fizetesi_moral); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('adatok_egyeztetve_datum')); ?>:</b>
	<?php echo CHtml::encode($data->adatok_egyeztetve_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('archiv')); ?>:</b>
	<?php echo CHtml::encode($data->archiv); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('archivbol_vissza_datum')); ?>:</b>
	<?php echo CHtml::encode($data->archivbol_vissza_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('felvetel_idopont')); ?>:</b>
	<?php echo CHtml::encode($data->felvetel_idopont); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />

	*/ ?>

</div>
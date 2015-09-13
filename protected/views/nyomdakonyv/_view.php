<?php
/* @var $this NyomdakonyvController */
/* @var $data Nyomdakonyv */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('megrendeles_tetel_id')); ?>:</b>
	<?php echo CHtml::encode($data->megrendeles_tetel_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('taskaszam')); ?>:</b>
	<?php echo CHtml::encode($data->taskaszam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hatarido')); ?>:</b>
	<?php echo CHtml::encode($data->hatarido); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pantone')); ?>:</b>
	<?php echo CHtml::encode($data->pantone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('munka_beerkezes_datum')); ?>:</b>
	<?php echo CHtml::encode($data->munka_beerkezes_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('taska_kiadasi_datum')); ?>:</b>
	<?php echo CHtml::encode($data->taska_kiadasi_datum); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('elkeszulesi_datum')); ?>:</b>
	<?php echo CHtml::encode($data->elkeszulesi_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ertesitesi_datum')); ?>:</b>
	<?php echo CHtml::encode($data->ertesitesi_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szallitolevel_sorszam')); ?>:</b>
	<?php echo CHtml::encode($data->szallitolevel_sorszam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szallitolevel_datum')); ?>:</b>
	<?php echo CHtml::encode($data->szallitolevel_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szamla_sorszam')); ?>:</b>
	<?php echo CHtml::encode($data->szamla_sorszam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szamla_datum')); ?>:</b>
	<?php echo CHtml::encode($data->szamla_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sos')); ?>:</b>
	<?php echo CHtml::encode($data->sos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szin_c')); ?>:</b>
	<?php echo CHtml::encode($data->szin_c); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szin_m')); ?>:</b>
	<?php echo CHtml::encode($data->szin_m); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szin_y')); ?>:</b>
	<?php echo CHtml::encode($data->szin_y); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szin_k')); ?>:</b>
	<?php echo CHtml::encode($data->szin_k); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('szin_mutaciok')); ?>:</b>
	<?php echo CHtml::encode($data->szin_mutaciok); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kifuto_bal')); ?>:</b>
	<?php echo CHtml::encode($data->kifuto_bal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kifuto_fent')); ?>:</b>
	<?php echo CHtml::encode($data->kifuto_fent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kifuto_jobb')); ?>:</b>
	<?php echo CHtml::encode($data->kifuto_jobb); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kifuto_lent')); ?>:</b>
	<?php echo CHtml::encode($data->kifuto_lent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('forditott_levezetes')); ?>:</b>
	<?php echo CHtml::encode($data->forditott_levezetes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hossziranyu_levezetes')); ?>:</b>
	<?php echo CHtml::encode($data->hossziranyu_levezetes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nyomas_tipus')); ?>:</b>
	<?php echo CHtml::encode($data->nyomas_tipus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('utasitas_ctp_nek')); ?>:</b>
	<?php echo CHtml::encode($data->utasitas_ctp_nek); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('utasitas_gepmesternek')); ?>:</b>
	<?php echo CHtml::encode($data->utasitas_gepmesternek); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kiszallitasi_informaciok')); ?>:</b>
	<?php echo CHtml::encode($data->kiszallitasi_informaciok); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gep_id')); ?>:</b>
	<?php echo CHtml::encode($data->gep_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kifutos')); ?>:</b>
	<?php echo CHtml::encode($data->kifutos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fekete_flekkben_szin_javitando')); ?>:</b>
	<?php echo CHtml::encode($data->fekete_flekkben_szin_javitando); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('magas_szinterheles_nagy_feluleten')); ?>:</b>
	<?php echo CHtml::encode($data->magas_szinterheles_nagy_feluleten); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('magas_szinterheles_szovegben')); ?>:</b>
	<?php echo CHtml::encode($data->magas_szinterheles_szovegben); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ofszet_festek')); ?>:</b>
	<?php echo CHtml::encode($data->ofszet_festek); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nyomas_minta_szerint')); ?>:</b>
	<?php echo CHtml::encode($data->nyomas_minta_szerint); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nyomas_vagojel_szerint')); ?>:</b>
	<?php echo CHtml::encode($data->nyomas_vagojel_szerint); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nyomas_specialis')); ?>:</b>
	<?php echo CHtml::encode($data->nyomas_specialis); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gepindulasra_jon_ugyfel')); ?>:</b>
	<?php echo CHtml::encode($data->gepindulasra_jon_ugyfel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ctp_nek_atadas_datum')); ?>:</b>
	<?php echo CHtml::encode($data->ctp_nek_atadas_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ctp_kezdes_datum')); ?>:</b>
	<?php echo CHtml::encode($data->ctp_kezdes_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ctp_belenyulasok')); ?>:</b>
	<?php echo CHtml::encode($data->ctp_belenyulasok); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ctp_hibalista')); ?>:</b>
	<?php echo CHtml::encode($data->ctp_hibalista); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jovahagyas')); ?>:</b>
	<?php echo CHtml::encode($data->jovahagyas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ctp_kesz_datum')); ?>:</b>
	<?php echo CHtml::encode($data->ctp_kesz_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nyomas_kezdes_datum')); ?>:</b>
	<?php echo CHtml::encode($data->nyomas_kezdes_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('raktarbol_kiadva_datum')); ?>:</b>
	<?php echo CHtml::encode($data->raktarbol_kiadva_datum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kep_file_nev')); ?>:</b>
	<?php echo CHtml::encode($data->kep_file_nev); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sztornozva')); ?>:</b>
	<?php echo CHtml::encode($data->sztornozva); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torolt')); ?>:</b>
	<?php echo CHtml::encode($data->torolt); ?>
	<br />

	*/ ?>

</div>
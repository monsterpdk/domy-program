<?php

class StatisztikakController extends Controller
{

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights',
		);
	}
/*	
	public function getArajanlatStatisztika($model, $kiemeltek) {
		if ($model->statisztika_mettol == "") {
			$model->statisztika_mettol = date("Y-m-d") ;	
		}
		if ($model->statisztika_meddig == "") {
			$model->statisztika_meddig = date("Y-m-d") ;	
		}
		$dataProvider=new CActiveDataProvider('Arajanlatok', array(
			'criteria'=>array(
				'condition'=>'ugyfel.kiemelt = ' . $kiemeltek . ' and t.torolt=0 and t.ajanlat_datum>=\'' . $model->statisztika_mettol . '\' and t.ajanlat_datum <= \'' . $model->statisztika_meddig . '\'',
//				'join'=>'left join dom_ugyfelek ugyfel on (t.ugyfel_id = ugyfel.id)',
				'order'=>'ugyfel_id',
				'with'=>array('tetelek', 'ugyfel'),
				'together'=>true,
			),
			'countCriteria'=>array(
				'condition'=>'ugyfel.kiemelt = ' . $kiemeltek . ' and t.torolt=0 and t.ajanlat_datum>=\'' . $model->statisztika_mettol . '\' and t.ajanlat_datum <= \'' . $model->statisztika_meddig . '\'',
				'with'=>array('tetelek', 'ugyfel'),
				'together'=>true,
//				'join'=>'left join dom_ugyfelek ugyfel on (t.ugyfel_id = ugyfel.id)',				
				// 'order' and 'with' clauses have no meaning for the count query
			),
			'sort'=> false,
			'pagination'=>false,
		));		
		return $dataProvider ;
	}
	*/
	public function getArajanlatTetelekStatisztika($model, $kiemeltek) {
		if ($model->statisztika_mettol == "") {
			$model->statisztika_mettol = date("Y-m-d") ;	
		}
		if ($model->statisztika_meddig == "") {
			$model->statisztika_meddig = date("Y-m-d") ;	
		}
		$dataProvider=new CActiveDataProvider('Arajanlatok', array(
			'criteria'=>array(
				'select'=>'tetelek.*',
				'condition'=>'ugyfel.kiemelt = ' . $kiemeltek . ' and t.torolt=0 and t.ajanlat_datum>=\'' . $model->statisztika_mettol . '\' and t.ajanlat_datum <= \'' . $model->statisztika_meddig . '\'',
//				'join'=>'left join dom_ugyfelek ugyfel on (t.ugyfel_id = ugyfel.id) left join dom_arajanlat_tetelek arajanlat_tetel on (t.id = arajanlat_tetel.arajanlat_id)',
				'with'=>array('tetelek', 'ugyfel'),
				'together'=>true,
			),
			'countCriteria'=>array(
				'select'=>'tetelek.*',
				'condition'=>'ugyfel.kiemelt = ' . $kiemeltek . ' and t.torolt=0 and t.ajanlat_datum>=\'' . $model->statisztika_mettol . '\' and t.ajanlat_datum <= \'' . $model->statisztika_meddig . '\'',
				'with'=>array('tetelek', 'ugyfel'),
				'together'=>true,
//				'join'=>'left join dom_ugyfelek ugyfel on (t.ugyfel_id = ugyfel.id) left join dom_arajanlat_tetelek arajanlat_tetel on (t.id = arajanlat_tetel.arajanlat_id)',
				// 'order' and 'with' clauses have no meaning for the count query
			),
			'sort'=> false,
			'pagination'=>false,
		));		
		return $dataProvider ;
	}
	
/*	
	public function getMegrendelesStatisztika($model, $kiemeltek) {
		if ($model->statisztika_mettol == "") {
			$model->statisztika_mettol = date("Y-m-d") ;	
		}
		if ($model->statisztika_meddig == "") {
			$model->statisztika_meddig = date("Y-m-d") ;	
		}
		$dataProvider=new CActiveDataProvider('Megrendelesek', array(
			'criteria'=>array(
				'condition'=>'ugyfel.kiemelt = ' . $kiemeltek . ' and t.torolt=0 and t.sztornozva=0 and t.rendeles_idopont>=\'' . $model->statisztika_mettol . '\' and t.rendeles_idopont <= \'' . $model->statisztika_meddig . '\'',
//				'join'=>'left join dom_ugyfelek ugyfel on (t.ugyfel_id = ugyfel.id) left join dom_megrendeles_tetelek megrendeles_tetel on (t.id = megrendeles_tetel.megrendeles_id)',				
				'order'=>'ugyfel_id',
				'with'=>array('tetelek', 'ugyfel'),
				'together'=>true,
			),
			'countCriteria'=>array(
				'condition'=>'ugyfel.kiemelt = ' . $kiemeltek . ' and t.torolt=0 and t.sztornozva=0 and t.rendeles_idopont>=\'' . $model->statisztika_mettol . '\' and t.rendeles_idopont <= \'' . $model->statisztika_meddig . '\'',
//				'join'=>'left join dom_ugyfelek ugyfel on (t.ugyfel_id = ugyfel.id) left join dom_megrendeles_tetelek megrendeles_tetel on (t.id = megrendeles_tetel.megrendeles_id)',				
				'with'=>array('tetelek', 'ugyfel'),
				'together'=>true,
				// 'order' and 'with' clauses have no meaning for the count query
			),
			'sort'=> false,
			'pagination'=>false,
		));		
		return $dataProvider ;
	}
	*/
//A megrendeléseket és azok tételeit adja vissza a lekérdezés paramétereinek megfelelően	
	public function getMegrendelesTetelekStatisztika($model, $kiemeltek, $elozmeny = "mind") {
		if ($model->statisztika_mettol == "") {
			$model->statisztika_mettol = date("Y-m-d") ;	
		}
		if ($model->statisztika_meddig == "") {
			$model->statisztika_meddig = date("Y-m-d") ;	
		}
		$mettol = $model->statisztika_mettol . " 00:00:00" ;
		$meddig = $model->statisztika_meddig . " 23:59:59" ;
		switch ($elozmeny) {
			case 'mind': $elozmeny_query = "" ;
				break ;
			case 'ajanlatbol': $elozmeny_query = " and t.arajanlat_id > 0 " ;
				break ;
			case 'ajanlat_nelkul': $elozmeny_query = " and t.arajanlat_id = 0 " ;			
		}
		$dataProvider=new CActiveDataProvider('Megrendelesek', array(
			'criteria'=>array(
				'select'=>'tetelek.*',
				'condition'=>'ugyfel.kiemelt = ' . $kiemeltek . ' and t.torolt=0 and t.sztornozva=0 and t.rendeles_idopont >=\'' . $mettol . '\' and t.rendeles_idopont <= \'' . $meddig . '\'' . $elozmeny_query ,
//				'join'=>'left join dom_ugyfelek ugyfel on (t.ugyfel_id = ugyfel.id) left join dom_megrendeles_tetelek megrendeles_tetel on (t.id = megrendeles_tetel.megrendeles_id)',
				'with'=>array('tetelek' => array('termek' => array('termekar')), 'ugyfel'),
//				'with'=>array('tetelek', 'ugyfel', 'termek', 'termekar'),
				'together'=>true,
			),
			'countCriteria'=>array(
				'select'=>'tetelek.*',
				'condition'=>'ugyfel.kiemelt = ' . $kiemeltek . ' and t.torolt=0 and t.sztornozva=0 and t.rendeles_idopont >=\'' . $mettol . '\' and t.rendeles_idopont <= \'' . $meddig . '\'' . $elozmeny_query ,
//				'join'=>'left join dom_ugyfelek ugyfel on (t.ugyfel_id = ugyfel.id) left join dom_megrendeles_tetelek megrendeles_tetel on (t.id = megrendeles_tetel.megrendeles_id)',
				'with'=>array('tetelek' => array('termek' => array('termekar')), 'ugyfel'),
				'together'=>true,
				// 'order' and 'with' clauses have no meaning for the count query
			),
			'sort'=> false,
			'pagination'=>false,
		));		
		return $dataProvider ;
	}	
	
//A számlázott (van hozzá szállítólevél) megrendeléseket és azok tételeit adja vissza a lekérdezés paramétereinek megfelelően	
	public function getMegrendelesTetelekStatisztikaSzamlazott($model, $elozmeny = "mind") {
		if ($model->statisztika_mettol == "") {
			$model->statisztika_mettol = date("Y-m-d") ;	
		}
		if ($model->statisztika_meddig == "") {
			$model->statisztika_meddig = date("Y-m-d") ;	
		}
		$mettol = $model->statisztika_mettol . " 00:00:00" ;
		$meddig = $model->statisztika_meddig . " 23:59:59" ;		
		switch ($elozmeny) {
			case 'mind': $elozmeny_query = "" ;
				break ;
			case 'ajanlatbol': $elozmeny_query = " and t.arajanlat_id > 0 " ;
				break ;
			case 'ajanlat_nelkul': $elozmeny_query = " and t.arajanlat_id = 0 " ;			
		}
		$dataProvider=new CActiveDataProvider('Megrendelesek', array(
			'criteria'=>array(
				'select'=>'tetelek.*',
				'condition'=>'t.torolt=0 and t.sztornozva=0 and t.rendeles_idopont>=\'' . $mettol . '\' and t.rendeles_idopont <= \'' . $meddig . '\' and szallitolevel.id IS NOT NULL' . $elozmeny_query,
//				'join'=>'left join dom_ugyfelek ugyfel on (t.ugyfel_id = ugyfel.id) left join dom_megrendeles_tetelek megrendeles_tetel on (t.id = megrendeles_tetel.megrendeles_id)',
				'with'=>array('szallitolevel', 'tetelek' => array('termek' => array('termekar')), 'ugyfel'),
//				'with'=>array('tetelek', 'ugyfel', 'termek', 'termekar'),
				'together'=>true,
			),
			'countCriteria'=>array(
				'select'=>'tetelek.*',
				'condition'=>'t.torolt=0 and t.sztornozva=0 and t.rendeles_idopont>=\'' . $mettol . '\' and t.rendeles_idopont <= \'' . $meddig . '\' and szallitolevel.id IS NOT NULL' . $elozmeny_query,
//				'join'=>'left join dom_ugyfelek ugyfel on (t.ugyfel_id = ugyfel.id) left join dom_megrendeles_tetelek megrendeles_tetel on (t.id = megrendeles_tetel.megrendeles_id)',
				'with'=>array('szallitolevel', 'tetelek' => array('termek' => array('termekar')), 'ugyfel'),
				'together'=>true,
				// 'order' and 'with' clauses have no meaning for the count query
			),
			'sort'=> false,
			'pagination'=>false,
		));		
		return $dataProvider ;
	}	

//A pénzügyi tranzakciókat adja vissza a megadott időintervallumon belül a hozzá tartozó megrendelés adatokkal
	public function getPenzugyiTranzakciok($model) {
		if ($model->statisztika_mettol == "") {
			$model->statisztika_mettol = date("Y-m-d") ;	
		}
		if ($model->statisztika_meddig == "") {
			$model->statisztika_meddig = date("Y-m-d") ;	
		}
		$dataProvider=new CActiveDataProvider('PenzugyiTranzakciok', array(
			'criteria'=>array(
				'select'=>'tetelek.*',
				'condition'=>'t.torolt=0 and t.datum >=\'' . $model->statisztika_mettol . '\' and t.datum <= \'' . $model->statisztika_meddig . '\'',
				'with'=>array('megrendeles' => array('tetelek')),
				'order'=>'megrendeles.id',
				'together'=>true,
			),
			'countCriteria'=>array(
				'condition'=>'t.torolt=0 and t.datum >=\'' . $model->statisztika_mettol . '\' and t.datum <= \'' . $model->statisztika_meddig . '\'',
				'with'=>array('megrendeles' => array('tetelek')),
				'together'=>true,
			),
			'sort'=> false,
			'pagination'=>false,
		));		
		return $dataProvider ;
	}	

//Az összes nem kiegyenlített számlával rendelkező (és nem sztornózott, vagy törölt) megrendelést adja vissza
	public function getTartozasok() {
		$dataProvider=new CActiveDataProvider('Megrendelesek', array(
			'criteria'=>array(
				'condition'=>'t.torolt=0 and t.sztornozva=0 and szamla_sorszam != \'\' and szamla_fizetve = 0',
			),
			'countCriteria'=>array(
				'condition'=>'t.torolt=0 and t.sztornozva=0 and szamla_sorszam != \'\' and szamla_fizetve = 0',
				// 'order' and 'with' clauses have no meaning for the count query
			),
			'sort'=> false,
			'pagination'=>false,
		));		
		return $dataProvider ;
	}	

//Az összes folyamatban lévő munka, ami a nem befejezett nyomdakönyvi munkákat takarja
	public function getMunkakFolyamatban() {
		$dataProvider=new CActiveDataProvider('Nyomdakonyv', array(
			'criteria'=>array(
				'condition'=>'t.torolt=0 and megrendeles_tetel.megrendeles_id IS NOT NULL and t.elkeszulesi_datum=\'0000-00-00 00:00:00\' and t.hatarido>\'0000-00-00 00:00:00\'',
				'with'=>array('megrendeles_tetel' => array('termek' => array('termekar')), 'megrendeles_tetel.megrendeles', 'megrendeles_tetel.megrendeles.ugyfel'),
				'together'=>true,
			),
			'countCriteria'=>array(
				'condition'=>'t.torolt=0 and megrendeles_tetel.megrendeles_id IS NOT NULL and t.elkeszulesi_datum=\'0000-00-00 00:00:00\' and t.hatarido>\'0000-00-00 00:00:00\'',
				'with'=>array('megrendeles_tetel' => array('termek' => array('termekar')), 'megrendeles_tetel.megrendeles', 'megrendeles_tetel.megrendeles.ugyfel'),
				'together'=>true,
				// 'order' and 'with' clauses have no meaning for the count query				
			),
			'sort'=> false,
			'pagination'=>false,
		));		
		return $dataProvider ;
	}		
	
	public function actionNapiKombinaltStatisztika()
	{
		$model = new Statisztikak;
		
		$this->render('napiKombinaltStatisztika',array('model'=>$model));		
	}
	
	public function actionNapiKombinaltStatisztikaPrintPDF()
	{
		$model = new Statisztikak;

		if ($_POST['Statisztikak']["statisztika_mettol"] != "" && $_POST['Statisztikak']["statisztika_meddig"] != "")
		{
			$model -> statisztika_mettol = $_POST['Statisztikak']["statisztika_mettol"] ;
			$model -> statisztika_meddig = $_POST['Statisztikak']["statisztika_meddig"] ;
		}
		else
		{
			$tegnap  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
			if (date("w", $tegnap) == 6) {
				$tegnap  = mktime(0, 0, 0, date("m")  , date("d")-2, date("Y"));
			}
			elseif (date("w", $tegnap) == 0) {
				$tegnap  = mktime(0, 0, 0, date("m")  , date("d")-3, date("Y"));
			} 
			
			$model -> statisztika_mettol = date("Y-m-d", $tegnap) ;
			$model -> statisztika_meddig = date("Y-m-d", $tegnap) ;			
		}
/*		$model -> statisztika_mettol .= " 00:00:00" ;
		$model -> statisztika_meddig .= " 23:59:59" ;	
//		die($model -> statisztika_mettol . ' - ' . 	$model -> statisztika_meddig) ;
		$model -> statisztika_mettol = "2016-02-01" ;
		$model -> statisztika_meddig = "2016-02-29" ;*/


		$stat_adatok = array() ;
//Árajánlattal kapcsolatos statisztikák	nem kiemelt cégek	
		$arajanlatTetelekStatisztika_kiemeltek_nelkul = $this->getArajanlatTetelekStatisztika($model, 0) ;
		$arajanlatokEladas = 0 ;
		$arajanlatTetelekEladas = 0 ;
		$arajanlatOsszegEladas_kiemeltek_nelkul = 0 ;
		$arajanlatTetelekLegparnas = 0 ;
		$arajanlatOsszegLegparnas = 0 ;
		$arajanlatokNyomas = 0 ;
		$arajanlatTetelekNyomas = 0 ;
		$arajanlatOsszegNyomas = 0 ;
		$arajanlatCegek_kiemeltek_nelkul = array("eladás"=>array(), "nyomás"=>array()) ;
		$arajanlatCegek_kiemeltek_nelkul_10000_alatt = array("eladás"=>array(), "nyomás"=>array()) ;
		$arajanlatCegek_kiemeltek_nelkul_10000_felett = array("eladás"=>array(), "nyomás"=>array()) ;
		$arajanlatokEladas_10000_alatt = 0 ;
		$arajanlatTetelekEladas_10000_alatt = 0 ;
		$arajanlatOsszegEladas_kiemeltek_nelkul_10000_alatt = 0 ;
		$arajanlatTetelekLegparnas_10000_alatt = 0 ;
		$arajanlatOsszegLegparnas_10000_alatt = 0 ;
		$arajanlatokNyomas_10000_alatt = 0 ;
		$arajanlatTetelekNyomas_10000_alatt = 0 ;
		$arajanlatOsszegNyomas_10000_felett = 0 ;
		$arajanlatokEladas_10000_felett = 0 ;
		$arajanlatTetelekEladas_10000_felett = 0 ;
		$arajanlatOsszegEladas_kiemeltek_nelkul_10000_felett = 0 ;
		$arajanlatTetelekLegparnas_10000_felett = 0 ;
		$arajanlatOsszegLegparnas_10000_felett = 0 ;
		$arajanlatokNyomas_10000_felett = 0 ;
		$arajanlatTetelekNyomas_10000_felett = 0 ;
		$arajanlatOsszegNyomas_10000_felett = 0 ;
		if ($arajanlatTetelekStatisztika_kiemeltek_nelkul->totalItemCount > 0) {
			foreach ($arajanlatTetelekStatisztika_kiemeltek_nelkul->getData() as $sor) {
				$nyomas = false ;
				$arajanlat_darabszamok = array("tizezer_alatt"=>0,"tizezer_felett"=>0) ;
				foreach ($sor->tetelek as $tetel_sor) {
					if ($tetel_sor->termek->termekcsoport_id == 1)	{	//Ha légpárnás boríték, akkor a légpárnás statba is betesszük
						$arajanlatTetelekLegparnas++ ;
						$arajanlatOsszegLegparnas += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						if ($tetel_sor->darabszam < 10000) {
							$arajanlatTetelekLegparnas_10000_alatt++ ;
							$arajanlatOsszegLegparnas_10000_alatt += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							$arajanlat_darabszamok["tizezer_alatt"] = 1 ;
						}
						else
						{
							$arajanlatTetelekLegparnas_10000_felett++ ;
							$arajanlatOsszegLegparnas_10000_felett += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;							
							$arajanlat_darabszamok["tizezer_felett"] = 1 ;
						}
					}
					elseif ($tetel_sor->szinek_szama1 + $tetel_sor->szinek_szama2 > 0) {
						$nyomas = true ;
						$arajanlatTetelekNyomas++ ;
						$arajanlatOsszegNyomas += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						if ($tetel_sor->darabszam < 10000) {
							$arajanlatTetelekNyomas_10000_alatt++ ;
							$arajanlatOsszegNyomas_10000_alatt += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							$arajanlat_darabszamok["tizezer_alatt"] = 1 ;
						}
						else
						{
							$arajanlatTetelekNyomas_10000_felett++ ;
							$arajanlatOsszegNyomas_10000_felett += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;							
							$arajanlat_darabszamok["tizezer_felett"] = 1 ;
						}
					}
					else
					{
						$arajanlatTetelekEladas++ ;
						$arajanlatOsszegEladas_kiemeltek_nelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;						
						if ($tetel_sor->darabszam < 10000) {
							$arajanlatTetelekEladas_10000_alatt++ ;
							$arajanlatOsszegEladas_kiemeltek_nelkul_10000_alatt += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							$arajanlat_darabszamok["tizezer_alatt"] = 1 ;
						}
						else
						{
							$arajanlatTetelekEladas_10000_felett++ ;
							$arajanlatOsszegEladas_kiemeltek_nelkul_10000_felett += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;							
							$arajanlat_darabszamok["tizezer_felett"] = 1 ;
						}
					}
				}
				if ($nyomas) {
					$arajanlatokNyomas++ ;
					if (!isset($arajanlatCegek_kiemeltek_nelkul["nyomás"][$sor->ugyfel_id])) {
						$arajanlatCegek_kiemeltek_nelkul["nyomás"][$sor->ugyfel_id] = 1 ;
					}
					else
					{
						$arajanlatCegek_kiemeltek_nelkul["nyomás"][$sor->ugyfel_id]++ ;	
					}
					if ($arajanlat_darabszamok["tizezer_alatt"] == 1) {
						$arajanlatokNyomas_10000_alatt++ ;
						$arajanlatCegek_kiemeltek_nelkul_10000_alatt["nyomás"][$sor->ugyfel_id]++ ;
					}
					if ($arajanlat_darabszamok["tizezer_felett"] == 1)
					{
						$arajanlatokNyomas_10000_felett++ ;
						$arajanlatCegek_kiemeltek_nelkul_10000_felett["nyomás"][$sor->ugyfel_id]++ ;						
					}
				}
				else
				{
					$arajanlatokEladas++ ;
					if (!isset($arajanlatCegek_kiemeltek_nelkul["eladás"][$sor->ugyfel_id])) {
						$arajanlatCegek_kiemeltek_nelkul["eladás"][$sor->ugyfel_id] = 1 ;
					}
					else
					{
						$arajanlatCegek_kiemeltek_nelkul["eladás"][$sor->ugyfel_id]++ ;	
					}
					if ($arajanlat_darabszamok["tizezer_alatt"] == 1) {
						$arajanlatokEladas_10000_alatt++ ;
						$arajanlatCegek_kiemeltek_nelkul_10000_alatt["eladás"][$sor->ugyfel_id]++ ;
					}
					if ($arajanlat_darabszamok["tizezer_felett"] == 1)
					{
						$arajanlatokEladas_10000_felett++ ;
						$arajanlatCegek_kiemeltek_nelkul_10000_felett["eladás"][$sor->ugyfel_id]++ ;						
					}
				}
			}
		}
		$stat_adatok["arajanlatStatisztika_kiemeltek_nelkul"] = $arajanlatokEladas ;
		$stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul"] = $arajanlatTetelekEladas ;		
		$stat_adatok["arajanlatOsszegEladas_kiemeltek_nelkul"] = $arajanlatOsszegEladas_kiemeltek_nelkul ;
		$stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul"] = $arajanlatokNyomas ;
		$stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul"] = $arajanlatTetelekNyomas ;		
		$stat_adatok["arajanlatOsszegNyomas_kiemeltek_nelkul"] = $arajanlatOsszegNyomas ;
		$stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul"] = $arajanlatTetelekLegparnas ;		
		$stat_adatok["arajanlatOsszegLegparnas_kiemeltek_nelkul"] = $arajanlatOsszegLegparnas ;
		$stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul"] = count($arajanlatCegek_kiemeltek_nelkul["eladás"]) ;
		$stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul"] = count($arajanlatCegek_kiemeltek_nelkul["nyomás"]) ;

		$stat_adatok["arajanlatStatisztika_kiemeltek_nelkul_10000_alatt"] = $arajanlatokEladas_10000_alatt ;
		$stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] = $arajanlatTetelekEladas_10000_alatt ;		
		$stat_adatok["arajanlatOsszegEladas_kiemeltek_nelkul_10000_alatt"] = $arajanlatOsszegEladas_kiemeltek_nelkul_10000_alatt ;
		$stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul_10000_alatt"] = $arajanlatokNyomas_10000_alatt ;
		$stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] = $arajanlatTetelekNyomas_10000_alatt ;		
		$stat_adatok["arajanlatOsszegNyomas_kiemeltek_nelkul_10000_alatt"] = $arajanlatOsszegNyomas_10000_alatt ;
		$stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] = $arajanlatTetelekLegparnas_10000_alatt ;		
		$stat_adatok["arajanlatOsszegLegparnas_kiemeltek_nelkul_10000_alatt"] = $arajanlatOsszegLegparnas_10000_alatt ;
		$stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul_10000_alatt"] = count($arajanlatCegek_kiemeltek_nelkul_10000_alatt["eladás"]) ;
		$stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul_10000_alatt"] = count($arajanlatCegek_kiemeltek_nelkul_10000_alatt["nyomás"]) ;

		$stat_adatok["arajanlatStatisztika_kiemeltek_nelkul_10000_felett"] = $arajanlatokEladas_10000_felett ;
		$stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul_10000_felett"] = $arajanlatTetelekEladas_10000_felett ;		
		$stat_adatok["arajanlatOsszegEladas_kiemeltek_nelkul_10000_felett"] = $arajanlatOsszegEladas_kiemeltek_nelkul_10000_felett ;
		$stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul_10000_felett"] = $arajanlatokNyomas_10000_felett ;
		$stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul_10000_felett"] = $arajanlatTetelekNyomas_10000_felett ;		
		$stat_adatok["arajanlatOsszegNyomas_kiemeltek_nelkul_10000_felett"] = $arajanlatOsszegNyomas_10000_felett ;
		$stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_felett"] = $arajanlatTetelekLegparnas_10000_felett ;		
		$stat_adatok["arajanlatOsszegLegparnas_kiemeltek_nelkul_10000_felett"] = $arajanlatOsszegLegparnas_10000_felett ;
		$stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul_10000_felett"] = count($arajanlatCegek_kiemeltek_nelkul_10000_felett["eladás"]) ;
		$stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul_10000_felett"] = count($arajanlatCegek_kiemeltek_nelkul_10000_felett["nyomás"]) ;
		
		unset($arajanlatTetelekStatisztika_kiemeltek_nelkul) ;

//Árajánlattal kapcsolatos statisztikák	kiemelt cégek	
		$arajanlatTetelekStatisztika_csak_kiemeltek = $this->getArajanlatTetelekStatisztika($model, 1) ;
		$arajanlatokEladas = 0 ;
		$arajanlatTetelekEladas = 0 ;
		$arajanlatOsszegEladas_csak_kiemeltek = 0 ;
		$arajanlatTetelekLegparnas = 0 ;
		$arajanlatOsszegLegparnas = 0 ;
		$arajanlatokNyomas = 0 ;
		$arajanlatTetelekNyomas = 0 ;
		$arajanlatOsszegNyomas = 0 ;
		if ($arajanlatTetelekStatisztika_csak_kiemeltek->totalItemCount > 0) {
			foreach ($arajanlatTetelekStatisztika_csak_kiemeltek->getData() as $sor) {
				$nyomas = false ;
				foreach ($sor->tetelek as $tetel_sor) {
					if ($tetel_sor->termek->termekcsoport_id == 1)	{	//Ha légpárnás boríték, akkor a légpárnás statba is betesszük
						$arajanlatTetelekLegparnas++ ;
						$arajanlatOsszegLegparnas += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
					}
					elseif ($tetel_sor->szinek_szama1 + $tetel_sor->szinek_szama2 > 0) {
						$nyomas = true ;
						$arajanlatTetelekNyomas++ ;
						$arajanlatOsszegNyomas += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
					}
					else
					{
						$arajanlatTetelekEladas++ ;
						$arajanlatOsszegEladas_csak_kiemeltek += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;						
					}
				}
				if ($nyomas) {
					$arajanlatokNyomas++ ;
				}
				else
				{
					$arajanlatokEladas++ ;
				}
			}
		}
		$stat_adatok["arajanlatStatisztika_csak_kiemeltek"] = $arajanlatokEladas ;
		$stat_adatok["arajanlatTetelekStatisztika_csak_kiemeltek"] = $arajanlatTetelekEladas ;		
		$stat_adatok["arajanlatOsszegEladas_csak_kiemeltek"] = $arajanlatOsszegEladas_csak_kiemeltek ;
		$stat_adatok["arajanlatNyomasStatisztika_csak_kiemeltek"] = $arajanlatokNyomas ;
		$stat_adatok["arajanlatNyomasTetelekStatisztika_csak_kiemeltek"] = $arajanlatTetelekNyomas ;		
		$stat_adatok["arajanlatOsszegNyomas_csak_kiemeltek"] = $arajanlatOsszegNyomas ;
		$stat_adatok["arajanlatLegparnasTetelekStatisztika_csak_kiemeltek"] = $arajanlatTetelekLegparnas ;		
		$stat_adatok["arajanlatOsszegLegparnas_csak_kiemeltek"] = $arajanlatOsszegLegparnas ;		
		unset($arajanlatTetelekStatisztika_csak_kiemeltek) ;
		
//Megrendeléssel kapcsolatos statisztikák nem kiemelt cégek		
		$megrendelesTetelekStatisztika_kiemeltek_nelkul = $this->getMegrendelesTetelekStatisztika($model, 0) ;
		$megrendelesekEladas = 0 ;
		$megrendelesTetelekEladas = 0 ;
		$megrendelesOsszegEladas_kiemeltek_nelkul = 0 ;
		$megrendelesTetelekLegparnas = 0 ;
		$megrendelesOsszegLegparnas = 0 ;
		$megrendelesekNyomas = 0 ;
		$megrendelesTetelekNyomas = 0 ;
		$megrendelesOsszegNyomas = 0 ;
		$megrendelesekEladasAjanlatNelkul = 0 ;
		$megrendelesTetelekEladasAjanlatNelkul = 0 ;
		$megrendelesOsszegEladasAjanlatNelkul = 0 ;
		$megrendelesekNyomasAjanlatNelkul = 0 ;
		$megrendelesTetelekNyomasAjanlatNelkul = 0 ;
		$megrendelesOsszegNyomasAjanlatNelkul = 0 ;
		$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul = 0 ;
		$bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul = 0 ;
		$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul = 0 ;
		$anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul = 0 ;
		$megrendelesCegek_kiemeltek_nelkul = array("eladás"=>array(), "nyomás"=>array()) ;
		$megrendelesCegek_kiemeltek_nelkul_10000_alatt = array("eladás"=>array(), "nyomás"=>array()) ;
		$megrendelesCegek_kiemeltek_nelkul_10000_felett = array("eladás"=>array(), "nyomás"=>array()) ;
		$megrendelesokEladas_10000_alatt = 0 ;
		$megrendelesTetelekEladas_10000_alatt = 0 ;
		$megrendelesOsszegEladas_kiemeltek_nelkul_10000_alatt = 0 ;
		$megrendelesTetelekLegparnas_10000_alatt = 0 ;
		$megrendelesOsszegLegparnas_10000_alatt = 0 ;
		$megrendelesokNyomas_10000_alatt = 0 ;
		$megrendelesTetelekNyomas_10000_alatt = 0 ;
		$megrendelesOsszegNyomas_10000_felett = 0 ;
		$megrendelesokEladas_10000_felett = 0 ;
		$megrendelesTetelekEladas_10000_felett = 0 ;
		$megrendelesOsszegEladas_kiemeltek_nelkul_10000_felett = 0 ;
		$megrendelesTetelekLegparnas_10000_felett = 0 ;
		$megrendelesOsszegLegparnas_10000_felett = 0 ;
		$megrendelesokNyomas_10000_felett = 0 ;
		$megrendelesTetelekNyomas_10000_felett = 0 ;
		$megrendelesOsszegNyomas_10000_felett = 0 ;
		
		if ($megrendelesTetelekStatisztika_kiemeltek_nelkul->totalItemCount > 0) {
			foreach ($megrendelesTetelekStatisztika_kiemeltek_nelkul->getData() as $sor) {
				$nyomas = false ;
				$megrendeles_darabszamok = array("tizezer_alatt"=>0,"tizezer_felett"=>0) ;				
				foreach ($sor->tetelek as $tetel_sor) {
					$db_eladasi_ar = 0 ;
					$termek = $tetel_sor->termek ;
					$ervenyes_termekar_rekord = "" ;
					$i = 0 ;
					$l = false ;
					while ($i < count($termek->termekar) && !$l) {
						if ($sor->rendeles_idopont >= $termek->termekar[$i]->datum_mettol && $sor->rendeles_idopont <= $termek->termekar[$i]->datum_meddig) {
							$l = true ;
							$ervenyes_termekar_rekord = $termek->termekar[$i] ;
						}
						$i++ ;						
					}					
//					print_r($termek->termekar) ;
					if ($tetel_sor->termek->termekcsoport_id == 1)	{	//Ha légpárnás boríték, akkor a légpárnás statba is betesszük
						if ($sor->arajanlat_id == 0) {
							$megrendelesTetelekEladasAjanlatNelkul++ ;
							$megrendelesOsszegEladasAjanlatNelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;														
						}
						else {
							$megrendelesTetelekLegparnas++ ;
							$megrendelesOsszegLegparnas += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;							
						}
						if ($tetel_sor->darabszam >= $termek->csom_egys) {
							$db_eladasi_ar = $ervenyes_termekar_rekord->csomag_eladasi_ar / $termek->csom_egys ;	
						}
						else
						{
							$db_eladasi_ar = $ervenyes_termekar_rekord->db_eladasi_ar ;
						}
//						echo "aaa $sor->id: $db_eladasi_ar * $tetel_sor->darabszam = " . ($db_eladasi_ar * $tetel_sor->darabszam) . "<br />" ;
						$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul += ($db_eladasi_ar * $tetel_sor->darabszam) ;
						if ($tetel_sor->hozott_boritek == 0) {
							$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
						}
						if ($tetel_sor->darabszam < 10000) {
							$megrendelesTetelekLegparnas_10000_alatt++ ;
							$megrendelesOsszegEladas_kiemeltek_nelkul_10000_alatt += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							$megrendeles_darabszamok["tizezer_alatt"] = 1 ;
							$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_alatt += ($db_eladasi_ar * $tetel_sor->darabszam) ;
							$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_alatt += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
						}
						else
						{
							$megrendelesTetelekLegparnas_10000_felett++ ;
							$megrendelesOsszegEladas_kiemeltek_nelkul_10000_felett += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;							
							$megrendeles_darabszamok["tizezer_felett"] = 1 ;
							$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_felett += ($db_eladasi_ar * $tetel_sor->darabszam) ;
							$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_felett += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
						}
						
					}
					elseif ($tetel_sor->szinek_szama1 + $tetel_sor->szinek_szama2 > 0) {
						$nyomas = true ;
						if ($sor->arajanlat_id == 0) {
							$megrendelesTetelekNyomasAjanlatNelkul++ ;
							$megrendelesOsszegNyomasAjanlatNelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;														
						}
						else {
							$megrendelesTetelekNyomas++ ;
							$megrendelesOsszegNyomas += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;							
						}
						if ($tetel_sor->darabszam >= $termek->csom_egys) {
							$db_eladasi_ar = $ervenyes_termekar_rekord->db_ar_nyomashoz / $termek->csom_egys ;	
						}
						else
						{
							$db_eladasi_ar = $ervenyes_termekar_rekord->csomag_ar_nyomashoz ;
						}						
//						echo "bbb: $db_eladasi_ar * $tetel_sor->darabszam = " . ($db_eladasi_ar * $tetel_sor->darabszam) . "<br />" ;
						$bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul += ($tetel_sor->netto_darabar * $tetel_sor->darabszam) ;
						if ($tetel_sor->hozott_boritek == 0) {
							$anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
						}
						if ($tetel_sor->darabszam < 10000) {
							$megrendelesTetelekNyomas_10000_alatt++ ;
							$megrendelesOsszegNyomas_10000_alatt += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							$megrendeles_darabszamok["tizezer_alatt"] = 1 ;
							$bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_alatt += ($tetel_sor->netto_darabar * $tetel_sor->darabszam) ;
							if ($tetel_sor->hozott_boritek == 0) {
								$anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_alatt += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
						}
						else
						{
							$megrendelesTetelekNyomas_10000_felett++ ;
							$megrendelesOsszegNyomas_10000_felett += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;							
							$megrendeles_darabszamok["tizezer_felett"] = 1 ;
							$bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_felett += ($tetel_sor->netto_darabar * $tetel_sor->darabszam) ;
							if ($tetel_sor->hozott_boritek == 0) {
								$anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_felett += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
						}
						
					}
					elseif ($tetel_sor->termek->tipus != "Szolgáltatás" && $tetel_sor->termek->nev != "Kuponfelhasználás")		//Ide most minden bemegy, ami nem légpárnás, nem nyomás, nem kuponfelhasználás és nem szolgáltatás, tehát ide megy a ragasztószalag, levélpapír, stb. is
					{
						if ($sor->arajanlat_id == 0) {
							$megrendelesTetelekEladasAjanlatNelkul++ ;
							$megrendelesOsszegEladasAjanlatNelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;														
						}
						else {
							$megrendelesTetelekEladas++ ;
							$megrendelesOsszegEladas_kiemeltek_nelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;							
						}
						if ($tetel_sor->darabszam >= $termek->csom_egys) {
							$db_eladasi_ar = $ervenyes_termekar_rekord->csomag_eladasi_ar / $termek->csom_egys ;	
						}
						else
						{
							$db_eladasi_ar = $ervenyes_termekar_rekord->db_eladasi_ar ;
						}		
//						echo "ccc $sor->id: $db_eladasi_ar * $tetel_sor->darabszam = " . ($db_eladasi_ar * $tetel_sor->darabszam) . "<br />" ;
						$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul += ($db_eladasi_ar * $tetel_sor->darabszam) ;						
						if ($tetel_sor->hozott_boritek == 0) {
							$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
						}
						if ($tetel_sor->darabszam < 10000) {
							$megrendelesTetelekEladas_10000_alatt++ ;
							$megrendelesOsszegEladas_kiemeltek_nelkul_10000_alatt += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							$megrendeles_darabszamok["tizezer_alatt"] = 1 ;
							$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_alatt += ($db_eladasi_ar * $tetel_sor->darabszam) ;						
							$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_alatt += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
						}
						else
						{
							$megrendelesTetelekEladas_10000_felett++ ;
							$megrendelesOsszegEladas_kiemeltek_nelkul_10000_felett += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;							
							$megrendeles_darabszamok["tizezer_felett"] = 1 ;
							$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_felett += ($db_eladasi_ar * $tetel_sor->darabszam) ;						
							$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_felett += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
						}
						
					}					
				}
				if ($nyomas) {
					
					if ($sor->arajanlat_id == 0) {
						$megrendelesekNyomasAjanlatNelkul++ ;
					}
					else
					{
						$megrendelesekNyomas++ ;
					}
					if (!isset($megrendelesCegek_kiemeltek_nelkul["nyomás"][$sor->ugyfel_id])) {
						$megrendelesCegek_kiemeltek_nelkul["nyomás"][$sor->ugyfel_id] = 1 ;
					}
					else
					{
						$megrendelesCegek_kiemeltek_nelkul["nyomás"][$sor->ugyfel_id]++ ;	
					}
					if ($megrendeles_darabszamok["tizezer_alatt"] == 1) {
						$megrendelesekNyomas_10000_alatt++ ;
						$megrendelesCegek_kiemeltek_nelkul_10000_alatt["nyomás"][$sor->ugyfel_id]++ ;
					}
					if ($megrendeles_darabszamok["tizezer_felett"] == 1)
					{
						$megrendelesekNyomas_10000_felett++ ;
						$megrendelesCegek_kiemeltek_nelkul_10000_felett["nyomás"][$sor->ugyfel_id]++ ;						
					}					
				}
				else
				{
					if ($sor->arajanlat_id == 0) {
						$megrendelesekEladasAjanlatNelkul++ ;
					}
					else
					{
						$megrendelesekEladas++ ;
					}
					
					if (!isset($megrendelesCegek_kiemeltek_nelkul["eladás"][$sor->ugyfel_id])) {
						$megrendelesCegek_kiemeltek_nelkul["eladás"][$sor->ugyfel_id] = 1 ;
					}
					else
					{
						$megrendelesCegek_kiemeltek_nelkul["eladás"][$sor->ugyfel_id]++ ;	
					}
					if ($megrendeles_darabszamok["tizezer_alatt"] == 1) {
						$megrendelesekEladas_10000_alatt++ ;
						$megrendelesCegek_kiemeltek_nelkul_10000_alatt["eladás"][$sor->ugyfel_id]++ ;
					}
					if ($megrendeles_darabszamok["tizezer_felett"] == 1)
					{
						$megrendelesekEladas_10000_felett++ ;
						$megrendelesCegek_kiemeltek_nelkul_10000_felett["eladás"][$sor->ugyfel_id]++ ;						
					}					
				}
			}
		}
//		die($anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul) ;
		$stat_adatok["megrendelesStatisztika_kiemeltek_nelkul"] = $megrendelesekEladas ;
		$stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul"] = $megrendelesTetelekEladas ;		
		$stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul"] = $megrendelesOsszegEladas_kiemeltek_nelkul ;
		$stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul"] = $megrendelesekNyomas ;
		$stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul"] = $megrendelesTetelekNyomas ;		
		$stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul"] = $megrendelesOsszegNyomas ;
		$stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul"] = $megrendelesTetelekLegparnas ;		
		$stat_adatok["megrendelesOsszegLegparnas_kiemeltek_nelkul"] = $megrendelesOsszegLegparnas ;

		$stat_adatok["megrendelesStatisztikaAjanlatNelkul_kiemeltek_nelkul"] = $megrendelesekEladasAjanlatNelkul ;
		$stat_adatok["megrendelesTetelekStatisztikaAjanlatNelkul_kiemeltek_nelkul"] = $megrendelesTetelekEladasAjanlatNelkul ;		
		$stat_adatok["megrendelesOsszegEladasAjanlatNelkul_kiemeltek_nelkul"] = $megrendelesOsszegEladasAjanlatNelkul ;
		$stat_adatok["megrendelesNyomasStatisztikaAjanlatNelkul_kiemeltek_nelkul"] = $megrendelesekNyomasAjanlatNelkul ;
		$stat_adatok["megrendelesNyomasTetelekStatisztikaAjanlatNelkul_kiemeltek_nelkul"] = $megrendelesTetelekNyomasAjanlatNelkul ;		
		$stat_adatok["megrendelesOsszegNyomasAjanlatNelkul_kiemeltek_nelkul"] = $megrendelesOsszegNyomasAjanlatNelkul ;
		
		
		$stat_adatok["megrendelesCegekEladas_kiemeltek_nelkul"] = count($megrendelesCegek_kiemeltek_nelkul["eladás"]) ;
		$stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkul"] = count($megrendelesCegek_kiemeltek_nelkul["nyomás"]) ;

		$stat_adatok["megrendelesStatisztika_kiemeltek_nelkul_10000_alatt"] = $megrendelesekEladas_10000_alatt ;
		$stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] = $megrendelesTetelekEladas_10000_alatt ;		
		$stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul_10000_alatt"] = $megrendelesOsszegEladas_kiemeltek_nelkul_10000_alatt ;
		$stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul_10000_alatt"] = $megrendelesekNyomas_10000_alatt ;
		$stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] = $megrendelesTetelekNyomas_10000_alatt ;		
		$stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul_10000_alatt"] = $megrendelesOsszegNyomas_10000_alatt ;
		$stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] = $megrendelesTetelekLegparnas_10000_alatt ;		
		$stat_adatok["megrendelesOsszegLegparnas_kiemeltek_nelkul_10000_alatt"] = $megrendelesOsszegLegparnas_10000_alatt ;
		$stat_adatok["megrendelesCegekEladas_kiemeltek_nelkul_10000_alatt"] = count($megrendelesCegek_kiemeltek_nelkul_10000_alatt["eladás"]) ;
		$stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkul_10000_alatt"] = count($megrendelesCegek_kiemeltek_nelkul_10000_alatt["nyomás"]) ;
		
		$stat_adatok["megrendelesStatisztika_kiemeltek_nelkul_10000_felett"] = $megrendelesekEladas_10000_felett ;
		$stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul_10000_felett"] = $megrendelesTetelekEladas_10000_felett ;		
		$stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul_10000_felett"] = $megrendelesOsszegEladas_kiemeltek_nelkul_10000_felett ;
		$stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul_10000_felett"] = $megrendelesekNyomas_10000_felett ;
		$stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul_10000_felett"] = $megrendelesTetelekNyomas_10000_felett ;		
		$stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul_10000_felett"] = $megrendelesOsszegNyomas_10000_felett ;
		$stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_felett"] = $megrendelesTetelekLegparnas_10000_felett ;		
		$stat_adatok["megrendelesOsszegLegparnas_kiemeltek_nelkul_10000_felett"] = $megrendelesOsszegLegparnas_10000_felett ;
		$stat_adatok["megrendelesCegekEladas_kiemeltek_nelkul_10000_felett"] = count($megrendelesCegek_kiemeltek_nelkul_10000_felett["eladás"]) ;
		$stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkul_10000_felett"] = count($megrendelesCegek_kiemeltek_nelkul_10000_felett["nyomás"]) ;		
		
		if ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul"] > 0)
//			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalek"] = round((($stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul"]) / ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul"])) * 100, 2) ;
			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalek"] = round(($stat_adatok["megrendelesStatisztika_kiemeltek_nelkul"] / $stat_adatok["arajanlatStatisztika_kiemeltek_nelkul"]) * 100, 2) ;
		else
			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalek"] = 0 ;
		if ($stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul"] > 0)
//			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalek"] = round(($stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul"] / $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul"]) * 100, 2) ;
			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalek"] = round(($stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul"] / $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul"]) * 100, 2) ;
		else
			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalek"] = 0 ;
		if ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul"] > 0)
//			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalek"] = round((($stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul"]) / ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul"])) * 100, 2) ;
			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalek"] = round((($stat_adatok["megrendelesStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul"]) / ($stat_adatok["arajanlatStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul"])) * 100, 2) ;
		else
			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalek"] = 0 ;
		if ($stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul"] > 0) 
			$stat_adatok["eladas_arajanlatcegek_megrendelescegek_szazalek"] = round(($stat_adatok["megrendelesCegekEladas_kiemeltek_nelkul"] / $stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul"]) * 100, 2) ;
		else
			$stat_adatok["eladas_arajanlatcegek_megrendelescegek_szazalek"] = 0 ;
		if ($stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul"] > 0) 
			$stat_adatok["nyomas_arajanlatcegek_megrendelescegek_szazalek"] = round(($stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkul"] / $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul"]) * 100, 2) ;
		else
			$stat_adatok["nyomas_arajanlatcegek_megrendelescegek_szazalek"] = 0 ;
		if ($stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul"] + $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul"] > 0) 
			$stat_adatok["osszesen_arajanlatcegek_megrendelescegek_szazalek"] = round((($stat_adatok["megrendelesCegekEladas_kiemeltek_nelkul"] + $stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkul"]) / ($stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul"] + $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul"])) * 100, 2) ;
		else
			$stat_adatok["osszesen_arajanlatcegek_megrendelescegek_szazalek"] = 0 ;
			
		$stat_adatok["anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul"] = $anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul ;
		$stat_adatok["anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul"] = $anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul ;
		$stat_adatok["anyagkoltseg_osszesen_kiemeltek_nelkul"] = $anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul + $anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul ;
		$stat_adatok["bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul"] = $bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul ;
		$stat_adatok["bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul"] = $bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul ;
		$stat_adatok["bevetel_termekeken_osszesen_kiemeltek_nelkul"] = $bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul + $bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul ;
		$stat_adatok["haszon_eladas_kiemeltek_nelkul"] = $bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul - $anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul;
		$stat_adatok["haszon_nyomas_kiemeltek_nelkul"] = $bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul - $anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul;
		$stat_adatok["haszon_osszesen_kiemeltek_nelkul"] = $stat_adatok["haszon_eladas_kiemeltek_nelkul"] + $stat_adatok["haszon_nyomas_kiemeltek_nelkul"];
		if ($stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul"] > 0)
			$stat_adatok["anyag_szazalek_kiemeltek_nelkul"] = round($stat_adatok["anyagkoltseg_osszesen_kiemeltek_nelkul"] / $stat_adatok["bevetel_termekeken_osszesen_kiemeltek_nelkul"] * 100, 2) ;
		else
			$stat_adatok["anyag_szazalek_kiemeltek_nelkul"] = 0 ;
		if ($stat_adatok["anyagkoltseg_osszesen_kiemeltek_nelkul"] > 0)			
			$stat_adatok["haszon_lentrol_kiemeltek_nelkul"] = round($stat_adatok["haszon_osszesen_kiemeltek_nelkul"] / $stat_adatok["anyagkoltseg_osszesen_kiemeltek_nelkul"] * 100, 2);
		else
			$stat_adatok["haszon_lentrol_kiemeltek_nelkul"] = 0 ;
		if ($stat_adatok["anyagkoltseg_osszesen_kiemeltek_nelkul"] > 0)
			$stat_adatok["haszon_fentrol_kiemeltek_nelkul"] = round($stat_adatok["haszon_osszesen_kiemeltek_nelkul"] / $stat_adatok["bevetel_termekeken_osszesen_kiemeltek_nelkul"] * 100, 2);
		else
			$stat_adatok["haszon_fentrol_kiemeltek_nelkul"] ;
			
		if ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] > 0)
//			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalek_10000_alatt"] = round((($stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"]) / ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"])) * 100, 2) ;
			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalek_10000_alatt"] = round(($stat_adatok["megrendelesStatisztika_kiemeltek_nelkul_10000_alatt"] / $stat_adatok["arajanlatStatisztika_kiemeltek_nelkul_10000_alatt"]) * 100, 2) ;
		else
			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalek_10000_alatt"] = 0 ;
		if ($stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] > 0)
//			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalek_10000_alatt"] = round(($stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] / $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"]) * 100, 2) ;
			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalek_10000_alatt"] = round(($stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul_10000_alatt"] / $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul_10000_alatt"]) * 100, 2) ;
		else
			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalek_10000_alatt"] = 0 ;
		if ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] > 0)
//			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalek_10000_alatt"] = round((($stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"]) / ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul_10000_alatt"])) * 100, 2) ;
			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalek_10000_alatt"] = round((($stat_adatok["megrendelesStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul_10000_alatt"]) / ($stat_adatok["arajanlatStatisztika_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul_10000_alatt"])) * 100, 2) ;
		else
			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalek_10000_alatt"] = 0 ;
		if ($stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul_10000_alatt"] > 0) 
			$stat_adatok["eladas_arajanlatcegek_megrendelescegek_szazalek_10000_alatt"] = round(($stat_adatok["megrendelesCegekEladas_kiemeltek_nelkul_10000_alatt"] / $stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul_10000_alatt"]) * 100, 2) ;
		else
			$stat_adatok["eladas_arajanlatcegek_megrendelescegek_szazalek_10000_alatt"] = 0 ;
		if ($stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul_10000_alatt"] > 0) 
			$stat_adatok["nyomas_arajanlatcegek_megrendelescegek_szazalek_10000_alatt"] = round(($stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkul_10000_alatt"] / $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul_10000_alatt"]) * 100, 2) ;
		else
			$stat_adatok["nyomas_arajanlatcegek_megrendelescegek_szazalek_10000_alatt"] = 0 ;
		if ($stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul_10000_alatt"] > 0) 
			$stat_adatok["osszesen_arajanlatcegek_megrendelescegek_szazalek_10000_alatt"] = round((($stat_adatok["megrendelesCegekEladas_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkul_10000_alatt"]) / ($stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul_10000_alatt"])) * 100, 2) ;
		else
			$stat_adatok["osszesen_arajanlatcegek_megrendelescegek_szazalek_10000_alatt"] = 0 ;
			
		$stat_adatok["anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_alatt"] = $anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_alatt ;
		$stat_adatok["anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_alatt"] = $anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_alatt ;
		$stat_adatok["anyagkoltseg_osszesen_kiemeltek_nelkul_10000_alatt"] = $anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_alatt + $anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_alatt ;
		$stat_adatok["bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_alatt"] = $bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_alatt ;
		$stat_adatok["bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_alatt"] = $bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_alatt ;
		$stat_adatok["bevetel_termekeken_osszesen_kiemeltek_nelkul_10000_alatt"] = $bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_alatt + $bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_alatt ;
		$stat_adatok["haszon_eladas_kiemeltek_nelkul_10000_alatt"] = $bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_alatt - $anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_alatt;
		$stat_adatok["haszon_nyomas_kiemeltek_nelkul_10000_alatt"] = $bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_alatt - $anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_alatt;
		$stat_adatok["haszon_osszesen_kiemeltek_nelkul_10000_alatt"] = $stat_adatok["haszon_eladas_kiemeltek_nelkul_10000_alatt"] + $stat_adatok["haszon_nyomas_kiemeltek_nelkul_10000_alatt"];
			
		if ($stat_adatok["arajanlatStatisztika_kiemeltek_nelkul_10000_felett"] > 0)
//			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalek_10000_felett"] = round((($stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_felett"]) / ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_felett"])) * 100, 2) ;
			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalek_10000_felett"] = round(($stat_adatok["megrendelesStatisztika_kiemeltek_nelkul_10000_felett"] / $stat_adatok["arajanlatStatisztika_kiemeltek_nelkul_10000_felett"]) * 100, 2) ;
		else
			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalek_10000_felett"] = 0 ;
		if ($stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul_10000_felett"] > 0)
//			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalek_10000_felett"] = round(($stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul_10000_felett"] / $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul_10000_felett"]) * 100, 2) ;
			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalek_10000_felett"] = round(($stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul_10000_felett"] / $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul_10000_felett"]) * 100, 2) ;
		else
			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalek_10000_felett"] = 0 ;
		if ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul_10000_felett"] > 0)
//			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalek_10000_felett"] = round((($stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul_10000_felett"]) / ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul_10000_felett"])) * 100, 2) ;
			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalek_10000_felett"] = round((($stat_adatok["megrendelesStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul_10000_felett"]) / ($stat_adatok["arajanlatStatisztika_kiemeltek_nelkul_10000_felett"] + $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul_10000_felett"])) * 100, 2) ;
		else
			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalek_10000_felett"] = 0 ;
		if ($stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul_10000_felett"] > 0) 
			$stat_adatok["eladas_arajanlatcegek_megrendelescegek_szazalek_10000_felett"] = round(($stat_adatok["megrendelesCegekEladas_kiemeltek_nelkul_10000_felett"] / $stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul_10000_felett"]) * 100, 2) ;
		else
			$stat_adatok["eladas_arajanlatcegek_megrendelescegek_szazalek_10000_felett"] = 0 ;
		if ($stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul_10000_felett"] > 0) 
			$stat_adatok["nyomas_arajanlatcegek_megrendelescegek_szazalek_10000_felett"] = round(($stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkul_10000_felett"] / $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul_10000_felett"]) * 100, 2) ;
		else
			$stat_adatok["nyomas_arajanlatcegek_megrendelescegek_szazalek_10000_felett"] = 0 ;
		if ($stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul_10000_felett"] + $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul_10000_felett"] > 0) 
			$stat_adatok["osszesen_arajanlatcegek_megrendelescegek_szazalek_10000_felett"] = round((($stat_adatok["megrendelesCegekEladas_kiemeltek_nelkul_10000_felett"] + $stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkul_10000_felett"]) / ($stat_adatok["arajanlatCegekEladas_kiemeltek_nelkul_10000_felett"] + $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkul_10000_felett"])) * 100, 2) ;
		else
			$stat_adatok["osszesen_arajanlatcegek_megrendelescegek_szazalek_10000_felett"] = 0 ;
			
		$stat_adatok["anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_felett"] = $anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_felett ;
		$stat_adatok["anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_felett"] = $anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_felett ;
		$stat_adatok["anyagkoltseg_osszesen_kiemeltek_nelkul_10000_felett"] = $anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_felett + $anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_felett ;
		$stat_adatok["bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_felett"] = $bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_felett ;
		$stat_adatok["bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_felett"] = $bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_felett ;
		$stat_adatok["bevetel_termekeken_osszesen_kiemeltek_nelkul_10000_felett"] = $bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_felett + $bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_felett ;
		$stat_adatok["haszon_eladas_kiemeltek_nelkul_10000_felett"] = $bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_felett - $anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_felett;
		$stat_adatok["haszon_nyomas_kiemeltek_nelkul_10000_felett"] = $bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_felett - $anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_felett;
		$stat_adatok["haszon_osszesen_kiemeltek_nelkul_10000_felett"] = $stat_adatok["haszon_eladas_kiemeltek_nelkul_10000_felett"] + $stat_adatok["haszon_nyomas_kiemeltek_nelkul_10000_felett"];

		unset($megrendelesTetelekStatisztika_kiemeltek_nelkul) ;
		
//Megrendeléssel kapcsolatos statisztikák kiemelt cégek		
		$megrendelesTetelekStatisztika_csak_kiemeltek = $this->getMegrendelesTetelekStatisztika($model, 1) ;
		$megrendelesekEladas = 0 ;
		$megrendelesTetelekEladas = 0 ;
		$megrendelesOsszegEladas_csak_kiemeltek = 0 ;
		$megrendelesTetelekLegparnas = 0 ;
		$megrendelesOsszegLegparnas = 0 ;
		$megrendelesekNyomas = 0 ;
		$megrendelesTetelekNyomas = 0 ;
		$megrendelesOsszegNyomas = 0 ;
		$bevetel_termekeken_eladas_osszesen_csak_kiemeltek = 0 ;
		$bevetel_termekeken_nyomas_osszesen_csak_kiemeltek = 0 ;
		$anyagkoltseg_termekeken_eladas_osszesen_csak_kiemeltek = 0 ;
		$anyagkoltseg_termekeken_nyomas_osszesen_csak_kiemeltek = 0 ;
		$cegek_kiemeltek = array() ;		
		$cegek_megrendelesszam_osszesen_csak_kiemeltek = 0 ;
		$cegek_megrendelesosszeg_csak_kiemeltek = 0 ;
		if ($megrendelesTetelekStatisztika_csak_kiemeltek->totalItemCount > 0) {
			foreach ($megrendelesTetelekStatisztika_csak_kiemeltek->getData() as $sor) {
				$cegek_kiemeltek[$sor->ugyfel->cegnev]["megrendelesszam"]++ ;
				$cegek_megrendelesszam_osszesen_csak_kiemeltek++ ;
				$nyomas = false ;				
				foreach ($sor->tetelek as $tetel_sor) {
					$cegek_kiemeltek[$sor->ugyfel->cegnev]["megrendeles_osszeg"] += ($tetel_sor->netto_darabar * $tetel_sor->darabszam) ;
					$cegek_megrendelesosszeg_csak_kiemeltek += ($tetel_sor->netto_darabar * $tetel_sor->darabszam) ;
					$db_eladasi_ar = 0 ;
					$termek = $tetel_sor->termek ;
					$ervenyes_termekar_rekord = "" ;
					$i = 0 ;
					$l = false ;
					while ($i < count($termek->termekar) && !$l) {
						if ($sor->rendeles_idopont >= $termek->termekar[$i]->datum_mettol && $sor->rendeles_idopont <= $termek->termekar[$i]->datum_meddig) {
							$l = true ;
							$ervenyes_termekar_rekord = $termek->termekar[$i] ;
						}
						$i++ ;						
					}					
//					print_r($termek->termekar) ;
					if ($tetel_sor->termek->termekcsoport_id == 1)	{	//Ha légpárnás boríték, akkor a légpárnás statba is betesszük
						$megrendelesTetelekLegparnas++ ;
						$megrendelesOsszegLegparnas += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						if ($tetel_sor->darabszam >= $termek->csom_egys) {
							$db_eladasi_ar = $ervenyes_termekar_rekord->csomag_eladasi_ar / $termek->csom_egys ;	
						}
						else
						{
							$db_eladasi_ar = $ervenyes_termekar_rekord->db_eladasi_ar ;
						}
//						echo "aaa $sor->id: $db_eladasi_ar * $tetel_sor->darabszam = " . ($db_eladasi_ar * $tetel_sor->darabszam) . "<br />" ;
						$bevetel_termekeken_eladas_osszesen_csak_kiemeltek += ($db_eladasi_ar * $tetel_sor->darabszam) ;
						if ($tetel_sor->hozott_boritek == 0) {
							$anyagkoltseg_termekeken_eladas_osszesen_csak_kiemeltek += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
						}
					}
					elseif ($tetel_sor->szinek_szama1 + $tetel_sor->szinek_szama2 > 0) {
						$nyomas = true ;
						$megrendelesTetelekNyomas++ ;
						$megrendelesOsszegNyomas += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						if ($tetel_sor->darabszam >= $termek->csom_egys) {
							$db_eladasi_ar = $ervenyes_termekar_rekord->db_ar_nyomashoz / $termek->csom_egys ;	
						}
						else
						{
							$db_eladasi_ar = $ervenyes_termekar_rekord->csomag_ar_nyomashoz ;
						}						
//						echo "bbb: $db_eladasi_ar * $tetel_sor->darabszam = " . ($db_eladasi_ar * $tetel_sor->darabszam) . "<br />" ;
						$bevetel_termekeken_nyomas_osszesen_csak_kiemeltek += ($tetel_sor->netto_darabar * $tetel_sor->darabszam) ;
						if ($tetel_sor->hozott_boritek == 0) {
							$anyagkoltseg_termekeken_nyomas_osszesen_csak_kiemeltek += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
						}
					}
					elseif ($tetel_sor->termek->tipus != "Szolgáltatás")		//Ide most minden bemegy, ami nem légpárnás, nem nyomás és nem szolgáltatás, tehát ide megy a ragasztószalag, levélpapír, stb. is
					{
						$megrendelesTetelekEladas++ ;
						$megrendelesOsszegEladas_csak_kiemeltek += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;	
						if ($tetel_sor->darabszam >= $termek->csom_egys) {
							$db_eladasi_ar = $ervenyes_termekar_rekord->csomag_eladasi_ar / $termek->csom_egys ;	
						}
						else
						{
							$db_eladasi_ar = $ervenyes_termekar_rekord->db_eladasi_ar ;
						}		
//						echo "ccc $sor->id: $db_eladasi_ar * $tetel_sor->darabszam = " . ($db_eladasi_ar * $tetel_sor->darabszam) . "<br />" ;
						$bevetel_termekeken_eladas_osszesen_csak_kiemeltek += ($db_eladasi_ar * $tetel_sor->darabszam) ;						
						if ($tetel_sor->hozott_boritek == 0) {
							$anyagkoltseg_termekeken_eladas_osszesen_csak_kiemeltek += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
						}
					}					
				}
				if ($nyomas) {
					$megrendelesekNyomas++ ;
				}
				else
				{
					$megrendelesekEladas++ ;
				}
			}
		}
//		die($anyagkoltseg_termekeken_eladas_osszesen_csak_kiemeltek) ;
		$stat_adatok["megrendelesStatisztika_csak_kiemeltek"] = $megrendelesekEladas ;
		$stat_adatok["megrendelesTetelekStatisztika_csak_kiemeltek"] = $megrendelesTetelekEladas ;		
		$stat_adatok["megrendelesOsszegEladas_csak_kiemeltek"] = $megrendelesOsszegEladas_csak_kiemeltek ;
		$stat_adatok["megrendelesNyomasStatisztika_csak_kiemeltek"] = $megrendelesekNyomas ;
		$stat_adatok["megrendelesNyomasTetelekStatisztika_csak_kiemeltek"] = $megrendelesTetelekNyomas ;		
		$stat_adatok["megrendelesOsszegNyomas_csak_kiemeltek"] = $megrendelesOsszegNyomas ;
		$stat_adatok["megrendelesLegparnasTetelekStatisztika_csak_kiemeltek"] = $megrendelesTetelekLegparnas ;		
		$stat_adatok["megrendelesOsszegLegparnas_csak_kiemeltek"] = $megrendelesOsszegLegparnas ;
		$stat_adatok["anyagkoltseg_termekeken_eladas_osszesen_csak_kiemeltek"] = $anyagkoltseg_termekeken_eladas_osszesen_csak_kiemeltek ;
		$stat_adatok["anyagkoltseg_termekeken_nyomas_osszesen_csak_kiemeltek"] = $anyagkoltseg_termekeken_nyomas_osszesen_csak_kiemeltek ;
		$stat_adatok["anyagkoltseg_osszesen_csak_kiemeltek"] = $anyagkoltseg_termekeken_eladas_osszesen_csak_kiemeltek + $anyagkoltseg_termekeken_nyomas_osszesen_csak_kiemeltek ;
		$stat_adatok["bevetel_termekeken_eladas_osszesen_csak_kiemeltek"] = $bevetel_termekeken_eladas_osszesen_csak_kiemeltek ;
		$stat_adatok["bevetel_termekeken_nyomas_osszesen_csak_kiemeltek"] = $bevetel_termekeken_nyomas_osszesen_csak_kiemeltek ;
		$stat_adatok["bevetel_termekeken_osszesen_csak_kiemeltek"] = $bevetel_termekeken_eladas_osszesen_csak_kiemeltek + $bevetel_termekeken_nyomas_osszesen_csak_kiemeltek ;
		$stat_adatok["haszon_eladas_csak_kiemeltek"] = $bevetel_termekeken_eladas_osszesen_csak_kiemeltek - $anyagkoltseg_termekeken_eladas_osszesen_csak_kiemeltek;
		$stat_adatok["haszon_nyomas_csak_kiemeltek"] = $bevetel_termekeken_nyomas_osszesen_csak_kiemeltek - $anyagkoltseg_termekeken_nyomas_osszesen_csak_kiemeltek;
		$stat_adatok["haszon_osszesen_csak_kiemeltek"] = $stat_adatok["haszon_eladas_csak_kiemeltek"] + $stat_adatok["haszon_nyomas_csak_kiemeltek"];
		if ($stat_adatok["megrendelesOsszegEladas_csak_kiemeltek"] + $stat_adatok["megrendelesOsszegNyomas_csak_kiemeltek"] > 0) 
			$stat_adatok["anyag_szazalek_csak_kiemeltek"] = round($stat_adatok["anyagkoltseg_osszesen_csak_kiemeltek"] / $stat_adatok["bevetel_termekeken_osszesen_csak_kiemeltek"] * 100, 2) ;
		else
			$stat_adatok["anyag_szazalek_csak_kiemeltek"] = 0 ;
		if ($stat_adatok["anyagkoltseg_osszesen_csak_kiemeltek"] > 0)
			$stat_adatok["haszon_lentrol_csak_kiemeltek"] = round($stat_adatok["haszon_osszesen_csak_kiemeltek"] / $stat_adatok["anyagkoltseg_osszesen_csak_kiemeltek"] * 100, 2);
		else
			$stat_adatok["haszon_lentrol_csak_kiemeltek"] = 0 ;
		if ($stat_adatok["anyagkoltseg_osszesen_csak_kiemeltek"] > 0)
			$stat_adatok["haszon_fentrol_csak_kiemeltek"] = round($stat_adatok["haszon_osszesen_csak_kiemeltek"] / $stat_adatok["bevetel_termekeken_osszesen_csak_kiemeltek"], 2);
		else
			$stat_adatok["haszon_fentrol_csak_kiemeltek"] = 0;
		$stat_adatok["cegek_kiemeltek"] = $cegek_kiemeltek ;
		$stat_adatok["cegek_megrendelesszam_osszesen_csak_kiemeltek"] = $cegek_megrendelesszam_osszesen_csak_kiemeltek ;
		$stat_adatok["cegek_megrendelesosszeg_csak_kiemeltek"] = $cegek_megrendelesosszeg_csak_kiemeltek ;
		$stat_adatok["kiadott_ajanlatok_szama_osszesen"] = $stat_adatok["arajanlatStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatStatisztika_csak_kiemeltek"] + $stat_adatok["arajanlatNyomasStatisztika_csak_kiemeltek"] ;
		$stat_adatok["kiadott_ajanlatok_erteke_osszesen"] = $stat_adatok["arajanlatOsszegEladas_kiemeltek_nelkul"] + $stat_adatok["arajanlatOsszegNyomas_kiemeltek_nelkul"] + $stat_adatok["arajanlatOsszegLegparnas_kiemeltek_nelkul"] + $stat_adatok["arajanlatOsszegEladas_csak_kiemeltek"] + $stat_adatok["arajanlatOsszegNyomas_csak_kiemeltek"] + $stat_adatok["arajanlatOsszegLegparnas_csak_kiemeltek"] ;
		$stat_adatok["megrendelesek_szama_osszesen"] = $stat_adatok["megrendelesStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesStatisztika_csak_kiemeltek"] + $stat_adatok["megrendelesNyomasStatisztika_csak_kiemeltek"] ;
		$stat_adatok["megrendelesek_erteke_osszesen"] = $stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegLegparnas_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegEladas_csak_kiemeltek"] + $stat_adatok["megrendelesOsszegNyomas_csak_kiemeltek"] + $stat_adatok["megrendelesOsszegLegparnas_csak_kiemeltek"] ;
		unset($megrendelesTetelekStatisztika_csak_kiemeltek) ;
		
		//Számlázás adatok, csak megrendelt (árajánlat kérés nélküli)
		$szamlazott_megrendelesek = $this->getMegrendelesTetelekStatisztikaSzamlazott($model, "ajanlat_nelkul") ;
		$szamlazott_megrendelesek_ajanlat_nelkul_eladas_kiemeltek_nelkul = 0 ;
		$szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszeg_kiemeltek_nelkul = 0 ;
		$szamlazott_megrendelesek_ajanlat_nelkul_nyomas_kiemeltek_nelkul = 0 ;
		$szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszeg_kiemeltek_nelkul = 0 ;
		$szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszesen = 0 ;
		$szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszeg_osszesen = 0 ;
		$szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszesen = 0 ;
		$szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszeg_osszesen = 0 ;
		$szamlazott_megrendelesek_ajanlat_nelkul_osszesen_kiemeltek_nelkul = 0 ;
		$szamlazott_megrendelesek_ajanlat_nelkul_osszesen_osszeg_kiemeltek_nelkul = 0 ;
		$szamlazott_megrendelesek_ajanlat_nelkul_osszesen = 0 ;
		$szamlazott_megrendelesek_ajanlat_nelkul_osszeg_osszesen = 0 ;
		if ($szamlazott_megrendelesek->totalItemCount > 0) {
			foreach ($szamlazott_megrendelesek->getData() as $sor) {
				$nyomas = false ;				
				foreach ($sor->tetelek as $tetel_sor) {
					$termek = $tetel_sor->termek ;
					if ($tetel_sor->szinek_szama1 + $tetel_sor->szinek_szama2 > 0) {
						$nyomas = true ;
						if ($sor->ugyfel->kiemelt == 1) {
							$szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszeg_osszesen += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						}
						else {
							$szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszeg_osszesen += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							$szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszeg_kiemeltek_nelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						}
					}
					elseif ($tetel_sor->termek->tipus != "Szolgáltatás")		//Ide most minden bemegy, ami nem légpárnás, nem nyomás és nem szolgáltatás, tehát ide megy a ragasztószalag, levélpapír, stb. is
					{
						if ($sor->ugyfel->kiemelt == 1) {
							$szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszeg_osszesen += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						}
						else {
							$szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszeg_osszesen += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							$szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszeg_kiemeltek_nelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						}
					}
				}					
				if ($nyomas) {
					if ($sor->ugyfel->kiemelt == 1) {
						$szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszesen++ ;
					}
					else
					{
						$szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszesen++ ;
						$szamlazott_megrendelesek_ajanlat_nelkul_nyomas_kiemeltek_nelkul++ ;
					}
				}
				else
				{
					if ($sor->ugyfel->kiemelt == 1) {
						$szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszesen++ ;
					}
					else
					{
						$szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszesen++ ;
						$szamlazott_megrendelesek_ajanlat_nelkul_eladas_kiemeltek_nelkul++ ;
					}
				}
			}		
			$szamlazott_megrendelesek_ajanlat_nelkul_osszesen_kiemeltek_nelkul = $szamlazott_megrendelesek_ajanlat_nelkul_nyomas_kiemeltek_nelkul + $szamlazott_megrendelesek_ajanlat_nelkul_eladas_kiemeltek_nelkul ;
			$szamlazott_megrendelesek_ajanlat_nelkul_osszesen_osszeg_kiemeltek_nelkul = $szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszeg_kiemeltek_nelkul + $szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszeg_kiemeltek_nelkul ;
			$szamlazott_megrendelesek_ajanlat_nelkul_osszesen = $szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszesen + $szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszesen ;
			$szamlazott_megrendelesek_ajanlat_nelkul_osszeg_osszesen = $szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszeg_osszesen + $szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszeg_osszesen ;			
		}
		$stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_eladas_kiemeltek_nelkul"] = $szamlazott_megrendelesek_ajanlat_nelkul_eladas_kiemeltek_nelkul ;
		$stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszeg_kiemeltek_nelkul"] = $szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszeg_kiemeltek_nelkul ;
		$stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_nyomas_kiemeltek_nelkul"] = $szamlazott_megrendelesek_ajanlat_nelkul_nyomas_kiemeltek_nelkul ;
		$stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszeg_kiemeltek_nelkul"] = $szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszeg_kiemeltek_nelkul ;
		$stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszesen"] = $szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszesen ;
		$stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszeg_osszesen"] = $szamlazott_megrendelesek_ajanlat_nelkul_eladas_osszeg_osszesen ;
		$stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszesen"] = $szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszesen ;
		$stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszeg_osszesen"] = $szamlazott_megrendelesek_ajanlat_nelkul_nyomas_osszeg_osszesen ;
		$stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_osszesen_kiemeltek_nelkul"] = $szamlazott_megrendelesek_ajanlat_nelkul_osszesen_kiemeltek_nelkul ;
		$stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_osszesen_osszeg_kiemeltek_nelkul"] = $szamlazott_megrendelesek_ajanlat_nelkul_osszesen_osszeg_kiemeltek_nelkul ;
		$stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_osszesen"] = $szamlazott_megrendelesek_ajanlat_nelkul_osszesen ;
		$stat_adatok["szamlazott_megrendelesek_ajanlat_nelkul_osszeg_osszesen"] = $szamlazott_megrendelesek_ajanlat_nelkul_osszeg_osszesen ;
		unset($szamlazott_megrendelesek) ;
		
		//Számlázás adatok összes
		$szamlazott_megrendelesek = $this->getMegrendelesTetelekStatisztikaSzamlazott($model) ;
		$szamlazott_megrendelesek_eladas_kiemeltek_nelkul = 0 ;
		$szamlazott_megrendelesek_eladas_osszeg_kiemeltek_nelkul = 0 ;
		$szamlazott_megrendelesek_nyomas_kiemeltek_nelkul = 0 ;
		$szamlazott_megrendelesek_nyomas_osszeg_kiemeltek_nelkul = 0 ;
		$szamlazott_megrendelesek_eladas_osszesen = 0 ;
		$szamlazott_megrendelesek_eladas_osszeg_osszesen = 0 ;
		$szamlazott_megrendelesek_nyomas_osszesen = 0 ;
		$szamlazott_megrendelesek_nyomas_osszeg_osszesen = 0 ;
		$szamlazott_megrendelesek_osszesen_kiemeltek_nelkul = 0 ;
		$szamlazott_megrendelesek_osszesen_osszeg_kiemeltek_nelkul = 0 ;
		$szamlazott_megrendelesek_osszesen = 0 ;
		$szamlazott_megrendelesek_osszeg_osszesen = 0 ;
		if ($szamlazott_megrendelesek->totalItemCount > 0) {
			foreach ($szamlazott_megrendelesek->getData() as $sor) {
				$nyomas = false ;				
				foreach ($sor->tetelek as $tetel_sor) {
					$termek = $tetel_sor->termek ;
					if ($tetel_sor->szinek_szama1 + $tetel_sor->szinek_szama2 > 0) {
						$nyomas = true ;
						if ($sor->ugyfel->kiemelt == 1) {
							$szamlazott_megrendelesek_nyomas_osszeg_osszesen += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						}
						else {
							$szamlazott_megrendelesek_nyomas_osszeg_osszesen += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							$szamlazott_megrendelesek_nyomas_osszeg_kiemeltek_nelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						}
					}
					elseif ($tetel_sor->termek->tipus != "Szolgáltatás")		//Ide most minden bemegy, ami nem légpárnás, nem nyomás és nem szolgáltatás, tehát ide megy a ragasztószalag, levélpapír, stb. is
					{
						if ($sor->ugyfel->kiemelt == 1) {
							$szamlazott_megrendelesek_eladas_osszeg_osszesen += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						}
						else {
							$szamlazott_megrendelesek_eladas_osszeg_osszesen += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							$szamlazott_megrendelesek_eladas_osszeg_kiemeltek_nelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						}
					}
				}					
				if ($nyomas) {
					if ($sor->ugyfel->kiemelt == 1) {
						$szamlazott_megrendelesek_nyomas_osszesen++ ;
					}
					else
					{
						$szamlazott_megrendelesek_nyomas_osszesen++ ;
						$szamlazott_megrendelesek_nyomas_kiemeltek_nelkul++ ;
					}
				}
				else
				{
					if ($sor->ugyfel->kiemelt == 1) {
						$szamlazott_megrendelesek_eladas_osszesen++ ;
					}
					else
					{
						$szamlazott_megrendelesek_eladas_osszesen++ ;
						$szamlazott_megrendelesek_eladas_kiemeltek_nelkul++ ;
					}
				}
			}		
			$szamlazott_megrendelesek_osszesen_kiemeltek_nelkul = $szamlazott_megrendelesek_nyomas_kiemeltek_nelkul + $szamlazott_megrendelesek_eladas_kiemeltek_nelkul ;
			$szamlazott_megrendelesek_osszesen_osszeg_kiemeltek_nelkul = $szamlazott_megrendelesek_nyomas_osszeg_kiemeltek_nelkul + $szamlazott_megrendelesek_eladas_osszeg_kiemeltek_nelkul ;
			$szamlazott_megrendelesek_osszesen = $szamlazott_megrendelesek_nyomas_osszesen + $szamlazott_megrendelesek_eladas_osszesen ;
			$szamlazott_megrendelesek_osszeg_osszesen = $szamlazott_megrendelesek_nyomas_osszeg_osszesen + $szamlazott_megrendelesek_eladas_osszeg_osszesen ;			
		}
		$stat_adatok["szamlazott_megrendelesek_eladas_kiemeltek_nelkul"] = $szamlazott_megrendelesek_eladas_kiemeltek_nelkul ;
		$stat_adatok["szamlazott_megrendelesek_eladas_osszeg_kiemeltek_nelkul"] = $szamlazott_megrendelesek_eladas_osszeg_kiemeltek_nelkul ;
		$stat_adatok["szamlazott_megrendelesek_nyomas_kiemeltek_nelkul"] = $szamlazott_megrendelesek_nyomas_kiemeltek_nelkul ;
		$stat_adatok["szamlazott_megrendelesek_nyomas_osszeg_kiemeltek_nelkul"] = $szamlazott_megrendelesek_nyomas_osszeg_kiemeltek_nelkul ;
		$stat_adatok["szamlazott_megrendelesek_eladas_osszesen"] = $szamlazott_megrendelesek_eladas_osszesen ;
		$stat_adatok["szamlazott_megrendelesek_eladas_osszeg_osszesen"] = $szamlazott_megrendelesek_eladas_osszeg_osszesen ;
		$stat_adatok["szamlazott_megrendelesek_nyomas_osszesen"] = $szamlazott_megrendelesek_nyomas_osszesen ;
		$stat_adatok["szamlazott_megrendelesek_nyomas_osszeg_osszesen"] = $szamlazott_megrendelesek_nyomas_osszeg_osszesen ;
		$stat_adatok["szamlazott_megrendelesek_osszesen_kiemeltek_nelkul"] = $szamlazott_megrendelesek_osszesen_kiemeltek_nelkul ;
		$stat_adatok["szamlazott_megrendelesek_osszesen_osszeg_kiemeltek_nelkul"] = $szamlazott_megrendelesek_osszesen_osszeg_kiemeltek_nelkul ;
		$stat_adatok["szamlazott_megrendelesek_osszesen"] = $szamlazott_megrendelesek_osszesen ;
		$stat_adatok["szamlazott_megrendelesek_osszeg_osszesen"] = $szamlazott_megrendelesek_osszeg_osszesen ;		
		unset($szamlazott_megrendelesek) ;
		
		//Pénzügyi tranzakciók
		$penzugyi_tranzakciok = $this->getPenzugyiTranzakciok($model) ;
		$termek_eladas_penztar_db = 0 ;
		$termek_eladas_penztar_netto = 0 ;
		$termek_eladas_penztar_brutto = 0 ;
		$termek_eladas_utalas_db = 0 ;
		$termek_eladas_utalas_netto = 0 ;
		$termek_eladas_utalas_brutto = 0 ;
		$termek_eladas_osszesen_netto = 0 ;
		$termek_eladas_osszesen_brutto = 0 ;
		$boritek_nyomas_penztar_db = 0 ;
		$boritek_nyomas_penztar_netto = 0 ;
		$boritek_nyomas_penztar_brutto = 0 ;
		$boritek_nyomas_utalas_db = 0 ;
		$boritek_nyomas_utalas_netto = 0 ;
		$boritek_nyomas_utalas_brutto = 0 ;
		$boritek_nyomas_osszesen_netto = 0 ;
		$boritek_nyomas_osszesen_brutto = 0 ;
		$penztar_tranzakcio_db_osszesen = 0 ;
		$penztar_tranzakcio_netto_osszesen = 0 ;
		$penztar_tranzakcio_brutto_osszesen = 0 ;
		$utalas_tranzakcio_db_osszesen = 0 ;
		$utalas_tranzakcio_netto_osszesen = 0 ;
		$utalas_tranzakcio_brutto_osszesen = 0 ;
		$tranzakciok_netto_osszesen = 0 ;
		$tranzakciok_brutto_osszesen = 0 ;
		$alap_afa_szazalek = Utils::getAlapertelmezettAFASzazalek() ;
		if ($penzugyi_tranzakciok->totalItemCount > 0) {
			$elozo_megrendeles_id = 0 ;
			foreach ($penzugyi_tranzakciok->getData() as $sor) {
				$szinek_szama = 0 ;
				foreach($sor->megrendeles->tetelek as $tetel) {
					$szinek_szama = $szinek_szama + $tetel->szinek_szama1 + $tetel->szinek_szama2 ;	
				}
				
				if ($szinek_szama == 0) {
					//Eladás volt
					if ($sor->mode == "Bank") {
						if ($elozo_megrendeles_id != $sor->megrendeles_id) {
							$termek_eladas_utalas_db++ ;
							$utalas_tranzakcio_db_osszesen++ ;
							$elozo_megrendeles_id = $sor->megrendeles_id ;
						}
						$termek_eladas_utalas_netto += ($sor->osszeg / (100 + $alap_afa_szazalek) * 100) ;
						$termek_eladas_utalas_brutto += $sor->osszeg;
						$utalas_tranzakcio_netto_osszesen += ($sor->osszeg / (100 + $alap_afa_szazalek) * 100) ;
						$utalas_tranzakcio_brutto_osszesen += $sor->osszeg;
					}
					else
					{
						if ($elozo_megrendeles_id != $sor->megrendeles_id) {
							$termek_eladas_penztar_db++ ;
							$penztar_tranzakcio_db_osszesen++ ;
							$elozo_megrendeles_id = $sor->megrendeles_id ;
						}
						$termek_eladas_penztar_netto += ($sor->osszeg / (100 + $alap_afa_szazalek) * 100) ;
						$termek_eladas_penztar_brutto += $sor->osszeg;
						$penztar_tranzakcio_netto_osszesen += ($sor->osszeg / (100 + $alap_afa_szazalek) * 100) ;
						$penztar_tranzakcio_brutto_osszesen += $sor->osszeg;
					}
					$termek_eladas_osszesen_netto += ($sor->osszeg / (100 + $alap_afa_szazalek) * 100) ;
					$termek_eladas_osszesen_brutto += $sor->osszeg;
				}
				else
				{
					//Nyomás volt
					if ($sor->mode == "Bank") {
						if ($elozo_megrendeles_id != $sor->megrendeles_id) {
							$boritek_nyomas_utalas_db++ ;
							$utalas_tranzakcio_db_osszesen++ ;
							$elozo_megrendeles_id = $sor->megrendeles_id ;
						}
						$boritek_nyomas_utalas_netto += ($sor->osszeg / (100 + $alap_afa_szazalek) * 100) ;
						$boritek_nyomas_utalas_brutto += $sor->osszeg;
						$utalas_tranzakcio_netto_osszesen += ($sor->osszeg / (100 + $alap_afa_szazalek) * 100) ;
						$utalas_tranzakcio_brutto_osszesen += $sor->osszeg;
					}
					else
					{
						if ($elozo_megrendeles_id != $sor->megrendeles_id) {
							$boritek_nyomas_penztar_db++ ;
							$penztar_tranzakcio_db_osszesen++ ;
							$elozo_megrendeles_id = $sor->megrendeles_id ;
						}
						$boritek_nyomas_penztar_netto += ($sor->osszeg / (100 + $alap_afa_szazalek) * 100) ;
						$boritek_nyomas_penztar_brutto += $sor->osszeg;
						$penztar_tranzakcio_netto_osszesen += ($sor->osszeg / (100 + $alap_afa_szazalek) * 100) ;
						$penztar_tranzakcio_brutto_osszesen += $sor->osszeg;						
					}		
					$boritek_nyomas_osszesen_netto += ($sor->osszeg / (100 + $alap_afa_szazalek) * 100) ;
					$boritek_nyomas_osszesen_brutto += $sor->osszeg;
				}
			}
			$tranzakciok_netto_osszesen = $penztar_tranzakcio_netto_osszesen + $utalas_tranzakcio_netto_osszesen ;
			$tranzakciok_brutto_osszesen = $penztar_tranzakcio_brutto_osszesen + $utalas_tranzakcio_brutto_osszesen ;
		}
		$stat_adatok["termek_eladas_penztar_db"] = $termek_eladas_penztar_db ;
		$stat_adatok["termek_eladas_penztar_netto"] = $termek_eladas_penztar_netto ;
		$stat_adatok["termek_eladas_penztar_brutto"] = $termek_eladas_penztar_brutto ;
		$stat_adatok["termek_eladas_utalas_db"] = $termek_eladas_utalas_db ;
		$stat_adatok["termek_eladas_utalas_netto"] = $termek_eladas_utalas_netto ;
		$stat_adatok["termek_eladas_utalas_brutto"] = $termek_eladas_utalas_brutto ;
		$stat_adatok["termek_eladas_osszesen_netto"] = $termek_eladas_osszesen_netto ;
		$stat_adatok["termek_eladas_osszesen_brutto"] = $termek_eladas_osszesen_brutto ;
		$stat_adatok["boritek_nyomas_penztar_db"] = $boritek_nyomas_penztar_db ;
		$stat_adatok["boritek_nyomas_penztar_netto"] = $boritek_nyomas_penztar_netto ;
		$stat_adatok["boritek_nyomas_penztar_brutto"] = $boritek_nyomas_penztar_brutto ;
		$stat_adatok["boritek_nyomas_utalas_db"] = $boritek_nyomas_utalas_db ;
		$stat_adatok["boritek_nyomas_utalas_netto"] = $boritek_nyomas_utalas_netto ;
		$stat_adatok["boritek_nyomas_utalas_brutto"] = $boritek_nyomas_utalas_brutto ;
		$stat_adatok["boritek_nyomas_osszesen_netto"] = $boritek_nyomas_osszesen_netto ;
		$stat_adatok["boritek_nyomas_osszesen_brutto"] = $boritek_nyomas_osszesen_brutto ;
		$stat_adatok["penztar_tranzakcio_db_osszesen"] = $penztar_tranzakcio_db_osszesen ;
		$stat_adatok["penztar_tranzakcio_netto_osszesen"] = $penztar_tranzakcio_netto_osszesen ;
		$stat_adatok["penztar_tranzakcio_brutto_osszesen"] = $penztar_tranzakcio_brutto_osszesen ;
		$stat_adatok["utalas_tranzakcio_db_osszesen"] = $utalas_tranzakcio_db_osszesen ;
		$stat_adatok["utalas_tranzakcio_netto_osszesen"] = $utalas_tranzakcio_netto_osszesen ;
		$stat_adatok["utalas_tranzakcio_brutto_osszesen"] = $utalas_tranzakcio_brutto_osszesen ;
		$stat_adatok["tranzakciok_netto_osszesen"] = $tranzakciok_netto_osszesen ;
		$stat_adatok["tranzakciok_brutto_osszesen"] = $tranzakciok_brutto_osszesen ;
		unset($penzugyi_tranzakciok) ;
		
		//Időszaktól független statisztikák
		$osszes_nyitott_megrendeles["db"] = 0 ;
		$osszes_nyitott_megrendeles["netto"] = 0 ;
		$osszes_nyitott_megrendeles["brutto"] = 0 ;		
		$mult_honapban_lejartak["db"] = 0 ;
		$mult_honapban_lejartak["netto"] = 0 ;
		$mult_honapban_lejartak["brutto"] = 0 ;		
		$mult_evben_lejartak["db"] = 0 ;
		$mult_evben_lejartak["netto"] = 0 ;
		$mult_evben_lejartak["brutto"] = 0 ;		
		$lejartak["db"] = 0 ;
		$lejartak["netto"] = 0 ;
		$lejartak["brutto"] = 0 ;		
		$nem_lejartak["db"] = 0 ;
		$nem_lejartak["netto"] = 0 ;
		$nem_lejartak["brutto"] = 0 ;		
		$lejarnak_ebben_a_honapban["db"] = 0 ;
		$lejarnak_ebben_a_honapban["netto"] = 0 ;
		$lejarnak_ebben_a_honapban["brutto"] = 0 ;		
		$behajto_cegnek_atadva["db"] = 0 ;
		$behajto_cegnek_atadva["netto"] = 0 ;
		$behajto_cegnek_atadva["brutto"] = 0 ;		
		$ugyvednek_atadva["db"] = 0 ;
		$ugyvednek_atadva["netto"] = 0 ;
		$ugyvednek_atadva["brutto"] = 0 ;		
		
		$nyitott_megrendelesek = $this->getTartozasok() ;
		$elozo_honap = mktime(0, 0, 0, date("m")-1, date("d"), date("Y"));
		$elozo_ev = mktime(0, 0, 0, date("m"), date("d"), date("Y")-1);
		if ($nyitott_megrendelesek->totalItemCount > 0) {
			foreach ($nyitott_megrendelesek->getData() as $sor) {
				$megrendeles_ertek = $sor->getMegrendelesOsszeg() ;			
				if ($sor->szamla_fizetesi_hatarido != '0000-00-00' && $sor->szamla_fizetesi_hatarido < date("Y-m-d")) {
					//Lejárt
					if ($sor->ugyvednek_atadva == 0) {
						$lejartak["db"]++ ;
						$lejartak["netto"] += $megrendeles_ertek["netto_osszeg"] ;
						$lejartak["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;
					}
					else
					{
						if ($sor->behajto_cegnek_atadva == 1) {
							$behajto_cegnek_atadva["db"]++ ;
							$behajto_cegnek_atadva["netto"] += $megrendeles_ertek["netto_osszeg"] ;
							$behajto_cegnek_atadva["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;							
						}
						$ugyvednek_atadva["db"]++ ;
						$ugyvednek_atadva["netto"] += $megrendeles_ertek["netto_osszeg"] ;
						$ugyvednek_atadva["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;						
					}
					if (substr($sor->szamla_fizetesi_hatarido, 0, 7) == date("Y-m", $elozo_honap)) {
						$mult_honapban_lejartak["db"]++ ;
						$mult_honapban_lejartak["netto"] += $megrendeles_ertek["netto_osszeg"] ;
						$mult_honapban_lejartak["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;
					}
					elseif (substr($sor->szamla_fizetesi_hatarido, 0, 4) == date("Y", $elozo_ev)) {
						$mult_evben_lejartak["db"]++ ;
						$mult_evben_lejartak["netto"] += $megrendeles_ertek["netto_osszeg"] ;
						$mult_evben_lejartak["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;
					}
				}
				else
				{
					//Nem lejárt	
					$nem_lejartak["db"]++ ;
					$nem_lejartak["netto"] += $megrendeles_ertek["netto_osszeg"] ;
					$nem_lejartak["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;
					if (substr($sor->szamla_fizetesi_hatarido, 0, 7) == date("Y-m")) {
						$lejarnak_ebben_a_honapban["db"]++ ;
						$lejarnak_ebben_a_honapban["netto"] += $megrendeles_ertek["netto_osszeg"] ;
						$lejarnak_ebben_a_honapban["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;
					}
				}
			}
			$osszes_nyitott_megrendeles["db"] = $lejartak["db"] + $nem_lejartak["db"] + $ugyvednek_atadva["db"] ;
			$osszes_nyitott_megrendeles["netto"] = $lejartak["netto"] + $nem_lejartak["netto"] + $ugyvednek_atadva["netto"] ;
			$osszes_nyitott_megrendeles["brutto"] = $lejartak["brutto"] + $nem_lejartak["brutto"] + $ugyvednek_atadva["brutto"] ;
		}
		$stat_adatok["osszes_nyitott_megrendeles"] = $osszes_nyitott_megrendeles ;
		$stat_adatok["mult_honapban_lejartak"] = $mult_honapban_lejartak ;
		$stat_adatok["mult_evben_lejartak"] = $mult_evben_lejartak ;
		$stat_adatok["lejartak"] = $lejartak ;
		$stat_adatok["nem_lejartak"] = $nem_lejartak ;
		$stat_adatok["lejarnak_ebben_a_honapban"] = $lejarnak_ebben_a_honapban ;
		$stat_adatok["behajto_cegnek_atadva"] = $behajto_cegnek_atadva ;
		$stat_adatok["ugyvednek_atadva"] = $ugyvednek_atadva ;
		unset($nyitott_megrendelesek) ;
		
		//Folyamatban lévő munkák
		$munkak_folyamatban = $this->getMunkakFolyamatban() ;
		$nyitott_munkak_db = $munkak_folyamatban->totalItemCount ;
		$nyitott_munkak_netto = 0 ;
		$nyitott_munkak_kiszamlazva_db = 0 ;
		$nyitott_munkak_kiszamlazva_netto = 0 ;
		$nyitott_munkak_kiszamlazva_adott_idoszakban_db = 0 ;
		$nyitott_munkak_kiszamlazva_adott_idoszakban_netto = 0 ;
		$nyitott_munkak_munkadij_netto = 0 ;
		$nyitott_munkak_normaido = 0 ;
		$nyitott_munkak_munkadij_netto_orankent = 0 ;
		if ($munkak_folyamatban->totalItemCount > 0) {
			foreach ($munkak_folyamatban->getData() as $sor) {
				$tetel_netto_osszeg = 0 ;
				$tetel_anyagkoltseg = 0 ;
				$tetel_kalkulalt_munkadij = 0 ;
				$tetel_netto_osszeg = $sor->megrendeles_tetel->darabszam * $sor->megrendeles_tetel->netto_darabar ;
				$tetel_norma = Utils::getNormaadat($sor->megrendeles_tetel_id, $sor->gep_id, $sor->munkatipus_id, $sor->max_fordulat) ;
				$tetel_beszerzesi_darabar = 0 ;	
				$i = 0 ;
				while ($i < count($sor->megrendeles_tetel->termek->termekar) && $tetel_beszerzesi_darabar == 0) {
					$tetel_termekar = $sor->megrendeles_tetel->termek->termekar[$i] ;
					if ($tetel_termekar->datum_mettol <= $sor->megrendeles_tetel->megrendeles->rendeles_idopont && 	$tetel_termekar->datum_meddig >= $sor->megrendeles_tetel->megrendeles->rendeles_idopont)
					{
						$tetel_beszerzesi_darabar = $tetel_termekar->darab_ar_szamolashoz ;
					}
					$i++ ;
				}
				if ($sor->megrendeles_tetel->hozott_boritek == 0) {
					$tetel_anyagkoltseg = $tetel_beszerzesi_darabar * $sor->megrendeles_tetel->darabszam ;
				}
				$tetel_kalkulalt_munkadij = $tetel_netto_osszeg - $tetel_anyagkoltseg ;
//				print_r($sor) ;
//				print_r($tetel_norma) ;
//				die() ;
				$nyitott_munkak_netto += $tetel_netto_osszeg ;
				if ($sor->megrendeles_tetel->megrendeles->szamla_sorszam != "") {
					$nyitott_munkak_kiszamlazva_db++ ;
					$nyitott_munkak_kiszamlazva_netto += $tetel_netto_osszeg ;
					if ($sor->megrendeles_tetel->megrendeles->szamla_kiallitas_datum >= $model->statisztika_mettol && $sor->megrendeles_tetel->megrendeles->szamla_kiallitas_datum <= $model->statisztika_meddig) {
						$nyitott_munkak_kiszamlazva_adott_idoszakban_db++;
						$nyitott_munkak_kiszamlazva_adott_idoszakban_netto += $tetel_netto_osszeg ;
					}
				}	
				if (is_numeric($tetel_norma["normaar"])) {
					$nyitott_munkak_munkadij_netto += $tetel_norma["normaar"] ;
				}
				else
				{
					$nyitott_munkak_munkadij_netto += $tetel_kalkulalt_munkadij ;
				}
				if (is_numeric($tetel_norma["normaido"])) {
					$nyitott_munkak_normaido += $tetel_norma["normaido"] ;
				}
			}
			if ($nyitott_munkak_normaido > 0) {
				$nyitott_munkak_munkadij_netto_orankent = round($nyitott_munkak_munkadij_netto / ($nyitott_munkak_normaido / 60)) ;
			}
		}
		$stat_adatok["nyitott_munkak_db"] = $nyitott_munkak_db ;
		$stat_adatok["nyitott_munkak_netto"] = $nyitott_munkak_netto ;
		$stat_adatok["nyitott_munkak_kiszamlazva_db"] = $nyitott_munkak_kiszamlazva_db ;
		$stat_adatok["nyitott_munkak_kiszamlazva_netto"] = $nyitott_munkak_kiszamlazva_netto ;
		$stat_adatok["nyitott_munkak_kiszamlazva_adott_idoszakban_db"] = $nyitott_munkak_kiszamlazva_adott_idoszakban_db ;
		$stat_adatok["nyitott_munkak_kiszamlazva_adott_idoszakban_netto"] = $nyitott_munkak_kiszamlazva_adott_idoszakban_netto ;
		$stat_adatok["nyitott_munkak_munkadij_netto"] = $nyitott_munkak_munkadij_netto ;
		$stat_adatok["nyitott_munkak_munkadij_netto_orankent"] = $nyitott_munkak_munkadij_netto_orankent ;
		unset($munkak_folyamatban) ;
		
		# mPDF
		$mPDF1 = Yii::app()->ePdf->mpdf();

		$mPDF1->SetHtmlHeader("Statisztika: " . $model->statisztika_mettol . " - " . $model->statisztika_meddig);
		
		# render
		$mPDF1->WriteHTML($this->renderPartial('printNapiKombinaltStatisztika', array('model' => $model, 
																					  'stat_adatok' => $stat_adatok,
																					  ), true));
 
		# Outputs ready PDF
		$mPDF1->Output();
		
		$this->render('printNapiKombinaltStatisztika',array('model'=>$model,
 														    'stat_adatok' => $stat_adatok,
		));		
	}
	

}
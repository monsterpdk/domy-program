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
				'with'=>array('tetelek' => array('termek' => array('termekar')), 'ugyfel', 'megrendeles_forras'),
//				'with'=>array('tetelek', 'ugyfel', 'termek', 'termekar'),
				'together'=>true,
			),
			'countCriteria'=>array(
				'select'=>'tetelek.*',
				'condition'=>'ugyfel.kiemelt = ' . $kiemeltek . ' and t.torolt=0 and t.sztornozva=0 and t.rendeles_idopont >=\'' . $mettol . '\' and t.rendeles_idopont <= \'' . $meddig . '\'' . $elozmeny_query ,
//				'join'=>'left join dom_ugyfelek ugyfel on (t.ugyfel_id = ugyfel.id) left join dom_megrendeles_tetelek megrendeles_tetel on (t.id = megrendeles_tetel.megrendeles_id)',
				'with'=>array('tetelek' => array('termek' => array('termekar')), 'ugyfel','megrendeles_forras'),
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
				'with'=>array('penzugyi_tranzakciok'),
				'together'=>true,
			),
			'countCriteria'=>array(
				'condition'=>'t.torolt=0 and t.sztornozva=0 and szamla_sorszam != \'\' and szamla_fizetve = 0',
				'with'=>array('penzugyi_tranzakciok'),
				'together'=>true,
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
		$arajanlatokLegparnas = 0 ;
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
		$arajanlatok_napra_bontva = array() ;
		$arajanlatok_napra_bontva_uj_ugyfelek = array() ;
		$arajanlatok_uj_ugyfelek = array() ;
		
		$arajanlatok_lista = array() ;
		$arajanlatok_lista_osszesites = array() ;
		$arajanlatok_lista_osszesites["db"] = 0 ;
		$arajanlatok_lista_osszesites["tetel_db"] = 0 ;
		$arajanlatok_lista_osszesites["netto_osszesen"] = 0 ;
		$arajanlatok_lista_osszesites["anyagkoltseg_osszesen"] = 0 ;
		$arajanlatok_lista_osszesites["haszon_osszesen"] = 0 ;
		
		if ($arajanlatTetelekStatisztika_kiemeltek_nelkul->totalItemCount > 0) {
			foreach ($arajanlatTetelekStatisztika_kiemeltek_nelkul->getData() as $sor) {				
				$eladas = false ;
				$nyomas = false ;
				$legparnas = false ;
				$arajanlat_darabszamok = array("tizezer_alatt"=>0,"tizezer_felett"=>0) ;
				$ugyfel = Ugyfelek::model()->findByPk($sor->ugyfel_id) ;		
				$admin = User::model()->findByPk($sor->admin_id) ;
				$uj_ugyfel = ($ugyfel->getAjanlatszam($sor->ajanlat_datum) + $ugyfel->getMegrendelesszam($sor->ajanlat_datum) == 0) ? true : false ;
				$arajanlatok_lista[$sor->sorszam]["datum"] = $sor->ajanlat_datum ;
				$arajanlatok_lista[$sor->sorszam]["cegnev"] = $sor->ugyfel->cegnev ;
				$arajanlatok_lista[$sor->sorszam]["ugyfel_elso_rendeles_datum"] = date("Y.m.d", strtotime($ugyfel->ElsoRendelesDatum)) ;
				$arajanlatok_lista[$sor->sorszam]["admin"] =  $admin->fullname ;
				$arajanlatok_lista[$sor->sorszam]["netto_osszeg"] = 0 ;
				$arajanlatok_lista[$sor->sorszam]["anyag_szazalek"] = 0 ;
				$arajanlatok_lista[$sor->sorszam]["anyag_szazalek_osszeg"] = 0 ;
				$arajanlatok_lista[$sor->sorszam]["anyagkoltseg"] = 0 ;
				$arajanlatok_lista[$sor->sorszam]["haszon_szazalek"] = 0 ;
				$arajanlatok_lista[$sor->sorszam]["haszon_szazalek_osszeg"] = 0 ;
				$arajanlatok_lista[$sor->sorszam]["haszon"] = 0 ;		
				if (!isset($arajanlatok_napra_bontva[$sor->ajanlat_datum]["eladas_db"])) {
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["nyomas_db"] = 0 ;	
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["eladas_db"] = 0 ;	
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["nyomas_osszeg"] = 0 ;	
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["eladas_osszeg"] = 0 ;	
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["nyomas_haszon"] = 0 ;	
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["nyomas_koltseg"] = 0 ;	
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["eladas_haszon"] = 0 ;	
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["eladas_koltseg"] = 0 ;	
				}
				if (!isset($arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["eladas_db"])) {
					$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["nyomas_db"] = 0 ;	
					$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["eladas_db"] = 0 ;	
					$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["nyomas_osszeg"] = 0 ;	
					$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["eladas_osszeg"] = 0 ;	
					$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["nyomas_haszon"] = 0 ;	
					$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["nyomas_koltseg"] = 0 ;	
					$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["eladas_haszon"] = 0 ;	
					$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["eladas_koltseg"] = 0 ;	
				}			
				$tetel_index = -1 ;
				foreach ($sor->tetelek as $tetel_sor) {
					$tetel_index++ ;
					$db_eladasi_ar = 0 ;
					$termek = $tetel_sor->termek ;
					$ervenyes_termekar_rekord = "" ;
					$i = 0 ;
					$l = false ;					
					while ($i < count($termek->termekar) && !$l) {
						if ($sor->ajanlat_datum >= $termek->termekar[$i]->datum_mettol && $sor->ajanlat_datum <= $termek->termekar[$i]->datum_meddig) {
							$l = true ;
							$ervenyes_termekar_rekord = $termek->termekar[$i] ;
						}
						$i++ ;						
					}
					
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["megrendelve"] = 0 ;
					$megrendeles_tetel = MegrendelesTetelek::model()->findByAttributes(array('arajanlat_tetel_id'=>$tetel_sor->id)) ;
					if ($megrendeles_tetel) {
						$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["megrendelve"] = 1 ; 						
					}
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["termeknev"] = $tetel_sor->termek->DisplayTermekTeljesNev ;
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["darabszam"] = $tetel_sor->darabszam ;
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["ar"] = $tetel_sor->netto_darabar ;
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["szinekszama"] = "" ;
					if ($tetel_sor->szinek_szama1 + $tetel_sor->szinek_szama2 > 0) {
						$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["szinekszama"] = $tetel_sor->szinek_szama1 . " + " . $tetel_sor->szinek_szama2 ;
					}
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["netto_osszeg"] = $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
					if ($tetel_sor->netto_darabar * $tetel_sor->darabszam == 0) {
						$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["anyag_szazalek"] = 0 ;	
					}
					else
					{
						$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["anyag_szazalek"] = round((($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) / ($tetel_sor->netto_darabar * $tetel_sor->darabszam) * 100), 2) ;
					}
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["anyag_koltseg"] = $ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam ;
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["db_koltseg"] = $ervenyes_termekar_rekord->darab_ar_szamolashoz ;
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["haszon"] = $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["netto_osszeg"] - $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["anyag_koltseg"] ;
					if ($arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["netto_osszeg"] == 0) {
						$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["haszon_szazalek"] = 0 ;
					}
					else
					{
						$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["haszon_szazalek"] = round(($arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["haszon"] / $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["netto_osszeg"] * 100), 2) ;
					}
					$arajanlatok_lista[$sor->sorszam]["netto_osszeg"] += $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["netto_osszeg"] ;
					$arajanlatok_lista[$sor->sorszam]["anyagkoltseg"] += $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["anyag_koltseg"] ;
					$arajanlatok_lista[$sor->sorszam]["haszon"] += $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["haszon"] ;				
					$arajanlatok_lista[$sor->sorszam]["anyag_szazalek_osszeg"] += $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["anyag_szazalek"] ;
					$arajanlatok_lista[$sor->sorszam]["haszon_szazalek_osszeg"] += $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["haszon_szazalek"] ;
					$arajanlatok_lista[$sor->sorszam]["anyag_szazalek"] = round($arajanlatok_lista[$sor->sorszam]["anyag_szazalek_osszeg"] / ($tetel_index + 1), 2) ;
					$arajanlatok_lista[$sor->sorszam]["haszon_szazalek"] = round($arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["haszon_szazalek"] / ($tetel_index + 1), 2) ;
					
					$arajanlatok_lista_osszesites["tetel_db"] += $tetel_sor->darabszam ;
					$arajanlatok_lista_osszesites["netto_osszesen"] += $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["netto_osszeg"] ;
					$arajanlatok_lista_osszesites["anyagkoltseg_osszesen"] += $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["anyag_koltseg"] ;
					$arajanlatok_lista_osszesites["haszon_osszesen"] += $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["haszon"] ;
					
					if ($tetel_sor->termek->termekcsoport_id == 1)	{	//Ha légpárnás boríték, akkor a légpárnás statba is betesszük
						$eladas = true ;
						$legparnas = true ;
						$arajanlatTetelekLegparnas++ ;
						$arajanlatOsszegLegparnas += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						
						if (!$uj_ugyfel) {
							$arajanlatok_napra_bontva[$sor->ajanlat_datum]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						}
						else
						{
							$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						}
						if ($tetel_sor->hozott_boritek == 0) {
							if (!$uj_ugyfel) {
								$arajanlatok_napra_bontva[substr($sor->ajanlat_datum, 0, 10)]["eladas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
							else
							{
								$arajanlatok_napra_bontva_uj_ugyfelek[substr($sor->ajanlat_datum, 0, 10)]["eladas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
						}						
						
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
						$arajanlatok_napra_bontva[$sor->ajanlat_datum]["nyomas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						if (!$uj_ugyfel) {
							$arajanlatok_napra_bontva[$sor->ajanlat_datum]["nyomas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						}
						else
						{
							$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["nyomas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						}			
						if ($tetel_sor->hozott_boritek == 0) {
							if (!$uj_ugyfel) {
								$arajanlatok_napra_bontva[substr($sor->ajanlat_datum, 0, 10)]["nyomas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
							else
							{
								$arajanlatok_napra_bontva_uj_ugyfelek[substr($sor->ajanlat_datum, 0, 10)]["nyomas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
						}						
						
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
						$eladas = true ;
						$arajanlatTetelekEladas++ ;
						$arajanlatOsszegEladas_kiemeltek_nelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;						
						if (!$uj_ugyfel) {
							$arajanlatok_napra_bontva[$sor->ajanlat_datum]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						}
						else
						{
							$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						}
						if ($tetel_sor->hozott_boritek == 0) {
							if (!$uj_ugyfel) {
								$arajanlatok_napra_bontva[substr($sor->ajanlat_datum, 0, 10)]["eladas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
							else
							{
								$arajanlatok_napra_bontva_uj_ugyfelek[substr($sor->ajanlat_datum, 0, 10)]["eladas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
						}												
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
				if ($uj_ugyfel) {
					$arajanlatok_uj_ugyfelek[$sor->ugyfel_id] = 1 ;	
				}
				if ($nyomas) {
					$arajanlatokNyomas++ ;
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["nyomas_db"]++ ;
					if ($uj_ugyfel) {
						$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["nyomas_db"]++ ;						
					}
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
				if ($eladas)
				{
					$arajanlatokEladas++ ;
					if ($legparnas) {
						$arajanlatokLegparnas++ ;	
					}
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["eladas_db"]++ ;
					if ($uj_ugyfel) {
						$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["eladas_db"]++ ;
					}					
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
		$stat_adatok["arajanlatLegparnasStatisztika_kiemeltek_nelkul"] = $arajanlatokLegparnas ;		
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
		$arajanlatokLegparnas = 0 ;
		$arajanlatTetelekLegparnas = 0 ;
		$arajanlatOsszegLegparnas = 0 ;
		$arajanlatokNyomas = 0 ;
		$arajanlatTetelekNyomas = 0 ;
		$arajanlatOsszegNyomas = 0 ;
		if ($arajanlatTetelekStatisztika_csak_kiemeltek->totalItemCount > 0) {
			foreach ($arajanlatTetelekStatisztika_csak_kiemeltek->getData() as $sor) {
				$nyomas = false ;
				$eladas = false ;
				$legparnas = false ;
				$ugyfel = Ugyfelek::model()->findByPk($sor->ugyfel_id) ;				
				$admin = User::model()->findByPk($sor->admin_id) ;
				$uj_ugyfel = ($ugyfel->getAjanlatszam($sor->ajanlat_datum) + $ugyfel->getMegrendelesszam($sor->ajanlat_datum) == 0) ? true : false ;
				$arajanlatok_lista[$sor->sorszam]["datum"] = $sor->ajanlat_datum ;
				$arajanlatok_lista[$sor->sorszam]["cegnev"] = $sor->ugyfel->cegnev ;
				$arajanlatok_lista[$sor->sorszam]["ugyfel_elso_rendeles_datum"] = date("Y.m.d", strtotime($ugyfel->ElsoRendelesDatum)) ;
				$arajanlatok_lista[$sor->sorszam]["admin"] =  $admin->fullname ;
				$arajanlatok_lista[$sor->sorszam]["netto_osszeg"] = 0 ;
				$arajanlatok_lista[$sor->sorszam]["anyag_szazalek"] = 0 ;
				$arajanlatok_lista[$sor->sorszam]["anyag_szazalek_osszeg"] = 0 ;
				$arajanlatok_lista[$sor->sorszam]["anyagkoltseg"] = 0 ;
				$arajanlatok_lista[$sor->sorszam]["haszon_szazalek"] = 0 ;
				$arajanlatok_lista[$sor->sorszam]["haszon_szazalek_osszeg"] = 0 ;
				$arajanlatok_lista[$sor->sorszam]["haszon"] = 0 ;				
				if (!isset($arajanlatok_napra_bontva)) {
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["nyomas_db"] = 0 ;	
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["eladas_db"] = 0 ;	
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["nyomas_osszeg"] = 0 ;	
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["eladas_osszeg"] = 0 ;	
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["nyomas_haszon"] = 0 ;	
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["nyomas_koltseg"] = 0 ;	
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["eladas_haszon"] = 0 ;	
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["eladas_koltseg"] = 0 ;	
				}
				if (!isset($arajanlatok_napra_bontva_uj_ugyfelek)) {
					$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["nyomas_db"] = 0 ;	
					$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["eladas_db"] = 0 ;	
					$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["nyomas_osszeg"] = 0 ;	
					$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["eladas_osszeg"] = 0 ;	
					$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["nyomas_haszon"] = 0 ;	
					$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["nyomas_koltseg"] = 0 ;	
					$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["eladas_haszon"] = 0 ;	
					$arajanlatok_napra_bontva_uj_ugyfelek[$sor->ajanlat_datum]["eladas_koltseg"] = 0 ;	
				}								
				$tetel_index = -1 ;
				foreach ($sor->tetelek as $tetel_sor) {
					$termek = $tetel_sor->termek ;
					$ervenyes_termekar_rekord = "" ;
					$i = 0 ;
					$l = false ;	
					$tetel_index++ ;
					
					while ($i < count($termek->termekar) && !$l) {
						if ($sor->ajanlat_datum >= $termek->termekar[$i]->datum_mettol && $sor->ajanlat_datum <= $termek->termekar[$i]->datum_meddig) {
							$l = true ;
							$ervenyes_termekar_rekord = $termek->termekar[$i] ;
						}
						$i++ ;						
					}					
					
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["megrendelve"] = 0 ;
					$megrendeles_tetel = MegrendelesTetelek::model()->findByAttributes(array('arajanlat_tetel_id'=>$tetel_sor->id)) ;
					if ($megrendeles_tetel) {
						$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["megrendelve"] = 1 ; 						
					}
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["termeknev"] = $tetel_sor->termek->DisplayTermekTeljesNev ;
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["darabszam"] = $tetel_sor->darabszam ;
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["ar"] = $tetel_sor->netto_darabar ;
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["netto_osszeg"] = $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["szinekszama"] = "" ;
					if ($tetel_sor->szinek_szama1 + $tetel_sor->szinek_szama2 > 0) {
						$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["szinekszama"] = $tetel_sor->szinek_szama1 . " + " . $tetel_sor->szinek_szama2 ;
					}
					if ($tetel_sor->netto_darabar * $tetel_sor->darabszam > 0) { 
						$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["anyag_szazalek"] = round((($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) / ($tetel_sor->netto_darabar * $tetel_sor->darabszam) * 100), 2) ;
					}
					else
					{
						$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["anyag_szazalek"] = 0 ;
					}
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["anyag_koltseg"] = $ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam ;
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["db_koltseg"] = $ervenyes_termekar_rekord->darab_ar_szamolashoz ;
					$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["haszon"] = $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["netto_osszeg"] - $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["anyag_koltseg"] ;
					if ($arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["netto_osszeg"] > 0) {
						$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["haszon_szazalek"] = round(($arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["haszon"] / $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["netto_osszeg"] * 100), 2) ;
					}
					else
					{
						$arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["haszon_szazalek"] = 0 ;
					}
					$arajanlatok_lista[$sor->sorszam]["netto_osszeg"] += $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["netto_osszeg"] ;
					$arajanlatok_lista[$sor->sorszam]["anyagkoltseg"] += $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["anyag_koltseg"] ;
					$arajanlatok_lista[$sor->sorszam]["haszon"] += $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["haszon"] ;				
					$arajanlatok_lista[$sor->sorszam]["anyag_szazalek_osszeg"] += $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["anyag_szazalek"] ;
					$arajanlatok_lista[$sor->sorszam]["haszon_szazalek_osszeg"] += $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["haszon_szazalek"] ;
					$arajanlatok_lista[$sor->sorszam]["anyag_szazalek"] = round($arajanlatok_lista[$sor->sorszam]["anyag_szazalek_osszeg"] / ($tetel_index + 1), 2) ;
					$arajanlatok_lista[$sor->sorszam]["haszon_szazalek"] = round($arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["haszon_szazalek"] / ($tetel_index + 1), 2) ;
										
					$arajanlatok_lista_osszesites["tetel_db"] += $tetel_sor->darabszam ;
					$arajanlatok_lista_osszesites["netto_osszesen"] += $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["netto_osszeg"] ;
					$arajanlatok_lista_osszesites["anyagkoltseg_osszesen"] += $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["anyag_koltseg"] ;
					$arajanlatok_lista_osszesites["haszon_osszesen"] += $arajanlatok_lista[$sor->sorszam]["tetelek"][$tetel_index]["haszon"] ;
					
					if ($tetel_sor->termek->termekcsoport_id == 1)	{	//Ha légpárnás boríték, akkor a légpárnás statba is betesszük
						$eladas = true ;
						$legparnas = true ;
						$arajanlatTetelekLegparnas++ ;
						$arajanlatOsszegLegparnas += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						$arajanlatok_napra_bontva[$sor->ajanlat_datum]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
					}
					elseif ($tetel_sor->szinek_szama1 + $tetel_sor->szinek_szama2 > 0) {
						$nyomas = true ;
						$arajanlatTetelekNyomas++ ;
						$arajanlatOsszegNyomas += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						$arajanlatok_napra_bontva[$sor->ajanlat_datum]["nyomas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
					}
					else
					{
						$eladas = true ;
						$arajanlatTetelekEladas++ ;
						$arajanlatOsszegEladas_csak_kiemeltek += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;						
						$arajanlatok_napra_bontva[$sor->ajanlat_datum]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
					}
				}
				if ($uj_ugyfel) {
					$arajanlatok_uj_ugyfelek[$sor->ugyfel_id] = 1 ;	
				}				
				if ($nyomas) {
					$arajanlatokNyomas++ ;
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["nyomas_db"]++ ;
				}
				if ($eladas)
				{
					$arajanlatokEladas++ ;
					if ($legparnas) {
						$arajanlatokLegparnas++ ;
					}
					$arajanlatok_napra_bontva[$sor->ajanlat_datum]["eladas_db"]++ ;
				}
			}
		}
		$stat_adatok["arajanlatStatisztika_csak_kiemeltek"] = $arajanlatokEladas ;
		$stat_adatok["arajanlatTetelekStatisztika_csak_kiemeltek"] = $arajanlatTetelekEladas ;		
		$stat_adatok["arajanlatOsszegEladas_csak_kiemeltek"] = $arajanlatOsszegEladas_csak_kiemeltek ;
		$stat_adatok["arajanlatNyomasStatisztika_csak_kiemeltek"] = $arajanlatokNyomas ;
		$stat_adatok["arajanlatNyomasTetelekStatisztika_csak_kiemeltek"] = $arajanlatTetelekNyomas ;		
		$stat_adatok["arajanlatOsszegNyomas_csak_kiemeltek"] = $arajanlatOsszegNyomas ;
		$stat_adatok["arajanlatLegparnasStatisztika_csak_kiemeltek"] = $arajanlatokLegparnas ;		
		$stat_adatok["arajanlatLegparnasTetelekStatisztika_csak_kiemeltek"] = $arajanlatTetelekLegparnas ;		
		$stat_adatok["arajanlatOsszegLegparnas_csak_kiemeltek"] = $arajanlatOsszegLegparnas ;	
		$stat_adatok["arajanlatok_lista"] = $arajanlatok_lista ;
		$arajanlatok_lista_osszesites["db"] = count($arajanlatok_lista) ;
		$stat_adatok["arajanlatok_lista_osszesites"] = $arajanlatok_lista_osszesites ;
				
		if (count($arajanlatok_napra_bontva) > 0) {
			$ajanlatok_napra_bontva_osszesites["uj_ajanlatkerok"] = count($arajanlatok_uj_ugyfelek) ;
			$ajanlatok_napra_bontva_osszesites["nyomas_ajanlatok_db_osszesen"] = 0 ;
			$ajanlatok_napra_bontva_osszesites["eladas_ajanlatok_db_osszesen"] = 0 ;
			$ajanlatok_napra_bontva_osszesites["nyomas_ajanlatok_netto_osszesen"] = 0 ;
			$ajanlatok_napra_bontva_osszesites["eladas_ajanlatok_netto_osszesen"] = 0 ;
			$ajanlatok_napra_bontva_osszesites["nyomas_ajanlatok_uj_ugyfel_db_osszesen"] = 0 ;
			$ajanlatok_napra_bontva_osszesites["eladas_ajanlatok_uj_ugyfel_db_osszesen"] = 0 ;
			$ajanlatok_napra_bontva_osszesites["nyomas_ajanlatok_uj_ugyfel_netto_osszesen"] = 0 ;
			$ajanlatok_napra_bontva_osszesites["eladas_ajanlatok_uj_ugyfel_netto_osszesen"] = 0 ;
			foreach ($arajanlatok_napra_bontva as $datum => $adatok) {
				$arajanlatok_napra_bontva[$datum]["nyomas_haszon"] = $arajanlatok_napra_bontva[$datum]["nyomas_osszeg"] - $arajanlatok_napra_bontva[$datum]["nyomas_koltseg"] ;
				$arajanlatok_napra_bontva_uj_ugyfelek[$datum]["nyomas_haszon"] = $arajanlatok_napra_bontva_uj_ugyfelek[$datum]["nyomas_osszeg"] - $arajanlatok_napra_bontva_uj_ugyfelek[$datum]["nyomas_koltseg"] ;
				$arajanlatok_napra_bontva[$datum]["eladas_haszon"] = $arajanlatok_napra_bontva[$datum]["eladas_osszeg"] - $arajanlatok_napra_bontva[$datum]["eladas_koltseg"] ;
				$arajanlatok_napra_bontva_uj_ugyfelek[$datum]["eladas_haszon"] = $arajanlatok_napra_bontva_uj_ugyfelek[$datum]["eladas_osszeg"] - $arajanlatok_napra_bontva_uj_ugyfelek[$datum]["eladas_koltseg"] ;
				$ajanlatok_napra_bontva_osszesites["nyomas_ajanlatok_db_osszesen"] += $arajanlatok_napra_bontva[$datum]["nyomas_db"] ;
				$ajanlatok_napra_bontva_osszesites["eladas_ajanlatok_db_osszesen"] += $arajanlatok_napra_bontva[$datum]["eladas_db"] ;
				$ajanlatok_napra_bontva_osszesites["nyomas_ajanlatok_netto_osszesen"] += $arajanlatok_napra_bontva[$datum]["nyomas_osszeg"] ;
				$ajanlatok_napra_bontva_osszesites["eladas_ajanlatok_netto_osszesen"] += $arajanlatok_napra_bontva[$datum]["eladas_osszeg"] ;
				$ajanlatok_napra_bontva_osszesites["nyomas_ajanlatok_uj_ugyfel_db_osszesen"] += $arajanlatok_napra_bontva_uj_ugyfelek[$datum]["nyomas_db"] ;
				$ajanlatok_napra_bontva_osszesites["eladas_ajanlatok_uj_ugyfel_db_osszesen"] += $arajanlatok_napra_bontva_uj_ugyfelek[$datum]["eladas_db"] ;
				$ajanlatok_napra_bontva_osszesites["nyomas_ajanlatok_uj_ugyfel_netto_osszesen"] += $arajanlatok_napra_bontva_uj_ugyfelek[$datum]["nyomas_osszeg"] ;
				$ajanlatok_napra_bontva_osszesites["eladas_ajanlatok_uj_ugyfel_netto_osszesen"] += $arajanlatok_napra_bontva_uj_ugyfelek[$datum]["eladas_osszeg"] ;
				$ajanlatok_napra_bontva_osszesites["nyomas_haszon"] += $arajanlatok_napra_bontva[$datum]["nyomas_haszon"] ;
				$ajanlatok_napra_bontva_osszesites["eladas_haszon"] += $arajanlatok_napra_bontva[$datum]["eladas_haszon"] ;
				$ajanlatok_napra_bontva_osszesites["nyomas_haszon_uj_ugyfel"] += $arajanlatok_napra_bontva_uj_ugyfelek[$datum]["nyomas_haszon"] ;
				$ajanlatok_napra_bontva_osszesites["eladas_haszon_uj_ugyfel"] += $arajanlatok_napra_bontva_uj_ugyfelek[$datum]["eladas_haszon"] ;
			}
		}		
		
		$stat_adatok["arajanlatok_napra_bontva"] = $arajanlatok_napra_bontva ;
		$stat_adatok["arajanlatok_napra_bontva_uj_ugyfelek"] = $arajanlatok_napra_bontva_uj_ugyfelek ;
		$stat_adatok["ajanlatok_napra_bontva_osszesites"] = $ajanlatok_napra_bontva_osszesites ;
		unset($arajanlatTetelekStatisztika_csak_kiemeltek) ;
		
//Megrendeléssel kapcsolatos statisztikák nem kiemelt cégek		
		$megrendelesTetelekStatisztika_kiemeltek_nelkul = $this->getMegrendelesTetelekStatisztika($model, 0) ;
		$megrendelesekEladas = 0 ;
		$megrendelesTetelekEladas = 0 ;
		$megrendelesOsszegEladas_kiemeltek_nelkul = 0 ;
		$megrendelesekLegparnas = 0 ;
		$megrendelesTetelekLegparnas = 0 ;
		$megrendelesOsszegLegparnas = 0 ;
		$megrendelesekNyomas = 0 ;
		$megrendelesTetelekNyomas = 0 ;
		$megrendelesOsszegNyomas = 0 ;
		$megrendelesekEladasAjanlatNelkul = 0 ;
		$megrendelesTetelekEladasAjanlatNelkul = 0 ;
		$megrendelesOsszegEladasAjanlatNelkul = 0 ;
		$megrendelesekLegparnasAjanlatNelkul = 0 ;
		$megrendelesTetelekLegparnasAjanlatNelkul = 0 ;
		$megrendelesOsszegLegparnasAjanlatNelkul = 0 ;
		$megrendelesekNyomasAjanlatNelkul = 0 ;
		$megrendelesTetelekNyomasAjanlatNelkul = 0 ;
		$megrendelesOsszegNyomasAjanlatNelkul = 0 ;
		$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul = 0 ;
		$bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul = 0 ;
		$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul = 0 ;
		$anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul = 0 ;
		$megrendelesCegek_kiemeltek_nelkul = array("eladás"=>array(), "nyomás"=>array(),"eladás_ajánlat_nélkül"=>array(), "nyomás_ajánlat_nélkül"=>array()) ;
		$megrendelesCegek_kiemeltek_nelkul_10000_alatt = array("eladás"=>array(), "nyomás"=>array(),"eladás_ajánlat_nélkül"=>array(), "nyomás_ajánlat_nélkül"=>array()) ;
		$megrendelesCegek_kiemeltek_nelkul_10000_felett = array("eladás"=>array(), "nyomás"=>array(),"eladás_ajánlat_nélkül"=>array(), "nyomás_ajánlat_nélkül"=>array()) ;
		$megrendelesekEladas_10000_alatt = 0 ;
		$megrendelesTetelekEladas_10000_alatt = 0 ;
		$megrendelesOsszegEladas_kiemeltek_nelkul_10000_alatt = 0 ;
		$megrendelesTetelekLegparnas_10000_alatt = 0 ;
		$megrendelesOsszegLegparnas_10000_alatt = 0 ;
		$megrendelesekNyomas_10000_alatt = 0 ;
		$megrendelesTetelekNyomas_10000_alatt = 0 ;
		$megrendelesOsszegNyomas_10000_felett = 0 ;
		$megrendelesekEladas_10000_felett = 0 ;
		$megrendelesTetelekEladas_10000_felett = 0 ;
		$megrendelesOsszegEladas_kiemeltek_nelkul_10000_felett = 0 ;
		$megrendelesTetelekLegparnas_10000_felett = 0 ;
		$megrendelesOsszegLegparnas_10000_felett = 0 ;
		$megrendelesekNyomas_10000_felett = 0 ;
		$megrendelesTetelekNyomas_10000_felett = 0 ;
		$megrendelesOsszegNyomas_10000_felett = 0 ;

		$megrendelesekEladasAjanlatNelkul_10000_alatt = 0 ;
		$megrendelesTetelekEladasAjanlatNelkul_10000_alatt = 0 ;
		$megrendelesOsszegEladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt = 0 ;
		$megrendelesTetelekLegparnasAjanlatNelkul_10000_alatt = 0 ;
		$megrendelesOsszegLegparnasAjanlatNelkul_10000_alatt = 0 ;
		$megrendelesekNyomasAjanlatNelkul_10000_alatt = 0 ;
		$megrendelesTetelekNyomasAjanlatNelkul_10000_alatt = 0 ;
		$megrendelesOsszegNyomasAjanlatNelkul_10000_felett = 0 ;
		$megrendelesekEladasAjanlatNelkul_10000_felett = 0 ;
		$megrendelesTetelekEladasAjanlatNelkul_10000_felett = 0 ;
		$megrendelesOsszegEladas_kiemeltek_nelkulAjanlatNelkul_10000_felett = 0 ;
		$megrendelesTetelekLegparnasAjanlatNelkul_10000_felett = 0 ;
		$megrendelesOsszegLegparnasAjanlatNelkul_10000_felett = 0 ;
		$megrendelesekNyomasAjanlatNelkul_10000_felett = 0 ;
		$megrendelesTetelekNyomasAjanlatNelkul_10000_felett = 0 ;
		$megrendelesOsszegNyomasAjanlatNelkul_10000_felett = 0 ;
		$megrendelesek_napra_bontva = array() ;
		$megrendelesek_napra_bontva_uj_ugyfelek = array() ;
		$megrendelesek_napra_bontva_ajanlat_nelkul = array() ;
		$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul = array() ;
		$megrendelesek_uj_ugyfelek = array() ;
		
		$megrendelesek_eladas_lista = array() ;
		$megrendelesek_nyomas_lista = array() ;		
		$megrendelesek_nyomas_nincs_nyomdakonyvben_lista = array() ;
		$megrendelesek_nyomas_nincs_nyomdakonyvben_osszeg = 0 ;
		
		$megrendelesek_eladas_lista_osszesites = array() ;
		$megrendelesek_eladas_lista_osszesites["db"] = 0 ;
		$megrendelesek_eladas_lista_osszesites["tetelek"] = 0 ;
		$megrendelesek_eladas_lista_osszesites["tetel_db"] = 0 ;
		$megrendelesek_eladas_lista_osszesites["netto_osszesen"] = 0 ;
		$megrendelesek_eladas_lista_osszesites["anyagkoltseg_szazalek"] = 0 ;
		$megrendelesek_eladas_lista_osszesites["anyagkoltseg_szazalek_osszeg"] = 0 ;
		$megrendelesek_eladas_lista_osszesites["anyagkoltseg_osszesen"] = 0 ;
		$megrendelesek_eladas_lista_osszesites["haszon_szazalek"] = 0 ;
		$megrendelesek_eladas_lista_osszesites["haszon_szazalek_osszeg"] = 0 ;
		$megrendelesek_eladas_lista_osszesites["haszon_osszesen"] = 0 ;

		$megrendelesek_nyomas_lista_osszesites = array() ;
		$megrendelesek_nyomas_lista_osszesites["db"] = 0 ;
		$megrendelesek_nyomas_lista_osszesites["tetelek"] = 0 ;
		$megrendelesek_nyomas_lista_osszesites["tetel_db"] = 0 ;
		$megrendelesek_nyomas_lista_osszesites["netto_osszesen"] = 0 ;
		$megrendelesek_eladas_lista_osszesites["anyagkoltseg_szazalek"] = 0 ;
		$megrendelesek_eladas_lista_osszesites["anyagkoltseg_szazalek_osszeg"] = 0 ;
		$megrendelesek_nyomas_lista_osszesites["anyagkoltseg_osszesen"] = 0 ;
		$megrendelesek_eladas_lista_osszesites["haszon_szazalek"] = 0 ;
		$megrendelesek_nyomas_lista_osszesites["haszon_osszesen"] = 0 ;
		$megrendelesek_eladas_lista_osszesites["haszon_szazalek"] = 0 ;
		$megrendelesek_eladas_lista_osszesites["haszon_szazalek_osszeg"] = 0 ;
		$megrendelesek_nyomas_lista_osszesites["haszon_osszesen"] = 0 ;
		
		
		if ($megrendelesTetelekStatisztika_kiemeltek_nelkul->totalItemCount > 0) {
			foreach ($megrendelesTetelekStatisztika_kiemeltek_nelkul->getData() as $sor) {
				$nyomas = false ;
				$eladas = false ;
				$legparnas = false ;
				$megrendeles_darabszamok = array("tizezer_alatt"=>0,"tizezer_felett"=>0) ;				
				$ugyfel = Ugyfelek::model()->findByPk($sor->ugyfel_id) ;				
				$admin = User::model()->findByPk($sor->rendelest_rogzito_user_id) ;
				$uj_ugyfel = ($ugyfel->getAjanlatszam(substr($sor->rendeles_idopont, 0, 10)) + $ugyfel->getMegrendelesszam(substr($sor->rendeles_idopont, 0, 10)) == 0) ? true : false ;
				
				$megrendeles_eladas_rekord["datum"] = $sor->rendeles_idopont ;
				$megrendeles_eladas_rekord["cegnev"] = $sor->ugyfel->cegnev ;
				$megrendeles_eladas_rekord["ugyfel_elso_rendeles_datum"] = date("Y.m.d", strtotime($ugyfel->ElsoRendelesDatum)) ;
				$megrendeles_eladas_rekord["admin"] =  $admin->fullname ;
				$megrendeles_eladas_rekord["netto_osszeg"] = 0 ;
				$megrendeles_eladas_rekord["anyag_szazalek"] = 0 ;
				$megrendeles_eladas_rekord["anyag_szazalek_osszeg"] = 0 ;
				$megrendeles_eladas_rekord["anyagkoltseg"] = 0 ;
				$megrendeles_eladas_rekord["haszon_szazalek"] = 0 ;
				$megrendeles_eladas_rekord["haszon_szazalek_osszeg"] = 0 ;
				$megrendeles_eladas_rekord["haszon"] = 0 ;		

				$megrendeles_nyomas_rekord["datum"] = $sor->rendeles_idopont ;
				$megrendeles_nyomas_rekord["cegnev"] = $sor->ugyfel->cegnev ;
				$megrendeles_nyomas_rekord["ugyfel_elso_rendeles_datum"] = date("Y.m.d", strtotime($ugyfel->ElsoRendelesDatum)) ;
				$megrendeles_nyomas_rekord["admin"] =  $admin->fullname ;
				$megrendeles_nyomas_rekord["netto_osszeg"] = 0 ;
				$megrendeles_nyomas_rekord["anyag_szazalek"] = 0 ;
				$megrendeles_nyomas_rekord["anyag_szazalek_osszeg"] = 0 ;
				$megrendeles_nyomas_rekord["anyagkoltseg"] = 0 ;
				$megrendeles_nyomas_rekord["haszon_szazalek"] = 0 ;
				$megrendeles_nyomas_rekord["haszon_szazalek_osszeg"] = 0 ;
				$megrendeles_nyomas_rekord["haszon"] = 0 ;		
				
				
				if (!isset($megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"])) {
					$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["nyomas_db"] = 0 ;	
					$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"] = 0 ;	
					$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["nyomas_osszeg"] = 0 ;	
					$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] = 0 ;	
					$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["nyomas_koltseg"] = 0 ;	
					$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["nyomas_haszon"] = 0 ;	
					$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_haszon"] = 0 ;	
					$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] = 0 ;	
				}
				if (!isset($megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"])) {
					$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["nyomas_db"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["nyomas_osszeg"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["nyomas_haszon"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["nyomas_koltseg"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["eladas_haszon"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] = 0 ;	
				}				
				if (!isset($megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"])) {
					$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_db"] = 0 ;	
					$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"] = 0 ;	
					$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_osszeg"] = 0 ;	
					$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] = 0 ;	
					$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_haszon"] = 0 ;	
					$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_koltseg"] = 0 ;	
					$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_haszon"] = 0 ;	
					$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] = 0 ;	
				}
				if (!isset($megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"])) {
					$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_db"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_osszeg"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_haszon"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_koltseg"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_haszon"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] = 0 ;	
				}				
				$eladas_tetel_index = -1 ;
				$nyomas_tetel_index = -1 ;
				$nyomas_nincs_nyomdakonyvben_index = -1 ;
				unset($megrendeles_eladas_rekord) ;
				unset($megrendeles_nyomas_rekord) ;
				unset($megrendeles_nyomas_nincs_nyomdakonyvben_rekord) ;
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
						$eladas = true ;
						$legparnas = true ;
						if ($tetel_sor->darabszam >= $termek->csom_egys && $termek->csom_egys > 0) {
							$db_eladasi_ar = $ervenyes_termekar_rekord->csomag_eladasi_ar / $termek->csom_egys ;	
						}
						else
						{
							$db_eladasi_ar = $ervenyes_termekar_rekord->db_eladasi_ar ;
						}
						if ($sor->arajanlat_id == 0) {
							$megrendelesTetelekEladasAjanlatNelkul++ ;
							$megrendelesTetelekLegparnasAjanlatNelkul++ ;
							$megrendelesOsszegEladasAjanlatNelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							$megrendelesOsszegLegparnasAjanlatNelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							if (!$uj_ugyfel) {
								$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							}
							else
							{
								$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							}
							if ($tetel_sor->hozott_boritek == 0) {
								if (!$uj_ugyfel) {
									$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
								}
								else
								{
									$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
								}
							}
						}
						else {
							$megrendelesTetelekLegparnas++ ;
							$megrendelesOsszegLegparnas += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							if (!$uj_ugyfel) {							
								$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							}
							else
							{
								$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							}
							if ($tetel_sor->hozott_boritek == 0) {
								if (!$uj_ugyfel) {
									$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
								}
								else
								{
									$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
								}
							}
						}						
//						echo "aaa $sor->id: $db_eladasi_ar * $tetel_sor->darabszam = " . ($db_eladasi_ar * $tetel_sor->darabszam) . "<br />" ;
						$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul += ($db_eladasi_ar * $tetel_sor->darabszam) ;
						if ($tetel_sor->hozott_boritek == 0) {
							$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
						}
						if ($tetel_sor->darabszam < 10000) {
							if ($sor->arajanlat_id == 0) {
								$megrendelesTetelekLegparnasAjanlatNelkul_10000_alatt++ ;
								$megrendelesOsszegEladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
								$megrendeles_darabszamok["tizezer_alatt"] = 1 ;
								$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt += ($db_eladasi_ar * $tetel_sor->darabszam) ;
								$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;								
							}
							else
							{
								$megrendelesTetelekLegparnas_10000_alatt++ ;
								$megrendelesOsszegEladas_kiemeltek_nelkul_10000_alatt += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
								$megrendeles_darabszamok["tizezer_alatt"] = 1 ;
								$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_alatt += ($db_eladasi_ar * $tetel_sor->darabszam) ;
								$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_alatt += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
						}
						else
						{
							if ($sor->arajanlat_id == 0) {
								$megrendelesTetelekLegparnasAjanlatNelkul_10000_felett++ ;
								$megrendelesOsszegEladas_kiemeltek_nelkulAjanlatNelkul_10000_felett += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;							
								$megrendeles_darabszamok["tizezer_felett"] = 1 ;
								$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett += ($db_eladasi_ar * $tetel_sor->darabszam) ;
								$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;								
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

						$eladas_tetel_index++ ;
						$megrendeles_eladas_rekord["datum"] = $sor->rendeles_idopont ;
						$megrendeles_eladas_rekord["cegnev"] = $sor->ugyfel->cegnev ;
						$megrendeles_eladas_rekord["ugyfel_elso_rendeles_datum"] = date("Y.m.d", strtotime($ugyfel->ElsoRendelesDatum)) ;
						$megrendeles_eladas_rekord["admin"] =  $admin->fullname ;
						$megrendeles_eladas_rekord["forras"] = $sor->megrendeles_forras->aruhaz_nev ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["termeknev"] = $tetel_sor->termek->DisplayTermekTeljesNev ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["darabszam"] = $tetel_sor->darabszam ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["ar"] = $tetel_sor->netto_darabar ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["szinekszama"] = "" ;
						if ($tetel_sor->szinek_szama1 + $tetel_sor->szinek_szama2 > 0) {
							$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["szinekszama"] = $tetel_sor->szinek_szama1 . " + " . $tetel_sor->szinek_szama2 ;
						}
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] = $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						if ($tetel_sor->netto_darabar * $tetel_sor->darabszam > 0) {
							$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_szazalek"] = round((($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) / ($tetel_sor->netto_darabar * $tetel_sor->darabszam) * 100), 2) ;
						}
						else
						{
							$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_szazalek"] = 0 ;
						}
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] = $ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["db_koltseg"] = $ervenyes_termekar_rekord->darab_ar_szamolashoz ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] = $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] - $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] ;
						if ($megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] > 0) {
							$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] = round(($megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] / $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] * 100), 2) ;
						}
						else
						{
							$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] = 0 ;
						}
						$megrendeles_eladas_rekord["netto_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] ;
						$megrendeles_eladas_rekord["anyagkoltseg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] ;
						$megrendeles_eladas_rekord["haszon"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] ;				
						$megrendeles_eladas_rekord["anyag_szazalek_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_szazalek"] ;
						$megrendeles_eladas_rekord["haszon_szazalek_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] ;
						$megrendeles_eladas_rekord["anyag_szazalek"] = round($megrendeles_eladas_rekord["anyag_szazalek_osszeg"] / ($eladas_tetel_index + 1), 2) ;
						$megrendeles_eladas_rekord["haszon_szazalek"] = round($megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] / ($eladas_tetel_index + 1), 2) ;
						
						$megrendelesek_eladas_lista_osszesites["tetel_db"] += $tetel_sor->darabszam ;
						$megrendelesek_eladas_lista_osszesites["tetelek"]++ ;
						$megrendelesek_eladas_lista_osszesites["netto_osszesen"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] ;
						$megrendelesek_eladas_lista_osszesites["anyagkoltseg_osszesen"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] ;
						$megrendelesek_eladas_lista_osszesites["haszon_osszesen"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] ;
						$megrendelesek_eladas_lista_osszesites["anyagkoltseg_szazalek_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_szazalek"] ;
						$megrendelesek_eladas_lista_osszesites["haszon_szazalek_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] ;
						
					}
					elseif ($tetel_sor->szinek_szama1 + $tetel_sor->szinek_szama2 > 0) {
						$nyomas = true ;
						if ($tetel_sor->darabszam >= $termek->csom_egys && $termek->csom_egys > 0) {
							$db_eladasi_ar = $ervenyes_termekar_rekord->db_ar_nyomashoz / $termek->csom_egys ;	
						}
						else
						{
							$db_eladasi_ar = $ervenyes_termekar_rekord->csomag_ar_nyomashoz ;
						}						
						if ($sor->arajanlat_id == 0) {
							$megrendelesTetelekNyomasAjanlatNelkul++ ;
							$megrendelesOsszegNyomasAjanlatNelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							if (!$uj_ugyfel) {
								$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							}
							else
							{
								$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							}
							if ($tetel_sor->hozott_boritek == 0) {
								if (!$uj_ugyfel) {
									$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
								}
								else
								{
									$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
								}
							}
						}
						else {
							$megrendelesTetelekNyomas++ ;
							$megrendelesOsszegNyomas += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;					
							if (!$uj_ugyfel) {
								$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["nyomas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							}
							else
							{
								$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["nyomas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							}
							if ($tetel_sor->hozott_boritek == 0) {
								if (!$uj_ugyfel) {
									$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["nyomas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
								}
								else
								{
									$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["nyomas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
								}
							}
						}
//						echo "bbb: $db_eladasi_ar * $tetel_sor->darabszam = " . ($db_eladasi_ar * $tetel_sor->darabszam) . "<br />" ;
						$bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul += ($tetel_sor->netto_darabar * $tetel_sor->darabszam) ;
						if ($tetel_sor->hozott_boritek == 0) {
							$anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
						}
						if ($tetel_sor->darabszam < 10000) {
							if ($sor->arajanlat_id == 0) {
								$megrendelesTetelekNyomasAjanlatNelkul_10000_alatt++ ;
								$megrendelesOsszegNyomasAjanlatNelkul_10000_alatt += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
								$megrendeles_darabszamok["tizezer_alatt"] = 1 ;
								$bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt += ($tetel_sor->netto_darabar * $tetel_sor->darabszam) ;
								if ($tetel_sor->hozott_boritek == 0) {
									$anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
								}								
							}
							else
							{
								$megrendelesTetelekNyomas_10000_alatt++ ;
								$megrendelesOsszegNyomas_10000_alatt += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
								$megrendeles_darabszamok["tizezer_alatt"] = 1 ;
								$bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_alatt += ($tetel_sor->netto_darabar * $tetel_sor->darabszam) ;
								if ($tetel_sor->hozott_boritek == 0) {
									$anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul_10000_alatt += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
								}
							}
						}
						else
						{
							if ($sor->arajanlat_id == 0) {
								$megrendelesTetelekNyomasAjanlatNelkul_10000_felett++ ;
								$megrendelesOsszegNyomasAjanlatNelkul_10000_felett += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;							
								$megrendeles_darabszamok["tizezer_felett"] = 1 ;
								$bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett += ($tetel_sor->netto_darabar * $tetel_sor->darabszam) ;
								if ($tetel_sor->hozott_boritek == 0) {
									$anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
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
						
						$nyomas_tetel_index++;						
						$nyomdakonyv_munka = Nyomdakonyv::model()->findByAttributes(array('megrendeles_tetel_id'=>$tetel_sor->id)) ;
						$megrendeles_nyomas_rekord["datum"] = $sor->rendeles_idopont ;
						$megrendeles_nyomas_rekord["cegnev"] = $sor->ugyfel->cegnev ;
						$megrendeles_nyomas_rekord["ugyfel_elso_rendeles_datum"] = date("Y.m.d", strtotime($ugyfel->ElsoRendelesDatum)) ;
						$megrendeles_nyomas_rekord["admin"] =  $admin->fullname ;
						$megrendeles_nyomas_rekord["forras"] = $sor->megrendeles_forras->aruhaz_nev ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["termeknev"] = $tetel_sor->termek->DisplayTermekTeljesNev ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["darabszam"] = $tetel_sor->darabszam ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["ar"] = $tetel_sor->netto_darabar ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["munka_neve"] = $tetel_sor->munka_neve ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["szinkodok"] = $nyomdakonyv_munka->SzinErtekek ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["szinekszama"] = $tetel_sor->szinek_szama1 . " + " . $tetel_sor->szinek_szama2 ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["netto_osszeg"] = $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["anyag_szazalek"] = round((($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) / ($tetel_sor->netto_darabar * $tetel_sor->darabszam) * 100), 2) ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["anyag_koltseg"] = $ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["db_koltseg"] = $ervenyes_termekar_rekord->darab_ar_szamolashoz ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["haszon"] = $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["netto_osszeg"] - $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["anyag_koltseg"] ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["haszon_szazalek"] = round(($megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["haszon"] / $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["netto_osszeg"] * 100), 2) ;					
						$megrendeles_nyomas_rekord["netto_osszeg"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["netto_osszeg"] ;
						$megrendeles_nyomas_rekord["anyagkoltseg"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["anyag_koltseg"] ;
						$megrendeles_nyomas_rekord["haszon"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["haszon"] ;				
						$megrendeles_nyomas_rekord["anyag_szazalek_osszeg"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["anyag_szazalek"] ;
						$megrendeles_nyomas_rekord["haszon_szazalek_osszeg"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["haszon_szazalek"] ;
						$megrendeles_nyomas_rekord["anyag_szazalek"] = round($megrendeles_nyomas_rekord["anyag_szazalek_osszeg"] / ($nyomas_tetel_index + 1), 2) ;
						$megrendeles_nyomas_rekord["haszon_szazalek"] = round($megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["haszon_szazalek"] / ($nyomas_tetel_index + 1), 2) ;
						
						$megrendelesek_nyomas_lista_osszesites["tetel_db"] += $tetel_sor->darabszam ;
						$megrendelesek_nyomas_lista_osszesites["tetelek"]++ ;
						$megrendelesek_nyomas_lista_osszesites["netto_osszesen"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["netto_osszeg"] ;
						$megrendelesek_nyomas_lista_osszesites["anyagkoltseg_osszesen"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["anyag_koltseg"] ;
						$megrendelesek_nyomas_lista_osszesites["haszon_osszesen"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["haszon"] ;
						$megrendelesek_nyomas_lista_osszesites["anyagkoltseg_szazalek_osszeg"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["anyag_szazalek"] ;
						$megrendelesek_nyomas_lista_osszesites["haszon_szazalek_osszeg"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["haszon_szazalek"] ;
						
						if (!$nyomdakonyv_munka) {
							$nyomas_nincs_nyomdakonyvben_index++ ;
							$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["datum"] = $sor->rendeles_idopont ;
							$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["cegnev"] = $sor->ugyfel->cegnev ;
							$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["tetelek"][$nyomas_nincs_nyomdakonyvben_index]["termeknev"] = $tetel_sor->termek->DisplayTermekTeljesNev ;
							$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["tetelek"][$nyomas_nincs_nyomdakonyvben_index]["darabszam"] = $tetel_sor->darabszam ;
							$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["tetelek"][$nyomas_nincs_nyomdakonyvben_index]["ar"] = $tetel_sor->netto_darabar ;
							$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["tetelek"][$nyomas_nincs_nyomdakonyvben_index]["szinekszama"] = $tetel_sor->szinek_szama1 . " + " . $tetel_sor->szinek_szama2 ;
							$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["tetelek"][$nyomas_nincs_nyomdakonyvben_index]["netto_osszeg"] = $tetel_sor->netto_darabar * $tetel_sor->darabszam ;							
							$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["netto_osszeg"] += $megrendeles_nyomas_nincs_nyomdakonyvben_rekord["tetelek"][$nyomas_nincs_nyomdakonyvben_index]["netto_osszeg"] ;
						}
						
					}
					elseif ($tetel_sor->termek->tipus != "Szolgáltatás" && $tetel_sor->termek->nev != "Kuponfelhasználás")		//Ide most minden bemegy, ami nem légpárnás, nem nyomás, nem kuponfelhasználás és nem szolgáltatás, tehát ide megy a ragasztószalag, levélpapír, stb. is
					{
						$eladas = true ;
						if ($tetel_sor->darabszam >= $termek->csom_egys && $termek->csom_egys > 0) {
							$db_eladasi_ar = $ervenyes_termekar_rekord->csomag_eladasi_ar / $termek->csom_egys ;	
						}
						else
						{
							$db_eladasi_ar = $ervenyes_termekar_rekord->db_eladasi_ar ;
						}		
						if ($sor->arajanlat_id == 0) {
							$megrendelesTetelekEladasAjanlatNelkul++ ;
							$megrendelesOsszegEladasAjanlatNelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							if (!$uj_ugyfel) {
								$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							}
							else
							{
								$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							}
						}
						else {
							$megrendelesTetelekEladas++ ;
							$megrendelesOsszegEladas_kiemeltek_nelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;							
							if (!$uj_ugyfel) {							
								$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							}
							else
							{
								$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							}
							if ($tetel_sor->hozott_boritek == 0) {
								if (!$uj_ugyfel) {
									$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
								}
								else
								{
									$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
								}
							}
						}
//						echo "ccc $sor->id: $db_eladasi_ar * $tetel_sor->darabszam = " . ($db_eladasi_ar * $tetel_sor->darabszam) . "<br />" ;
						$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul += ($db_eladasi_ar * $tetel_sor->darabszam) ;						
						if ($tetel_sor->hozott_boritek == 0) {
							$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
						}
						if ($tetel_sor->darabszam < 10000) {
							if ($sor->arajanlat_id == 0) {
								$megrendelesTetelekEladasAjanlatNelkul_10000_alatt++ ;
								$megrendelesOsszegEladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
								$megrendeles_darabszamok["tizezer_alatt"] = 1 ;
								$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt += ($db_eladasi_ar * $tetel_sor->darabszam) ;						
								$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
							else
							{
								$megrendelesTetelekEladas_10000_alatt++ ;
								$megrendelesOsszegEladas_kiemeltek_nelkul_10000_alatt += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
								$megrendeles_darabszamok["tizezer_alatt"] = 1 ;
								$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_alatt += ($db_eladasi_ar * $tetel_sor->darabszam) ;						
								$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul_10000_alatt += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
						}
						else
						{
							if ($sor->arajanlat_id == 0) {							
								$megrendelesTetelekEladasAjanlatNelkul_10000_felett++ ;
								$megrendelesOsszegEladas_kiemeltek_nelkulAjanlatNelkul_10000_felett += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;							
								$megrendeles_darabszamok["tizezer_felett"] = 1 ;
								$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett += ($db_eladasi_ar * $tetel_sor->darabszam) ;						
								$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
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

						$eladas_tetel_index++ ;						
						$megrendeles_eladas_rekord["datum"] = $sor->rendeles_idopont ;
						$megrendeles_eladas_rekord["cegnev"] = $sor->ugyfel->cegnev ;
						$megrendeles_eladas_rekord["ugyfel_elso_rendeles_datum"] = date("Y.m.d", strtotime($ugyfel->ElsoRendelesDatum)) ;
						$megrendeles_eladas_rekord["admin"] =  $admin->fullname ;
						$megrendeles_eladas_rekord["forras"] = $sor->megrendeles_forras->aruhaz_nev ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["termeknev"] = $tetel_sor->termek->DisplayTermekTeljesNev ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["darabszam"] = $tetel_sor->darabszam ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["ar"] = $tetel_sor->netto_darabar ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["szinekszama"] = "" ;
						if ($tetel_sor->szinek_szama1 + $tetel_sor->szinek_szama2 > 0) {
							$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["szinekszama"] = $tetel_sor->szinek_szama1 . " + " . $tetel_sor->szinek_szama2 ;
						}
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] = $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_szazalek"] = round((($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) / ($tetel_sor->netto_darabar * $tetel_sor->darabszam) * 100), 2) ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] = $ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["db_koltseg"] = $ervenyes_termekar_rekord->darab_ar_szamolashoz ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] = $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] - $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] = round(($megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] / $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] * 100), 2) ;					
						$megrendeles_eladas_rekord["netto_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] ;
						$megrendeles_eladas_rekord["anyagkoltseg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] ;
						$megrendeles_eladas_rekord["haszon"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] ;				
						$megrendeles_eladas_rekord["anyag_szazalek_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_szazalek"] ;
						$megrendeles_eladas_rekord["haszon_szazalek_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] ;
						$megrendeles_eladas_rekord["anyag_szazalek"] = round($megrendeles_eladas_rekord["anyag_szazalek_osszeg"] / ($eladas_tetel_index + 1), 2) ;
						$megrendeles_eladas_rekord["haszon_szazalek"] = round($megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] / ($eladas_tetel_index + 1), 2) ;
						
						$megrendelesek_eladas_lista_osszesites["tetel_db"] += $tetel_sor->darabszam ;
						$megrendelesek_eladas_lista_osszesites["tetelek"]++ ;
						$megrendelesek_eladas_lista_osszesites["netto_osszesen"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] ;
						$megrendelesek_eladas_lista_osszesites["anyagkoltseg_osszesen"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] ;
						$megrendelesek_eladas_lista_osszesites["haszon_osszesen"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] ;
						$megrendelesek_eladas_lista_osszesites["anyagkoltseg_szazalek_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_szazalek"] ;
						$megrendelesek_eladas_lista_osszesites["haszon_szazalek_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] ;
						
					}					
				}
				if ($uj_ugyfel) {
					$megrendelesek_uj_ugyfelek[$sor->ugyfel_id] = 1 ;	
				}				
				if ($megrendeles_eladas_rekord["netto_osszeg"] > 0) {
					$megrendelesek_eladas_lista[$sor->sorszam] = $megrendeles_eladas_rekord ;		
					$megrendelesek_eladas_lista_osszesites["db"]++ ;
					$megrendelesek_eladas_lista_osszesites["anyagkoltseg_szazalek"] = round($megrendelesek_eladas_lista_osszesites["anyagkoltseg_szazalek_osszeg"] / $megrendelesek_eladas_lista_osszesites["tetelek"], 2) ;
					$megrendelesek_eladas_lista_osszesites["haszon_szazalek"] = round($megrendelesek_eladas_lista_osszesites["haszon_szazalek_osszeg"] / $megrendelesek_eladas_lista_osszesites["tetelek"], 2) ;

				}
				if ($megrendeles_nyomas_rekord["netto_osszeg"] > 0) {
					$megrendelesek_nyomas_lista[$sor->sorszam] = $megrendeles_nyomas_rekord ;					
					$megrendelesek_nyomas_lista_osszesites["db"]++ ;
					$megrendelesek_nyomas_lista_osszesites["anyagkoltseg_szazalek"] = round($megrendelesek_nyomas_lista_osszesites["anyagkoltseg_szazalek_osszeg"] / $megrendelesek_nyomas_lista_osszesites["tetelek"], 2) ;
					$megrendelesek_nyomas_lista_osszesites["haszon_szazalek"] = round($megrendelesek_nyomas_lista_osszesites["haszon_szazalek_osszeg"] / $megrendelesek_nyomas_lista_osszesites["tetelek"], 2) ;
				}				
				if ($megrendeles_nyomas_nincs_nyomdakonyvben_rekord["netto_osszeg"] > 0) {
					$megrendelesek_nyomas_nincs_nyomdakonyvben_lista[$sor->sorszam] = $megrendeles_nyomas_nincs_nyomdakonyvben_rekord ;
					$megrendelesek_nyomas_nincs_nyomdakonyvben_osszeg += $megrendeles_nyomas_nincs_nyomdakonyvben_rekord["netto_osszeg"] ;
					$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["netto_osszeg"] = 0	;
				}
				if ($nyomas) {
					
					if ($sor->arajanlat_id == 0) {
						$megrendelesekNyomasAjanlatNelkul++ ;
						$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_db"]++ ;
						if ($uj_ugyfel) {
							$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_db"]++ ;
						}
					}
					else
					{
						$megrendelesekNyomas++ ;
						$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["nyomas_db"]++ ;
						if ($uj_ugyfel) {
							$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["nyomas_db"]++ ;
						}
					}
					if ($sor->arajanlat_id == 0) {
						if (!isset($megrendelesCegek_kiemeltek_nelkul["nyomás_ajánlat_nélkül"][$sor->ugyfel_id])) {
							$megrendelesCegek_kiemeltek_nelkul["nyomás_ajánlat_nélkül"][$sor->ugyfel_id] = 1 ;
						}
						else
						{
							$megrendelesCegek_kiemeltek_nelkul["nyomás_ajánlat_nélkül"][$sor->ugyfel_id]++ ;	
						}
						if ($megrendeles_darabszamok["tizezer_alatt"] == 1) {
							$megrendelesekNyomasAjanlatNelkul_10000_alatt++ ;
							$megrendelesCegek_kiemeltek_nelkul_10000_alatt["nyomás_ajánlat_nélkül"][$sor->ugyfel_id]++ ;
						}
						if ($megrendeles_darabszamok["tizezer_felett"] == 1)
						{
							$megrendelesekNyomasAjanlatNelkul_10000_felett++ ;
							$megrendelesCegek_kiemeltek_nelkul_10000_felett["nyomás_ajánlat_nélkül"][$sor->ugyfel_id]++ ;						
						}						
					}
					else
					{
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
				}
				if ($eladas)
				{
					if ($sor->arajanlat_id == 0) {
						$megrendelesekEladasAjanlatNelkul++ ;
						if ($legparnas) {
							$megrendelesekLegparnasAjanlatNelkul++ ;
						}						
						$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"]++ ;
						if ($uj_ugyfel) {
							$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"]++ ;
						}
					}
					else
					{
						$megrendelesekEladas++ ;
						if ($legparnas) {
							$megrendelesekLegparnas++ ;
						}
						$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"]++ ;
						if ($uj_ugyfel) {
							$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"]++ ;
						}
					}
					
					if ($sor->arajanlat_id == 0) {
						if (!isset($megrendelesCegek_kiemeltek_nelkul["eladás_ajánlat_nélkül"][$sor->ugyfel_id])) {
							$megrendelesCegek_kiemeltek_nelkul["eladás_ajánlat_nélkül"][$sor->ugyfel_id] = 1 ;
						}
						else
						{
							$megrendelesCegek_kiemeltek_nelkul["eladás_ajánlat_nélkül"][$sor->ugyfel_id]++ ;	
						}
						if ($megrendeles_darabszamok["tizezer_alatt"] == 1) {
							$megrendelesekEladasAjanlatNelkul_10000_alatt++ ;
							$megrendelesCegek_kiemeltek_nelkul_10000_alatt["eladás_ajánlat_nélkül"][$sor->ugyfel_id]++ ;
						}
						if ($megrendeles_darabszamok["tizezer_felett"] == 1)
						{
							$megrendelesekEladasAjanlatNelkul_10000_felett++ ;
							$megrendelesCegek_kiemeltek_nelkul_10000_felett["eladás_ajánlat_nélkül"][$sor->ugyfel_id]++ ;						
						}						
					}
					else
					{
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
		}
//		die($anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul) ;
		$stat_adatok["megrendelesStatisztika_kiemeltek_nelkul"] = $megrendelesekEladas ;
		$stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul"] = $megrendelesTetelekEladas ;		
		$stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul"] = $megrendelesOsszegEladas_kiemeltek_nelkul ;
		$stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul"] = $megrendelesekNyomas ;
		$stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul"] = $megrendelesTetelekNyomas ;		
		$stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul"] = $megrendelesOsszegNyomas ;
		$stat_adatok["megrendelesLegparnasStatisztika_kiemeltek_nelkul"] = $megrendelesekLegparnas ;		
		$stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul"] = $megrendelesTetelekLegparnas ;		
		$stat_adatok["megrendelesOsszegLegparnas_kiemeltek_nelkul"] = $megrendelesOsszegLegparnas ;

		$stat_adatok["megrendelesStatisztikaAjanlatNelkul_kiemeltek_nelkul"] = $megrendelesekEladasAjanlatNelkul ;
		$stat_adatok["megrendelesTetelekStatisztikaAjanlatNelkul_kiemeltek_nelkul"] = $megrendelesTetelekEladasAjanlatNelkul ;		
		$stat_adatok["megrendelesOsszegEladasAjanlatNelkul_kiemeltek_nelkul"] = $megrendelesOsszegEladasAjanlatNelkul ;
		$stat_adatok["megrendelesLegparnasStatisztikaAjanlatNelkul_kiemeltek_nelkul"] = $megrendelesekLegparnasAjanlatNelkul ;
		$stat_adatok["megrendelesLegparnasTetelekStatisztikaAjanlatNelkul_kiemeltek_nelkul"] = $megrendelesTetelekLegparnasAjanlatNelkul ;		
		$stat_adatok["megrendelesLegparnasOsszegEladasAjanlatNelkul_kiemeltek_nelkul"] = $megrendelesOsszegLegparnasAjanlatNelkul ;
		$stat_adatok["megrendelesNyomasStatisztikaAjanlatNelkul_kiemeltek_nelkul"] = $megrendelesekNyomasAjanlatNelkul ;
		$stat_adatok["megrendelesNyomasTetelekStatisztikaAjanlatNelkul_kiemeltek_nelkul"] = $megrendelesTetelekNyomasAjanlatNelkul ;		
		$stat_adatok["megrendelesOsszegNyomasAjanlatNelkul_kiemeltek_nelkul"] = $megrendelesOsszegNyomasAjanlatNelkul ;
		
		
		$stat_adatok["megrendelesCegekEladas_kiemeltek_nelkul"] = count($megrendelesCegek_kiemeltek_nelkul["eladás"]) ;
		$stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkul"] = count($megrendelesCegek_kiemeltek_nelkul["nyomás"]) ;
		$stat_adatok["megrendelesCegekEladasAjanlatNelkul_kiemeltek_nelkul"] = count($megrendelesCegek_kiemeltek_nelkul["eladás_ajánlat_nélkül"]) ;
		$stat_adatok["megrendelesCegekNyomasAjanlatNelkul_kiemeltek_nelkul"] = count($megrendelesCegek_kiemeltek_nelkul["nyomás_ajánlat_nélkül"]) ;

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

		$stat_adatok["megrendelesStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $megrendelesekEladasAjanlatNelkul_10000_alatt ;
		$stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $megrendelesTetelekEladasAjanlatNelkul_10000_alatt ;		
		$stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $megrendelesOsszegEladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt ;
		$stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $megrendelesekNyomasAjanlatNelkul_10000_alatt ;
		$stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $megrendelesTetelekNyomasAjanlatNelkul_10000_alatt ;		
		$stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $megrendelesOsszegNyomasAjanlatNelkul_10000_alatt ;
		$stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $megrendelesTetelekLegparnasAjanlatNelkul_10000_alatt ;		
		$stat_adatok["megrendelesOsszegLegparnas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $megrendelesOsszegLegparnasAjanlatNelkul_10000_alatt ;
		$stat_adatok["megrendelesCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = count($megrendelesCegek_kiemeltek_nelkul_10000_alatt["eladás_ajánlat_nélkül"]) ;
		$stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = count($megrendelesCegek_kiemeltek_nelkul_10000_alatt["nyomás_ajánlat_nélkül"]) ;
		
		$stat_adatok["megrendelesStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $megrendelesekEladasAjanlatNelkul_10000_felett ;
		$stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $megrendelesTetelekEladasAjanlatNelkul_10000_felett ;		
		$stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $megrendelesOsszegEladas_kiemeltek_nelkulAjanlatNelkul_10000_felett ;
		$stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $megrendelesekNyomasAjanlatNelkul_10000_felett ;
		$stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $megrendelesTetelekNyomasAjanlatNelkul_10000_felett ;		
		$stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $megrendelesOsszegNyomasAjanlatNelkul_10000_felett ;
		$stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $megrendelesTetelekLegparnasAjanlatNelkul_10000_felett ;		
		$stat_adatok["megrendelesOsszegLegparnas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $megrendelesOsszegLegparnasAjanlatNelkul_10000_felett ;
		$stat_adatok["megrendelesCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = count($megrendelesCegek_kiemeltek_nelkul_10000_felett["eladás_ajánlat_nélkül"]) ;
		$stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = count($megrendelesCegek_kiemeltek_nelkul_10000_felett["nyomás_ajánlat_nélkül"]) ;		

		
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

		if ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] > 0)
//			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_alatt"] = round((($stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"]) / ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"])) * 100, 2) ;
			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_alatt"] = round(($stat_adatok["megrendelesStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] / $stat_adatok["arajanlatStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"]) * 100, 2) ;
		else
			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_alatt"] = 0 ;
		if ($stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] > 0)
//			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_alatt"] = round(($stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] / $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"]) * 100, 2) ;
			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_alatt"] = round(($stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] / $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"]) * 100, 2) ;
		else
			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_alatt"] = 0 ;
		if ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] > 0)
//			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_alatt"] = round((($stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"]) / ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"])) * 100, 2) ;
			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_alatt"] = round((($stat_adatok["megrendelesStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"]) / ($stat_adatok["arajanlatStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_alatt"])) * 100, 2) ;
		else
			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_alatt"] = 0 ;
		if ($stat_adatok["arajanlatCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] > 0) 
			$stat_adatok["eladas_arajanlatcegek_megrendelescegek_szazalekAjanlatNelkul_10000_alatt"] = round(($stat_adatok["megrendelesCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] / $stat_adatok["arajanlatCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"]) * 100, 2) ;
		else
			$stat_adatok["eladas_arajanlatcegek_megrendelescegek_szazalekAjanlatNelkul_10000_alatt"] = 0 ;
		if ($stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] > 0) 
			$stat_adatok["nyomas_arajanlatcegek_megrendelescegek_szazalekAjanlatNelkul_10000_alatt"] = round(($stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] / $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"]) * 100, 2) ;
		else
			$stat_adatok["nyomas_arajanlatcegek_megrendelescegek_szazalekAjanlatNelkul_10000_alatt"] = 0 ;
		if ($stat_adatok["arajanlatCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] > 0) 
			$stat_adatok["osszesen_arajanlatcegek_megrendelescegek_szazalekAjanlatNelkul_10000_alatt"] = round((($stat_adatok["megrendelesCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"]) / ($stat_adatok["arajanlatCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"])) * 100, 2) ;
		else
			$stat_adatok["osszesen_arajanlatcegek_megrendelescegek_szazalekAjanlatNelkul_10000_alatt"] = 0 ;
			
		$stat_adatok["anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt ;
		$stat_adatok["anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt ;
		$stat_adatok["anyagkoltseg_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt + $anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt ;
		$stat_adatok["bevetel_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $bevetel_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt ;
		$stat_adatok["bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt ;
		$stat_adatok["bevetel_termekeken_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $bevetel_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt + $bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt ;
		$stat_adatok["haszon_eladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $bevetel_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt - $anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt;
		$stat_adatok["haszon_nyomas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt - $anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt;
		$stat_adatok["haszon_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] = $stat_adatok["haszon_eladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["haszon_nyomas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"];
			
		if ($stat_adatok["arajanlatStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] > 0)
//			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_felett"] = round((($stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"]) / ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"])) * 100, 2) ;
			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_felett"] = round(($stat_adatok["megrendelesStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] / $stat_adatok["arajanlatStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"]) * 100, 2) ;
		else
			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_felett"] = 0 ;
		if ($stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] > 0)
//			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_felett"] = round(($stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] / $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"]) * 100, 2) ;
			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_felett"] = round(($stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] / $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"]) * 100, 2) ;
		else
			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_felett"] = 0 ;
		if ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] > 0)
//			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_felett"] = round((($stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"]) / ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"])) * 100, 2) ;
			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_felett"] = round((($stat_adatok["megrendelesStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"]) / ($stat_adatok["arajanlatStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkulAjanlatNelkul_10000_felett"])) * 100, 2) ;
		else
			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalekAjanlatNelkul_10000_felett"] = 0 ;
		if ($stat_adatok["arajanlatCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] > 0) 
			$stat_adatok["eladas_arajanlatcegek_megrendelescegek_szazalekAjanlatNelkul_10000_felett"] = round(($stat_adatok["megrendelesCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] / $stat_adatok["arajanlatCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_felett"]) * 100, 2) ;
		else
			$stat_adatok["eladas_arajanlatcegek_megrendelescegek_szazalekAjanlatNelkul_10000_felett"] = 0 ;
		if ($stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] > 0) 
			$stat_adatok["nyomas_arajanlatcegek_megrendelescegek_szazalekAjanlatNelkul_10000_felett"] = round(($stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] / $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_felett"]) * 100, 2) ;
		else
			$stat_adatok["nyomas_arajanlatcegek_megrendelescegek_szazalekAjanlatNelkul_10000_felett"] = 0 ;
		if ($stat_adatok["arajanlatCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] > 0) 
			$stat_adatok["osszesen_arajanlatcegek_megrendelescegek_szazalekAjanlatNelkul_10000_felett"] = round((($stat_adatok["megrendelesCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["megrendelesCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_felett"]) / ($stat_adatok["arajanlatCegekEladas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["arajanlatCegekNyomas_kiemeltek_nelkulAjanlatNelkul_10000_felett"])) * 100, 2) ;
		else
			$stat_adatok["osszesen_arajanlatcegek_megrendelescegek_szazalekAjanlatNelkul_10000_felett"] = 0 ;
			
		$stat_adatok["anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett ;
		$stat_adatok["anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett ;
		$stat_adatok["anyagkoltseg_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett + $anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett ;
		$stat_adatok["bevetel_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $bevetel_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett ;
		$stat_adatok["bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett ;
		$stat_adatok["bevetel_termekeken_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $bevetel_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett + $bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett ;
		$stat_adatok["haszon_eladas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $bevetel_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett - $anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett;
		$stat_adatok["haszon_nyomas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett - $anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett;
		$stat_adatok["haszon_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett"] = $stat_adatok["haszon_eladas_kiemeltek_nelkulAjanlatNelkul_10000_felett"] + $stat_adatok["haszon_nyomas_kiemeltek_nelkulAjanlatNelkul_10000_felett"];

		$stat_adatok["haszon_eladas_kiemeltek_nelkulAjanlatNelkul"] = $stat_adatok["haszon_eladas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["haszon_eladas_kiemeltek_nelkulAjanlatNelkul_10000_felett"];
		$stat_adatok["haszon_nyomas_kiemeltek_nelkulAjanlatNelkul"] = $stat_adatok["haszon_nyomas_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["haszon_nyomas_kiemeltek_nelkulAjanlatNelkul_10000_felett"];
		$stat_adatok["haszon_osszesen_kiemeltek_nelkulAjanlatNelkul"] = $stat_adatok["haszon_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_alatt"] + $stat_adatok["haszon_osszesen_kiemeltek_nelkulAjanlatNelkul_10000_felett"];

		
		unset($megrendelesTetelekStatisztika_kiemeltek_nelkul) ;
		
//Megrendeléssel kapcsolatos statisztikák kiemelt cégek		
		$megrendelesTetelekStatisztika_csak_kiemeltek = $this->getMegrendelesTetelekStatisztika($model, 1) ;
		$megrendelesekEladas = 0 ;
		$megrendelesTetelekEladas = 0 ;
		$megrendelesOsszegEladas_csak_kiemeltek = 0 ;
		$megrendelesekLegparnas = 0 ;
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
				$eladas = false ;
				$legparnas = false ;				
				$ugyfel = Ugyfelek::model()->findByPk($sor->ugyfel_id) ;				
				$admin = User::model()->findByPk($sor->rendelest_rogzito_user_id) ;
				$uj_ugyfel = ($ugyfel->getAjanlatszam(substr($sor->rendeles_idopont, 0, 10)) + $ugyfel->getMegrendelesszam(substr($sor->rendeles_idopont, 0, 10)) == 0) ? true : false ;
				
				$megrendeles_eladas_rekord["datum"] = $sor->rendeles_idopont ;
				$megrendeles_eladas_rekord["cegnev"] = $sor->ugyfel->cegnev ;
				$megrendeles_eladas_rekord["ugyfel_elso_rendeles_datum"] = date("Y.m.d", strtotime($ugyfel->ElsoRendelesDatum)) ;
				$megrendeles_eladas_rekord["admin"] =  $admin->fullname ;
				$megrendeles_eladas_rekord["netto_osszeg"] = 0 ;
				$megrendeles_eladas_rekord["anyag_szazalek"] = 0 ;
				$megrendeles_eladas_rekord["anyag_szazalek_osszeg"] = 0 ;
				$megrendeles_eladas_rekord["anyagkoltseg"] = 0 ;
				$megrendeles_eladas_rekord["haszon_szazalek"] = 0 ;
				$megrendeles_eladas_rekord["haszon_szazalek_osszeg"] = 0 ;
				$megrendeles_eladas_rekord["haszon"] = 0 ;		

				$megrendeles_nyomas_rekord["datum"] = $sor->rendeles_idopont ;
				$megrendeles_nyomas_rekord["cegnev"] = $sor->ugyfel->cegnev ;
				$megrendeles_nyomas_rekord["ugyfel_elso_rendeles_datum"] = date("Y.m.d", strtotime($ugyfel->ElsoRendelesDatum)) ;
				$megrendeles_nyomas_rekord["admin"] =  $admin->fullname ;
				$megrendeles_nyomas_rekord["netto_osszeg"] = 0 ;
				$megrendeles_nyomas_rekord["anyag_szazalek"] = 0 ;
				$megrendeles_nyomas_rekord["anyag_szazalek_osszeg"] = 0 ;
				$megrendeles_nyomas_rekord["anyagkoltseg"] = 0 ;
				$megrendeles_nyomas_rekord["haszon_szazalek"] = 0 ;
				$megrendeles_nyomas_rekord["haszon_szazalek_osszeg"] = 0 ;
				$megrendeles_nyomas_rekord["haszon"] = 0 ;		
				
				if (!isset($megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"])) {
					$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["nyomas_db"] = 0 ;	
					$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"] = 0 ;	
					$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["nyomas_osszeg"] = 0 ;	
					$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] = 0 ;	
					$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["nyomas_koltseg"] = 0 ;	
					$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["nyomas_haszon"] = 0 ;	
					$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_haszon"] = 0 ;	
					$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] = 0 ;	
				}
				if (!isset($megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"])) {
					$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["nyomas_db"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["nyomas_osszeg"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["nyomas_haszon"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["nyomas_koltseg"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["eladas_haszon"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] = 0 ;	
				}				
				if (!isset($megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"])) {
					$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_db"] = 0 ;	
					$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"] = 0 ;	
					$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_osszeg"] = 0 ;	
					$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] = 0 ;	
					$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_haszon"] = 0 ;	
					$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_koltseg"] = 0 ;	
					$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_haszon"] = 0 ;	
					$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] = 0 ;	
				}
				if (!isset($megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"])) {
					$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_db"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_osszeg"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_haszon"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_koltseg"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_haszon"] = 0 ;	
					$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] = 0 ;	
				}				
				
				$eladas_tetel_index = -1 ;
				$nyomas_tetel_index = -1 ;
				$nyomas_nincs_nyomdakonyvben_index = -1 ;
				unset($megrendeles_eladas_rekord) ;
				unset($megrendeles_nyomas_rekord) ;
				unset($megrendeles_nyomas_nincs_nyomdakonyvben_rekord) ;
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
						$eladas = true ;			
						$legparnas = true ;
						$megrendelesTetelekLegparnas++ ;
						$megrendelesOsszegLegparnas += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						if ($tetel_sor->darabszam >= $termek->csom_egys && $termek->csom_egys > 0) {
							$db_eladasi_ar = $ervenyes_termekar_rekord->csomag_eladasi_ar / $termek->csom_egys ;	
						}
						else
						{
							$db_eladasi_ar = $ervenyes_termekar_rekord->db_eladasi_ar ;
						}
						if ($sor->arajanlat_id == 0) {
							$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							if ($tetel_sor->hozott_boritek == 0) {
								$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
						}
						else {
							$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							if ($tetel_sor->hozott_boritek == 0) {
								$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
						}
//						echo "aaa $sor->id: $db_eladasi_ar * $tetel_sor->darabszam = " . ($db_eladasi_ar * $tetel_sor->darabszam) . "<br />" ;
						$bevetel_termekeken_eladas_osszesen_csak_kiemeltek += ($db_eladasi_ar * $tetel_sor->darabszam) ;
						if ($tetel_sor->hozott_boritek == 0) {
							$anyagkoltseg_termekeken_eladas_osszesen_csak_kiemeltek += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
						}
						
						$eladas_tetel_index++ ;
						$megrendeles_eladas_rekord["datum"] = $sor->rendeles_idopont ;
						$megrendeles_eladas_rekord["cegnev"] = $sor->ugyfel->cegnev ;
						$megrendeles_eladas_rekord["ugyfel_elso_rendeles_datum"] = date("Y.m.d", strtotime($ugyfel->ElsoRendelesDatum)) ;
						$megrendeles_eladas_rekord["admin"] =  $admin->fullname ;
						$megrendeles_eladas_rekord["forras"] = $sor->megrendeles_forras->aruhaz_nev ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["termeknev"] = $tetel_sor->termek->DisplayTermekTeljesNev ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["darabszam"] = $tetel_sor->darabszam ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["ar"] = $tetel_sor->netto_darabar ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["szinekszama"] = "" ;
						if ($tetel_sor->szinek_szama1 + $tetel_sor->szinek_szama2 > 0) {
							$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["szinekszama"] = $tetel_sor->szinek_szama1 . " + " . $tetel_sor->szinek_szama2 ;
						}
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] = $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_szazalek"] = round((($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) / ($tetel_sor->netto_darabar * $tetel_sor->darabszam) * 100), 2) ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] = $ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["db_koltseg"] = $ervenyes_termekar_rekord->darab_ar_szamolashoz ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] = $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] - $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] = round(($megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] / $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] * 100), 2) ;					
						$megrendeles_eladas_rekord["netto_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] ;
						$megrendeles_eladas_rekord["anyagkoltseg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] ;
						$megrendeles_eladas_rekord["haszon"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] ;				
						$megrendeles_eladas_rekord["anyag_szazalek_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_szazalek"] ;
						$megrendeles_eladas_rekord["haszon_szazalek_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] ;
						$megrendeles_eladas_rekord["anyag_szazalek"] = round($megrendeles_eladas_rekord["anyag_szazalek_osszeg"] / ($eladas_tetel_index + 1), 2) ;
						$megrendeles_eladas_rekord["haszon_szazalek"] = round($megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] / ($eladas_tetel_index + 1), 2) ;
					
						$megrendelesek_eladas_lista_osszesites["tetel_db"] += $tetel_sor->darabszam ;
						$megrendelesek_eladas_lista_osszesites["tetelek"]++ ;
						$megrendelesek_eladas_lista_osszesites["netto_osszesen"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] ;
						$megrendelesek_eladas_lista_osszesites["anyagkoltseg_osszesen"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] ;
						$megrendelesek_eladas_lista_osszesites["haszon_osszesen"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] ;
						$megrendelesek_eladas_lista_osszesites["anyagkoltseg_szazalek_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_szazalek"] ;
						$megrendelesek_eladas_lista_osszesites["haszon_szazalek_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] ;
						
					}
					elseif ($tetel_sor->szinek_szama1 + $tetel_sor->szinek_szama2 > 0) {
						$nyomas = true ;
						$megrendelesTetelekNyomas++ ;
						$megrendelesOsszegNyomas += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						if ($tetel_sor->darabszam >= $termek->csom_egys && $termek->csom_egys > 0) {
							$db_eladasi_ar = $ervenyes_termekar_rekord->db_ar_nyomashoz / $termek->csom_egys ;	
						}
						else
						{
							$db_eladasi_ar = $ervenyes_termekar_rekord->csomag_ar_nyomashoz ;
						}						
						if ($sor->arajanlat_id == 0) {
							$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							if ($tetel_sor->hozott_boritek == 0) {
								$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
						}
						else {
							$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["nyomas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							if ($tetel_sor->hozott_boritek == 0) {
								$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["nyomas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
						}
//						echo "bbb: $db_eladasi_ar * $tetel_sor->darabszam = " . ($db_eladasi_ar * $tetel_sor->darabszam) . "<br />" ;
						$bevetel_termekeken_nyomas_osszesen_csak_kiemeltek += ($tetel_sor->netto_darabar * $tetel_sor->darabszam) ;
						if ($tetel_sor->hozott_boritek == 0) {
							$anyagkoltseg_termekeken_nyomas_osszesen_csak_kiemeltek += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
						}
						
						$nyomas_tetel_index++ ;
						$nyomdakonyv_munka = Nyomdakonyv::model()->findByAttributes(array('megrendeles_tetel_id'=>$tetel_sor->id)) ;
						$megrendeles_nyomas_rekord["datum"] = $sor->rendeles_idopont ;
						$megrendeles_nyomas_rekord["cegnev"] = $sor->ugyfel->cegnev ;
						$megrendeles_nyomas_rekord["ugyfel_elso_rendeles_datum"] = date("Y.m.d", strtotime($ugyfel->ElsoRendelesDatum)) ;
						$megrendeles_nyomas_rekord["admin"] =  $admin->fullname ;
						$megrendeles_nyomas_rekord["forras"] = $sor->megrendeles_forras->aruhaz_nev ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["termeknev"] = $tetel_sor->termek->DisplayTermekTeljesNev ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["darabszam"] = $tetel_sor->darabszam ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["ar"] = $tetel_sor->netto_darabar ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["munka_neve"] = $tetel_sor->munka_neve ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["szinkodok"] = $nyomdakonyv_munka->SzinErtekek ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["szinekszama"] = $tetel_sor->szinek_szama1 . " + " . $tetel_sor->szinek_szama2 ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["netto_osszeg"] = $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						if ($tetel_sor->netto_darabar * $tetel_sor->darabszam > 0) {
							$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["anyag_szazalek"] = round((($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) / ($tetel_sor->netto_darabar * $tetel_sor->darabszam) * 100), 2) ;
						}
						else
						{
							$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["anyag_szazalek"] = 0 ;
						}
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["anyag_koltseg"] = $ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["db_koltseg"] = $ervenyes_termekar_rekord->darab_ar_szamolashoz ;
						$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["haszon"] = $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["netto_osszeg"] - $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["anyag_koltseg"] ;
						if ($megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["netto_osszeg"] > 0) {
							$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["haszon_szazalek"] = round(($megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["haszon"] / $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["netto_osszeg"] * 100), 2) ;
						}
						else
						{
							$megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["haszon_szazalek"] = 0 ;
						}
						$megrendeles_nyomas_rekord["netto_osszeg"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["netto_osszeg"] ;
						$megrendeles_nyomas_rekord["anyagkoltseg"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["anyag_koltseg"] ;
						$megrendeles_nyomas_rekord["haszon"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["haszon"] ;				
						$megrendeles_nyomas_rekord["anyag_szazalek_osszeg"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["anyag_szazalek"] ;
						$megrendeles_nyomas_rekord["haszon_szazalek_osszeg"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["haszon_szazalek"] ;
						$megrendeles_nyomas_rekord["anyag_szazalek"] = round($megrendeles_nyomas_rekord["anyag_szazalek_osszeg"] / ($nyomas_tetel_index + 1), 2) ;
						$megrendeles_nyomas_rekord["haszon_szazalek"] = round($megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["haszon_szazalek"] / ($nyomas_tetel_index + 1), 2) ;

						$megrendelesek_nyomas_lista_osszesites["tetel_db"] += $tetel_sor->darabszam ;
						$megrendelesek_nyomas_lista_osszesites["tetelek"]++ ;						
						$megrendelesek_nyomas_lista_osszesites["netto_osszesen"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] ;
						$megrendelesek_nyomas_lista_osszesites["anyagkoltseg_osszesen"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] ;
						$megrendelesek_nyomas_lista_osszesites["haszon_osszesen"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] ;
						$megrendelesek_nyomas_lista_osszesites["anyagkoltseg_szazalek_osszeg"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["anyag_szazalek"] ;
						$megrendelesek_nyomas_lista_osszesites["haszon_szazalek_osszeg"] += $megrendeles_nyomas_rekord["tetelek"][$nyomas_tetel_index]["haszon_szazalek"] ;
						
						if (!$nyomdakonyv_munka) {
							$nyomas_nincs_nyomdakonyvben_index++ ;
							$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["datum"] = $sor->rendeles_idopont ;
							$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["cegnev"] = $sor->ugyfel->cegnev ;
							$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["tetelek"][$nyomas_nincs_nyomdakonyvben_index]["termeknev"] = $tetel_sor->termek->DisplayTermekTeljesNev ;
							$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["tetelek"][$nyomas_nincs_nyomdakonyvben_index]["darabszam"] = $tetel_sor->darabszam ;
							$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["tetelek"][$nyomas_nincs_nyomdakonyvben_index]["ar"] = $tetel_sor->netto_darabar ;
							$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["tetelek"][$nyomas_nincs_nyomdakonyvben_index]["szinekszama"] = $tetel_sor->szinek_szama1 . " + " . $tetel_sor->szinek_szama2 ;
							$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["tetelek"][$nyomas_nincs_nyomdakonyvben_index]["netto_osszeg"] = $tetel_sor->netto_darabar * $tetel_sor->darabszam ;							
							$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["netto_osszeg"] += $megrendeles_nyomas_nincs_nyomdakonyvben_rekord["tetelek"][$nyomas_nincs_nyomdakonyvben_index]["netto_osszeg"] ;
						}
						
					}
					elseif ($tetel_sor->termek->tipus != "Szolgáltatás" && $tetel_sor->termek->nev != "Kuponfelhasználás")		//Ide most minden bemegy, ami nem légpárnás, nem nyomás és nem szolgáltatás, tehát ide megy a ragasztószalag, levélpapír, stb. is
					{
						$eladas = true ;
						$megrendelesTetelekEladas++ ;
						$megrendelesOsszegEladas_csak_kiemeltek += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;	
						if ($tetel_sor->darabszam >= $termek->csom_egys && $termek->csom_egys > 0) {
							$db_eladasi_ar = $ervenyes_termekar_rekord->csomag_eladasi_ar / $termek->csom_egys ;	
						}
						else
						{
							$db_eladasi_ar = $ervenyes_termekar_rekord->db_eladasi_ar ;
						}		
						if ($sor->arajanlat_id == 0) {
							$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							if ($tetel_sor->hozott_boritek == 0) {
								$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
						}
						else {
							$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_osszeg"] += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
							if ($tetel_sor->hozott_boritek == 0) {
								$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_koltseg"] += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
							}
						}
//						echo "ccc $sor->id: $db_eladasi_ar * $tetel_sor->darabszam = " . ($db_eladasi_ar * $tetel_sor->darabszam) . "<br />" ;
						$bevetel_termekeken_eladas_osszesen_csak_kiemeltek += ($db_eladasi_ar * $tetel_sor->darabszam) ;						
						if ($tetel_sor->hozott_boritek == 0) {
							$anyagkoltseg_termekeken_eladas_osszesen_csak_kiemeltek += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
						}
						
						$eladas_tetel_index++ ;
						$megrendeles_eladas_rekord["datum"] = $sor->rendeles_idopont ;
						$megrendeles_eladas_rekord["cegnev"] = $sor->ugyfel->cegnev ;
						$megrendeles_eladas_rekord["ugyfel_elso_rendeles_datum"] = date("Y.m.d", strtotime($ugyfel->ElsoRendelesDatum)) ;
						$megrendeles_eladas_rekord["admin"] =  $admin->fullname ;
						$megrendeles_eladas_rekord["forras"] = $sor->megrendeles_forras->aruhaz_nev ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["termeknev"] = $tetel_sor->termek->DisplayTermekTeljesNev ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["darabszam"] = $tetel_sor->darabszam ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["ar"] = $tetel_sor->netto_darabar ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["szinekszama"] = "" ;
						if ($tetel_sor->szinek_szama1 + $tetel_sor->szinek_szama2 > 0) {
							$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["szinekszama"] = $tetel_sor->szinek_szama1 . " + " . $tetel_sor->szinek_szama2 ;
						}
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] = $tetel_sor->netto_darabar * $tetel_sor->darabszam ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_szazalek"] = round((($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) / ($tetel_sor->netto_darabar * $tetel_sor->darabszam) * 100), 2) ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] = $ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["db_koltseg"] = $ervenyes_termekar_rekord->darab_ar_szamolashoz ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] = $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] - $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] ;
						$megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] = round(($megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] / $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] * 100), 2) ;					
						$megrendeles_eladas_rekord["netto_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] ;
						$megrendeles_eladas_rekord["anyagkoltseg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] ;
						$megrendeles_eladas_rekord["haszon"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] ;				
						$megrendeles_eladas_rekord["anyag_szazalek_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_szazalek"] ;
						$megrendeles_eladas_rekord["haszon_szazalek_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] ;
						$megrendeles_eladas_rekord["anyag_szazalek"] = round($megrendeles_eladas_rekord["anyag_szazalek_osszeg"] / ($eladas_tetel_index + 1), 2) ;
						$megrendeles_eladas_rekord["haszon_szazalek"] = round($megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] / ($eladas_tetel_index + 1), 2) ;
						
						$megrendelesek_eladas_lista_osszesites["tetel_db"] += $tetel_sor->darabszam ;
						$megrendelesek_eladas_lista_osszesites["tetelek"]++ ;						
						$megrendelesek_eladas_lista_osszesites["netto_osszesen"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["netto_osszeg"] ;
						$megrendelesek_eladas_lista_osszesites["anyagkoltseg_osszesen"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_koltseg"] ;
						$megrendelesek_eladas_lista_osszesites["haszon_osszesen"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon"] ;
						$megrendelesek_eladas_lista_osszesites["anyagkoltseg_szazalek_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["anyag_szazalek"] ;
						$megrendelesek_eladas_lista_osszesites["haszon_szazalek_osszeg"] += $megrendeles_eladas_rekord["tetelek"][$eladas_tetel_index]["haszon_szazalek"] ;
					}					
				}
				if ($uj_ugyfel) {
					$megrendelesek_uj_ugyfelek[$sor->ugyfel_id] = 1 ;	
				}				
				if ($megrendeles_eladas_rekord["netto_osszeg"] > 0) {
					$megrendelesek_eladas_lista[$sor->sorszam] = $megrendeles_eladas_rekord ;
					$megrendelesek_eladas_lista_osszesites["db"]++ ;
					$megrendelesek_eladas_lista_osszesites["anyagkoltseg_szazalek"] = round($megrendelesek_eladas_lista_osszesites["anyagkoltseg_szazalek_osszeg"] / $megrendelesek_eladas_lista_osszesites["tetelek"], 2) ;
					$megrendelesek_eladas_lista_osszesites["haszon_szazalek"] = round($megrendelesek_eladas_lista_osszesites["haszon_szazalek_osszeg"] / $megrendelesek_eladas_lista_osszesites["tetelek"], 2) ;
				}
				if ($megrendeles_nyomas_rekord["netto_osszeg"] > 0) {
					$megrendelesek_nyomas_lista[$sor->sorszam] = $megrendeles_nyomas_rekord ;					
					$megrendelesek_nyomas_lista_osszesites["db"]++ ;
					$megrendelesek_nyomas_lista_osszesites["anyagkoltseg_szazalek"] = round($megrendelesek_nyomas_lista_osszesites["anyagkoltseg_szazalek_osszeg"] / $megrendelesek_nyomas_lista_osszesites["tetelek"], 2) ;
					$megrendelesek_nyomas_lista_osszesites["haszon_szazalek"] = round($megrendelesek_nyomas_lista_osszesites["haszon_szazalek_osszeg"] / $megrendelesek_nyomas_lista_osszesites["tetelek"], 2) ;
				}				
				if ($megrendeles_nyomas_nincs_nyomdakonyvben_rekord["netto_osszeg"] > 0) {
					$megrendelesek_nyomas_nincs_nyomdakonyvben_lista[$sor->sorszam] = $megrendeles_nyomas_nincs_nyomdakonyvben_rekord ;
					$megrendelesek_nyomas_nincs_nyomdakonyvben_osszeg += $megrendeles_nyomas_nincs_nyomdakonyvben_rekord["netto_osszeg"] ;
					$megrendeles_nyomas_nincs_nyomdakonyvben_rekord["netto_osszeg"] = 0	;
				}
				if ($nyomas) {
					if ($sor->arajanlat_id == 0) {
						$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_db"]++ ;
						if ($uj_ugyfel) {
							$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["nyomas_db"]++ ;
						}
					}
					else
					{
						$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["nyomas_db"]++ ;
						if ($uj_ugyfel) {
							$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["nyomas_db"]++ ;
						}
					}					
					$megrendelesekNyomas++ ;
				}
				if ($eladas)
				{
					if ($legparnas) {
						$megrendelesekLegparnas++ ;
					}					
					if ($sor->arajanlat_id == 0) {
						$megrendelesek_napra_bontva_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"]++ ;
						if ($uj_ugyfel) {
							$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"]++ ;
						}
					}
					else
					{
						$megrendelesek_napra_bontva[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"]++ ;
						if ($uj_ugyfel) {
							$megrendelesek_napra_bontva_uj_ugyfelek[substr($sor->rendeles_idopont, 0, 10)]["eladas_db"]++ ;
						}
					}
					
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
		$stat_adatok["megrendelesLegparnasStatisztika_csak_kiemeltek"] = $megrendelesekLegparnas ;		
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
		
		if (count($megrendelesek_napra_bontva) > 0 || count($megrendelesek_napra_bontva_uj_ugyfelek) > 0) {
			$megrendelesek_napra_bontva_osszesites["uj_megrendelok"] = count($megrendelesek_uj_ugyfelek) ;
			if ($ajanlatok_napra_bontva_osszesites["uj_ajanlatkerok"] > 0) {
				$megrendelesek_napra_bontva_osszesites["uj_megrendelok_arajanlatkerok_szazalek"] = round($megrendelesek_napra_bontva_osszesites["uj_megrendelok"] / $ajanlatok_napra_bontva_osszesites["uj_ajanlatkerok"] * 100, 2) ;
			}
			else
			{
				$megrendelesek_napra_bontva_osszesites["uj_megrendelok_arajanlatkerok_szazalek"] = 0 ;
			}
			$megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_db_osszesen"] = 0 ;
			$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_db_osszesen"] = 0 ;
			$megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_netto_osszesen"] = 0 ;
			$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_netto_osszesen"] = 0 ;
			$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_szazalek"] = 0 ;
			$megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_uj_ugyfel_db_osszesen"] = 0 ;
			$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_uj_ugyfel_db_osszesen"] = 0 ;
			$megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_uj_ugyfel_netto_osszesen"] = 0 ;
			$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_uj_ugyfel_netto_osszesen"] = 0 ;
			$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_uj_ugyfel_szazalek"] = 0 ;

			$megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_ajanlat_nelkul_db_osszesen"] = 0 ;
			$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_ajanlat_nelkul_db_osszesen"] = 0 ;
			$megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_ajanlat_nelkul_netto_osszesen"] = 0 ;
			$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_ajanlat_nelkul_netto_osszesen"] = 0 ;
			$megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_ajanlat_nelkul_uj_ugyfel_db_osszesen"] = 0 ;
			$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_ajanlat_nelkul_uj_ugyfel_db_osszesen"] = 0 ;
			$megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_ajanlat_nelkul_uj_ugyfel_netto_osszesen"] = 0 ;
			$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_ajanlat_nelkul_uj_ugyfel_netto_osszesen"] = 0 ;
						
			foreach ($megrendelesek_napra_bontva as $datum => $adatok) {
				$arajanlatok_napra_bontva[$datum]["nyomas_haszon"] = $arajanlatok_napra_bontva[$datum]["nyomas_osszeg"] - $arajanlatok_napra_bontva[$datum]["nyomas_koltseg"] ;
				$arajanlatok_napra_bontva_uj_ugyfelek[$datum]["nyomas_haszon"] = $arajanlatok_napra_bontva_uj_ugyfelek[$datum]["nyomas_osszeg"] - $arajanlatok_napra_bontva_uj_ugyfelek[$datum]["nyomas_koltseg"] ;
				$arajanlatok_napra_bontva[$datum]["eladas_haszon"] = $arajanlatok_napra_bontva[$datum]["eladas_osszeg"] - $arajanlatok_napra_bontva[$datum]["eladas_koltseg"] ;
				$arajanlatok_napra_bontva_uj_ugyfelek[$datum]["eladas_haszon"] = $arajanlatok_napra_bontva_uj_ugyfelek[$datum]["eladas_osszeg"] - $arajanlatok_napra_bontva_uj_ugyfelek[$datum]["eladas_koltseg"] ;				
				$megrendelesek_napra_bontva[$datum]["nyomas_haszon"] = $megrendelesek_napra_bontva[$datum]["nyomas_osszeg"] - $megrendelesek_napra_bontva[$datum]["nyomas_koltseg"] ;
				$megrendelesek_napra_bontva_uj_ugyfelek[$datum]["nyomas_haszon"] = $megrendelesek_napra_bontva_uj_ugyfelek[$datum]["nyomas_osszeg"] - $megrendelesek_napra_bontva_uj_ugyfelek[$datum]["nyomas_koltseg"] ;
				$megrendelesek_napra_bontva_ajanlat_nelkul[$datum]["nyomas_haszon"] = $megrendelesek_napra_bontva_ajanlat_nelkul[$datum]["nyomas_osszeg"] - $megrendelesek_napra_bontva_ajanlat_nelkul[$datum]["nyomas_koltseg"] ;
				$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[$datum]["nyomas_haszon"] = $megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[$datum]["nyomas_osszeg"] - $megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[$datum]["nyomas_koltseg"] ;
				$megrendelesek_napra_bontva[$datum]["eladas_haszon"] = $megrendelesek_napra_bontva[$datum]["eladas_osszeg"] - $megrendelesek_napra_bontva[$datum]["eladas_koltseg"] ;
				$megrendelesek_napra_bontva_uj_ugyfelek[$datum]["eladas_haszon"] = $megrendelesek_napra_bontva_uj_ugyfelek[$datum]["eladas_osszeg"] - $megrendelesek_napra_bontva_uj_ugyfelek[$datum]["eladas_koltseg"] ;
				$megrendelesek_napra_bontva_ajanlat_nelkul[$datum]["eladas_haszon"] = $megrendelesek_napra_bontva_ajanlat_nelkul[$datum]["eladas_osszeg"] - $megrendelesek_napra_bontva_ajanlat_nelkul[$datum]["eladas_koltseg"] ;
				$megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[$datum]["eladas_haszon"] = $megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[$datum]["eladas_osszeg"] - $megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[$datum]["eladas_koltseg"] ;				
				if ($arajanlatok_napra_bontva[$datum]["nyomas_db"] > 0) {
					$megrendelesek_napra_bontva[$datum]["megrendeles_szazalek"] = round(($megrendelesek_napra_bontva[$datum]["nyomas_db"] / $arajanlatok_napra_bontva[$datum]["nyomas_db"]) * 100, 2) ;					
				}
				else
				{
					$megrendelesek_napra_bontva[$datum]["megrendeles_szazalek"] = 0;
				}
				if ($arajanlatok_napra_bontva_uj_ugyfelek[$datum]["nyomas_db"] > 0) {
					$megrendelesek_napra_bontva_uj_ugyfelek[$datum]["megrendeles_szazalek"] = round(($megrendelesek_napra_bontva_uj_ugyfelek[$datum]["nyomas_db"] / $arajanlatok_napra_bontva_uj_ugyfelek[$datum]["nyomas_db"]) * 100, 2) ;
				}
				else
				{
					$megrendelesek_napra_bontva_uj_ugyfelek[$datum]["megrendeles_szazalek"] = 0;
				}
				$megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_db_osszesen"] += $megrendelesek_napra_bontva[$datum]["nyomas_db"] ;
				$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_db_osszesen"] += $megrendelesek_napra_bontva[$datum]["eladas_db"] ;
				$megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_netto_osszesen"] += $megrendelesek_napra_bontva[$datum]["nyomas_osszeg"] ;
				$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_netto_osszesen"] += $megrendelesek_napra_bontva[$datum]["eladas_osszeg"] ;
				$megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_uj_ugyfel_db_osszesen"] += $megrendelesek_napra_bontva_uj_ugyfelek[$datum]["nyomas_db"] ;
				$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_uj_ugyfel_db_osszesen"] += $megrendelesek_napra_bontva_uj_ugyfelek[$datum]["eladas_db"] ;
				$megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_uj_ugyfel_netto_osszesen"] += $megrendelesek_napra_bontva_uj_ugyfelek[$datum]["nyomas_osszeg"] ;
				$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_uj_ugyfel_netto_osszesen"] += $megrendelesek_napra_bontva_uj_ugyfelek[$datum]["eladas_osszeg"] ;
								
				$megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_ajanlat_nelkul_db_osszesen"] += $megrendelesek_napra_bontva_ajanlat_nelkul[$datum]["nyomas_db"] ;
				$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_ajanlat_nelkul_db_osszesen"] += $megrendelesek_napra_bontva_ajanlat_nelkul[$datum]["eladas_db"] ;
				$megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_ajanlat_nelkul_netto_osszesen"] += $megrendelesek_napra_bontva_ajanlat_nelkul[$datum]["nyomas_osszeg"] ;
				$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_ajanlat_nelkul_netto_osszesen"] += $megrendelesek_napra_bontva_ajanlat_nelkul[$datum]["eladas_osszeg"] ;
				$megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_ajanlat_nelkul_uj_ugyfel_db_osszesen"] += $megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[$datum]["nyomas_db"] ;
				$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_ajanlat_nelkul_uj_ugyfel_db_osszesen"] += $megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[$datum]["eladas_db"] ;
				$megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_ajanlat_nelkul_uj_ugyfel_netto_osszesen"] += $megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[$datum]["nyomas_osszeg"] ;
				$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_ajanlat_nelkul_uj_ugyfel_netto_osszesen"] += $megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[$datum]["eladas_osszeg"] ;
				
				$megrendelesek_napra_bontva_osszesites["nyomas_haszon"] += $megrendelesek_napra_bontva[$datum]["nyomas_haszon"] + $megrendelesek_napra_bontva_ajanlat_nelkul[$datum]["nyomas_haszon"];
				$megrendelesek_napra_bontva_osszesites["eladas_haszon"] += $megrendelesek_napra_bontva[$datum]["eladas_haszon"] + $megrendelesek_napra_bontva_ajanlat_nelkul[$datum]["eladas_haszon"] ;
				$megrendelesek_napra_bontva_osszesites["nyomas_haszon_uj_ugyfel"] += $megrendelesek_napra_bontva_uj_ugyfelek[$datum]["nyomas_haszon"] + $megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[$datum]["nyomas_haszon"] ;
				$megrendelesek_napra_bontva_osszesites["eladas_haszon_uj_ugyfel"] += $megrendelesek_napra_bontva_uj_ugyfelek[$datum]["eladas_haszon"] + $megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul[$datum]["eladas_haszon"];
				
				
			}
			if ($ajanlatok_napra_bontva_osszesites["nyomas_ajanlatok_db_osszesen"] > 0) {
				$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_szazalek"] = round(($megrendelesek_napra_bontva_osszesites["nyomas_megrendelesek_db_osszesen"] / $ajanlatok_napra_bontva_osszesites["nyomas_ajanlatok_db_osszesen"]) * 100, 2) ;
			}
			else
			{
				$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_szazalek"] = 0;
			}
			if ($ajanlatok_napra_bontva_osszesites["nyomas_ajanlatok_uj_ugyfel_db_osszesen"] > 0) {
				$megrendelesek_napra_bontva_osszesites["eladas_megrendelesek_uj_ugyfel_szazalek"] = round(($megrendelesek_napra_bontva_uj_ugyfelek["nyomas_megrendelesek_db_osszesen"] / $ajanlatok_napra_bontva_osszesites["nyomas_ajanlatok_uj_ugyfel_db_osszesen"]) * 100, 2) ;
			}
			else
			{
				$megrendelesek_napra_bontva_osszesites["nyomas_ajanlatok_uj_ugyfel_db_osszesen"] = 0 ;	
			}
			
		}
				
		$stat_adatok["megrendelesek_napra_bontva"] = $megrendelesek_napra_bontva ;
		$stat_adatok["megrendelesek_napra_bontva_uj_ugyfelek"] = $megrendelesek_napra_bontva_uj_ugyfelek ;
		$stat_adatok["megrendelesek_napra_bontva_ajanlat_nelkul"] = $megrendelesek_napra_bontva_ajanlat_nelkul ;
		$stat_adatok["megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul"] = $megrendelesek_napra_bontva_uj_ugyfelek_ajanlat_nelkul ;
		$stat_adatok["megrendelesek_napra_bontva_osszesites"] = $megrendelesek_napra_bontva_osszesites ;
		
		$stat_adatok["megrendelesek_eladas_lista"] = $megrendelesek_eladas_lista ;
		$stat_adatok["megrendelesek_nyomas_lista"] = $megrendelesek_nyomas_lista ;
		$stat_adatok["megrendelesek_nyomas_nincs_nyomdakonyvben_lista"] = $megrendelesek_nyomas_nincs_nyomdakonyvben_lista ;
		$stat_adatok["megrendelesek_nyomas_nincs_nyomdakonyvben_osszeg"] = $megrendelesek_nyomas_nincs_nyomdakonyvben_osszeg ;

		$stat_adatok["megrendelesek_eladas_lista_osszesites"] = $megrendelesek_eladas_lista_osszesites ;
		$stat_adatok["megrendelesek_nyomas_lista_osszesites"] = $megrendelesek_nyomas_lista_osszesites ;		
		
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
				$elasas = false ;
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
						$eladas = true ;
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
				if ($eladas)
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
				$eladas = false ;
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
						$eladas = true ;
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
				if ($eladas)
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

		$osszes_nyitott_megrendeles_kiemeltek_nelkul["db"] = 0 ;
		$osszes_nyitott_megrendeles_kiemeltek_nelkul["netto"] = 0 ;
		$osszes_nyitott_megrendeles_kiemeltek_nelkul["brutto"] = 0 ;		
		$mult_honapban_lejartak_kiemeltek_nelkul["db"] = 0 ;
		$mult_honapban_lejartak_kiemeltek_nelkul["netto"] = 0 ;
		$mult_honapban_lejartak_kiemeltek_nelkul["brutto"] = 0 ;		
		$mult_evben_lejartak_kiemeltek_nelkul["db"] = 0 ;
		$mult_evben_lejartak_kiemeltek_nelkul["netto"] = 0 ;
		$mult_evben_lejartak_kiemeltek_nelkul["brutto"] = 0 ;		
		$lejartak_kiemeltek_nelkul["db"] = 0 ;
		$lejartak_kiemeltek_nelkul["netto"] = 0 ;
		$lejartak_kiemeltek_nelkul["brutto"] = 0 ;		
		$nem_lejartak_kiemeltek_nelkul["db"] = 0 ;
		$nem_lejartak_kiemeltek_nelkul["netto"] = 0 ;
		$nem_lejartak_kiemeltek_nelkul["brutto"] = 0 ;		
		$lejarnak_ebben_a_honapban_kiemeltek_nelkul["db"] = 0 ;
		$lejarnak_ebben_a_honapban_kiemeltek_nelkul["netto"] = 0 ;
		$lejarnak_ebben_a_honapban_kiemeltek_nelkul["brutto"] = 0 ;		
		$behajto_cegnek_atadva_kiemeltek_nelkul["db"] = 0 ;
		$behajto_cegnek_atadva_kiemeltek_nelkul["netto"] = 0 ;
		$behajto_cegnek_atadva_kiemeltek_nelkul["brutto"] = 0 ;		
		$ugyvednek_atadva_kiemeltek_nelkul["db"] = 0 ;
		$ugyvednek_atadva_kiemeltek_nelkul["netto"] = 0 ;
		$ugyvednek_atadva_kiemeltek_nelkul["brutto"] = 0 ;		

		$osszes_nyitott_megrendeles_csak_kiemeltek["db"] = 0 ;
		$osszes_nyitott_megrendeles_csak_kiemeltek["netto"] = 0 ;
		$osszes_nyitott_megrendeles_csak_kiemeltek["brutto"] = 0 ;		
		$mult_honapban_lejartak_csak_kiemeltek["db"] = 0 ;
		$mult_honapban_lejartak_csak_kiemeltek["netto"] = 0 ;
		$mult_honapban_lejartak_csak_kiemeltek["brutto"] = 0 ;		
		$mult_evben_lejartak_csak_kiemeltek["db"] = 0 ;
		$mult_evben_lejartak_csak_kiemeltek["netto"] = 0 ;
		$mult_evben_lejartak_csak_kiemeltek["brutto"] = 0 ;		
		$lejartak_csak_kiemeltek["db"] = 0 ;
		$lejartak_csak_kiemeltek["netto"] = 0 ;
		$lejartak_csak_kiemeltek["brutto"] = 0 ;		
		$nem_lejartak_csak_kiemeltek["db"] = 0 ;
		$nem_lejartak_csak_kiemeltek["netto"] = 0 ;
		$nem_lejartak_csak_kiemeltek["brutto"] = 0 ;		
		$lejarnak_ebben_a_honapban_csak_kiemeltek["db"] = 0 ;
		$lejarnak_ebben_a_honapban_csak_kiemeltek["netto"] = 0 ;
		$lejarnak_ebben_a_honapban_csak_kiemeltek["brutto"] = 0 ;		
		$behajto_cegnek_atadva_csak_kiemeltek["db"] = 0 ;
		$behajto_cegnek_atadva_csak_kiemeltek["netto"] = 0 ;
		$behajto_cegnek_atadva_csak_kiemeltek["brutto"] = 0 ;		
		$ugyvednek_atadva_csak_kiemeltek["db"] = 0 ;
		$ugyvednek_atadva_csak_kiemeltek["netto"] = 0 ;
		$ugyvednek_atadva_csak_kiemeltek["brutto"] = 0 ;		

		$kiemelt_cegek_nyitott_megrendelesekkel = array() ;
		
		$nyitott_megrendelesek = $this->getTartozasok() ;
		$elozo_honap = mktime(0, 0, 0, date("m")-1, date("d"), date("Y"));
		$elozo_ev = mktime(0, 0, 0, date("m"), date("d"), date("Y")-1);
		$tartozasok_ev_honap = array() ;
		if ($nyitott_megrendelesek->totalItemCount > 0) {
			foreach ($nyitott_megrendelesek->getData() as $sor) {
				$megrendeles_ertek = $sor->getMegrendelesOsszeg() ;
				$befizetett_osszeg = 0 ;				
				if (count($sor->penzugyi_tranzakciok) > 0) {
					foreach ($sor->penzugyi_tranzakciok as $tranzakcio) {
						$befizetett_osszeg += $tranzakcio->osszeg ;	
					}
				}
				$tartozas = $megrendeles_ertek["brutto_osszeg"] - $befizetett_osszeg ;
				if ($sor->szamla_fizetesi_hatarido != '0000-00-00' && $sor->szamla_fizetesi_hatarido < date("Y-m-d")) {
					//Lejárt
					if (!isset($tartozasok_ev_honap[date("Y-m", strtotime($sor->szamla_fizetesi_hatarido))]["db"])) {
						$tartozasok_ev_honap[date("Y-m", strtotime($sor->szamla_fizetesi_hatarido))]["db"] = 1 ;	
						$tartozasok_ev_honap[date("Y-m", strtotime($sor->szamla_fizetesi_hatarido))]["cegek"][$sor->ugyfel->cegnev] = 1 ;
						$tartozasok_ev_honap[date("Y-m", strtotime($sor->szamla_fizetesi_hatarido))]["netto"] = $megrendeles_ertek["netto_osszeg"] ;
						$tartozasok_ev_honap[date("Y-m", strtotime($sor->szamla_fizetesi_hatarido))]["brutto"] = $megrendeles_ertek["brutto_osszeg"] ;
						$tartozasok_ev_honap[date("Y-m", strtotime($sor->szamla_fizetesi_hatarido))]["tartozas"] = $tartozas ;
					}
					else
					{
						$tartozasok_ev_honap[date("Y-m", strtotime($sor->szamla_fizetesi_hatarido))]["db"]++ ;
						$tartozasok_ev_honap[date("Y-m", strtotime($sor->szamla_fizetesi_hatarido))]["cegek"][$sor->ugyfel->cegnev] = 1 ;
						$tartozasok_ev_honap[date("Y-m", strtotime($sor->szamla_fizetesi_hatarido))]["netto"] += $megrendeles_ertek["netto_osszeg"] ;
						$tartozasok_ev_honap[date("Y-m", strtotime($sor->szamla_fizetesi_hatarido))]["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;
						$tartozasok_ev_honap[date("Y-m", strtotime($sor->szamla_fizetesi_hatarido))]["tartozas"] += $tartozas ;
					}
					if ($sor->ugyvednek_atadva == 0) {
						$lejartak["db"]++ ;
						$lejartak["netto"] += $megrendeles_ertek["netto_osszeg"] ;
						$lejartak["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;
						if ($sor->ugyfel->kiemelt == 1) {							
							$lejartak_csak_kiemeltek["db"]++ ;
							$lejartak_csak_kiemeltek["netto"] += $megrendeles_ertek["netto_osszeg"] ;
							$lejartak_csak_kiemeltek["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;							
						}
						else
						{
							$lejartak_kiemeltek_nelkul["db"]++ ;
							$lejartak_kiemeltek_nelkul["netto"] += $megrendeles_ertek["netto_osszeg"] ;
							$lejartak_kiemeltek_nelkul["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;							
						}
					}
					else
					{
						if ($sor->behajto_cegnek_atadva == 1) {
							$behajto_cegnek_atadva["db"]++ ;
							$behajto_cegnek_atadva["netto"] += $megrendeles_ertek["netto_osszeg"] ;
							$behajto_cegnek_atadva["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;							
							if ($sor->ugyfel->kiemelt == 1) {
								$behajto_cegnek_atadva_csak_kiemeltek["db"]++ ;
								$behajto_cegnek_atadva_csak_kiemeltek["netto"] += $megrendeles_ertek["netto_osszeg"] ;
								$behajto_cegnek_atadva_csak_kiemeltek["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;							
							}
							else
							{
								$behajto_cegnek_atadva_kiemeltek_nelkul["db"]++ ;
								$behajto_cegnek_atadva_kiemeltek_nelkul["netto"] += $megrendeles_ertek["netto_osszeg"] ;
								$behajto_cegnek_atadva_kiemeltek_nelkul["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;							
							}
						}
						$ugyvednek_atadva["db"]++ ;
						$ugyvednek_atadva["netto"] += $megrendeles_ertek["netto_osszeg"] ;
						$ugyvednek_atadva["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;		
						if ($sor->ugyfel->kiemelt == 1) {
							$ugyvednek_atadva_csak_kiemeltek["db"]++ ;
							$ugyvednek_atadva_csak_kiemeltek["netto"] += $megrendeles_ertek["netto_osszeg"] ;
							$ugyvednek_atadva_csak_kiemeltek["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;							
						}
						else
						{
							$ugyvednek_atadva_kiemeltek_nelkul["db"]++ ;
							$ugyvednek_atadva_kiemeltek_nelkul["netto"] += $megrendeles_ertek["netto_osszeg"] ;
							$ugyvednek_atadva_kiemeltek_nelkul["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;							
						}						
					}
					if (substr($sor->szamla_fizetesi_hatarido, 0, 7) == date("Y-m", $elozo_honap)) {
						$mult_honapban_lejartak["db"]++ ;
						$mult_honapban_lejartak["netto"] += $megrendeles_ertek["netto_osszeg"] ;
						$mult_honapban_lejartak["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;
						if ($sor->ugyfel->kiemelt == 1) {
							$mult_honapban_lejartak_csak_kiemeltek["db"]++ ;
							$mult_honapban_lejartak_csak_kiemeltek["netto"] += $megrendeles_ertek["netto_osszeg"] ;
							$mult_honapban_lejartak_csak_kiemeltek["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;							
						}
						else
						{
							$mult_honapban_lejartak_kiemeltek_nelkul["db"]++ ;
							$mult_honapban_lejartak_kiemeltek_nelkul["netto"] += $megrendeles_ertek["netto_osszeg"] ;
							$mult_honapban_lejartak_kiemeltek_nelkul["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;							
						}						
					}
					elseif (substr($sor->szamla_fizetesi_hatarido, 0, 4) == date("Y", $elozo_ev)) {
						$mult_evben_lejartak["db"]++ ;
						$mult_evben_lejartak["netto"] += $megrendeles_ertek["netto_osszeg"] ;
						$mult_evben_lejartak["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;
						if ($sor->ugyfel->kiemelt == 1) {
							$mult_evben_lejartak_csak_kiemeltek["db"]++ ;
							$mult_evben_lejartak_csak_kiemeltek["netto"] += $megrendeles_ertek["netto_osszeg"] ;
							$mult_evben_lejartak_csak_kiemeltek["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;							
						}
						else
						{
							$mult_evben_lejartak_kiemeltek_nelkul["db"]++ ;
							$mult_evben_lejartak_kiemeltek_nelkul["netto"] += $megrendeles_ertek["netto_osszeg"] ;
							$mult_evben_lejartak_kiemeltek_nelkul["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;							
						}												
					}
					if ($sor->ugyfel->kiemelt == 1) {
						if (!isset($kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["legregebbi_datum"]) || $kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["legregebbi_datum"] > $sor->szamla_fizetesi_hatarido) {
							$kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["legregebbi_datum"] = $sor->szamla_fizetesi_hatarido ;
						}
						if (!isset($kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["lejart"]["db"])) {
							$kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["lejart"]["db"] = 1 ;
							$kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["lejart"]["netto"] = $megrendeles_ertek["netto_osszeg"] ;
							$kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["lejart"]["brutto"] = $megrendeles_ertek["brutto_osszeg"] ;
						}
						else
						{
							$kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["lejart"]["db"]++ ;
							$kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["lejart"]["netto"] += $megrendeles_ertek["netto_osszeg"] ;
							$kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["lejart"]["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;
						}
					}					
				}
				else
				{
					//Nem lejárt	
					$nem_lejartak["db"]++ ;
					$nem_lejartak["netto"] += $megrendeles_ertek["netto_osszeg"] ;
					$nem_lejartak["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;
					if ($sor->ugyfel->kiemelt == 1) {
						$nem_lejartak_csak_kiemeltek["db"]++ ;
						$nem_lejartak_csak_kiemeltek["netto"] += $megrendeles_ertek["netto_osszeg"] ;
						$nem_lejartak_csak_kiemeltek["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;							
					}
					else
					{
						$nem_lejartak_kiemeltek_nelkul["db"]++ ;
						$nem_lejartak_kiemeltek_nelkul["netto"] += $megrendeles_ertek["netto_osszeg"] ;
						$nem_lejartak_kiemeltek_nelkul["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;							
					}												
					
					if (substr($sor->szamla_fizetesi_hatarido, 0, 7) == date("Y-m")) {
						$lejarnak_ebben_a_honapban["db"]++ ;
						$lejarnak_ebben_a_honapban["netto"] += $megrendeles_ertek["netto_osszeg"] ;
						$lejarnak_ebben_a_honapban["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;
						if ($sor->ugyfel->kiemelt == 1) {
							$lejarnak_ebben_a_honapban_csak_kiemeltek["db"]++ ;
							$lejarnak_ebben_a_honapban_csak_kiemeltek["netto"] += $megrendeles_ertek["netto_osszeg"] ;
							$lejarnak_ebben_a_honapban_csak_kiemeltek["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;							
						}
						else
						{
							$lejarnak_ebben_a_honapban_kiemeltek_nelkul["db"]++ ;
							$lejarnak_ebben_a_honapban_kiemeltek_nelkul["netto"] += $megrendeles_ertek["netto_osszeg"] ;
							$lejarnak_ebben_a_honapban_kiemeltek_nelkul["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;							
						}												
					}
					if ($sor->ugyfel->kiemelt == 1) {
						if (!isset($kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["legregebbi_datum"]) || $kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["legregebbi_datum"] > $sor->szamla_fizetesi_hatarido) {
							$kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["legregebbi_datum"] = $sor->szamla_fizetesi_hatarido ;
						}
						if (!isset($kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["nem_lejart"]["db"])) {
							$kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["nem_lejart"]["db"] = 1 ;
							$kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["nem_lejart"]["netto"] = $megrendeles_ertek["netto_osszeg"] ;
							$kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["nem_lejart"]["brutto"] = $megrendeles_ertek["brutto_osszeg"] ;
						}
						else
						{
							$kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["nem_lejart"]["db"]++ ;
							$kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["nem_lejart"]["netto"] += $megrendeles_ertek["netto_osszeg"] ;
							$kiemelt_cegek_nyitott_megrendelesekkel[$sor->ugyfel->cegnev]["nem_lejart"]["brutto"] += $megrendeles_ertek["brutto_osszeg"] ;
						}
					}					
				}
			}
			$osszes_nyitott_megrendeles["db"] = $lejartak["db"] + $nem_lejartak["db"] + $ugyvednek_atadva["db"] ;
			$osszes_nyitott_megrendeles["netto"] = $lejartak["netto"] + $nem_lejartak["netto"] + $ugyvednek_atadva["netto"] ;
			$osszes_nyitott_megrendeles["brutto"] = $lejartak["brutto"] + $nem_lejartak["brutto"] + $ugyvednek_atadva["brutto"] ;

			$osszes_nyitott_megrendeles_csak_kiemeltek["db"] = $lejartak_csak_kiemeltek["db"] + $nem_lejartak_csak_kiemeltek["db"] + $ugyvednek_atadva_csak_kiemeltek["db"] ;
			$osszes_nyitott_megrendeles_csak_kiemeltek["netto"] = $lejartak_csak_kiemeltek["netto"] + $nem_lejartak_csak_kiemeltek["netto"] + $ugyvednek_atadva_csak_kiemeltek["netto"] ;
			$osszes_nyitott_megrendeles_csak_kiemeltek["brutto"] = $lejartak_csak_kiemeltek["brutto"] + $nem_lejartak_csak_kiemeltek["brutto"] + $ugyvednek_atadva_csak_kiemeltek["brutto"] ;

			$osszes_nyitott_megrendeles_kiemeltek_nelkul["db"] = $lejartak_kiemeltek_nelkul["db"] + $nem_lejartak_kiemeltek_nelkul["db"] + $ugyvednek_atadva_kiemeltek_nelkul["db"] ;
			$osszes_nyitott_megrendeles_kiemeltek_nelkul["netto"] = $lejartak_kiemeltek_nelkul["netto"] + $nem_lejartak_kiemeltek_nelkul["netto"] + $ugyvednek_atadva_kiemeltek_nelkul["netto"] ;
			$osszes_nyitott_megrendeles_kiemeltek_nelkul["brutto"] = $lejartak_kiemeltek_nelkul["brutto"] + $nem_lejartak_kiemeltek_nelkul["brutto"] + $ugyvednek_atadva_kiemeltek_nelkul["brutto"] ;
		}
		$stat_adatok["osszes_nyitott_megrendeles"] = $osszes_nyitott_megrendeles ;
		$stat_adatok["mult_honapban_lejartak"] = $mult_honapban_lejartak ;
		$stat_adatok["mult_evben_lejartak"] = $mult_evben_lejartak ;
		$stat_adatok["lejartak"] = $lejartak ;
		$stat_adatok["nem_lejartak"] = $nem_lejartak ;
		$stat_adatok["lejarnak_ebben_a_honapban"] = $lejarnak_ebben_a_honapban ;
		$stat_adatok["behajto_cegnek_atadva"] = $behajto_cegnek_atadva ;
		$stat_adatok["ugyvednek_atadva"] = $ugyvednek_atadva ;

		$stat_adatok["osszes_nyitott_megrendeles_csak_kiemeltek"] = $osszes_nyitott_megrendeles_csak_kiemeltek ;
		$stat_adatok["mult_honapban_lejartak_csak_kiemeltek"] = $mult_honapban_lejartak_csak_kiemeltek ;
		$stat_adatok["mult_evben_lejartak_csak_kiemeltek"] = $mult_evben_lejartak_csak_kiemeltek ;
		$stat_adatok["lejartak_csak_kiemeltek"] = $lejartak_csak_kiemeltek ;
		$stat_adatok["nem_lejartak_csak_kiemeltek"] = $nem_lejartak_csak_kiemeltek ;
		$stat_adatok["lejarnak_ebben_a_honapban_csak_kiemeltek"] = $lejarnak_ebben_a_honapban_csak_kiemeltek ;
		$stat_adatok["behajto_cegnek_atadva_csak_kiemeltek"] = $behajto_cegnek_atadva_csak_kiemeltek ;
		$stat_adatok["ugyvednek_atadva_csak_kiemeltek"] = $ugyvednek_atadva_csak_kiemeltek ;

		$stat_adatok["osszes_nyitott_megrendeles_kiemeltek_nelkul"] = $osszes_nyitott_megrendeles_kiemeltek_nelkul ;
		$stat_adatok["mult_honapban_lejartak_kiemeltek_nelkul"] = $mult_honapban_lejartak_kiemeltek_nelkul ;
		$stat_adatok["mult_evben_lejartak_kiemeltek_nelkul"] = $mult_evben_lejartak_kiemeltek_nelkul ;
		$stat_adatok["lejartak_kiemeltek_nelkul"] = $lejartak_kiemeltek_nelkul ;
		$stat_adatok["nem_lejartak_kiemeltek_nelkul"] = $nem_lejartak_kiemeltek_nelkul ;
		$stat_adatok["lejarnak_ebben_a_honapban_kiemeltek_nelkul"] = $lejarnak_ebben_a_honapban_kiemeltek_nelkul ;
		$stat_adatok["behajto_cegnek_atadva_kiemeltek_nelkul"] = $behajto_cegnek_atadva_kiemeltek_nelkul ;
		$stat_adatok["ugyvednek_atadva_kiemeltek_nelkul"] = $ugyvednek_atadva_kiemeltek_nelkul ;
		
		$stat_adatok["kiemelt_cegek_nyitott_megrendelesekkel"] = $kiemelt_cegek_nyitott_megrendelesekkel ;
		$stat_adatok["tartozasok_ev_honap"] = $tartozasok_ev_honap ;
		
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

	// sztornózott megrendelések felületét kezelire irányít
	public function actionSztornozottMegrendelesek () {
		$model = new StatisztikakSztornozottMegrendelesek;
		
		if (isset($_POST['StatisztikakSztornozottMegrendelesek'])) {
            $model->attributes = $_POST['StatisztikakSztornozottMegrendelesek'];

            if ($model->validate()) {
				// minden rendben, jók a dátumszűrők, mehet a lekérdezés
				$this -> sztornozottMegrendelesekPrintPDF($model);
			} else {
				// nincs kitöltve/jól kitöltve valamelyik szűrőmező
				$this->render('_sztornozottMegrendelesek',array('model'=>$model,));
			}
			
			return;
        } else {
			$model = new StatisztikakSztornozottMegrendelesek;
			$this->render('_sztornozottMegrendelesek',array(
				'model'=>$model,)
			);
		}
	}

	// a kapott model alapján összeállítja a sztornózott megrendelések PDF-ét
	public function sztornozottMegrendelesekPrintPDF ($model) {
		// ilyen elvileg nem lehet, de biztos ami biztos, akár a jövőre nézve is
		if ($model != null) {
			$dataProvider = new CActiveDataProvider('Megrendelesek', array(
				'criteria'=>array(
					'condition'=>'rendeles_idopont >= :mettol AND rendeles_idopont <= :meddig AND sztornozva = 1',
					'params'=>array(':mettol' => $model -> statisztika_mettol, ':meddig' => $model -> statisztika_meddig),
				),
				'pagination'=>false,
			));
			
			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();

			$mPDF1->SetHtmlHeader("Sztornózott megrendelések: " . $model->statisztika_mettol . " - " . $model->statisztika_meddig);
			
			# render
			$mPDF1->WriteHTML($this->renderPartial('printSztornozottMegrendelesek', array('dataProvider' => $dataProvider, 'model' => $model), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
		}
	}
	
}
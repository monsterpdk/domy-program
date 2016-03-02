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
				'condition'=>'ugyfel.kiemelt = ' . $kiemeltek . ' and t.torolt=0 and t.sztornozva=0 and t.rendeles_idopont>=\'' . $model->statisztika_mettol . '\' and t.rendeles_idopont <= \'' . $model->statisztika_meddig . '\'' . $elozmeny_query ,
//				'join'=>'left join dom_ugyfelek ugyfel on (t.ugyfel_id = ugyfel.id) left join dom_megrendeles_tetelek megrendeles_tetel on (t.id = megrendeles_tetel.megrendeles_id)',
				'with'=>array('tetelek' => array('termek' => array('termekar')), 'ugyfel'),
//				'with'=>array('tetelek', 'ugyfel', 'termek', 'termekar'),
				'together'=>true,
			),
			'countCriteria'=>array(
				'select'=>'tetelek.*',
				'condition'=>'ugyfel.kiemelt = ' . $kiemeltek . ' and t.torolt=0 and t.sztornozva=0 and t.rendeles_idopont>=\'' . $model->statisztika_mettol . '\' and t.rendeles_idopont <= \'' . $model->statisztika_meddig . '\'' . $elozmeny_query ,
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
				'condition'=>'t.torolt=0 and t.sztornozva=0 and t.rendeles_idopont>=\'' . $model->statisztika_mettol . '\' and t.rendeles_idopont <= \'' . $model->statisztika_meddig . '\' and szallitolevel.id IS NOT NULL' . $elozmeny_query,
//				'join'=>'left join dom_ugyfelek ugyfel on (t.ugyfel_id = ugyfel.id) left join dom_megrendeles_tetelek megrendeles_tetel on (t.id = megrendeles_tetel.megrendeles_id)',
				'with'=>array('szallitolevel', 'tetelek' => array('termek' => array('termekar')), 'ugyfel'),
//				'with'=>array('tetelek', 'ugyfel', 'termek', 'termekar'),
				'together'=>true,
			),
			'countCriteria'=>array(
				'select'=>'tetelek.*',
				'condition'=>'t.torolt=0 and t.sztornozva=0 and t.rendeles_idopont>=\'' . $model->statisztika_mettol . '\' and t.rendeles_idopont <= \'' . $model->statisztika_meddig . '\' and szallitolevel.id IS NOT NULL' . $elozmeny_query,
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
	
	public function actionNapiKombinaltStatisztika()
	{
		$model = new Statisztikak;
		
		$this->render('napiKombinaltStatisztika',array('model'=>$model));		
	}
	
	public function actionNapiKombinaltStatisztikaPrintPDF()
	{
		$model = new Statisztikak;

		if (isset($_POST['Statisztikak']))
		{
			$model -> statisztika_mettol = $_POST['Statisztikak']["statisztika_mettol"] ;
			$model -> statisztika_meddig = $_POST['Statisztikak']["statisztika_meddig"] ;
		}
		$model -> statisztika_mettol = "2016-01-07" ;
		$model -> statisztika_meddig = "2016-01-14" ;

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
		if ($arajanlatTetelekStatisztika_kiemeltek_nelkul->totalItemCount > 0) {
			foreach ($arajanlatTetelekStatisztika_kiemeltek_nelkul->getData() as $sor) {
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
						$arajanlatOsszegEladas_kiemeltek_nelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;						
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
		$stat_adatok["arajanlatStatisztika_kiemeltek_nelkul"] = $arajanlatokEladas ;
		$stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul"] = $arajanlatTetelekEladas ;		
		$stat_adatok["arajanlatOsszegEladas_kiemeltek_nelkul"] = $arajanlatOsszegEladas_kiemeltek_nelkul ;
		$stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul"] = $arajanlatokNyomas ;
		$stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul"] = $arajanlatTetelekNyomas ;		
		$stat_adatok["arajanlatOsszegNyomas_kiemeltek_nelkul"] = $arajanlatOsszegNyomas ;
		$stat_adatok["arajanlatLegparnasTetelekStatisztika_kiemeltek_nelkul"] = $arajanlatTetelekLegparnas ;		
		$stat_adatok["arajanlatOsszegLegparnas_kiemeltek_nelkul"] = $arajanlatOsszegLegparnas ;
		

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
		
//Megrendeléssel kapcsolatos statisztikák nem kiemelt cégek		
		$megrendelesTetelekStatisztika_kiemeltek_nelkul = $this->getMegrendelesTetelekStatisztika($model, 0) ;
		$megrendelesokEladas = 0 ;
		$megrendelesTetelekEladas = 0 ;
		$megrendelesOsszegEladas_kiemeltek_nelkul = 0 ;
		$megrendelesTetelekLegparnas = 0 ;
		$megrendelesOsszegLegparnas = 0 ;
		$megrendelesokNyomas = 0 ;
		$megrendelesTetelekNyomas = 0 ;
		$megrendelesOsszegNyomas = 0 ;
		$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul = 0 ;
		$bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul = 0 ;
		$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul = 0 ;
		$anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul = 0 ;
		if ($megrendelesTetelekStatisztika_kiemeltek_nelkul->totalItemCount > 0) {
			foreach ($megrendelesTetelekStatisztika_kiemeltek_nelkul->getData() as $sor) {
				$nyomas = false ;				
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
						$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul += ($db_eladasi_ar * $tetel_sor->darabszam) ;
						$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
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
						$bevetel_termekeken_nyomas_osszesen_kiemeltek_nelkul += ($tetel_sor->netto_darabar * $tetel_sor->darabszam) ;
						$anyagkoltseg_termekeken_nyomas_osszesen_kiemeltek_nelkul += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
					}
					elseif ($tetel_sor->termek->tipus != "Szolgáltatás")		//Ide most minden bemegy, ami nem légpárnás, nem nyomás és nem szolgáltatás, tehát ide megy a ragasztószalag, levélpapír, stb. is
					{
						$megrendelesTetelekEladas++ ;
						$megrendelesOsszegEladas_kiemeltek_nelkul += $tetel_sor->netto_darabar * $tetel_sor->darabszam ;	
						if ($tetel_sor->darabszam >= $termek->csom_egys) {
							$db_eladasi_ar = $ervenyes_termekar_rekord->csomag_eladasi_ar / $termek->csom_egys ;	
						}
						else
						{
							$db_eladasi_ar = $ervenyes_termekar_rekord->db_eladasi_ar ;
						}		
//						echo "ccc $sor->id: $db_eladasi_ar * $tetel_sor->darabszam = " . ($db_eladasi_ar * $tetel_sor->darabszam) . "<br />" ;
						$bevetel_termekeken_eladas_osszesen_kiemeltek_nelkul += ($db_eladasi_ar * $tetel_sor->darabszam) ;						
						$anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
					}					
				}
				if ($nyomas) {
					$megrendelesokNyomas++ ;
				}
				else
				{
					$megrendelesokEladas++ ;
				}
			}
		}
//		die($anyagkoltseg_termekeken_eladas_osszesen_kiemeltek_nelkul) ;
		$stat_adatok["megrendelesStatisztika_kiemeltek_nelkul"] = $megrendelesokEladas ;
		$stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul"] = $megrendelesTetelekEladas ;		
		$stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul"] = $megrendelesOsszegEladas_kiemeltek_nelkul ;
		$stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul"] = $megrendelesokNyomas ;
		$stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul"] = $megrendelesTetelekNyomas ;		
		$stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul"] = $megrendelesOsszegNyomas ;
		$stat_adatok["megrendelesLegparnasTetelekStatisztika_kiemeltek_nelkul"] = $megrendelesTetelekLegparnas ;		
		$stat_adatok["megrendelesOsszegLegparnas_kiemeltek_nelkul"] = $megrendelesOsszegLegparnas ;
		if ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul"] > 0)
			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalek"] = round(($stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul"] / $stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul"]) * 100, 2) ;
		else
			$stat_adatok["eladas_arajanlatszam_megrendelesszam_szazalek"] = 0 ;
		if ($stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul"] > 0)
			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalek"] = round(($stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul"] / $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul"]) * 100, 2) ;
		else
			$stat_adatok["nyomas_arajanlatszam_megrendelesszam_szazalek"] = 0 ;
		if ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul"] > 0)
			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalek"] = round((($stat_adatok["megrendelesTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesNyomasTetelekStatisztika_kiemeltek_nelkul"]) / ($stat_adatok["arajanlatTetelekStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatNyomasTetelekStatisztika_kiemeltek_nelkul"])) * 100, 2) ;
		else
			$stat_adatok["osszesen_arajanlatszam_megrendelesszam_szazalek"] = 0 ;
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
			$stat_adatok["anyag_szazalek_kiemeltek_nelkul"] = round($stat_adatok["anyagkoltseg_osszesen_kiemeltek_nelkul"] / ($stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul"]), 2) ;
		else
			$stat_adatok["anyag_szazalek_kiemeltek_nelkul"] = 0 ;
		if ($stat_adatok["anyagkoltseg_osszesen_kiemeltek_nelkul"] > 0)			
			$stat_adatok["haszon_lentrol_kiemeltek_nelkul"] = round($stat_adatok["haszon_osszesen_kiemeltek_nelkul"] / $stat_adatok["anyagkoltseg_osszesen_kiemeltek_nelkul"], 2);
		else
			$stat_adatok["haszon_lentrol_kiemeltek_nelkul"] = 0 ;
		if ($stat_adatok["anyagkoltseg_osszesen_kiemeltek_nelkul"] > 0)
			$stat_adatok["haszon_fentrol_kiemeltek_nelkul"] = round(($megrendelesOsszegEladas_kiemeltek_nelkul + $megrendelesOsszegNyomas + $megrendelesOsszegLegparnas) / $stat_adatok["anyagkoltseg_osszesen_kiemeltek_nelkul"], 2);
		else
			$stat_adatok["haszon_fentrol_kiemeltek_nelkul"] ;
		
		
//Megrendeléssel kapcsolatos statisztikák kiemelt cégek		
		$megrendelesTetelekStatisztika_csak_kiemeltek = $this->getMegrendelesTetelekStatisztika($model, 1) ;
		$megrendelesokEladas = 0 ;
		$megrendelesTetelekEladas = 0 ;
		$megrendelesOsszegEladas_csak_kiemeltek = 0 ;
		$megrendelesTetelekLegparnas = 0 ;
		$megrendelesOsszegLegparnas = 0 ;
		$megrendelesokNyomas = 0 ;
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
						$anyagkoltseg_termekeken_eladas_osszesen_csak_kiemeltek += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
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
						$anyagkoltseg_termekeken_nyomas_osszesen_csak_kiemeltek += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
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
						$anyagkoltseg_termekeken_eladas_osszesen_csak_kiemeltek += ($ervenyes_termekar_rekord->darab_ar_szamolashoz * $tetel_sor->darabszam) ;
					}					
				}
				if ($nyomas) {
					$megrendelesokNyomas++ ;
				}
				else
				{
					$megrendelesokEladas++ ;
				}
			}
		}
//		die($anyagkoltseg_termekeken_eladas_osszesen_csak_kiemeltek) ;
		$stat_adatok["megrendelesStatisztika_csak_kiemeltek"] = $megrendelesokEladas ;
		$stat_adatok["megrendelesTetelekStatisztika_csak_kiemeltek"] = $megrendelesTetelekEladas ;		
		$stat_adatok["megrendelesOsszegEladas_csak_kiemeltek"] = $megrendelesOsszegEladas_csak_kiemeltek ;
		$stat_adatok["megrendelesNyomasStatisztika_csak_kiemeltek"] = $megrendelesokNyomas ;
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
			$stat_adatok["anyag_szazalek_csak_kiemeltek"] = round($stat_adatok["anyagkoltseg_osszesen_csak_kiemeltek"] / ($stat_adatok["megrendelesOsszegEladas_csak_kiemeltek"] + $stat_adatok["megrendelesOsszegNyomas_csak_kiemeltek"]), 2) ;
		else
			$stat_adatok["anyag_szazalek_csak_kiemeltek"] = 0 ;
		if ($stat_adatok["anyagkoltseg_osszesen_csak_kiemeltek"] > 0)
			$stat_adatok["haszon_lentrol_csak_kiemeltek"] = round($stat_adatok["haszon_osszesen_csak_kiemeltek"] / $stat_adatok["anyagkoltseg_osszesen_csak_kiemeltek"], 2);
		else
			$stat_adatok["haszon_lentrol_csak_kiemeltek"] = 0 ;
		if ($stat_adatok["anyagkoltseg_osszesen_csak_kiemeltek"] > 0)
			$stat_adatok["haszon_fentrol_csak_kiemeltek"] = round(($megrendelesOsszegEladas_csak_kiemeltek + $megrendelesOsszegNyomas + $megrendelesOsszegLegparnas) / $stat_adatok["anyagkoltseg_osszesen_csak_kiemeltek"], 2);
		else
			$stat_adatok["haszon_fentrol_csak_kiemeltek"] = 0;
		$stat_adatok["cegek_kiemeltek"] = $cegek_kiemeltek ;
		$stat_adatok["cegek_megrendelesszam_osszesen_csak_kiemeltek"] = $cegek_megrendelesszam_osszesen_csak_kiemeltek ;
		$stat_adatok["cegek_megrendelesosszeg_csak_kiemeltek"] = $cegek_megrendelesosszeg_csak_kiemeltek ;
		$stat_adatok["kiadott_ajanlatok_szama_osszesen"] = $stat_adatok["arajanlatStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatNyomasStatisztika_kiemeltek_nelkul"] + $stat_adatok["arajanlatStatisztika_csak_kiemeltek"] + $stat_adatok["arajanlatNyomasStatisztika_csak_kiemeltek"] ;
		$stat_adatok["kiadott_ajanlatok_erteke_osszesen"] = $stat_adatok["arajanlatOsszegEladas_kiemeltek_nelkul"] + $stat_adatok["arajanlatOsszegNyomas_kiemeltek_nelkul"] + $stat_adatok["arajanlatOsszegLegparnas_kiemeltek_nelkul"] + $stat_adatok["arajanlatOsszegEladas_csak_kiemeltek"] + $stat_adatok["arajanlatOsszegNyomas_csak_kiemeltek"] + $stat_adatok["arajanlatOsszegLegparnas_csak_kiemeltek"] ;
		$stat_adatok["megrendelesek_szama_osszesen"] = $stat_adatok["megrendelesStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesNyomasStatisztika_kiemeltek_nelkul"] + $stat_adatok["megrendelesStatisztika_csak_kiemeltek"] + $stat_adatok["megrendelesNyomasStatisztika_csak_kiemeltek"] ;
		$stat_adatok["megrendelesek_erteke_osszesen"] = $stat_adatok["megrendelesOsszegEladas_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegNyomas_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegLegparnas_kiemeltek_nelkul"] + $stat_adatok["megrendelesOsszegEladas_csak_kiemeltek"] + $stat_adatok["megrendelesOsszegNyomas_csak_kiemeltek"] + $stat_adatok["megrendelesOsszegLegparnas_csak_kiemeltek"] ;
		
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
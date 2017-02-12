<?php

class RaktarTermekekController extends Controller
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
	
	public function actionIndex()
	{
		$model=new RaktarTermekek('search');
		$model->unsetAttributes();
		if(isset($_GET['RaktarTermekek']))
			$model->attributes=$_GET['RaktarTermekek'];
	 	
		$dataProvider=new CActiveDataProvider('RaktarTermekek',
			array('criteria'=>array('order'=>'raktarhely_id ASC',), 'pagination'=>array('pageSize'=>10000))
		);
		
		//send model object for search
		$this->render('index',array(
			'model'=>$model,)
		);
	}

	public function actionPrintRaktarkeszlet()
	{
		$model=new RaktarTermekek('search');
		$model->unsetAttributes();
		
		if(isset($_GET['RaktarTermekek']))
			$model->attributes=$_GET['RaktarTermekek'];

		$dataProvider=$model -> search();

		if ($dataProvider != null) {
			// az összes darab és összes ár mezőket itt számoljuk ki (ehhez kell egy új lekérdezés, amiben nincs group meg sum)
			$criteria = clone($dataProvider->getCriteria());

			$criteria->select = '*';
			$criteria->group = '';
			
			$dataproviderSum = new CActiveDataProvider('RaktarTermekek', array(
				'criteria'=>$criteria,
				'pagination'=>array('pageSize'=>100000,)
			));
			
			$osszesen_db = 0;
			$osszesen_ft = 0;
			
			foreach($dataproviderSum -> getData() as $record) {
				$osszesen_db += $record->osszes_db;
				
				$termekAr = Utils::getArchiveTermekar ($record->anyagbeszallitas_id, $record->termek->id);
				$osszesen_ft += $termekAr * $record->osszes_db;
     	    }

			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();
	
			$mPDF1->SetHtmlHeader("Raktárkészlet");
			
			# render
			$mPDF1->WriteHTML($this->renderPartial("printRaktarkeszlet", array('dataProvider' => $dataProvider, 'osszesen_db' => $osszesen_db, 'osszesen_ft' => $osszesen_ft), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
		}		
	}	
	
	// cikkszámok szerint csoportosított raktárösszesítés nyomtatása
	public function actionPrintRaktarkeszletByCikkszam($cikkszamok)
	{
		$criteria=new CDbCriteria;
		
		$criteria->together = true;
		$criteria->with = array('termek', 'termek.gyarto');
		
		$criteria->select = 'gyarto.cegnev as gyarto, termek.cikkszam as cikkszam, sum(osszes_db) as osszes_db, sum(foglalt_db) as foglalt_db, sum(elerheto_db) as elerheto_db';
		$criteria->group = 'cikkszam, gyarto';

		// minden szóköz, tab, új sor karakter törlése
		if (isset($cikkszamok)) {
			$cikkszamok = preg_replace('/\s+/S', '', $cikkszamok);
		}
		
		$cikkszamokList = (isset($cikkszamok)) ? explode(",", $cikkszamok) : array();
		
		if (count($cikkszamokList)) {
			foreach ($cikkszamokList as $cikkszam) {
				if (strlen($cikkszam) > 0) {
					$criteria->compare('termek.cikkszam', $cikkszam, false, 'OR');
				}
			}
		}
		
		$criteria->order = 'cikkszam ASC';

		$dataProvider = new CActiveDataProvider('RaktarTermekek', array(
			'criteria' => $criteria,
			'pagination'=>array('pageSize'=>100000,)
		));

		// összesítéshez (ez így nem szép, de nem jár legalább DB módosítással, ha esetleg később performanica gondot okoz, akkor viszont át kell írni, hogy ne legyen ennyi lekérdezés, most ennyi adatnál nem jelent gondot)
		$criteriaSum = new CDbCriteria;
		$criteriaSum->together = true;
		$criteriaSum->with = array('termek', 'termek.gyarto');
		$criteriaSum->select = 'anyagbeszallitas_id, gyarto.cegnev as gyarto, termek.cikkszam as cikkszam, osszes_db, foglalt_db, elerheto_db';
		
		if (count($cikkszamokList)) {
			foreach ($cikkszamokList as $cikkszam) {
				if (strlen($cikkszam) > 0) {
					$criteriaSum->compare('termek.cikkszam', $cikkszam, false, 'OR');
				}
			}
		}
		
		$criteriaSum->order = 'cikkszam ASC';
		
		$dataProviderSum = new CActiveDataProvider('RaktarTermekek', array(
			'criteria' => $criteriaSum,
			'pagination'=>array('pageSize'=>100000,)
		));
		//
		
		if ($dataProviderSum != null) {
			// az összes darab és összes ár mezőket itt számoljuk ki
			$osszesen_db = 0;
			$osszesen_ft = 0;
			
			foreach($dataProviderSum -> getData() as $record) {
				$osszesen_db += $record->osszes_db;
				
				$termekAr = Utils::getArchiveTermekar ($record->anyagbeszallitas_id, $record->termek->id);
				$osszesen_ft += $termekAr * $record->osszes_db;
     	    }
			
			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();
	
			$mPDF1->SetHtmlHeader("Raktárkészlet cikkszámok szerint");
			
			# render
			$mPDF1->WriteHTML($this->renderPartial("printRaktarkeszletByCikkszam", array('dataProvider' => $dataProvider, 'osszesen_db' => $osszesen_db, 'osszesen_ft' => $osszesen_ft), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
		}		
	}	
	
	// termékcsoport szerint csoportosított raktárösszesítés nyomtatása
	public function actionPrintRaktarkeszletByTermekcsoport($termekcsoportok)
	{
		$criteria=new CDbCriteria;
		
		$criteria->together = true;
		$criteria->with = array('termek', 'termek.termekcsoport', 'termek.gyarto');
		
		$criteria->select = 'gyarto.cegnev as gyarto, termek.cikkszam as cikkszam, termek.nev as termeknev, sum(osszes_db) as osszes_db, sum(foglalt_db) as foglalt_db, sum(elerheto_db) as elerheto_db';
		$criteria->group = 'cikkszam, gyarto';

		$termekcsoportokList = (isset($termekcsoportok)) ? explode(",", $termekcsoportok) : array();
		
		if (count($termekcsoportokList)) {
			foreach ($termekcsoportokList as $termekcsoport) {
				$termekcsoport = trim($termekcsoport);
				if (strlen($termekcsoport) > 0) {
					$criteria->compare('termekcsoport.nev', $termekcsoport, false, 'OR');
				}
			}
		}
		
		$criteria->order = 'termeknev ASC';

		$dataProvider = new CActiveDataProvider('RaktarTermekek', array(
			'criteria' => $criteria,
			'pagination'=>array('pageSize'=>100000,)
		));

		// összesítéshez (ez így nem szép, de nem jár legalább DB módosítással, ha esetleg később performanica gondot okoz, akkor viszont át kell írni, hogy ne legyen ennyi lekérdezés, most ennyi adatnál nem jelent gondot)
		$criteriaSum = new CDbCriteria;
		$criteriaSum->together = true;
		$criteriaSum->with = array('termek', 'termek.termekcsoport', 'termek.gyarto');
		$criteriaSum->select = 'anyagbeszallitas_id, gyarto.cegnev as gyarto, termek.cikkszam as cikkszam, termek.nev as termeknev, osszes_db, foglalt_db, elerheto_db';
		
		if (count($termekcsoportokList)) {
			foreach ($termekcsoportokList as $termekcsoport) {
				$termekcsoport = trim($termekcsoport);
				if (strlen($termekcsoport) > 0) {
					$criteriaSum->compare('termekcsoport.nev', $termekcsoport, false, 'OR');
				}
			}
		}
		
		$criteriaSum->order = 'termeknev ASC';
		
		$dataProviderSum = new CActiveDataProvider('RaktarTermekek', array(
			'criteria' => $criteriaSum,
			'pagination'=>array('pageSize'=>100000,)
		));
		//
		
		if ($dataProviderSum != null) {
			// az összes darab és összes ár mezőket itt számoljuk ki
			$osszesen_db = 0;
			$osszesen_ft = 0;
			
			foreach($dataProviderSum -> getData() as $record) {
				$osszesen_db += $record->osszes_db;
				
				$termekAr = Utils::getArchiveTermekar ($record->anyagbeszallitas_id, $record->termek->id);
				$osszesen_ft += $termekAr * $record->osszes_db;
     	    }

			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();
	
			$mPDF1->SetHtmlHeader("Raktárkészlet cikkszámok szerint");
			
			# render
			$mPDF1->WriteHTML($this->renderPartial("printRaktarkeszletByTermekcsoport", array('dataProvider' => $dataProvider, 'osszesen_db' => $osszesen_db, 'osszesen_ft' => $osszesen_ft), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
		}		
	}
	
	// egyik raktárból egy másikba áthelyező dialog feldobását rakja össze
	public function actionTermekAthelyez ($id, $grid_id) {
		$raktarTermek = RaktarTermekek::model() -> findByPk ($id);
		if ($raktarTermek == null) {
			return null;
		}
		
		$model = new TermekAthelyezForm;
		
		if (isset($_POST['TermekAthelyezForm']))
		{
			$model->attributes=$_POST['TermekAthelyezForm'];
			$model->raktarTermekId=$_POST['TermekAthelyezForm']['raktarTermekId'];
			$model->forrasRaktarHelyId=$_POST['TermekAthelyezForm']['forrasRaktarHelyId'];
			$model->forrasElerhetoDb=$_POST['TermekAthelyezForm']['forrasElerhetoDb'];
			$model->forrasFoglaltDb=$_POST['TermekAthelyezForm']['forrasFoglaltDb'];
		} else {
			$model->celElerhetoDb = 0;
			$model->celFoglaltDb = 0;
		}
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'termek-athelyez-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (Yii::app()->request->isAjaxRequest)
        {			
			$model->raktarTermekId = $id;
			$model->termekId = $raktarTermek->termek->id;
			$model->termekNevDsp = $raktarTermek->termek->displayTermekTeljesNev;
			$model->forrasRaktarHelyId = $raktarTermek->raktarhely_id;
			$model->forrasElerhetoDb = $raktarTermek->elerheto_db;
			$model->forrasFoglaltDb = $raktarTermek->foglalt_db;
			
			// Stop jQuery from re-initialization
			Yii::app()->clientScript->scriptMap['*.js'] = false;
			Yii::app()->clientScript->scriptMap['*.css'] = false;
		
			$status = $model -> validate() ? 'success' : 'failure';
			
			// rendben lefutott a validáció és az 'Áthelyez' gombot nyomtuk, akkor végrehajtjuk a tényleges termékáthelyezést
			// ha a forrás és cél megegyezik, akkor nem hajtjuk végre az áthelyezést, mert duplázódnának a darabszámok
			if ($status == 'success' && isset($_GET['form']) && $model->forrasRaktarHelyId != $model->celRaktarHelyId) {

				// LI: áthelyezésnél levonjuk az áthelyezendő mennyiséget a tranzakciós táblában tárolt sorokból,
				//	   majd létrehozunk egy újat (ha még nincs) az új raktárhely adataival
				Utils::foglaltDbAtmozgatas($raktarTermek, $model);

				// megnézzük van-e már egyező beszállításból származó bejegyzése az adott terméknek
				// ha van, odaírjuk az új darabszámokat, ha nincs, akkor létrehozunk egy új rekordot rá
				$ujRaktarTermek = RaktarTermekek::model()->findByAttributes(
					array('termek_id'=>$raktarTermek->termek_id, 'anyagbeszallitas_id'=>$raktarTermek->anyagbeszallitas_id, 'raktarhely_id'=>$model->celRaktarHelyId)
				);
				
				$raktarTermek -> foglalt_db -= $model -> celFoglaltDb;
				$raktarTermek -> osszes_db -= $model -> celFoglaltDb;
				
				$raktarTermek -> elerheto_db -= $model -> celElerhetoDb;
				$raktarTermek -> osszes_db -= $model -> celElerhetoDb;

				$raktarTermek -> save (false);
				
				// összerakjuk és elmentjük a forrás raktártermék rekordot
				if ($ujRaktarTermek == null) {
					$ujRaktarTermek = new RaktarTermekek;
					$ujRaktarTermek -> termek_id = $raktarTermek -> termek_id;
					$ujRaktarTermek -> anyagbeszallitas_id = $raktarTermek -> anyagbeszallitas_id;
					$ujRaktarTermek -> raktarhely_id = $model->celRaktarHelyId;
					$ujRaktarTermek -> osszes_db = 0;
					$ujRaktarTermek -> foglalt_db = 0;
					$ujRaktarTermek -> elerheto_db = 0;
				}
				
				$ujRaktarTermek->osszes_db += $model -> celElerhetoDb;
				$ujRaktarTermek->elerheto_db += $model -> celElerhetoDb;
				
				$ujRaktarTermek->osszes_db += $model -> celFoglaltDb;
				$ujRaktarTermek->foglalt_db += $model -> celFoglaltDb;
				
				$ujRaktarTermek -> save (false);
			}
			
			// töröljük az olyan raktártermék sorokat, ahol az összes, elérhető és foglalt darabszámok is 0-ák
			Utils::removeEmptyRaktarTermekek();
			
			echo CJSON::encode(array(
				'status'=>$status, 
				'div'=>$this->renderPartial('_termekAthelyez', array('model' => $model, 'grid_id' => $grid_id), true, true)));
			exit;  
        }

	}
	
	// adott termék foglalásának listáját rakja össze
	public function actionFoglaltDbLista ($id, $reszletes, $grid_id) {
		
		$whereClause = "";
		
		$raktarTermek = RaktarTermekek::model()->findByPk($id);
		if ($raktarTermek != null) {
			if ($reszletes) {
				// ilyenkor csak 1 db RaktarTermekek rekord lesz
				$whereClause = "dom_raktar_termekek_tranzakciok.termek_id = " . $raktarTermek->termek_id . " AND dom_megrendeles_tetelek.termek_id = " . $raktarTermek->termek_id . " AND dom_raktar_termekek_tranzakciok.anyagbeszallitas_id = " . $raktarTermek->anyagbeszallitas_id . " AND dom_raktar_termekek_tranzakciok.raktarhely_id = " . $raktarTermek->raktarhely_id;
			} else {
				// ilyenkor akár több RaktarTermekek rekord is lehet
				$whereClause = "dom_raktar_termekek_tranzakciok.termek_id = " . $raktarTermek->termek_id . " AND dom_megrendeles_tetelek.termek_id = " . $raktarTermek -> termek_id;
			}
		}
	
		$sqlMegrendelesTetelek = "
			SELECT DISTINCT 	 dom_raktar_termekek_tranzakciok.id AS tranzakcio_id,
								 dom_raktar_termekek_tranzakciok.raktarhely_id,
								 dom_raktar_termekek_tranzakciok.anyagbeszallitas_id,
								 dom_termekek.id AS termek_id,
								 dom_megrendelesek.id AS megrendelesek_id,
								 dom_megrendeles_tetelek.id AS megrendeles_tetel_id,
								 dom_megrendelesek.sorszam,
								 dom_termekek.nev,
								 dom_megrendeles_tetelek.munka_neve,
								 dom_nyomdakonyv.taskaszam," . ($reszletes ? "foglal_darabszam * -1 AS darabszam" : "darabszam") . "
								 
			FROM dom_raktar_termekek_tranzakciok

			INNER JOIN dom_nyomdakonyv
			ON dom_raktar_termekek_tranzakciok.szallitolevel_nyomdakonyv_id = dom_nyomdakonyv.id

			INNER JOIN dom_megrendeles_tetelek
			ON dom_nyomdakonyv.megrendeles_tetel_id = dom_megrendeles_tetelek.id

			INNER JOIN dom_megrendelesek
			ON dom_megrendeles_tetelek.megrendeles_id = dom_megrendelesek.id

			INNER JOIN dom_termekek
			ON dom_raktar_termekek_tranzakciok.termek_id = dom_termekek.id

			WHERE foglal_darabszam <> 0 AND " . $whereClause . " AND dom_nyomdakonyv.sztornozva = 0 AND dom_megrendeles_tetelek.torolt = 0 AND dom_nyomdakonyv.torolt=0 AND dom_megrendeles_tetelek.hozott_boritek=0 AND dom_megrendeles_tetelek.negativ_raktar_termek = 0

			GROUP BY dom_megrendeles_tetelek.id
		";
		
		// lekérdezzük az összes ide vonatkozó megrendelés tételt a megrendelésekkel együtt (itt még NINCSENEK levonva azon mennyiségek, amiket esetleg időközben már szállítóra tettek, vagy töröltek stb.)
		$megrendelesTetelek = Yii::app() -> db -> createCommand  ($sqlMegrendelesTetelek) -> queryAll();
		
		$sqlKivettDarabok = "
			SELECT dom_szallitolevel_tetelek.megrendeles_tetel_id, dom_szallitolevel_tetelek.darabszam, dom_raktar_termekek_tranzakciok.anyagbeszallitas_id FROM dom_szallitolevel_tetelek
			
			INNER JOIN dom_megrendeles_tetelek
			ON dom_szallitolevel_tetelek.megrendeles_tetel_id = dom_megrendeles_tetelek.id
			
			INNER JOIN dom_szallitolevelek
			ON dom_szallitolevel_tetelek.szallitolevel_id = dom_szallitolevelek.id
			
			INNER JOIN dom_raktar_termekek_tranzakciok
			ON dom_szallitolevelek.id = dom_raktar_termekek_tranzakciok.szallitolevel_nyomdakonyv_id
			
			WHERE dom_szallitolevel_tetelek.torolt = 0 AND dom_szallitolevel_tetelek.darabszam != 0 
			AND (dom_megrendeles_tetelek.szinek_szama1 != 0 OR dom_megrendeles_tetelek.szinek_szama2 != 0) AND dom_megrendeles_tetelek.negativ_raktar_termek = 0 
			AND dom_megrendeles_tetelek.hozott_boritek = 0 AND dom_megrendeles_tetelek.negativ_raktar_termek = 0
			AND dom_raktar_termekek_tranzakciok.betesz_kivesz_darabszam < 0 
			AND " . $whereClause . " GROUP BY dom_szallitolevel_tetelek.id";

// echo $sqlMegrendelesTetelek . '<br /> <br />' . $sqlKivettDarabok; die();

		// lekérdezzük az összes már kivételezett terméket darabszámmal együtt (ezeket vonjuk le az előző lekérdezésbne kapott eredményhalmazból)
		$kivettDarabok = Yii::app() -> db -> createCommand  ($sqlKivettDarabok) -> queryAll();

		if ($megrendelesTetelek != null) {
			foreach ($megrendelesTetelek as $key => $megrendelesTetel) {
				if ($kivettDarabok != null) {
					foreach ($kivettDarabok as $kivettDarab) {
						if ($reszletes) {
							if ($megrendelesTetel['megrendeles_tetel_id'] == $kivettDarab['megrendeles_tetel_id'] && ($megrendelesTetel['anyagbeszallitas_id'] == $kivettDarab['anyagbeszallitas_id'])) {
								if (isset($megrendelesTetelek[$key])) {
									$megrendelesTetelek[$key]['darabszam'] = $megrendelesTetelek[$key]['darabszam'] - $kivettDarab['darabszam'];
									
									if ($megrendelesTetelek[$key]['darabszam'] <= 0) {
										unset($megrendelesTetelek[$key]);
										break;
									}
								}
							}
						} else {
							if ($megrendelesTetel['megrendeles_tetel_id'] == $kivettDarab['megrendeles_tetel_id'] /*&& ($megrendelesTetel['anyagbeszallitas_id'] == $kivettDarab['anyagbeszallitas_id']) */) {
								if (isset($megrendelesTetelek[$key])) {
									$megrendelesTetelek[$key]['darabszam'] = $megrendelesTetelek[$key]['darabszam'] - $kivettDarab['darabszam'];
									
									if ($megrendelesTetelek[$key]['darabszam'] <= 0) {
										unset($megrendelesTetelek[$key]);
										break;
									}
								}
							}
						}
					}
				}
			}
		}
		
		$dataProvider=new CArrayDataProvider($megrendelesTetelek, array(
			'keyField'=>'megrendelesek_id',
			'sort'=>array(
				'attributes'=>array(
					 'megrendelesek_id DESC',
				),
			),
			'pagination'=>array(
				'pageSize'=>10000,
			),
		));
		
		echo CJSON::encode(array(
				'status'=>'success', 
				'div'=>$this->renderPartial('_foglaltDbLista', array('dataProvider' => $dataProvider, 'grid_id' => $grid_id), true, true)));
			exit;
	}

	public function actionUjrageneralas () {
			Utils::raktarTermekekUjrageneralas ();
	}
	
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
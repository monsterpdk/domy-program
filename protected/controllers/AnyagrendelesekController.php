<?php

class AnyagrendelesekController extends Controller
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Anyagrendelesek;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Anyagrendelesek']))
		{
			$model->attributes=$_POST['Anyagrendelesek'];
			if($model->save())
				$this->redirect(array('index'));
		} else {
			$model -> user_id = Yii::app()->user->getId();
			$model -> rendeles_datum = date('Y-m-d');
			
			$model->getNewBizonylatszam() ;
			$model -> save(false);
			$this->redirect(array('update', 'id'=>$model -> id,));
		}

		$this->render('create',array(
			'model'=>$model,
		));
		
	}

	/**
	 * Anyagbeszállításról indított anyagrendelés létrehozása.
	 * Létrehozás után rámentjük az anyagbeszállítás megfelelő mezőit ill. a
	 * hozzá tartozó, iroda által átvett termékeket, könnyítva ezzel a kitöltést.
	 */
	public function actionCreateFromBeszallitas ($anyagbeszallitas_id)
	{
		$anyagbeszallitas = Anyagbeszallitasok::model() -> with('termekekIroda') -> findByPk ($anyagbeszallitas_id);
		$anyagrendeles = new Anyagrendelesek;
		
		// alapadatok átvétele
		$anyagrendeles -> gyarto_id = $anyagbeszallitas -> gyarto_id;
		$anyagrendeles -> megjegyzes = $anyagbeszallitas -> megjegyzes;
		$anyagrendeles -> user_id = Yii::app()->user->getId();
		$anyagrendeles -> rendeles_datum = date('Y-m-d');

		// elmentjük a modelt, hogy legyen model id a kezünkben
		$anyagrendeles -> save(false);
		
		// az anyagbeszállításhoz hozzákapcsoljuk az anyagbeszállítást, amiről indítottuk a műveletet
		$anyagbeszallitas ->anyagrendeles_id = $anyagrendeles ->id;
		$anyagbeszallitas -> save(false);
		
		// az anyagbeszállításhoz felvett termékek átmásolása az újonnan létrejövő anyagrendelésre
		foreach ($anyagbeszallitas -> termekekIroda as $termek) {
			$anyagrendeles_termek = new AnyagrendelesTermekek;
			$anyagrendeles_termek -> anyagrendeles_id = $anyagrendeles -> id;
			$anyagrendeles_termek -> termek_id = $termek -> termek_id;
			$anyagrendeles_termek -> rendelt_darabszam = $termek -> darabszam;
			$anyagrendeles_termek -> rendeleskor_netto_darabar = $termek -> netto_darabar;
			
			$anyagrendeles_termek ->save (false);
		}
		
		$this->redirect(array('anyagrendelesek/update', 'id' => $anyagrendeles -> id,));
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if ($model -> lezarva == 1 && !Yii::app()->user->checkAccess("Admin"))
		{
			throw new CHttpException(403, "Hozzáférés megtagadva!, nincs jogosultsága a kért lap megtekintéséhez.");
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
		if(isset($_POST['Anyagrendelesek']))
		{
			// elmentjük az anyagrendelést az ellenőrzés előtt
			// ha validációs hibát találunk, visszalépünk a szerkesztéshez
			$model -> attributes = $_POST['Anyagrendelesek'];
			
			if (!$model -> save(true)) {
				$this->render('update',array(
					'model' => $model,
				));
				
				return;
			}	
			
			// ha a raktárellenőrzés nem talált eltérést a tételek között, valamint rendben vannak a jogosultságok,
			// akkor lezárjuk az anyagrendelést és az anyagbeszállítást
			if (Yii::app()->user->checkAccess('AnyagbeszallitasTermekek.Create') || Yii::app()->user->checkAccess('Admin')) {
				$anyagbeszallitas = Anyagbeszallitasok::model() -> findByAttributes(array('anyagrendeles_id' => $model->id));
				
				if ($anyagbeszallitas != null) {
					$anyagbeszallitasCheck = Utils::checkAnyagrendelesBeszallitas ($model -> id, $anyagbeszallitas -> id) ;		
				}
				
				if ($anyagbeszallitas != null && $anyagbeszallitasCheck["ok"] == 1  && $model -> lezarva != 1) {
				
					// ha választottunk ki raktárat és létezik is (nem kamu id-t hackeltek a POST-ba), akkor lezárjuk a rendelést és beszállítást
					// és eltároljuk a kiválasztott raktárba a tételeket
					if (isset($_POST['raktarhely_id'])) {
						$raktarHely = RaktarHelyek::model() -> findByPk ($_POST['raktarhely_id']);
						
						if ($raktarHely != null) {
							$anyagrendeles = $model;
							
							// lezárjuk az anyagrendelést és a hozzá tartozó anyagbeszállítást
							$anyagbeszallitas->lezarva = 1;
							$anyagbeszallitas->save();

							$anyagrendeles->lezarva = 1;
							$anyagrendeles->save();
							
							// végigmegyünk az anyaglistán és eltároljuk a megrendelt termékeket a kiválasztott raktárba
							// TÁ: Módosítom, hogy ne a megrendelt, hanem a beszállított termékeken menjen végig, mert nem feltétlenül fog egyezni a megrendelés tételsor a beszállítás tételsorral
							//
							// TODO: ez így nem túl szép, mert minden elemet egyesével mentek, az mindig egy SQL update/insert.
							//		 Szebb lenne egy tömbben kezelni az elemeket és a végén egyszer menteni mindegyiket, de most idő hiányában
							//		 így csináltam, talán egy rendelésen nem lesz több 100 termék, úgyhogy nem lesz érezhető performancia romlás.
							$termekek = AnyagbeszallitasTermekek::model()->findAllByAttributes(array("anyagbeszallitas_id" => $anyagbeszallitas -> id));
							$hozottBoritekRaktarhelyId = Utils::getHozottBoritekRaktarHely() -> id;
							
							foreach ($termekek as $termek) {
								$raktarTermek = RaktarTermekek::model()->findByAttributes( array('termek_id' => $termek -> termek_id, 'anyagbeszallitas_id' => $anyagbeszallitas->id) );
								
								// ha van már a raktárban ilyen termék, akkor frissítjük a darabszámát
								if ($raktarTermek != null) {
									$raktarTermek -> elerheto_db += $termek -> darabszam;
									$raktarTermek -> osszes_db += $termek -> darabszam;
								} else {
									// ha nincs, akkor létrehozunk egy új bejegyzést
									$raktarTermek = new RaktarTermekek;
									$raktarTermek -> termek_id = $termek -> termek_id;
									$raktarTermek -> raktarhely_id = $termek->hozott_boritek == 1 ? $hozottBoritekRaktarhelyId : $raktarHely -> id;
									$raktarTermek -> anyagbeszallitas_id = $anyagbeszallitas -> id;
									
									$raktarTermek -> elerheto_db = $termek -> darabszam;
									$raktarTermek -> osszes_db = $termek -> darabszam;
								}
								
								$raktarTermek -> save ();
								
								// a tranzakció adatait külön mentjük (jelenleg csak a statisztikákhoz szükséges)
								$raktarTermekekTranzakciok = new RaktarTermekekTranzakciok;
								$raktarTermekekTranzakciok->termek_id = $raktarTermek->termek_id;
								$raktarTermekekTranzakciok->anyagbeszallitas_id = $raktarTermek->anyagbeszallitas_id;
								$raktarTermekekTranzakciok->raktarhely_id = $termek->hozott_boritek == 1 ? $hozottBoritekRaktarhelyId : $raktarHely -> id;
								$raktarTermekekTranzakciok->tranzakcio_datum = date("Y-m-d H:i:s");
								$raktarTermekekTranzakciok->betesz_kivesz_darabszam = $termek -> darabszam;
								$raktarTermekekTranzakciok->save(false);
								
								// itt vizsgáljuk, hogy túlléptük-e a termék megadott maximum raktárkészletét,
								// ha igen e-mailt küldünk azoknak felhasználóknak, akik jogosultat megkapni ezt az infót
								/* E-mailt mégsem kérnek a maximum raktárkészlet túllépésről
								if ($raktarTermek -> osszes_db > $termek -> termek -> maximum_raktarkeszlet) {
									$recipients = Utils::getRaktarkeszletLimitAtlepesEsetenErtesitendokEmail();
									$termek_info = $termek->termek->nev . ', jelenlegi raktármennyiség:  <strong>' . $raktarTermek -> osszes_db . ' db</strong>, maximum raktármennyiség: <strong>' . $termek ->termek-> maximum_raktarkeszlet . '</strong>';
									$email_body = Yii::app()->controller->renderPartial('application.views.szallitolevelek.ertesites_maximum_raktarkeszlet', array('termek_info'=>$termek_info), true);
									
									Utils::sendEmail ($recipients, 'Figyelmeztetés! Maximum raktárkészlet túllépve', $email_body);
								}*/
								
								// sztornózzuk a nyomdakönyvi munkát, majd megcsináljuk újra a foglalást, már az újonnan bevételezett hozott borítékokkal
								$nyomdakonyv = Nyomdakonyv::model()->findByPk($termek -> nyomdakonyv_id);
								
								if ($nyomdakonyv != null) {
									$megrendelesTetel = $nyomdakonyv -> megrendeles_tetel;
									
									if (!Utils::isMunkaInNegativRaktar($nyomdakonyv -> id)) {
										// ha NEM mínuszos a darabszám
										Utils::raktarbanSztornoz($megrendelesTetel->termek_id, $megrendelesTetel->darabszam, $nyomdakonyv->id);
										
										// töröljük továbbá az ide tartozó kivét(eket) (ha van(nak))
										$sql = "
											SELECT termek_id, dom_szallitolevel_tetelek.darabszam, dom_szallitolevelek.id AS szallitolevel_id FROM dom_szallitolevel_tetelek

											INNER JOIN dom_szallitolevelek ON dom_szallitolevel_tetelek.szallitolevel_id = dom_szallitolevelek.id
											INNER JOIN dom_megrendeles_tetelek ON dom_szallitolevel_tetelek.megrendeles_tetel_id = dom_megrendeles_tetelek.id
											
											WHERE dom_szallitolevelek.sztornozva = 0 AND dom_szallitolevel_tetelek.darabszam > 0 AND dom_szallitolevel_tetelek.megrendeles_tetel_id = 
											" . $megrendelesTetel -> id;
								
										$command = Yii::app()->db->createCommand($sql);
										$result = $command -> queryAll();
										
										if ($result != null && count($result) > 0) {
											// találtunk szállítólevelet a nyomdakönyvi munkához kapcsolódóan
											
											foreach ($result as $szallitolevelTetel) {
												Utils::raktarbolKiveszSztornoz ($szallitolevelTetel['termek_id'], $szallitolevelTetel['darabszam'], $szallitolevelTetel['szallitolevel_id']);
											}
										}
										
									} else {
										// ha mínuszos a darabszám
										Utils::negativRaktarbanSztornoz($nyomdakonyv->id);
									
										// töröljük a megrendelés tételről is, hogy ő egy negatív raktártermék tétel
										$megrendelesTetel -> negativ_raktar_termek = 0;
										$megrendelesTetel -> save (false);
									}
									
									// foglalunk, vagy negatív raktárba rakunk (ez utóbbi nem annyira jó eset, mert többet akkor az nem lesz kiegyenlítve, de mindenre nem tudok most felkészülni)
									$elerheto_db = Utils::getTermekRaktarkeszlet($megrendelesTetel->termek_id, "elerheto_db", $megrendelesTetel -> hozott_boritek != 1);
									if ( $elerheto_db < $megrendelesTetel -> darabszam) {
										$raktarTermekNegativ = new RaktarTermekekNegativ;
										$raktarTermekNegativ -> termek_id = $megrendelesTetel -> termek_id;
										$raktarTermekNegativ -> darabszam = $megrendelesTetel -> darabszam;
										$raktarTermekNegativ -> megrendeles_id = $megrendelesTetel -> megrendeles -> id;
										$raktarTermekNegativ -> nyomdakonyv_id = $nyomdakonyv -> id;
										$raktarTermekNegativ -> hatarido = $nyomdakonyv -> hatarido;
										$raktarTermekNegativ -> save (false);
										
										// rámentjük a megrendelés tételre is, hogy ő egy negatív raktártermék tétel lett, így könnyebb később kezelnünk a lekérdezésekben
										$megrendelesTetel -> negativ_raktar_termek = 1;
										$megrendelesTetel -> save (false);
									} else {
										// a raktárban foglaljuk a megfelelő mennyiséget
										Utils::raktarbanFoglal($megrendelesTetel -> termek_id, $megrendelesTetel -> darabszam, $nyomdakonyv->id, true, true, false, null, false, $megrendelesTetel -> id);
									}
								}
							}
							
							// megnézzük van-e termék a negatív raktártermék táblában és ha igen, akkor kielégíthető-e valamely igény
							Utils::checkNegativRaktarTermekek();
							
							//Ha nem volt minden termék meg a megrendeléshez képest a beszállításnál, akkor létrehozunk a hiányzókkal egy új anyagrendelést
							if (count($anyagbeszallitasCheck["tetel_elteresek"]) > 0) {
								$new_anyagrendeles = new Anyagrendelesek;
								$new_anyagrendeles -> gyarto_id = $anyagrendeles->gyarto_id ;
								$new_anyagrendeles -> getNewBizonylatszam() ;
								$new_anyagrendeles -> user_id = $anyagrendeles->user_id;
								$new_anyagrendeles -> rendeles_datum = date('Y-m-d');
								$new_anyagrendeles -> megjegyzes = "Az " . $anyagrendeles->bizonylatszam . " hiányos beszállítása után a kimaradt termékekkel automatikusan jött létre." ;
								$new_anyagrendeles -> save() ;						
								//Az új anyagrendeléshez felvesszük a termékeket
								foreach ($anyagbeszallitasCheck["tetel_elteresek"] as $tetel) {
									if ($tetel["db"] > 0) {
										$anyagrendeles_tetel = new AnyagrendelesTermekek ;
										$anyagrendeles_tetel -> anyagrendeles_id = $new_anyagrendeles->id ;
										$anyagrendeles_tetel -> termek_id = $tetel["termek"]->termek_id ;
										$anyagrendeles_tetel -> rendelt_darabszam = $tetel["db"] ;
										$termekar = Utils::getActiveTermekar($anyagrendeles_tetel -> termek_id, $tetel["db"]) ;
										$kalkulalt_termekar = $termekar != null && is_array($termekar) ? $termekar['db_beszerzesi_ar'] : 0 ;
										$anyagrendeles_tetel -> rendeleskor_netto_darabar = $kalkulalt_termekar ;
										$anyagrendeles_tetel->save() ;
									}
								}
							}							
						}
					}

					Utils::goToPrevPage("anyagrendelesekIndex");
				}
			}
			
			// ha a raktárellenőrzés során eltéréseket találtunk valahol, akkor csak 'simán' mentjük a modelt
			$model->attributes=$_POST['Anyagrendelesek'];
			if($model->save()) {
				Utils::goToPrevPage("anyagrendelesekIndex");
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		Utils::saveCurrentPage("anyagrendelesekIndex");
		
		$dataProvider=new CActiveDataProvider('Anyagrendelesek', array('criteria'=>array('order'=>"t.id DESC, rendeles_datum DESC",), 'pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),)));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionPrintPDF()
	{
		if (isset($_GET['id'])) {
			$model = $this->loadModel($_GET['id']);
		}
		
		if ($model != null && isset($_GET['type'])) {
			$printTemplate = ($_GET['type'] == 'arral') ? 'printAnyagrendelesekArral' : 'printAnyagrendelesekArNelkul';
			
			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();

			$mPDF1->SetHtmlHeader("Anyagrendelés #" . $model->id);
			
			# render
			$mPDF1->WriteHTML($this->renderPartial($printTemplate, array('model' => $model), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
		}
	}
	
	// AJAX-os híváshoz: visszaadja egy adott anyagrendelés összértékét
	public function actionRefreshOsszertek($anyagrendeles_id) {
		$anyagrendeles = Anyagrendelesek::model()->findByPk ($anyagrendeles_id);

		echo CJSON::encode(array(
				'osszertek'=>$anyagrendeles == null ? 0 : $anyagrendeles->displayOsszertek,
				));
		Yii::app()->end();
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Anyagrendelesek('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Anyagrendelesek']))
			$model->attributes=$_GET['Anyagrendelesek'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Anyagrendelesek the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Anyagrendelesek::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Anyagrendelesek $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='anyagrendelesek-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

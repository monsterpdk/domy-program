<?php

class AnyagbeszallitasokController extends Controller
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
		$model=new Anyagbeszallitasok;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Anyagbeszallitasok']))
		{
			$model -> attributes=$_POST['Anyagbeszallitasok'];
			if($model -> save())
				$this -> redirect(array('index'));
		} else {
			$model -> user_id = Yii::app()->user->getId();
			$model -> beszallitas_datum = date('Y-m-d');
			
			$model -> save(false);
			$this -> redirect(array('update', 'id'=>$model -> id,));
		}

		$this->render('create',array(
			'model'=>$model,
		));

	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Anyagbeszallitasok']))
		{
			// elmentjük az anyagbeszállítást az ellenőrzés előtt
			// ha validációs hibát találunk, visszalépünk a szerkesztéshez
			$model -> attributes = $_POST['Anyagbeszallitasok'];
			
			if (!$model -> save(true)) {
				$this->render('update',array(
					'model' => $model,
				));
				
				return;
			}

			// ha a raktárellenőrzés nem talált eltérést a tételek között, valamint rendben vannak a jogosultságok,
			// akkor lezárjuk az anyagrendelést és az anyagbeszállítást
			if (Yii::app()->user->checkAccess('AnyagbeszallitasTermekek.Create') || Yii::app()->user->checkAccess('Admin')) {
				$anyagbeszallitasCheck = Utils::checkAnyagrendelesBeszallitas ($model -> anyagrendeles_id, $id) ;  
//				print_r($anyagbeszallitasCheck) ;
//				die() ;
				if ($anyagbeszallitasCheck["ok"] == 1 && $model -> lezarva != 1) {
					// ha választottunk ki raktárat és létezik is (nem kamu id-t hackeltek a POST-ba), akkor lezárjuk a rendelést és beszállítást
					// és eltároljuk a kiválasztott raktárba a tételeket
					if (isset($_POST['raktarhely_id'])) {
						$raktarHely = RaktarHelyek::model() -> findByPk ($_POST['raktarhely_id']);
						
						if ($raktarHely != null) {
							$anyagbeszallitas = $model;
							$anyagrendeles = Anyagrendelesek::model()->findByPk($model -> anyagrendeles_id);
							
							// lezárjuk az anyagrendelést és a hozzá tartozó anyagbeszállítást					
							$anyagbeszallitas->lezarva = 1;
							$anyagbeszallitas->save();

							if ($anyagrendeles != null) {
								$anyagrendeles->lezarva = 1;
								$anyagrendeles->save();
							}
							
							// végigmegyünk az anyaglistán és eltároljuk a megrendelt termékeket a kiválasztott raktárba
							//
							// TODO: ez így nem túl szép, mert minden elemet egyesével mentek, az mindig egy SQL update/insert.
							//		 Szebb lenne egy tömbben kezelni az elemeket és a végén egyszer menteni mindegyiket, de most idő hiányában
							//		 így csináltam, talán egy rendelésen nem lesz több 100 termék, úgyhogy nem lesz érezhető performancia romlás.
							$termekek = AnyagbeszallitasTermekek::model()->findAllByAttributes(array("anyagbeszallitas_id" => $anyagbeszallitas -> id));
							
							foreach ($termekek as $termek) {
								$raktarTermek = RaktarTermekek::model()->findByAttributes( array('termek_id' => $termek -> termek_id, 'anyagbeszallitas_id' => $anyagbeszallitas->id, 'raktarhely_id' => $raktarHely -> id) );
								
								// ha van már a raktárban ilyen termék, akkor frissítjük a darabszámát
								if ($raktarTermek != null) {
									$raktarTermek -> elerheto_db += $termek -> darabszam;
									$raktarTermek -> osszes_db += $termek -> darabszam;
								} else {
									// ha nincs, akkor létrehozunk egy új bejegyzést
									$raktarTermek = new RaktarTermekek;
									$raktarTermek -> termek_id = $termek -> termek_id;
									$raktarTermek -> raktarhely_id = $raktarHely -> id;
									$raktarTermek -> anyagbeszallitas_id = $anyagbeszallitas -> id;
									
									$raktarTermek -> elerheto_db = $termek -> darabszam;
									$raktarTermek -> osszes_db = $termek -> darabszam;
								}
								
								$raktarTermek -> save ();
								
								// a tranzakció adatait külön menjtük (jelenleg csak a statisztikákhoz szükséges)
								$raktarTermekekTranzakciok = new RaktarTermekekTranzakciok;
								$raktarTermekekTranzakciok->termek_id = $raktarTermek->termek_id;
								$raktarTermekekTranzakciok->anyagbeszallitas_id = $raktarTermek->anyagbeszallitas_id;
								$raktarTermekekTranzakciok->raktarhely_id = $raktarHely->id;
								$raktarTermekekTranzakciok->tranzakcio_datum = date("Y-m-d H:i:s");
								$raktarTermekekTranzakciok->betesz_kivesz_darabszam = $termek -> darabszam;
								$raktarTermekekTranzakciok->save(false);
								
								// itt vizsgáljuk, hogy túlléptük-e a termék megadott maximum raktárkészletét,
								// ha igen e-mailt küldünk azoknak felhasználóknak, akik jogosultat megkapni ezt az infót
								if ($raktarTermek -> osszes_db > $termek -> termek -> maximum_raktarkeszlet) {
									$recipients = Utils::getRaktarkeszletLimitAtlepesEsetenErtesitendokEmail();
									$termek_info = $termek->termek->nev . ', jelenlegi raktármennyiség:  <strong>' . $raktarTermek -> osszes_db . ' db</strong>, maximum raktármennyiség: <strong>' . $termek ->termek-> maximum_raktarkeszlet . '</strong>';
									$email_body = Yii::app()->controller->renderPartial('application.views.szallitolevelek.ertesites_maximum_raktarkeszlet', array('termek_info'=>$termek_info), true);
									
									Utils::sendEmail ($recipients, 'Figyelmeztetés! Maximum raktárkészlet túllépve', $email_body);
								}
							}
							
							// megnézzük van-e termék a negatív raktártermék táblában és ha igen, akkor kielégíthető-e valamely igény
							Utils::checkNegativRaktarTermekek();
						}
					}
					
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
					
					Utils::goToPrevPage("anyagbeszallitasokIndex");
				}
			}
			
			// ha a raktárellenőrzés során eltéréseket találtunk valahol, akkor csak 'simán' mentjük a modelt
			$model->attributes=$_POST['Anyagbeszallitasok'];
			if($model->save())
				Utils::goToPrevPage("anyagbeszallitasokIndex");
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
		Utils::saveCurrentPage("anyagbeszallitasokIndex");
		
		$dataProvider=new CActiveDataProvider('Anyagbeszallitasok', array('criteria'=>array('order'=>"beszallitas_datum DESC",), 'pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),)));
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
			$printTemplate = ($_GET['type'] == 'atveteli') ? 'printAnyagbeszallitasokAtveteli' : 'printAnyagbeszallitasokRaktar';
			
			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();

			$mPDF1->SetHtmlHeader("Anyagbeszállítás #" . $model->id);
			
			# render
			$mPDF1->WriteHTML($this->renderPartial($printTemplate, array('model' => $model), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
		}
	}
	
	public function actionCheckProductDifference ($anyagbeszallitas_id, $anyagrendeles_id) {
		$result = Utils::checkAnyagrendelesBeszallitas ($anyagrendeles_id, $anyagbeszallitas_id);
		if ($result["ok"] == 1) {
			$result = "" ;	
		}
		else
		{
			$result = $result["uzenet"] ;	
		}
		echo json_encode($result);
		
		exit();
	}

	// AJAX-os híváshoz: visszaadja egy adott anyagbeszállítás összértékét
	public function actionRefreshOsszertek($anyagbeszallitas_id) {
		$anyagbeszallitas = Anyagbeszallitasok::model()->findByPk ($anyagbeszallitas_id);

		echo CJSON::encode(array(
				'osszertekIroda'=>$anyagbeszallitas == null ? 0 : $anyagbeszallitas->displayOsszertekIroda,
				'osszertekRaktar'=>$anyagbeszallitas == null ? 0 : $anyagbeszallitas->displayOsszertekRaktar,
				));
		Yii::app()->end();
	}
	
	// AJAX-os híváshoz: létrehozza egy anyagbeszállításhoz a tételeket egy kapcsolódó anyagrendelés tételeiből
	public function actionSynchronizeTetel($anyagbeszallitas_id, $anyagrendeles_id) {
		$anyagbeszallitas = Anyagbeszallitasok::model()->findByPk ($anyagbeszallitas_id);
		$anyagrendeles = Anyagrendelesek::model()->findByPk ($anyagrendeles_id);

		if ($anyagbeszallitas != null && $anyagrendeles != null) {
			// töröljük az anyagbeszállításhoz jelenleg felvett tételeket (iroda és raktár nézetekből is)
			AnyagbeszallitasTermekek::model()->deleteAll(
				'anyagbeszallitas_id = :anyagbeszallitas_id',
				array('anyagbeszallitas_id' => $anyagbeszallitas->id)
			);
			AnyagbeszallitasTermekekIroda::model()->deleteAll(
				'anyagbeszallitas_id = :anyagbeszallitas_id',
				array('anyagbeszallitas_id' => $anyagbeszallitas->id)
			);
			
			// végigmegyünk a kiválasztott anyagrendelés termékein is hozzáadjuk az anyagbeszállítás mindkét táblázatába őket (iroda / raktár)
			foreach ($anyagrendeles->termekek as $anyagrendeles_termek) {
				// raktár
				$ujAnyagbeszallitasTermek = new AnyagbeszallitasTermekek;
				$ujAnyagbeszallitasTermek->anyagbeszallitas_id = $anyagbeszallitas->id;
				$ujAnyagbeszallitasTermek->termek_id = $anyagrendeles_termek->termek_id;
				$ujAnyagbeszallitasTermek->netto_darabar = $anyagrendeles_termek->rendeleskor_netto_darabar;
				$ujAnyagbeszallitasTermek->save(false);
				
				// iroda
				$ujAnyagbeszallitasTermekIroda = new AnyagbeszallitasTermekekIroda;
				$ujAnyagbeszallitasTermekIroda->anyagbeszallitas_id = $anyagbeszallitas->id;
				$ujAnyagbeszallitasTermekIroda->termek_id = $anyagrendeles_termek->termek_id;
				$ujAnyagbeszallitasTermekIroda->netto_darabar = $anyagrendeles_termek->rendeleskor_netto_darabar;
				$ujAnyagbeszallitasTermekIroda->save(false);
			}
		}
	}
	
	// egy irodai termék darabszámát inline edit segítségével módosították, így mentenünk kell DB-be
	public function actionUpdateDarabszamIroda () {
		if ( isset($_POST['pk']) && isset($_POST['value']) && is_numeric($_POST['value'])) {
			$anyagbeszallitasTermekIroda = AnyagbeszallitasTermekekIroda::model()->findByPk($_POST['pk']);
			
			if ($anyagbeszallitasTermekIroda != null) {
				$anyagbeszallitasTermekIroda->darabszam = $_POST['value'];
				$anyagbeszallitasTermekIroda->save(false);
			}
		}
	}
	
	// egy raktári termék darabszámát inline edit segítségével módosították, így mentenünk kell DB-be
	public function actionUpdateDarabszamRaktar () {
		if ( isset($_POST['pk']) && isset($_POST['value']) && is_numeric($_POST['value'])) {
			$anyagbeszallitasTermek = AnyagbeszallitasTermekek::model()->findByPk($_POST['pk']);
			
			if ($anyagbeszallitasTermek != null) {
				$anyagbeszallitasTermek->darabszam = $_POST['value'];
				$anyagbeszallitasTermek->save(false);
			}
		}
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Anyagbeszallitasok('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Anyagbeszallitasok']))
			$model->attributes=$_GET['Anyagbeszallitasok'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Anyagbeszallitasok the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Anyagbeszallitasok::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Anyagbeszallitasok $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='anyagbeszallitasok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

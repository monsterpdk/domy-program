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
			
			// megkeressük a legutóbb felvett árajánlatot és az ID-jához egyet hozzáadva beajánljuk az újonnan létrejött sorszámának
			// formátum: AJ2015000001, ahol az évszám után 000001 a rekord ID-ja 6 jeggyel reprezentálva, balról 0-ákkal feltöltve
			$criteria = new CDbCriteria;
			$criteria->select = 'max(id) AS id';
			$row = Anyagrendelesek::model() -> find ($criteria);
			$utolsoAnyagrendeles = $row['id'];

			$model -> bizonylatszam = "TM" . date("Y") . str_pad( ($utolsoAnyagrendeles != null) ? ($utolsoAnyagrendeles + 1) : "000001", 6, '0', STR_PAD_LEFT );
			
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
				
				if ($anyagbeszallitas != null && Utils::checkAnyagrendelesBeszallitas ($model -> id, $anyagbeszallitas -> id) == "" && $model -> lezarva != 1) {
				
					// ha választottunk ki raktárat és létezik is (nem kamu id-t hackeltek a POST-ba), akkor lezárjuk a rendelést és beszállítást
					// és eltároljuk a kiválasztott raktárba a tételeket
					if (isset($_POST['raktar_id'])) {
						$raktar = Raktarak::model() -> findByPk ($_POST['raktar_id']);
						
						if ($raktar != null) {
							$anyagrendeles = $model;
							
							// lezárjuk az anyagrendelést és a hozzá tartozó anyagbeszállítást
							
							$anyagbeszallitas->lezarva = 1;
							$anyagbeszallitas->save();

							$anyagrendeles->lezarva = 1;
							$anyagrendeles->save();
							
							// végigmegyünk az anyaglistán és eltároljuk a megrendelt termékeket a kiválasztott raktárba
							//
							// TODO: ez így nem túl szép, mert minden elemet egyesével mentek, az mindig egy SQL update/insert.
							//		 Szebb lenne egy tömbben kezelni az elemeket és a végén egyszer menteni mindegyiket, de most idő hiányában
							//		 így csináltam, talán egy rendelésen nem lesz több 100 termék, úgyhogy nem lesz érezhető performancia romlás.
							$termekek = AnyagrendelesTermekek::model()->findAllByAttributes(array("anyagrendeles_id" => $anyagrendeles -> id));
							
							foreach ($termekek as $termek) {
								$raktarTermek = RaktarTermekek::model()->findByAttributes( array('termek_id' => $termek -> termek_id, 'raktar_id' => $raktar -> id) );
								
								// ha van már a raktárban ilyen termék, akkor frissítjük a darabszámát
								if ($raktarTermek != null) {
									$raktarTermek -> elerheto_db += $termek -> rendelt_darabszam;
									$raktarTermek -> osszes_db += $termek -> rendelt_darabszam;
								} else {
									// ha nincs, akkor létrehozunk egy új bejegyzést
									$raktarTermek = new RaktarTermekek;
									$raktarTermek -> termek_id = $termek -> termek_id;
									$raktarTermek -> raktar_id = $raktar -> id;
									
									$raktarTermek -> elerheto_db = $termek -> rendelt_darabszam;
									$raktarTermek -> osszes_db = $termek -> rendelt_darabszam;
								}
								
								$raktarTermek -> save ();
								
								// itt vizsgáljuk, hogy túlléptük-e a termék megadott maximum raktárkészletét,
								// ha igen e-mailt küldünk azoknak felhasználóknak, akik jogosultat megkapni ezt az infót
								if ($raktarTermek -> osszes_db > $termek -> termek -> maximum_raktarkeszlet) {
									$recipients = Utils::getRaktarkeszletLimitAtlepesEsetenErtesitendokEmail();
									$termek_info = $termek->termek->nev . ', jelenlegi raktármennyiség:  <strong>' . $raktarTermek -> osszes_db . ' db</strong>, maximum raktármennyiség: <strong>' . $termek -> termek->maximum_raktarkeszlet . '</strong>';
									$email_body = Yii::app()->controller->renderPartial('application.views.szallitolevelek.ertesites_maximum_raktarkeszlet', array('termek_info'=>$termek_info), true);
									
									Utils::sendEmail ($recipients, 'Figyelmeztetés! Maximum raktárkészlet túllépve', $email_body);
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

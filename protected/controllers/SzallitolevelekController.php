<?php

class SzallitolevelekController extends Controller
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
	public function actionCreate($id)
	{
		if ($id == null)
			$this -> redirect(array('index',));

		$model=new Szallitolevelek;
		$model -> megrendeles_id = $id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Szallitolevelek']))
		{
			$model->attributes=$_POST['Szallitolevelek'];

			$elso_szallitolevel = true ;
			if (count($model->findByAttributes(array('megrendeles_id'=>$id))) > 0) {
					$elso_szallitolevel = false;
			}
			
			//Létrehozzuk a számlát a szállítólevél létrejötte után, ha még nem volt szállítólevele korábban
			if ($elso_szallitolevel) {
				Utils::szamla_letrehozasa($id) ;
			}
			
			if ($model->save()) {
				// LI : miután elmentettük az újonnan létrehozott szállítólevelet elmentjük a hozzá tartozó tételeket is
				$tetelekAMegrendelon = Utils::getSzallitolevelTetelToMegrendeles($id);
				$tetelekASzallitolevelen = explode('$#$', $model -> szallito_darabszamok);
				
				$minuszosTermekek = '';
				for ($i = 0; $i < count($tetelekAMegrendelon); $i++) {
					
					if ( ($tetelekASzallitolevelen[$i] >= 0) || ( ($tetelekASzallitolevelen[$i] == 0) && ($tetelekAMegrendelon[$i]->darabszam == 0) ) ) {
						$tetelASzalliton = new SzallitolevelTetelek;
						
						$tetelASzalliton -> szallitolevel_id = $model -> id;
						$tetelASzalliton -> megrendeles_tetel_id = $tetelekAMegrendelon[$i] -> id;
						$tetelASzalliton -> darabszam = $tetelekASzallitolevelen[$i];
						
						$megrendelesTetel = MegrendelesTetelek::model()->findByPk($tetelASzalliton -> megrendeles_tetel_id);
						$tetelASzalliton -> save();
						
						// a raktárban csökkentjük a foglalt és az elérhető mennyiségeket
						// ha nyomdakönyves munkáról van szó
						if (/* $megrendelesTetel -> hozott_boritek != 1 && */ $megrendelesTetel->szinek_szama1 + $megrendelesTetel->szinek_szama2 > 0) {
							if (!Utils::raktarbolKivesz($megrendelesTetel->termek_id, $tetelASzalliton->darabszam, $model->id, true, true, false, null, true, $megrendelesTetel->id)) {
								$minuszosTermekek .= (strlen($minuszosTermekek) == 0 ? '<br />' : '') . '- ' . $megrendelesTetel->termek->nev;
							}
						} else if ($megrendelesTetel->szinek_szama1 + $megrendelesTetel->szinek_szama2 == 0 && $megrendelesTetel->negativ_raktar_termek == 0) {
							// ha sima boríték eladásról van szó, akkor nincs foglalás, csak levonjuk a raktárkészletből a megfelelő mennyiséget
							Utils::raktarbanFoglal ($megrendelesTetel->termek_id, $tetelASzalliton->darabszam, $model->id, true, true, false, null, $i > 0, $megrendelesTetel->id);
							Utils::raktarbolKivesz ($megrendelesTetel->termek_id, $tetelASzalliton->darabszam, $model->id, true, true, false, null, true, $megrendelesTetel->id);
						}
					}
					
				}

				if (strlen($minuszosTermekek) > 0) {
					$minuszosTermekek = '<strong>' . $minuszosTermekek . '</strong>';
					$minuszosTermekek = 'A következő termékeknél negatív darabszám keletkezett (további információ a <strong><a href="' . Yii::app()->createUrl("raktartermekek/index") . '" target="_blank">Raktárkészletek</a></strong> menüpont alatt):<br />' . $minuszosTermekek;
					Yii::app()->user->setFlash('error', $minuszosTermekek);
				}
				//Létrehozzuk a számlát a szállítólevél létrejötte után, ha még nem volt szállítólevele korábban
/*				if ($elso_szallitolevel) {
					szamla_letrehozasa($id) ;
				}
*/				

				$this->redirect(array('szallitolevelek/index','id'=>$model->megrendeles_id,));
			}
		} else {
			// megkeressük a legutóbb felvett szállítólevelet és az ID-jához egyet hozzáadva beajánljuk az újonnan létrejött sorszámának
			// formátum: SZ2015000001, ahol az évszám után 000001 a rekord ID-ja 6 jeggyel reprezentálva, balról 0-ákkal feltöltve
			$criteria = new CDbCriteria;
			$criteria->select = 'max(id) AS id';
			$row = Szallitolevelek::model() -> find ($criteria);
			$utolsoArajanlat = $row['id'];

			$model -> sorszam = "SZ" . date("Y") . str_pad( ($utolsoArajanlat != null) ? ($utolsoArajanlat + 1) : "000001", 6, '0', STR_PAD_LEFT );
		}

		$dataProvider = new CArrayDataProvider(Utils::getSzallitolevelTetelToMegrendeles($id),
			array(
				'pagination'=>array(
					'pageSize'=>100,
				),
			)
		);

		$this->render('create',array(
			'dataProvider'=>$dataProvider,
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
		if ($id == null)
			$this -> redirect(array('index',));

		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Szallitolevelek']))
		{
			$model->attributes=$_POST['Szallitolevelek'];

			if ($model->save()) {
				// LI : miután elmentettük az újonnan létrehozott szállítólevelet elmentjük a hozzá tartozó tételeket is
				$tetelekAMegrendelon = Utils::getSzallitolevelTetelToMegrendeles($model -> megrendeles_id, $model -> id);
				$tetelekASzallitolevelen = explode('$#$', $model -> szallito_darabszamok);
				
				// LI: a raktárból sztornózzuk a szállítólevél egyes tételeit, majd újra felvesszük őket az új darabszámmal
				// mivel a sztornó egy komplett terméket sztornóz ID szerint, ezért itt figyeljük, hogy volt-e már sztornó egy adott termékre
				$hasStorno = array();
				foreach ($model->tetelek as $szallitolevel_tetel) {
					$megrendelesTetel = $szallitolevel_tetel->megrendeles_tetel;

					if (!in_array($megrendelesTetel -> termek_id, $hasStorno)) {
						// nyomdakönyvi a munka
						if (/*$megrendelesTetel -> hozott_boritek != 1 && */ $megrendelesTetel -> szinek_szama1 + $megrendelesTetel -> szinek_szama2 > 0) {
							Utils::raktarbolKiveszSztornoz($megrendelesTetel->termek_id, $szallitolevel_tetel->darabszam, $model->id);
						} else if ($megrendelesTetel -> szinek_szama1 + $megrendelesTetel -> szinek_szama2 == 0) {
							// sima boríték eladás
							// sztornózzuk az eddigi levont mennyiséget, lejjebb újra kivesszük az új összeggel
							Utils::raktarbanSztornoz ($megrendelesTetel->termek_id, $szallitolevel_tetel->darabszam, $model->id, true);
							Utils::raktarbolKiveszSztornoz ($megrendelesTetel->termek_id, $szallitolevel_tetel->darabszam, $model->id, true);
						}
						
						array_push($hasStorno, $megrendelesTetel -> termek_id);
					}
				}

				// töröljük a szállítólevélhez már felvett tételeket, majd újra létrehozzuk őket az új darabszámmal
				$command = Yii::app()->db->createCommand("DELETE FROM dom_szallitolevel_tetelek WHERE szallitolevel_id = " . $id);
				$command -> execute ();
				
				$minuszosTermekek = '';

				for ($i = 0; $i < count($tetelekAMegrendelon); $i++) {
					if ( ($tetelekASzallitolevelen[$i] >= 0) || ( ($tetelekASzallitolevelen[$i] == 0) && ($tetelekAMegrendelon[$i]->darabszam == 0) ) ) {
						$tetelASzalliton = new SzallitolevelTetelek;
						
						$tetelASzalliton -> szallitolevel_id = $model -> id;
						$tetelASzalliton -> megrendeles_tetel_id = $tetelekAMegrendelon[$i] -> id;
						$tetelASzalliton -> darabszam = $tetelekASzallitolevelen[$i];

						$megrendelesTetel = MegrendelesTetelek::model()->findByPk($tetelASzalliton -> megrendeles_tetel_id);
						
						// a raktárban csökkentjük a foglalt és az elérhető mennyiségeket
						// nyomdakönyvi munka
						if (/* $megrendelesTetel -> hozott_boritek != 1 && */ $megrendelesTetel -> szinek_szama1 + $megrendelesTetel -> szinek_szama2 > 0) {
							if (!Utils::raktarbolKivesz($megrendelesTetel->termek_id, $tetelASzalliton->darabszam, $model->id, true, true, false, null, false, $megrendelesTetel->id)) {
								$minuszosTermekek .= (strlen($minuszosTermekek) == 0 ? '<br />' : '') . '- ' . $megrendelesTetel->termek->nev;
							}
						} else if ($megrendelesTetel -> szinek_szama1 + $megrendelesTetel -> szinek_szama2 == 0 && $megrendelesTetel -> negativ_raktar_termek == 0) {
							// sima eladás
							Utils::raktarbanFoglal ($megrendelesTetel->termek_id, $tetelASzalliton->darabszam, $model->id, true, true, false, null, false, $megrendelesTetel->id);
							Utils::raktarbolKivesz ($megrendelesTetel->termek_id, $tetelASzalliton->darabszam, $model->id, true, true, false, null, false, $megrendelesTetel->id);
						}
						
						
						$tetelASzalliton -> save();
					}
				}

				if (strlen($minuszosTermekek) > 0) {
					$minuszosTermekek = '<strong>' . $minuszosTermekek . '</strong>';
					$minuszosTermekek = 'A következő termékeknél negatív darabszám keletkezett (további információ a <strong><a href="' . Yii::app()->createUrl("raktartermekek/index") . '" target="_blank">Raktárkészletek</a></strong> menüpont alatt):<br />' . $minuszosTermekek;
					Yii::app()->user->setFlash('error', $minuszosTermekek);
				}

				$this->redirect(array('szallitolevelek/index','id'=>$model->megrendeles_id,));
			}
			
		}
		
		$dataProvider = new CArrayDataProvider(Utils::getSzallitolevelTetelToMegrendeles($model -> megrendeles_id, $model -> id));
		
		$this->render('update', array(
			'dataProvider'=>$dataProvider,
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
		// logikai törlést alkalmazunk, 'torolt' mező értékét állítjuk 1-re
		$model=$this->loadModel($id);

		$model->torolt = 1;
		$model->save(false);

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($id)
	{
		if ($id == null)
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		
		$megrendeles = Megrendelesek::model() -> findByPk ($id);		
		
		$dataProvider=new CActiveDataProvider('Szallitolevelek',
			Yii::app()->user->checkAccess('Admin') ? array('criteria'=>array('order'=>"datum ASC", 'condition'=>'megrendeles_id = ' . $id),) : array( 'criteria'=>array('condition'=>"torolt = 0 AND megrendeles_id = " . $id,),)
		);
		
		// ha még nem létezik szállítólevél az adott megrendeléshez, akkor átirányítjuk a létrehozó oldalra a felhasználót
		if ($dataProvider->getTotalItemCount() == 0)
			$this->redirect(array('szallitolevelek/create','id'=>$id,));
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'megrendeles'=>$megrendeles,
		));

	}

	public function actionPrintPDF()
	{
		if (isset($_GET['id'])) {
			$model = $this -> loadModel($_GET['id']);
		}

		$print_copies = 3;
		if (isset($_GET['copies'])) {
			$print_copies = (int)$_GET['copies'];
			if ($print_copies == 0) $print_copies = 3;
		}
		
		$futarszolgalatos = false;
		if (isset($_GET['futaros'])) {
			$futaros = (int)$_GET['futaros'];
			if ($futaros == 1) $futarszolgalatos = true;
		}
		
		if ($model != null) {
			$model->setAttributes(array('nyomtatva' => 1)) ;
			$model->save(false) ;

			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();
			$mPDF1->SetHtmlHeader("SZÁLLÍTÓLEVÉL #" . $model->sorszam);

			# render
			$mPDF1->WriteHTML($this->renderPartial("printSzallitolevel", array('model' => $model, 'futarszolgalatos' => false), true));

			// LI: lementjük a szerverre a PDF fájlt, hogy a több példányt onnan nyomtathassuk, ne kelljen minden egyes nyomtatás előtt
			//     legenerálni az egészet, mert nagyon erőforrásigényes művelet
			$mPDF1->Output('uploads/szallitolevelek/' . $model->id . '.pdf', EYiiPdf::OUTPUT_TO_FILE);

			// a példány, aminél választható a nyomtató és kiírjuk, ha futárszolgálatos
			$mPDF1 = Yii::app()->ePdf->mpdf();
			$mPDF1->SetHtmlHeader("SZÁLLÍTÓLEVÉL #" . $model->sorszam);

			// dobja fel a print dialog-ot
			$mPDF1->SetJS('this.print();');
			
			# render
			$mPDF1->WriteHTML($this->renderPartial("printSzallitolevel", array('model' => $model, 'futarszolgalatos' => $futarszolgalatos), true));
			
			// LI: kirajkuk böngészőre az elkészült pdf-et
			$mPDF1->Output();
			
			// kinyomtatjuk annyiszor, ahányat beállítottunk
			$this->printPdf($model->id, $print_copies);
			
		}
	}
	
	// LI : egy megadott PDF-et nyomtat ki a megadott darabszámban
	private function printPdf ($id, $print_copies) {
		$webroot_url = Yii::app()->getBaseUrl(true) . '/uploads/szallitolevelek/';
		$PdfBoxUrl = Yii::app()->config->get('PdfBoxUrl');
		$print_cmd = "java -classpath " . $PdfBoxUrl . " org.apache.pdfbox.tools.PrintPDF -silentPrint " . $webroot_url . $id . ".pdf";

		for ($i = 0; $i < $print_copies; $i++) {
			exec($print_cmd);
		} 
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Szallitolevelek('search');
		$model->unsetAttributes();  // clear any default values
		
		if (isset($_GET['Szallitolevelek']))
			$model->attributes=$_GET['Szallitolevelek'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Megrendelés sztornózása.
	 */
	public function actionStorno ()
	{
		if ( isset($_POST['szallitolevel_id']) ) {
			$model_id = $_POST['szallitolevel_id'];
			
			$szallitolevel = Szallitolevelek::model() -> findByPk ($model_id);

			if ($szallitolevel != null) {
				$szallitolevel -> sztornozva = 1;
				
				// a raktárban növeljük a foglalt és az összes mennyiségeket
				foreach ($szallitolevel->tetelek as $szallitolevel_tetel) {
					$megrendelesTetel = $szallitolevel_tetel->megrendeles_tetel;
					
					if (/* $megrendelesTetel -> hozott_boritek != 1 && */ $megrendelesTetel -> szinek_szama1 + $megrendelesTetel -> szinek_szama2 > 0) {
						Utils::raktarbolKiveszSztornoz($megrendelesTetel->termek_id, $szallitolevel_tetel->darabszam, $szallitolevel->id);
					} else if ($megrendelesTetel -> szinek_szama1 + $megrendelesTetel -> szinek_szama2 == 0) {
						// visszarakjuk a raktárba a sztornózott darabszámot
						Utils::raktarbolKiveszSztornoz ($megrendelesTetel->termek_id, $szallitolevel_tetel->darabszam, $szallitolevel->id, true);
						Utils::raktarbanSztornoz ($megrendelesTetel->termek_id, $szallitolevel_tetel->darabszam, $szallitolevel->id, true);
					}
				}
				
				$szallitolevel -> save(false);
			}
		}
		
		$this->redirect(array('szallitolevelek/index/' . $szallitolevel -> megrendeles_id));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Szallitolevelek the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Szallitolevelek::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Szallitolevelek $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='arajanlatok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionRepairHozottBoritek () {
		$javitandoMegrendelesek = array('6457', '6434', '6304', '6295', '6293', '6243', '6198', '6135', '5700');
		$result = '';
		
		foreach ($javitandoMegrendelesek as $javitandoMegrendeles) {
			$megrendeles = Megrendelesek::model()->findByPk($javitandoMegrendeles);
			
			if ($megrendeles != null) {
				$result .= ' ' . $megrendeles -> id;
				foreach ($megrendeles->tetelek as $megrendelesTetel) {
					$nyomdakonyv = Nyomdakonyv::model()->findByAttributes(array("megrendeles_tetel_id" => $megrendelesTetel -> id, "sztornozva" => "0"));
					
					if ($nyomdakonyv != null) {
						Utils::raktarbanFoglal($megrendelesTetel -> termek_id, $megrendelesTetel -> darabszam, $nyomdakonyv->id);
					}
				}
			}
		}
		
		echo "Javított megrendelések: " . $result;
	}

	public function actionSzallitolevelAdatokAjax(){
		$sorszam = Yii::app()->request->getQuery('szallitolevel_szam');
		$szallitolevel = Szallitolevelek::model()->findByAttributes(array('sorszam'=>$sorszam,'torolt'=>'0'));
		$szallitolevel_tomb["szallitas_cegnev"] = $szallitolevel->megrendeles->ugyfel->cegnev ;
		$szallitolevel_tomb["szallitas_cim"] = $szallitolevel->megrendeles->ugyfel->szekhely_irsz . " " . $szallitolevel->megrendeles->ugyfel->szekhely_varos_dsp->varosnev . ", " . $szallitolevel->megrendeles->ugyfel->szekhely_cim ;
		$szallitolevel_tomb["szallitas_telefonszam"] = $szallitolevel->megrendeles->ugyfel->kapcsolattarto_telefon ;
		if (count($szallitolevel->tetelek) > 0) {
			foreach ($szallitolevel->tetelek as $tetel) {
				$tetel_sor = array();
				$tetel_sor["megnevezes"] = $tetel->megrendeles_tetel->termek->displayTermeknev;
				$tetel_sor["darab"] = $tetel->darabszam;
				$szallitolevel_tomb["tetelek"][] = $tetel_sor;
			}
		}


		echo json_encode($szallitolevel_tomb);
	}
}

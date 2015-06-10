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
				if (Utils::checkAnyagrendelesBeszallitas ($model -> anyagrendeles_id, $id) == "" && $model -> lezarva != 1) {
				
					// ha választottunk ki raktárat és létezik is (nem kamu id-t hackeltek a POST-ba), akkor lezárjuk a rendelést és beszállítást
					// és eltároljuk a kiválasztott raktárba a tételeket
					if (isset($_POST['raktar_id'])) {
						$raktar = Raktarak::model() -> findByPk ($_POST['raktar_id']);
						
						if ($raktar != null) {
							$anyagbeszallitas = $model;
							$anyagrendeles = Anyagrendelesek::model()->findByPk($model -> anyagrendeles_id);
							
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
							}
						}
					}
					
					$this->redirect(array('index'));
				}
			}
			
			// ha a raktárellenőrzés során eltéréseket találtunk valahol, akkor csak 'simán' mentjük a modelt
			$model->attributes=$_POST['Anyagbeszallitasok'];
			if($model->save())
				$this->redirect(array('index'));
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
		$dataProvider=new CActiveDataProvider('Anyagbeszallitasok');
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
		
		echo json_encode($result);
		
		exit();
	}

	// AJAX-os híváshoz: visszaadja egy adott anyagbeszállítás összértékét
	public function actionRefreshOsszertek($anyagbeszallitas_id) {
		$anyagbeszallitas = Anyagbeszallitasok::model()->findByPk ($anyagbeszallitas_id);

		echo CJSON::encode(array(
				'osszertek'=>$anyagbeszallitas == null ? 0 : $anyagbeszallitas->displayOsszertek,
				));
		Yii::app()->end();
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

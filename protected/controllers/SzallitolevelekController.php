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
					$elso_szallitolevel = false ;
			}
			
			//Létrehozzuk a számlát a szállítólevél létrejötte után, ha még nem volt szállítólevele korábban
			if ($elso_szallitolevel) {
				Utils::szamla_letrehozasa($id) ;
				$szamla_sorszam = Utils::szamla_sorszam_beolvas($id) ;
			}
			
			if ($model->save()) {
				// LI : miután elmentettük az újonnan létrehozott szállítólevelet elmentjük a hozzá tartozó tételeket is
				$tetelekAMegrendelon = Utils::getSzallitolevelTetelToMegrendeles($id);
				$tetelekASzallitolevelen = explode('$#$', $model -> szallito_darabszamok);
				
				for ($i = 0; $i < count($tetelekAMegrendelon); $i++) {
					if ( ($tetelekASzallitolevelen[$i] != 0) || ( ($tetelekASzallitolevelen[$i] == 0) && ($tetelekAMegrendelon[$i]->darabszam == 0) ) ) {
						$tetelASzalliton = new SzallitolevelTetelek;
						
						$tetelASzalliton -> szallitolevel_id = $model -> id;
						$tetelASzalliton -> megrendeles_tetel_id = $tetelekAMegrendelon[$i] -> id;
						$tetelASzalliton -> darabszam = $tetelekASzallitolevelen[$i];
						
						$tetelASzalliton -> save();
					}
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
		
		$dataProvider = new CArrayDataProvider(Utils::getSzallitolevelTetelToMegrendeles($id));
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
				
				// töröljük a szállítólevélhez már felvett tételeket, majd újra létrehozzuk őket az új darabszámmal
				$command = Yii::app()->db->createCommand("DELETE FROM dom_szallitolevel_tetelek WHERE szallitolevel_id = " . $id);
				$command -> execute ();
				
				for ($i = 0; $i < count($tetelekAMegrendelon); $i++) {
					if ( ($tetelekASzallitolevelen[$i] != 0) || ( ($tetelekASzallitolevelen[$i] == 0) && ($tetelekAMegrendelon[$i]->darabszam == 0) ) ) {
						$tetelASzalliton = new SzallitolevelTetelek;
						
						$tetelASzalliton -> szallitolevel_id = $model -> id;
						$tetelASzalliton -> megrendeles_tetel_id = $tetelekAMegrendelon[$i] -> id;
						$tetelASzalliton -> darabszam = $tetelekASzallitolevelen[$i];
						
						$tetelASzalliton -> save();
					}
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
		
		if ($model != null) {
			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();

			$mPDF1->SetHtmlHeader("SZÁLLÍTÓLEVÉL #" . $model->sorszam);
			
			# render
			$mPDF1->WriteHTML($this->renderPartial("printSzallitolevel", array('model' => $model), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
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
}

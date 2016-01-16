<?php

class TermekekController extends Controller
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

	public function actions() {
		return array('upload' => array('class' => 'xupload.actions.XUploadAction', 'path' => Yii::app() -> getBasePath() . "/../uploads", "publicPath" => Yii::app()->getBaseUrl()."/uploads" ), );
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
		$model=new Termekek;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Termekek']))
		{
			$model->attributes=$_POST['Termekek'];
			if($model->save())
				$this->redirect(array('index'));
		} else {
			// LI : új termék létrehozásánál beállítjuk az alapértelmezettnek beállított ÁFA kulcsot
			$afaKulcs = AfaKulcsok::model()->findByAttributes(array('alapertelmezett'=> 1));

			if ($afaKulcs != null) {
				$model -> afakulcs_id = $afaKulcs -> id;
			}
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

		if(isset($_POST['Termekek']))
		{
			$model->attributes=$_POST['Termekek'];
			if($model->save())
				Utils::goToPrevPage("termekekIndex");
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
		// logikai törlést alkalmazunk, 'torolt' mező értékét állítjuk 1-re
		$model=$this->loadModel($id);
		
		$model->torolt = 1;
		$model->save();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		Utils::saveCurrentPage("termekekIndex");
		
		$dataProvider = new CActiveDataProvider('Termekek',
			Yii::app()->user->checkAccess('Admin') ? array() : array( 'criteria'=>array('condition'=>"torolt = 0 ",),)
		);
		
		// LI : exporthoz kell ez a blokk
		 if ($this->isExportRequest()) {
			//nagy adathalmaz export-ja esetén érdemes bekapcsolni:
            //set_time_limit(0);
            $this->exportCSV(array(), null, false);
			
			// mindig az aktuális
            $this->exportCSV($dataProvider, array('id', 'nev', 'tipus', 'kodszam', 'cikkszam', 'meret.id', 'meret.nev', 'suly', 'zaras.id', 'zaras.nev', 'ablakmeret.id', 'ablakmeret.nev', 'ablakhely.id', 'ablakhely.nev', 'papirtipus.id', 'papirtipus.nev', 'afakulcs.id', 'afakulcs.afa_szazalek', 'redotalp', 'belesnyomott', 'kategoria_tipus', 'gyarto.id', 'gyarto.cegnev', 'ksh_kod', 'csom_egys', 'minimum_raktarkeszlet', 'maximum_raktarkeszlet', 'doboz_suly', 'raklap_db', 'doboz_hossz', 'doboz_szelesseg', 'doboz_magassag', 'megjegyzes', 'megjelenes_mettol', 'megjelenes_meddig', 'datum', 'torolt'));
        }
		
		// LI : importhoz kell ez
		Yii::import("xupload.models.XUploadForm");
		$model = new XUploadForm;
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model' => $model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Termekek('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Termekek']))
			$model->attributes=$_GET['Termekek'];
			
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Termekek the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Termekek::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	// LI : export-hoz kell
	public function behaviors() {
		return array(
			'exportableGrid' => array(
				'class' => 'application.components.ExportableGridBehavior',
				'filename' => 'termekek.csv',
				'csvDelimiter' => ";", // i.e. Excel friendly csv delimiter
            ));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
		if ($error = Yii::app() -> errorHandler -> error) {
			if (Yii::app() -> request -> isAjaxRequest)
				echo $error['message'];
			else
				$this -> render('error', $error);
		}
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param Termekek $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='termekek-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

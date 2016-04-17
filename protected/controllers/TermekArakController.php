<?php

class TermekArakController extends Controller
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
		$model=new TermekArak;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TermekArak']))
		{
			$model->attributes=$_POST['TermekArak'];
			if($model->save())
				$this->redirect(array('index'));
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
		$termek = Termekek::model()->findAllByAttributes(array("id" => $model -> termek_id));

//		echo "aaa:" . $termek[0]["attributes"]["belesnyomott"] ;
		$termek_adatok = ($termek != null) ? $termek[0]["attributes"] : null;
//		print_r($termek_adatok) ;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['TermekArak']))
		{
			$model->attributes=$_POST['TermekArak'];
			if($model->save())
				Utils::goToPrevPage("termekarakIndex");
		}

		$this->render('update',array(
			'model'=>$model,
			'termek_adatok'=>$termek_adatok,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete ($id)
	{
		// logikai törlést alkalmazunk, 'torolt' mező értékét állítjuk 1-re
		$model = $this->loadModel($id);

		$model->torolt = 1;
		$model->save(false);

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		Utils::saveCurrentPage("termekarakIndex");
		
		$model=new TermekArak('search');
		$model->unsetAttributes();
		if(isset($_GET['TermekArak']))
			$model->attributes=$_GET['TermekArak'];
	 	
		$non_admin_criteria=new CDbCriteria;

		$non_admin_criteria->together = true;
		$non_admin_criteria->with = array('termek', 'termek.gyarto', 'termek.meret', 'termek.zaras');
		$non_admin_criteria->compare('t.torolt', 0, false);
		$non_admin_criteria->compare('termek.torolt', 0, false);
		
		$dataProvider=new CActiveDataProvider('TermekArak',
			Yii::app()->user->checkAccess('Admin') ? array('criteria'=>array('order'=>'id DESC',),) : array('criteria'=>$non_admin_criteria)
		);

/*		$dataProvider=new CActiveDataProvider('TermekArak',
			Yii::app()->user->checkAccess('Admin') ? array('criteria'=>array('order'=>'id DESC',),) : array('criteria'=>array('condition'=>"torolt = 0 ",'order'=>'id DESC',),)
		);*/
		
		
		// LI : exporthoz kell ez a blokk
		 if ($this->isExportRequest()) {
			//nagy adathalmaz export-ja esetén érdemes bekapcsolni:
            //set_time_limit(0);
            $this->exportCSV(array(), null, false);
			
			// mindig az aktuális
            $this->exportCSV($dataProvider, array('id', 'termek.nev', 'termek.id', 'termek.belesnyomott', 'csomag_beszerzesi_ar', 'db_beszerzesi_ar', 'darab_ar_szamolashoz', 'csomag_ar_nyomashoz', 'db_ar_nyomashoz', 'csomag_eladasi_ar', 'db_eladasi_ar', 'datum_mettol', 'datum_meddig', 'torolt'));
        }
		
		// LI : importhoz kell ez
		Yii::import("xupload.models.XUploadForm");
		$importModel = new XUploadForm;
		
		$this->render('index', array(
			'importModel' => $importModel,
			'model' => $model,
		));
	}

	// LI: visszaadja, hogy egy megadott termék bélésnyomott-e (1 - igen, 0 - nem)
	public function actionUpdateBelesnyomottCheckbox ($termek_id)
	{
		$status =  'failure';
		$belesnyomott = 0;
		
		$termek = Termekek::model()->findByPk ($termek_id);
		if ($termek != null) {
			$belesnyomott = $termek->belesnyomott == 1 ? 1 : 0;
			$status = 'success';
		}
		
		echo CJSON::encode(array(
			'status'=>$status,
			'belesnyomott'=> $belesnyomott
		));
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TermekArak('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TermekArak']))
			$model->attributes=$_GET['TermekArak'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TermekArak the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TermekArak::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	// LI : export-hoz kell
	public function behaviors() {
		return array(
			'exportableGrid' => array(
				'class' => 'application.components.ExportableGridBehavior',
				'filename' => 'termekArak.csv',
				'csvDelimiter' => ";", // i.e. Excel friendly csv delimiter
            ));
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param TermekArak $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='termek-arak-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

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
			// új termék felvétele esetén az 'Árkalkulációban megjelenik' checkbox alapértelmezettkén be van pipálva
			$model -> arkalkulacioban_megjelenik = 1;
			
			// LI : új termék létrehozásánál beállítjuk az alapértelmezettnek beállított ÁFA kulcsot és a felvételi dátumot mostra
			$afaKulcs = AfaKulcsok::model()->findByAttributes(array('alapertelmezett'=> 1));

			if ($afaKulcs != null) {
				$model -> afakulcs_id = $afaKulcs -> id;
			}
			
			// felvételi dátum alapértelmezetten a mai nap lesz
			$model->felveteli_datum = date('Y-m-d');	
			
			// cikkszámnak beírjuk a legutoljára felvett terméket cikkszámát egyel megnövelve
			$criteria = new CDbCriteria;
			$criteria->select = 'max(id) AS id';
			$row = Termekek::model() -> find ($criteria);
			
			if ($row != null) {
				$utolsoTermekId = $row['id'];

				$utolsoTermek = Termekek::model()->findByPk($utolsoTermekId);
				if ($utolsoTermek != null) {
					$model -> cikkszam = filter_var($utolsoTermek->cikkszam, FILTER_SANITIZE_NUMBER_INT) + 1;
				}
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
				Utils::goToPrevPage("termekekIndex", array("updated"=>$id));
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
		$model->save(false);

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
		$updated = "0" ;
		if (isset($_GET["updated"]) && is_numeric($_GET["updated"]))
			$updated = $_GET["updated"] ;
		
		$model=new Termekek('search');
		$model->unsetAttributes();
		if(isset($_GET['Termekek']))
			$model->attributes=$_GET['Termekek'];
	 	
		$dataProvider=new CActiveDataProvider('Termekek',
			Yii::app()->user->checkAccess('Admin') ? array('criteria'=>array('order'=>'nev DESC',), ) : array('criteria'=>array('condition'=>"torolt = 0 ",'order'=>'nev DESC',),)
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
		$importMmodel = new XUploadForm;
		
		$this->render('index',array(
			'importModel' => $importMmodel,
			'model' => $model,
			'updated' => $updated
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

	// LI : export-hoz kell.
	public function behaviors() {
		return array(
			'exportableGrid' => array(
				'class' => 'application.components.ExportableGridBehavior',
				'filename' => 'termekek.csv',
				'csvDelimiter' => ";", // i.e. Excel friendly csv delimiter
            ));
	}
	
	// LI: képek feltöltéséhez kell.
	public function actionUploadImages () {
		$termekId = isset($_POST['termekId']) ? $_POST['termekId'] : 'omlesztve';
		$tempFolder = Yii::getPathOfAlias('webroot').'/uploads/termekek/kepek/' . $termekId . '/';

		if (!is_dir($tempFolder)) {
			mkdir($tempFolder, 0777, TRUE);
		}
		if (!is_dir($tempFolder.'chunks')) {
			mkdir($tempFolder.'chunks', 0777, TRUE);
		}

		Yii::import("ext.EFineUploader.qqFileUploader");

		$uploader = new qqFileUploader();
		$uploader->allowedExtensions = array('jpg','jpeg','png');
		$uploader->sizeLimit = 5 * 1024 * 1024; //maximum fájlméret egyelőre 5 MB
		$uploader->chunksFolder = $tempFolder.'chunks';

		$result = $uploader->handleUpload($tempFolder);
		$result['filename'] = $uploader->getUploadName();
		$result['folder'] = $tempFolder;
		$result['imageUrl'] = Yii::app()->getBaseUrl(true) . '/uploads/termekek/kepek/' . $termekId . '/' . $result['filename'];

		$uploadedFile=$tempFolder.$result['filename'];

		header("Content-Type: text/plain");
		$result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		echo $result;
		Yii::app()->end();
	}
	
	// LI: képek feltöltésénél a törléshez kell.
	public function actionDeleteImage () {
		if (isset($_POST['filename'])) {
			$termekId = isset($_POST['termekId']) ? $_POST['termekId'] : 'omlesztve';
			
			$tempFolder = Yii::getPathOfAlias('webroot').'/uploads/termekek/kepek/' . $termekId . '/';
			
			if (file_exists($tempFolder.$_POST['filename'])) {
				unlink ($tempFolder.$_POST['filename']);
			}
		}
	}
	
	// cikkszámok előregépelős beajánlásának keresője
	public function actionSearchCikkszamok ($anotherParam = null, $term)
	{
		if(Yii::app()->request->isAjaxRequest && !empty($term))
        {
              $variants = array();
              $criteria = new CDbCriteria;
              $criteria->select='cikkszam';
              $criteria->addSearchCondition('cikkszam', $term.'%', false);
			  
			  // ezzel tudunk termékcsoportra szűrni, ha szükséges
			  if ($anotherParam != null) {
				  $criteria->addSearchCondition('termekcsoport_id', $anotherParam, false);
			  }
			  
              $cikkszamok = Termekek::model()->findAll($criteria);
			  
              if(!empty($cikkszamok))
              {
                foreach($cikkszamok as $cikkszam)
                {
                    $variants[] = $cikkszam->attributes['cikkszam'];
                }
              }
              echo CJSON::encode($variants);
        }
        else
            throw new CHttpException(400,'Hibás kérés.');
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

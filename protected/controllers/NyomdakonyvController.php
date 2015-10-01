<?php

class NyomdakonyvController extends Controller
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
	 /*
	public function actionCreate()
	{
		$model=new Nyomdakonyv;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Nyomdakonyv']))
		{
			$model->attributes=$_POST['Nyomdakonyv'];
 
            $uploadedFile=CUploadedFile::getInstance($model,'kep_file_nev');
            $fileName = "{$uploadedFile}";
            $model->kep_file_nev = $fileName;
			
			if($model->save()) {
				// sikeres validáció/mentés esetén lementjük a betallózott fájlt is
				$uploadedFile->saveAs(Yii::app()->basePath . '/../uploads/' . $model->id . '/' . $fileName);
				
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
*/

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Nyomdakonyv']))
		{
			$model->attributes=$_POST['Nyomdakonyv'];
            $uploadedFile = CUploadedFile::getInstance($model,'kep_file_nev');

			if (!empty($uploadedFile)) {
				$model->kep_file_nev = $uploadedFile->name;
			}
			
			if($model->save()) {
				// szükség esetén firssítjük az űrlapon a csatolt képet
				if(!empty($uploadedFile))
                {
					// ha nem létezik még a nyomdakönyvhöz tartozó upload könyvtár, akkor létrehozzuk
					$nyomdakonyv_upload_folder = Yii::app()->basePath . '/../uploads/nyomdakonyv/' . $model->id;
					if(!is_dir($nyomdakonyv_upload_folder)) {
						//echo $nyomdakonyv_upload_folder; die();
						mkdir ($nyomdakonyv_upload_folder, 0777, true);
					}
					
                    $uploadedFile->saveAs(Yii::app()->basePath . '/../uploads/nyomdakonyv/' . $model->id. '/' .$uploadedFile->name);
                }
				$this->redirect(array('index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Nyomdakönyv sztornózása.
	 */
	public function actionStorno ()
	{
		if ( isset($_POST['nyomdakonyv_id']) ) {
			$model_id = $_POST['nyomdakonyv_id'];
			$storno_ok = isset($_POST['selected_storno']) ? $_POST['selected_storno'] : '';
			
			$nyomdakonyv = Nyomdakonyv::model() -> findByPk ($model_id);

			if ($nyomdakonyv != null) {
				$nyomdakonyv -> sztornozas_oka = $storno_ok;
				$nyomdakonyv -> sztornozva = 1;
				
				$nyomdakonyv -> save(false);
			}
		}
		
		$this->redirect(array('nyomdakonyv/index'));
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
		$dataProvider=new CActiveDataProvider('Nyomdakonyv',
			Yii::app()->user->checkAccess('Admin') ? array() : array( 'criteria'=>array('condition'=>"torolt = 0 ",),)
		);
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Nyomdakonyv('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Nyomdakonyv']))
			$model->attributes=$_GET['Nyomdakonyv'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Nyomdakonyv the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Nyomdakonyv::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Nyomdakonyv $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='nyomdakonyv-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

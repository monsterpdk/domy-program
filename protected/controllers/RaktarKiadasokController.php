<?php

class RaktarKiadasokController extends Controller
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
		$model=new RaktarKiadasok;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RaktarKiadasok']))
		{
			$model->attributes=$_POST['RaktarKiadasok'];

			$nyomdakonyv = Nyomdakonyv::model()->findByPk($model->nyomdakonyv_id);
			
			if ($nyomdakonyv != null) {
				if($model->save()) {
					// kivesszük a raktárból a kért darabszámot
					Utils::raktarbanFoglal ($model->termek_id, $model->darabszam, $model->nyomdakonyv_id, true);
					Utils::raktarbolKivesz ($model->termek_id, $model->darabszam, $model->nyomdakonyv_id, true, true, false, null, false, 0);

					$this->redirect(array('index'));
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

		if(isset($_POST['RaktarKiadasok']))
		{
			$elozoDarabszam = $model->darabszam;
			$model->attributes=$_POST['RaktarKiadasok'];
			
			$nyomdakonyv = Nyomdakonyv::model()->findByPk($model->nyomdakonyv_id);
			
			if($nyomdakonyv != null && $model->save()) {
				// stornozzuk az eddigi levont mennyiséget, majd kivesszük az újat
				Utils::raktarbolKiveszSztornoz ($model->termek_id, $elozoDarabszam, $model->nyomdakonyv_id, true);
				Utils::raktarbanFoglal ($model->termek_id, $model->darabszam, $model->nyomdakonyv_id, true);
				Utils::raktarbolKivesz ($model->termek_id, $model->darabszam, $model->nyomdakonyv_id, true, true, false, null, false, $nyomdakonyv->megrendeles_tetel_id);
				$this->redirect(array('index'));
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
		$dataProvider=new CActiveDataProvider('RaktarKiadasok');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new RaktarKiadasok('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RaktarKiadasok']))
			$model->attributes=$_GET['RaktarKiadasok'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionTetelValaszto($grid_id)
	{
		// Keresés esetén visszaadjuk a szűrt listát és kilépünk a metódusból
		$termek=new Termekek('search');
		$termek->unsetAttributes();  // clear any default values
		
		if (isset($_GET['ajax']) && strpos($_GET['ajax'], 'termekek-grid') !== FALSE) {
			if(isset($_GET['Termekek'])) {
				$termek->attributes=$_GET['Termekek'];
			}
			
			// Stop jQuery from re-initialization
			Yii::app()->clientScript->scriptMap['*.js'] = false;
			Yii::app()->clientScript->scriptMap['*.css'] = false;
			
			$this->renderPartial('_selectTermek', array('termek' => $termek, 'grid_id'=>$grid_id), false, true);
			exit;
		}

		if (Yii::app()->request->isAjaxRequest)
        {
			// Stop jQuery from re-initialization
			Yii::app()->clientScript->scriptMap['*.js'] = false;
			Yii::app()->clientScript->scriptMap['*.css'] = false;
		
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_selectTermek', array('termek' => $termek, 'grid_id'=>$grid_id), true, true)));
            exit;               
        }
		
	}

	/**
	 * Raktár kiadás sztornózása.
	 */
	public function actionStorno ()
	{
		if ( isset($_POST['raktarkiadas_id']) ) {
			$model_id = $_POST['raktarkiadas_id'];
			
			$raktarKiadas = RaktarKiadasok::model() -> findByPk ($model_id);

			if ($raktarKiadas != null) {
				$raktarKiadas -> sztornozva = 1;
				$raktarKiadas -> save(false);
				
				// visszarakjuk a raktárba a sztornózott darabszámot
				Utils::raktarbolKiveszSztornoz ($raktarKiadas->termek_id, $raktarKiadas->darabszam, $raktarKiadas->nyomdakonyv_id, true);
				Utils::raktarbanSztornoz ($raktarKiadas->termek_id, $raktarKiadas->darabszam, $raktarKiadas->nyomdakonyv_id, true);
			}
		}
		
		$this->redirect(array('raktarKiadasok/index'));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return RaktarKiadasok the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=RaktarKiadasok::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param RaktarKiadasok $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='raktar-kiadasok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

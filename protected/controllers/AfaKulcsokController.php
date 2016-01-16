<?php

class AfaKulcsokController extends Controller
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
		$model=new AfaKulcsok;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AfaKulcsok']))
		{
			$model->attributes=$_POST['AfaKulcsok'];
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AfaKulcsok']))
		{
			$model->attributes=$_POST['AfaKulcsok'];
			
			// LI : megnézzük, hogy a mentés alatt lévő ÁFA kulcson kívül van-e még aktív (nem törölt) ÁFA kulcs,
			//		ha nincs, akkor automatikusan alapértelmezetté tesszük a mentés alatt lévőt
			$afaKulcsok = AfaKulcsok::model()->findAll(array("condition"=>"torolt=0"));

			if (count($afaKulcsok) == 1 && $model -> torolt != 1) {
				$afaKulcs = $afaKulcsok[0];
				
				if ($afaKulcs -> id == $model -> id) {
					$model -> alapertelmezett = 1;
				}
			}
			
			// LI : előfordulhat olyan eset, hogy egy alapértelmezettnek beállított ÁFA kulcsot törlünk,
			//		ezután beállítunk egy másikat alapértelmezettnek, majd a töröltet visszaállítjuk.
			//		Ekkor kettő (vagy több) alapértelmezett ÁFA kulcs lesz a táblában. Emiatt mentéskor meg kell
			//		nézni, hogy van-e alapértelmezett ÁFA kulcs. Ha van, akkor nem engedjük alapértelmezettnek beállítani
			//		a mentendőt, így az 'alapertelmezett' flag-et 0-ra állítom mentés előtt.
			$defaultAfaKulcsok = AfaKulcsok::model()->findAll(array("condition"=>"torolt=0 AND alapertelmezett=1"));
			if (count($defaultAfaKulcsok) >= 1) {
				$defaultAfaKulcs = $defaultAfaKulcsok[0];
				
				if ($defaultAfaKulcs -> id != $model -> id) {
					$model -> alapertelmezett = 0;
				}
			}
			
			if($model->save())
				Utils::goToPrevPage("afaKulcsokIndex");
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
		Utils::saveCurrentPage("afaKulcsokIndex");
		
		$dataProvider=new CActiveDataProvider('AfaKulcsok',
			Yii::app()->user->checkAccess('Admin') ? array() : array( 'criteria'=>array('condition'=>"torolt = 0 ",),)
		);
				
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionSetDefaultAFA ()
	{
		if (isset($_POST['default_id'])) {
			$model = AfaKulcsok::model()->findByPk(array("id" => $_POST['default_id']));
			
			if ($model != null) {
				// LI : töröljük rekordról az 'alapertelmezett' flag-et (bár elvileg egyszerre csak 1-en lehet)
				$criteria = new CDbCriteria();
				$criteria->addCondition("alapertelmezett=1");
				$afaKulcsok = AfaKulcsok::model()->findAll($criteria, '');

				if (isset($afaKulcsok)) {
					foreach($afaKulcsok as $afaKulcs) {
						$afaKulcs -> alapertelmezett = 0;
						$afaKulcs -> save();
					}				
				}
				
				// LI : beállítjuk a kiválasztott ÁFA kulcs rekordjához tartozó 'alapertelmezett' mezőt 1-re
				$model -> alapertelmezett = 1;
				$model ->save();
			}
		}
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AfaKulcsok('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AfaKulcsok']))
			$model->attributes=$_GET['AfaKulcsok'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AfaKulcsok the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AfaKulcsok::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AfaKulcsok $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='afa-kulcsok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

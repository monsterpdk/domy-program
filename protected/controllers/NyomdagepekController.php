<?php

class NyomdagepekController extends Controller
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
		$model=new Nyomdagepek;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Nyomdagepek']))
		{
			$model->attributes=$_POST['Nyomdagepek'];

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

		if(isset($_POST['Nyomdagepek']))
		{
			$model->attributes=$_POST['Nyomdagepek'];
			
			// LI : megnézzük, hogy a mentés alatt lévő nyomdagépen kívül van-e még aktív (nem törölt) nyomdagép,
			//		ha nincs, akkor automatikusan alapértelmezetté tesszük a mentés alatt lévőt
			$nyomdagepek = Nyomdagepek::model()->findAll(array("condition"=>"torolt=0"));

			if (count($nyomdagepek) == 1 && $model -> torolt != 1) {
				$nyomdagep = $nyomdagepek[0];
				
				if ($nyomdagep -> id == $model -> id) {
					$model -> alapertelmezett = 1;
				}
			}
			
			// LI : előfordulhat olyan eset, hogy egy alapértelmezettnek beállított nyomdagépet törlünk,
			//		ezután beállítunk egy másikat alapértelmezettnek, majd a töröltet visszaállítjuk.
			//		Ekkor kettő (vagy több) alapértelmezett nyomdagép lesz a táblában. Emiatt mentéskor meg kell
			//		nézni, hogy van-e alapértelmezett nyomdagép. Ha van, akkor nem engedjük alapértelmezettnek beállítani
			//		a mentendőt, így az 'alapertelmezett' flag-et 0-ra állítom mentés előtt.
			$defaultNyomdagepek = Nyomdagepek::model()->findAll(array("condition"=>"torolt=0 AND alapertelmezett=1"));
			if (count($defaultNyomdagepek) >= 1) {
				$defaultNyomdagep = $defaultNyomdagepek[0];
				
				if ($defaultNyomdagep -> id != $model -> id) {
					$model -> alapertelmezett = 0;
				}
			}
			
			if($model->save())
				Utils::goToPrevPage("nyomdagepekIndex");
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
		Utils::saveCurrentPage("nyomdagepekIndex");
		
		$dataProvider=new CActiveDataProvider('Nyomdagepek',
			Yii::app()->user->checkAccess('Admin') ? array('pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),)) : array( 'criteria'=>array('condition'=>"torolt = 0 ",), 'pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),))
		);
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionSetDefaultNyomdagep ()
	{
		if (isset($_POST['default_id'])) {
			$model = Nyomdagepek::model()->findByPk(array("id" => $_POST['default_id']));
			
			if ($model != null) {
				// LI : töröljük rekordról az 'alapertelmezett' flag-et (bár elvileg egyszerre csak 1-en lehet)
				$criteria = new CDbCriteria();
				$criteria->addCondition("alapertelmezett=1");
				$nyomdagepek = Nyomdagepek::model()->findAll($criteria, '');

				if (isset($nyomdagepek)) {
					foreach($nyomdagepek as $nyomdagep) {
						$nyomdagep -> alapertelmezett = 0;
						$nyomdagep -> save();
					}				
				}
				
				// LI : beállítjuk a kiválasztott nyomdagép rekordjához tartozó 'alapertelmezett' mezőt 1-re
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
		$model=new Nyomdagepek('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Nyomdagepek']))
			$model->attributes=$_GET['Nyomdagepek'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Nyomdagepek the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Nyomdagepek::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Nyomdagepek $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='nyomdagepek-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

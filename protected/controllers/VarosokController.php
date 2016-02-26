<?php

class VarosokController extends Controller
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
		$model=new Varosok;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Varosok']))
		{
			$model->attributes=$_POST['Varosok'];
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

		if(isset($_POST['Varosok']))
		{
			$model->attributes=$_POST['Varosok'];
			if($model->save())
				Utils::goToPrevPage("varosokIndex");
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
		Utils::saveCurrentPage("varosokIndex");
		
		$dataProvider=new CActiveDataProvider('Varosok',
			Yii::app()->user->checkAccess('Admin') ? array('pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),)) : array( 'criteria'=>array('condition'=>"torolt = 0 ",), 'pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),))
		);
				
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	// LI : irányítószámok  előregépeléséhez
	public function actionAutoCompleteZipCode(){
		$term = Yii::app()->request->getQuery('term');
		
		$match = addcslashes($term, '%_'); // escape LIKE's special characters
		$q = new CDbCriteria( array(
			'condition' => "iranyitoszam LIKE :term AND torolt = 0",
			'params'    => array(':term' => "$term%")
		) );
        $cities = Varosok::model()->findAll($q);

        $lists = array();
		
        foreach($cities as $city) {
            $lists[] = array(
                'id' => $city->id,
				'iranyitoszam' => $city->iranyitoszam,
                'varosnev' => $city->varosnev,
            );
        }
        echo json_encode($lists);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Varosok('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Varosok']))
			$model->attributes=$_GET['Varosok'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Varosok the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Varosok::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Varosok $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='varosok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

<?php

class NyomdaMuveletekController extends Controller
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
		$model=new NyomdaMuveletek;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['NyomdaMuveletek']))
		{
			$model->attributes=$_POST['NyomdaMuveletek'];
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

		if(isset($_POST['NyomdaMuveletek']))
		{
			$model->attributes=$_POST['NyomdaMuveletek'];
			if($model->save())
				Utils::goToPrevPage("nyomdaMuveletekIndex");
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
		Utils::saveCurrentPage("nyomdaMuveletekIndex");
		
		$dataProvider=new CActiveDataProvider('NyomdaMuveletek',
			Yii::app()->user->checkAccess('Admin') ? array('pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),)) : array( 'criteria'=>array('condition'=>"torolt = 0 ",), 'pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),))
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
		$model=new NyomdaMuveletek('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['NyomdaMuveletek']))
			$model->attributes=$_GET['NyomdaMuveletek'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return NyomdaMuveletek the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=NyomdaMuveletek::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param NyomdaMuveletek $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='nyomda-muveletek-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

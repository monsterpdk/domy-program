<?php

class TermekCsoportokController extends Controller
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
		$model=new Termekcsoportok;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Termekcsoportok']))
		{
			$model->attributes=$_POST['Termekcsoportok'];
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

		if(isset($_POST['Termekcsoportok']))
		{
			$model->attributes=$_POST['Termekcsoportok'];
			if($model->save())
				Utils::goToPrevPage("termekcsoportokIndex");
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	// termékcsoportok előregépelős beajánlásának keresője
	public function actionSearchTermekcsoportok ($term)
	{
		if(Yii::app()->request->isAjaxRequest && !empty($term))
        {
              $variants = array();
              $criteria = new CDbCriteria;
              $criteria->select='nev';
              $criteria->addSearchCondition('nev', $term.'%', false);
              $termekcsoportok = Termekcsoportok::model()->findAll($criteria);
			  
              if(!empty($termekcsoportok))
              {
                foreach($termekcsoportok as $termekcsoport)
                {
                    $variants[] = $termekcsoport->attributes['nev'];
                }
              }
              echo CJSON::encode($variants);
        }
        else
            throw new CHttpException(400,'Hibás kérés.');
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
		Utils::saveCurrentPage("termekcsoportokIndex");
		
		$dataProvider=new CActiveDataProvider('Termekcsoportok',
			Yii::app()->user->checkAccess('Admin') ? array('criteria'=>array('order'=>'nev DESC',), 'pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),)) : array('criteria'=>array('condition'=>"torolt = 0 ",'order'=>'nev DESC',), 'pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),))
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
		$model=new Termekcsoportok('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Termekcsoportok']))
			$model->attributes=$_GET['Termekcsoportok'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Termekcsoportok the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Termekcsoportok::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Termekcsoportok $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='termekcsoportok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

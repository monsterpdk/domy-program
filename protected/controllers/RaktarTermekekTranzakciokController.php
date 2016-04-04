<?php

class RaktarTermekekTranzakciokController extends Controller
{

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return RaktarTermekekTranzakciok the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=RaktarTermekekTranzakciok::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param RaktarTermekekTranzakciok $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='raktar-termekek-tranzakciok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

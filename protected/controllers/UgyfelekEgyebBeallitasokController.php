<?php

class UgyfelekEgyebBeallitasokController extends Controller
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
	
	public function actionIndex()
	{
		$model = new UgyfelekEgyebBeallitasokForm;
		
		$defaultTartozasiLimit = Yii::app()->config->get('alapertelmezettRendelesTartozasLimit');
		if ($defaultTartozasiLimit != null)
			$model -> alapertelmezettRendelesTartozasLimit = $defaultTartozasiLimit;
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'ugyfelek-egyeb-beallitasok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if (isset($_POST['UgyfelekEgyebBeallitasokForm']))
		{
			$model -> attributes=$_POST['UgyfelekEgyebBeallitasokForm'];
			
			// validate user input and redirect to the previous page if valid
			if ($model->validate())
				if ($model->save())
					$this->redirect(Yii::app()->user->returnUrl);
		}

		$this->render('_form', array('model'=>$model));
	}

}
<?php

class NyomtatoBeallitasokController extends Controller
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
		$model = new NyomtatoBeallitasokForm;
		
		$PdfBoxUrl = Yii::app()->config->get('PdfBoxUrl');
		
		if ($PdfBoxUrl != null)
			$model -> PdfBoxUrl = $PdfBoxUrl;
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'nyomtato-beallitasok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if (isset($_POST['NyomtatoBeallitasokForm']))
		{
			$model -> PdfBoxUrl = $_POST['NyomtatoBeallitasokForm']["PdfBoxUrl"] ;
						
			// validate user input and redirect to the previous page if valid
			if ($model->validate())
				if ($model->save())
					$this->redirect(Yii::app()->user->returnUrl);
		}

		$this->render('_form', array('model'=>$model));
	}

}
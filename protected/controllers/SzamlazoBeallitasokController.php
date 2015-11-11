<?php

class SzamlazoBeallitasokController extends Controller
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
		$model = new SzamlazoBeallitasokForm;
		
		$AlapertelmezettFizetesiMod = Yii::app()->config->get('AlapertelmezettFizetesiMod');
		$SzamlaImportPath = Yii::app()->config->get('SzamlaImportPath');
		$SzamlaImportVisszaigazolasPath = Yii::app()->config->get('SzamlaImportVisszaigazolasPath');
		
		if ($AlapertelmezettFizetesiMod != null)
			$model -> AlapertelmezettFizetesiMod = $AlapertelmezettFizetesiMod;
		if ($SzamlaImportPath != null)
			$model -> SzamlaImportPath = $SzamlaImportPath;
		if ($SzamlaImportVisszaigazolasPath != null)
			$model -> SzamlaImportVisszaigazolasPath = $SzamlaImportVisszaigazolasPath;
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'szamlazo-beallitasok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if (isset($_POST['SzamlazoBeallitasokForm']))
		{
//			$model -> attributes=$_POST['SzamlazoBeallitasokForm'];
			$model -> AlapertelmezettFizetesiMod = $_POST['SzamlazoBeallitasokForm']["AlapertelmezettFizetesiMod"] ;
			$model -> SzamlaImportPath = $_POST['SzamlazoBeallitasokForm']["SzamlaImportPath"] ;
			$model -> SzamlaImportVisszaigazolasPath = $_POST['SzamlazoBeallitasokForm']["SzamlaImportVisszaigazolasPath"] ;
						
			// validate user input and redirect to the previous page if valid
			if ($model->validate())
				if ($model->save())
					$this->redirect(Yii::app()->user->returnUrl);
		}

		$this->render('_form', array('model'=>$model));
	}

}
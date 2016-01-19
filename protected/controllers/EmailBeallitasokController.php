<?php

class EmailBeallitasokController extends Controller
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
		$model = new EmailBeallitasokForm;
		
		$ArajanlatKuldoEmail = Yii::app()->config->get('ArajanlatKuldoEmail');
		$ArajanlatKuldoHost = Yii::app()->config->get('ArajanlatKuldoHost');
		$ArajanlatKuldoPort = Yii::app()->config->get('ArajanlatKuldoPort');
		$ArajanlatKuldoTitkositas = Yii::app()->config->get('ArajanlatKuldoTitkositas');
		$ArajanlatKuldoSMTP = Yii::app()->config->get('ArajanlatKuldoSMTP');
		$ArajanlatKuldoSMTPUser = Yii::app()->config->get('ArajanlatKuldoSMTPUser');
		$ArajanlatKuldoSMTPPassword = Yii::app()->config->get('ArajanlatKuldoSMTPPassword');
		$ArajanlatKuldoFromName = Yii::app()->config->get('ArajanlatKuldoFromName');
		$ArajanlatKuldoAlapertelmezettSubject = Yii::app()->config->get('ArajanlatKuldoAlapertelmezettSubject');
		
		if ($ArajanlatKuldoEmail != null)
			$model -> ArajanlatKuldoEmail = $ArajanlatKuldoEmail;
		if ($ArajanlatKuldoHost != null)
			$model -> ArajanlatKuldoHost = $ArajanlatKuldoHost;
		if ($ArajanlatKuldoPort != null)
			$model -> ArajanlatKuldoPort = $ArajanlatKuldoPort;
		if ($ArajanlatKuldoTitkositas != null)
			$model -> ArajanlatKuldoTitkositas = $ArajanlatKuldoTitkositas;
		if ($ArajanlatKuldoSMTP != null)
			$model -> ArajanlatKuldoSMTP = $ArajanlatKuldoSMTP;
		if ($ArajanlatKuldoSMTPUser != null)
			$model -> ArajanlatKuldoSMTPUser = $ArajanlatKuldoSMTPUser;
		if ($ArajanlatKuldoSMTPPassword != null)
			$model -> ArajanlatKuldoSMTPPassword = $ArajanlatKuldoSMTPPassword;
		if ($ArajanlatKuldoFromName != null)
			$model -> ArajanlatKuldoFromName = $ArajanlatKuldoFromName;
		if ($ArajanlatKuldoAlapertelmezettSubject != null)
			$model -> ArajanlatKuldoAlapertelmezettSubject = $ArajanlatKuldoAlapertelmezettSubject;
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'szamlazo-beallitasok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if (isset($_POST['EmailBeallitasokForm']))
		{
//			$model -> attributes=$_POST['EmailBeallitasokForm'];
			$model -> ArajanlatKuldoEmail = $_POST['EmailBeallitasokForm']["ArajanlatKuldoEmail"] ;
			$model -> ArajanlatKuldoHost = $_POST['EmailBeallitasokForm']["ArajanlatKuldoHost"] ;
			$model -> ArajanlatKuldoPort = $_POST['EmailBeallitasokForm']["ArajanlatKuldoPort"] ;
			$model -> ArajanlatKuldoTitkositas = $_POST['EmailBeallitasokForm']["ArajanlatKuldoTitkositas"] ;
			$model -> ArajanlatKuldoSMTP = $_POST['EmailBeallitasokForm']["ArajanlatKuldoSMTP"] ;
			$model -> ArajanlatKuldoSMTPUser = $_POST['EmailBeallitasokForm']["ArajanlatKuldoSMTPUser"] ;
			$model -> ArajanlatKuldoSMTPPassword = $_POST['EmailBeallitasokForm']["ArajanlatKuldoSMTPPassword"] ;
			$model -> ArajanlatKuldoFromName = $_POST['EmailBeallitasokForm']["ArajanlatKuldoFromName"] ;
			$model -> ArajanlatKuldoAlapertelmezettSubject = $_POST['EmailBeallitasokForm']["ArajanlatKuldoAlapertelmezettSubject"] ;
						
			// validate user input and redirect to the previous page if valid
			if ($model->validate())
				if ($model->save())
					$this->redirect(Yii::app()->user->returnUrl);
		}

		$this->render('_form', array('model'=>$model));
	}

}
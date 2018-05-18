<?php

class NyomdakonyvBeallitasokController extends Controller
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
		$model = new NyomdakonyvBeallitasokForm;
		
		$NyomDbfPath = Yii::app()->config->get('NyomDbfPath');
		$WorkflowDbfPath = Yii::app()->config->get('WorkflowDbfPath');
		$MunkataskaXmlExportPath = Yii::app()->config->get('MunkataskaXmlExportPath');
		$NyomdakonyvPicEmailText = Yii::app()->config->get('NyomdakonyvPicEmailText');
		
		if ($NyomDbfPath != null)
			$model -> NyomDbfPath = $NyomDbfPath;
		
		if ($WorkflowDbfPath != null)
			$model -> WorkflowDbfPath = $WorkflowDbfPath;
		
		if ($MunkataskaXmlExportPath != null)
			$model -> MunkataskaXmlExportPath = $MunkataskaXmlExportPath;
		
		if ($NyomdakonyvPicEmailText != null)
			$model -> NyomdakonyvPicEmailText = $NyomdakonyvPicEmailText;
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'Nyomdakonyv-beallitasok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if (isset($_POST['NyomdakonyvBeallitasokForm']))
		{
//			$model -> attributes=$_POST['NyomdakonyvBeallitasokForm'];
			$model -> NyomDbfPath = $_POST['NyomdakonyvBeallitasokForm']["NyomDbfPath"] ;
			$model -> WorkflowDbfPath = $_POST['NyomdakonyvBeallitasokForm']["WorkflowDbfPath"] ;
			$model -> MunkataskaXmlExportPath = $_POST['NyomdakonyvBeallitasokForm']["MunkataskaXmlExportPath"] ;
			$model -> NyomdakonyvPicEmailText = $_POST['NyomdakonyvBeallitasokForm']["NyomdakonyvPicEmailText"] ;

			// validate user input and redirect to the previous page if valid
			if ($model->validate())
				if ($model->save())
					$this->redirect(Yii::app()->user->returnUrl);
		}

		$this->render('_form', array('model'=>$model));
	}

}
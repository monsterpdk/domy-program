<?php

class AltalanosBeallitasokController extends Controller
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
		$model = new AltalanosBeallitasokForm;
		
		$IndexViewPagination = Yii::app()->config->get('IndexViewPagination');
		
		if ($IndexViewPagination != null)
			$model -> IndexViewPagination = $IndexViewPagination;
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'altalanos-beallitasok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if (isset($_POST['AltalanosBeallitasokForm']))
		{
			$model -> IndexViewPagination = $_POST['AltalanosBeallitasokForm']["IndexViewPagination"] ;
						
			// validate user input and redirect to the previous page if valid
			if ($model->validate())
				if ($model->save())
					$this->redirect(Yii::app()->user->returnUrl);
		}

		$this->render('_form', array('model'=>$model));
	}

}
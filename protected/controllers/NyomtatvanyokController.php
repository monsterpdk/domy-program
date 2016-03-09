<?php

class NyomtatvanyokController extends Controller
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
		$model = new NyomtatvanyokForm;
		
		$AnyagBeszallitasokAtveteli = 	Yii::app()->config->get('AnyagBeszallitasokAtveteli');
		$AnyagBeszallitasokRaktar = 	Yii::app()->config->get('AnyagBeszallitasokRaktar');
		$AnyagrendelesekArNelkul = 		Yii::app()->config->get('AnyagrendelesekArNelkul');
		$AnyagrendelesekArral = 		Yii::app()->config->get('AnyagrendelesekArral');
		$Arajanlat = 					Yii::app()->config->get('Arajanlat');
		$MegrendelesekProforma = 		Yii::app()->config->get('MegrendelesekProforma');
		$MegrendelesekVisszaigazolas = 	Yii::app()->config->get('MegrendelesekVisszaigazolas');
		$NyomdakonyvCtp = 				Yii::app()->config->get('NyomdakonyvCtp');
		$NyomdakonyvMunkataska = 		Yii::app()->config->get('NyomdakonyvMunkataska');
		$NyomdakonyvUtemezes = 			Yii::app()->config->get('NyomdakonyvUtemezes');
		$Szallitolevel = 				Yii::app()->config->get('Szallitolevel');
		
		if ($AnyagBeszallitasokAtveteli != null) $model -> AnyagBeszallitasokAtveteli = $AnyagBeszallitasokAtveteli;
		if ($AnyagBeszallitasokRaktar != null) $model -> AnyagBeszallitasokRaktar = $AnyagBeszallitasokRaktar;
		if ($AnyagrendelesekArNelkul != null) $model -> AnyagrendelesekArNelkul = $AnyagrendelesekArNelkul;
		if ($AnyagrendelesekArral != null) $model -> AnyagrendelesekArral = $AnyagrendelesekArral;
		if ($Arajanlat != null) $model -> Arajanlat = $Arajanlat;
		if ($MegrendelesekProforma != null) $model -> MegrendelesekProforma = $MegrendelesekProforma;
		if ($MegrendelesekVisszaigazolas != null) $model -> MegrendelesekVisszaigazolas = $MegrendelesekVisszaigazolas;
		if ($NyomdakonyvCtp != null) $model -> NyomdakonyvCtp = $NyomdakonyvCtp;
		if ($NyomdakonyvMunkataska != null) $model -> NyomdakonyvMunkataska = $NyomdakonyvMunkataska;
		if ($NyomdakonyvUtemezes != null) $model -> NyomdakonyvUtemezes = $NyomdakonyvUtemezes;
		if ($Szallitolevel != null) $model -> Szallitolevel = $Szallitolevel;
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'nyomtatvanyok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if (isset($_POST['NyomtatvanyokForm']))
		{
			$model -> AnyagBeszallitasokAtveteli = $_POST['NyomtatvanyokForm']["AnyagBeszallitasokAtveteli"] ;
			$model -> AnyagBeszallitasokRaktar = $_POST['NyomtatvanyokForm']["AnyagBeszallitasokRaktar"] ;
			$model -> AnyagrendelesekArNelkul = $_POST['NyomtatvanyokForm']["AnyagrendelesekArNelkul"] ;
			$model -> AnyagrendelesekArral = $_POST['NyomtatvanyokForm']["AnyagrendelesekArral"] ;
			$model -> Arajanlat = $_POST['NyomtatvanyokForm']["Arajanlat"] ;
			$model -> MegrendelesekProforma = $_POST['NyomtatvanyokForm']["MegrendelesekProforma"] ;
			$model -> MegrendelesekVisszaigazolas = $_POST['NyomtatvanyokForm']["MegrendelesekVisszaigazolas"] ;
			$model -> NyomdakonyvCtp = $_POST['NyomtatvanyokForm']["NyomdakonyvCtp"] ;
			$model -> NyomdakonyvMunkataska = $_POST['NyomtatvanyokForm']["NyomdakonyvMunkataska"] ;
			$model -> NyomdakonyvUtemezes = $_POST['NyomtatvanyokForm']["NyomdakonyvUtemezes"] ;
			$model -> Szallitolevel = $_POST['NyomtatvanyokForm']["Szallitolevel"] ;
						
			// validate user input and redirect to the previous page if valid
			if ($model->validate())
				if ($model->save())
					$this->redirect(Yii::app()->user->returnUrl);
		}

		$this->render('_form', array('model'=>$model));
	}

}
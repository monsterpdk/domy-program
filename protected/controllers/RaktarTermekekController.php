<?php

class RaktarTermekekController extends Controller
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
		$dataProvider=new CActiveDataProvider('RaktarTermekek', array());
				
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),)
		));
	}

	public function actionPrintRaktarkeszlet()
	{
		$dataProvider=new CActiveDataProvider('RaktarTermekek', array());
		if ($dataProvider != null) {			
			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();
	
			$mPDF1->SetHtmlHeader("Raktárkészlet");
			
			# render
			$mPDF1->WriteHTML($this->renderPartial("printRaktarkeszlet", array('dataProvider' => $dataProvider), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
		}		
	}	
	
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
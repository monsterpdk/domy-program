<?php

class StatisztikakController extends Controller
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
	
	public function getArajanlatStatisztika($mettol = "", $meddig = "") {
		if ($mettol == "") {
			$mettol = date("Y-m-d") ;	
		}
		if ($meddig == "") {
			$meddig = date("Y-m-d") ;	
		}
		$dataProvider=new CActiveDataProvider('Arajanlatok', array(
			'criteria'=>array(
				'condition'=>'t.torolt=0 and t.sztornozva=0 and t.ajanlat_datum>=\'' . $mettol . '\' and t.ajalnlat_datum <= \'' . $meddig . '\'',
				'order'=>'ugyfel_id',
				'with'=>array('arajanlat_tetel', 'ugyfel'),
			),
			'countCriteria'=>array(
				'condition'=>'t.torolt=0 and t.sztornozva=0 and t.ajanlat_datum>=\'' . $mettol . '\' and t.ajalnlat_datum <= \'' . $meddig . '\'',
				// 'order' and 'with' clauses have no meaning for the count query
			),
			'sort'=> false,
		));		
		return $dataProvider ;
	}
	
	public function actionNapiKombinaltStatisztika()
	{
		$arajanlatStatisztika_1 = $this->getArajanlatStatisztika() ;
		$this->render('napiKombinaltStatisztika',array(
			'arajanlatStatisztika_1'=>$arajanlatStatisztika_1,
		));		
	}

}
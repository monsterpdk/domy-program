<?php

class ArajanlatokController extends Controller
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Arajanlatok;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Arajanlatok']))
		{
			$model->attributes=$_POST['Arajanlatok'];
			if($model->save())
				$this->redirect(array('index'));
		} else {
			// LI : új árajánlat létrehozásánál beállítjuk az alapértelmezettnek beállított ÁFA kulcsot
			$afaKulcs = AfaKulcsok::model()->findByAttributes(array('alapertelmezett'=> 1));

			if ($afaKulcs != null) {
				$model -> afakulcs_id = $afaKulcs -> id;
			}
			
			$model->ajanlat_datum = date('Y-m-d');
			
			// megkeressük a legutóbb felvett árajánlatot és az ID-jához egyet hozzáadva beajánljuk az újonnan létrejött sorszámának
			// formátum: AJ0001, ahol 0001 a rekord ID-ja 4 jeggyel reprezentálva, balról 0-ákkal feltöltve
			$criteria = new CDbCriteria;
			$criteria->select = 'max(id) AS id';
			$row = Arajanlatok::model() -> find ($criteria);
			$utolsoArajanlat = $row['id'];

			$model -> sorszam = "AJ" . str_pad( ($utolsoArajanlat != null) ? ($utolsoArajanlat + 1) : "0001", 4, '0', STR_PAD_LEFT );
				
			$model -> save(false);
			$this -> redirect(array('update', 'id'=>$model -> id,));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if ($model -> van_megrendeles == 1 && !Yii::app()->user->checkAccess("Admin"))
		{
			throw new CHttpException(403, "Hozzáférés megtagadva!, nincs jogosultsága a kért lap megtekintéséhez.");
		}			
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Arajanlatok']))
		{
			$model->attributes=$_POST['Arajanlatok'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		// logikai törlést alkalmazunk, 'torolt' mező értékét állítjuk 1-re
		$model=$this->loadModel($id);
		
		$model->torolt = 1;
		$model->save(false);

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Arajanlatok',
			Yii::app()->user->checkAccess('Admin') ? array('criteria'=>array('order'=>"ajanlat_datum DESC",),) : array('criteria'=>array('condition'=>"torolt = 0 ",'order'=>"ajanlat_datum DESC",),)
		);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));

	}

	public function actionPrintPDF()
	{
		if (isset($_GET['id'])) {
			$model = $this -> loadModel($_GET['id']);
		}
		
		if ($model != null) {
			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();

			$mPDF1->SetHtmlHeader("Árajánlat #" . $model->sorszam);
			
			# render
			$mPDF1->WriteHTML($this->renderPartial("printArajanlat", array('model' => $model), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
		}
		
	}
	
	/*
		Egy paraméterben kapott árajánlathoz adjuk vissza a tételeit tartalmazó GridView-t HTML-ben
	*/
	public function actionGetTetelList ($arajanlat_id, $grid_id)
	{
		$model = Arajanlatok::model()->findByPk ($arajanlat_id);
		
		if ($model != null) {
			Yii::app()->clientScript->scriptMap['*.css'] = false;
			Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery.yiigridview.js'] = false;
			
			$this->renderPartial('_selectTetel', array ('model'=>$model, 'arajanlat_id'=>$arajanlat_id, 'grid_id'=>$grid_id), false, true);
			exit;
		}
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Arajanlatok('search');
		$model->unsetAttributes();  // clear any default values
		
		if (isset($_GET['Arajanlatok']))
			$model->attributes=$_GET['Arajanlatok'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Az előregépelős ügyfélkiválasztóhoz kell.
	 */
	public function actionAutoCompleteUgyfel ()
	{
		$arr = array();
		if ($_GET['term']) {
			$match = addcslashes($_GET['term'], '%_');
			$q = new CDbCriteria( array(
				'condition' => "cegnev LIKE :match",
				'params'    => array(':match' => "%$match%")
			) );
			 
			$ugyfelek = Ugyfelek::model()->findAll( $q );

			foreach($ugyfelek as $ugyfel) {
				$arr[] = array(
					'label'=>$ugyfel->cegnev,
					'value'=>$ugyfel->cegnev,
					'tel'=>$ugyfel->ceg_telefon,
					'fax'=>$ugyfel->ceg_fax,
					'cim'=>$ugyfel->display_ugyfel_cim,
					'cimzett'=>$ugyfel->display_ugyfel_ugyintezok,
					'adoszam'=>$ugyfel->adoszam,
					'fizetesi_moral'=>$ugyfel->fizetesi_moral,
					'max_fizetesi_keses'=>$ugyfel->max_fizetesi_keses,
					'atlagos_fizetesi_keses'=>$ugyfel->atlagos_fizetesi_keses,
					'rendelesi_tartozas_limit'=>$ugyfel->rendelesi_tartozasi_limit,
					'fontos_megjegyzes'=>$ugyfel->fontos_megjegyzes,
					'id'=>$ugyfel->id,
					);      
			}
		}
		echo CJSON::encode($arr);
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Arajanlatok the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Arajanlatok::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Arajanlatok $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='arajanlatok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

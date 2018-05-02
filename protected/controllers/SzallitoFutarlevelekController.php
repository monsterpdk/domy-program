<?php

class SzallitoFutarlevelekController extends Controller
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
		$model=new SzallitoFutarlevelek;
		$aruk = new CActiveDataProvider('SzallitoFutarlevelTetelek', array('data' => array()));
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SzallitoFutarlevelek']))
		{
			$tetel_sorok_uj = $_POST["SzallitoFutarlevelTetelek"] ;

			$model -> attributes = $_POST['SzallitoFutarlevelek'];
			$model -> szallito_futar = $_POST["szallito_futar"] ;
			if($model->save()) {
				if (count($tetel_sorok_uj["megnevezes"]) > 0) {
					for ($i=0; $i < count($tetel_sorok_uj["megnevezes"]); $i++) {
						if ($tetel_sorok_uj["megnevezes"][$i] != "") {
							$tetel = new SzallitoFutarlevelTetelek;
							$tetel->futarlevel_id = $model->id;
							$tetel->megnevezes = $tetel_sorok_uj["megnevezes"][$i];
							$tetel->darab = intval($tetel_sorok_uj["darab"][$i]);
							$tetel->megjegyzes = $tetel_sorok_uj["megjegyzes"][$i];
							$tetel->save(false);
						}
					}
				}
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'aruk'=>$aruk,
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

		$aruk=new CActiveDataProvider('SzallitoFutarlevelTetelek', array(
			'criteria'=>array(
				'condition'=>'futarlevel_id = ' . $id . ' and t.torolt=0',
				'order'=>'megnevezes',
			),
			'countCriteria'=>array(
				'condition'=>'futarlevel_id = ' . $id . ' and t.torolt=0',
			),
			'sort'=> false,	));


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SzallitoFutarlevelek']))
		{
			$tetel_sorok_regi = $_POST["dom_szallitas_futarlevel_tetelek"] ;
			$tetel_sorok_uj = $_POST["SzallitoFutarlevelTetelek"] ;

			$model -> attributes = $_POST['SzallitoFutarlevelek'];
			$model -> szallito_futar = $_POST["szallito_futar"] ;

			if (count($tetel_sorok_regi) > 0) {
				$sor = $tetel_sorok_regi ;
				for ($i=0; $i < count($sor["id"]); $i++) {
					$tetel = SzallitoFutarlevelTetelek::model()->findByPk($sor["id"][$i]);
					$tetel->megnevezes = $sor["megnevezes"][$i];
					$tetel->darab = intval($sor["darab"][$i]);
					$tetel->megjegyzes = $sor["megjegyzes"][$i];
					$tetel->torolt = $sor["torolt"][$i];
					$tetel->save(false);
				}
			}

			if (count($tetel_sorok_uj["megnevezes"]) > 0) {
				for ($i=0; $i < count($tetel_sorok_uj["megnevezes"]); $i++) {
					if ($tetel_sorok_uj["megnevezes"][$i] != "") {
						$tetel = new SzallitoFutarlevelTetelek;
						$tetel->futarlevel_id = $id;
						$tetel->megnevezes = $tetel_sorok_uj["megnevezes"][$i];
						$tetel->darab = intval($tetel_sorok_uj["darab"][$i]);
						$tetel->megjegyzes = $tetel_sorok_uj["megjegyzes"][$i];
						$tetel->save(false);
					}
				}
			}

			if (!$model -> save(true)) {
				$this->render('update',array(
					'model' => $model,
					'aruk' => $aruk,
				));
				
				return;
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'aruk'=>$aruk,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		Utils::saveCurrentPage("szallitofuvarlevelekIndex");
		
		$dataProvider=new CActiveDataProvider('SzallitoFutarlevelek', array('criteria'=>array('order'=>"felvetel_ideje DESC",), 'pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),)));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionPrintPDF()
	{
		if (isset($_GET['id'])) {
			$model = $this->loadModel($_GET['id']);
		}
		
		if ($model != null) {

			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();

			$mPDF1->SetHtmlHeader("Futárlevél #" . $model->szamla_sorszam);
			
			# render
			$mPDF1->WriteHTML($this->renderPartial("printFutarlevel", array('model' => $model), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
		}
	}
	

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SzallitoFutarlevelek('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SzallitoFutarlevelek']))
			$model->attributes=$_GET['SzallitoFutarlevelek'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Anyagbeszallitasok the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SzallitoFutarlevelek::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Anyagbeszallitasok $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='szallito-futarlevelek-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

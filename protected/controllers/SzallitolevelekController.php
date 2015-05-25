<?php

class SzallitolevelekController extends Controller
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
		$model=new Szallitolevelek;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['szallitolevelek']))
		{
			$model->attributes=$_POST['szallitolevelek'];
			if($model->save())
				$this->redirect(array('index'));
		} else {
			$model->datum = date('Y-m-d');
			
			// megkeressük a legutóbb felvett megrendelést és az ID-jához egyet hozzáadva beajánljuk az újonnan létrejött sorszámának
			// formátum: RE2015000001, ahol az évszám után 000001 a rekord ID-ja 6 jeggyel reprezentálva, balról 0-ákkal feltöltve
			$criteria = new CDbCriteria;
			$criteria->select = 'max(id) AS id';
			$row = Szallitolevelek::model() -> find ($criteria);
			$utolsoSzallitolevel = $row['id'];

			$model -> sorszam = "SZ" . date("Y") . str_pad( ($utolsoSzallitolevel != null) ? ($utolsoSzallitolevel + 1) : "000001", 6, '0', STR_PAD_LEFT );
			
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
//
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
		$model->save();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Szallitolevelek',
			Yii::app()->user->checkAccess('Admin') ? array('criteria'=>array('order'=>"datum DESC",),) : array( 'criteria'=>array('condition'=>"torolt = 0 ",),)
		);
				
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));

	}

	public function actionPrintPDF()
	{
		/*
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
		*/
	}	
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Szallitolevelek('search');
		$model->unsetAttributes();  // clear any default values
		
		if (isset($_GET['Szallitolevelek']))
			$model->attributes=$_GET['Szallitolevelek'];

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
	 * Árajánlatról indított megrendelés létrehozása.
	 * Létrehozás után rámentjük az árajánlat megfelelő mezőit ill. a
	 * hozzá tartozó tételeket.
	 */
	public function actionCreateFromArajanlat ()
	{
		if ( isset($_POST['arajanlat_id']) && isset($_POST['selected_tetel_list']) ) {
			$arajanlat_id = $_POST['arajanlat_id'];
			$selected_tetels = $_POST['selected_tetel_list'];
			
			$selected_tetel_list = array ();
			if (strlen($selected_tetels) > 0) {
				$selected_tetel_list = explode (',', $selected_tetels);
			}

			$arajanlat = Arajanlatok::model() -> with('tetelek') -> findByPk ($arajanlat_id);
			$Szallitolevel = new Szallitolevelek;
			
			if ( Utils::reachedUgyfelLimit ($arajanlat->id) )
			{
				throw new CHttpException(403, "Elérte az ügyfélhez tartozó rendelési limitet., így nincs jogosultsága a funkció használatához!");
			}
			
			// megkeressük a legutóbb felvett megrendelést és az ID-jához egyet hozzáadva beajánljuk az újonnan létrejött sorszámának
			// formátum: RE0001, ahol 0001 a rekord ID-ja 4 jeggyel reprezentálva, balról 0-ákkal feltöltve
			$criteria = new CDbCriteria;
			$criteria->select = 'max(id) AS id';
			$row = Szallitolevelek::model() -> find ($criteria);
			$utolsoSzallitolevel = $row['id'];

			$Szallitolevel -> sorszam = "MR" . str_pad( ($utolsoSzallitolevel != null) ? ($utolsoSzallitolevel + 1) : "0001", 4, '0', STR_PAD_LEFT );
			
			// alapadatok átvétele
			$Szallitolevel -> ugyfel_id = $arajanlat -> ugyfel_id;
			$Szallitolevel -> cimzett = $arajanlat -> cimzett;
			$Szallitolevel -> arkategoria_id = $arajanlat -> arkategoria_id;
			$Szallitolevel -> afakulcs_id = $arajanlat -> afakulcs_id;
			$Szallitolevel -> ugyfel_tel = $arajanlat -> ugyfel_tel;
			$Szallitolevel -> ugyfel_fax = $arajanlat -> ugyfel_fax;
			$Szallitolevel -> visszahivas_jegyzet = $arajanlat -> visszahivas_jegyzet;
			$Szallitolevel -> jegyzet = $arajanlat -> jegyzet;
			$Szallitolevel -> reklamszoveg = $arajanlat -> reklamszoveg;
			$Szallitolevel -> egyeb_megjegyzes = $arajanlat -> egyeb_megjegyzes;

			$Szallitolevel -> arajanlat_id = $arajanlat -> id;
			$Szallitolevel -> rendelest_rogzito_user_id = Yii::app()->user->getId();
			$Szallitolevel -> rendeles_idopont = date('Y-m-d');

			// elmentjük a modelt, hogy legyen model id a kezünkben
			$Szallitolevel -> save(false);

			// az árajánlatnál beállítjuk, hogy van már hozzá megrendelés
			$arajanlat -> van_Szallitolevel = 1;
			$arajanlat -> save(false);
			
			// az árajánlathoz felvett termékek átmásolása az újonnan létrejövő megrendelésre
			// ha volt kiválasztva valami a léterhozás előtt, akkor csak azokat visszük ár,
			// egyébként az összeset
			foreach ($arajanlat -> tetelek as $termek) {
				if ( empty($selected_tetel_list) || (in_array($termek -> id, $selected_tetel_list)) ) {
					$Szallitolevel_tetel = new SzallitolevelTetelek;
					$Szallitolevel_tetel -> Szallitolevel_id = $Szallitolevel -> id;
					$Szallitolevel_tetel -> termek_id = $termek -> termek_id;
					$Szallitolevel_tetel -> szinek_szama1 = $termek -> szinek_szama1;
					$Szallitolevel_tetel -> szinek_szama2 = $termek -> szinek_szama2;
					$Szallitolevel_tetel -> darabszam = $termek -> darabszam;
					$Szallitolevel_tetel -> netto_darabar = $termek -> netto_darabar;
					$Szallitolevel_tetel -> megjegyzes = $termek -> megjegyzes;
					$Szallitolevel_tetel -> mutacio = $termek -> mutacio;
					$Szallitolevel_tetel -> hozott_boritek = $termek -> hozott_boritek;
					$Szallitolevel_tetel -> egyedi_ar = $termek -> egyedi_ar;

					// az árajánlatból létrehozott tételeket külön jelezzük, mert azoknak az adatai nem szerkeszthettők többé
					$Szallitolevel_tetel -> arajanlatbol_letrehozva = 1;
	
					
					$Szallitolevel_tetel ->save (false);
				}
			}
			
			// frissítjük az egyedi ár flag-et a megrendelésen
			Utils::isEgyediArSzallitolevelArajanlat ($Szallitolevel -> id, true);

			$this->redirect(array('Szallitolevelek/update', 'id' => $Szallitolevel -> id,));
		}
	}

	/**
	 * Megrendelés sztornózása.
	 */
	public function actionStorno ()
	{
		if ( isset($_POST['Szallitolevel_id']) ) {
			$model_id = $_POST['Szallitolevel_id'];
			$storno_ok = isset($_POST['selected_storno']) ? $_POST['selected_storno'] : '';
			
			$Szallitolevel = Szallitolevelek::model() -> findByPk ($model_id);

			if ($Szallitolevel != null) {
				$Szallitolevel -> sztornozas_oka = $storno_ok;
				$Szallitolevel -> sztornozva = 1;
				
				$Szallitolevel -> save(false);
			}
		}
		
		$this->redirect(array('Szallitolevelek/index'));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Szallitolevelek the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Szallitolevelek::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Szallitolevelek $model the model to be validated
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

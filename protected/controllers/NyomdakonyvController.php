<?php

class NyomdakonyvController extends Controller
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
	 /*
	public function actionCreate()
	{
		$model=new Nyomdakonyv;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Nyomdakonyv']))
		{
			$model->attributes=$_POST['Nyomdakonyv'];
 
            $uploadedFile=CUploadedFile::getInstance($model,'kep_file_nev');
            $fileName = "{$uploadedFile}";
            $model->kep_file_nev = $fileName;
			
			if($model->save()) {
				// sikeres validáció/mentés esetén lementjük a betallózott fájlt is
				$uploadedFile->saveAs(Yii::app()->basePath . '/../uploads/' . $model->id . '/' . $fileName);
				
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
*/

	public function actionKezi_jelentes_ment($id) {
		$model = $this->loadModel($id);
		if (isset($_POST["Nyomdakonyv"])) {
			$eredmenyek = $_POST["Nyomdakonyv"] ;
			$model->kesz_jo = $eredmenyek["kesz_jo"] ;
			$model->kesz_selejt = $eredmenyek["kesz_selejt"] ;
			$model->kesz_visszazu = $eredmenyek["kesz_visszazu"] ;
			if($model->save()) {
				$this->redirect(array('nyomdakonyv/update/' . $id));				
			}
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Nyomdakonyv']))
		{
			$model->attributes=$_POST['Nyomdakonyv'];
            $uploadedFile = CUploadedFile::getInstance($model,'kep_file_nev');

			if (!empty($uploadedFile)) {
				$model->kep_file_nev = $uploadedFile->name;
			}
			
			if($model->save()) {
				// szükség esetén firssítjük az űrlapon a csatolt képet
				if(!empty($uploadedFile))
                {
					// ha nem létezik még a nyomdakönyvhöz tartozó upload könyvtár, akkor létrehozzuk
					$nyomdakonyv_upload_folder = Yii::app()->basePath . '/../uploads/nyomdakonyv/' . $model->id;
					if(!is_dir($nyomdakonyv_upload_folder)) {
						//echo $nyomdakonyv_upload_folder; die();
						mkdir ($nyomdakonyv_upload_folder, 0777, true);
					}
					
                    $uploadedFile->saveAs(Yii::app()->basePath . '/../uploads/nyomdakonyv/' . $model->id. '/' .$uploadedFile->name);
                }
				$this->redirect(array('index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Nyomdakönyv sztornózása.
	 */
	public function actionStorno ()
	{
		if ( isset($_POST['nyomdakonyv_id']) ) {
			$model_id = $_POST['nyomdakonyv_id'];
			$storno_ok = isset($_POST['selected_storno']) ? $_POST['selected_storno'] : '';
			
			$nyomdakonyv = Nyomdakonyv::model() -> findByPk ($model_id);

			if ($nyomdakonyv != null) {
				$nyomdakonyv -> sztornozas_oka = $storno_ok;
				$nyomdakonyv -> sztornozva = 1;
				
				$nyomdakonyv -> save(false);
			}
		}
		
		$this->redirect(array('nyomdakonyv/index'));
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
		$model=new Nyomdakonyv('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Nyomdakonyv']))
			$model->attributes=$_GET['Nyomdakonyv'];
		
		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Nyomdakonyv('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Nyomdakonyv']))
			$model->attributes=$_GET['Nyomdakonyv'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Visszaadja egy megrendelt termékhez és géphez kalkulált normaadatokat.
	 */
	public function actionNormaSzamitas($termekId, $gepId, $munkatipusId, $maxFordulat) {
		$status = 'failure';
		$normaido = 0;
		$normaar = 0;
		
		$normaAdatok = Utils::getNormaadat($termekId, $gepId, $munkatipusId, $maxFordulat);
		if ($normaAdatok != null) {
			$status = 'success';
			$normaido = $normaAdatok['normaido'];
			$normaar = $normaAdatok['normaar'];
		}
		
		echo CJSON::encode(array(
			'status' => $status,
			'normaido' => $normaido,
			'normaar'=> $normaar
		));
	}

	// Táska/CTP-s táska PDF-et előállító action.
	public function actionPrintTaska()
	{
		if (isset($_GET['id'])) {
			$model = $this -> loadModel($_GET['id']);
		}
		
		// ha nem CTP-s a munkatáska, akkor 'simát' nyomtatunk
		$pdfTemplateName = (isset($_GET['isCtp']) && ($_GET['isCtp'] == 1) ) ? 'printCtpTaska' : 'printTaska';
		
		if ($model != null) {
			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();

			$mPDF1->SetHtmlHeader("Munkatáska #" . $model->taskaszam);
			
			# render
			$mPDF1->WriteHTML($this->renderPartial($pdfTemplateName, array('model' => $model), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
		}
		
	}
	
	// Meghívja a géptermi program adatbázisát, megnézi, hogy ehhez a munkához van-e már benne bejegyzés, ha nincs, akkor létrehozza, ha van, akkor pedig visszaadja az ott rögzített két olyan mezőt, ami kell nekünk: keszido (elkészülés dátum), keszsec (elkészülés idő - óra, perc)
	public function actionGepteremHivas($munka_id) {
//		$nyom_dbf_url = rawurlencode("C:\inetpub\wwwroot\domyweb/gepterem_komm/gepterem/NYOM.dbf") ;
//		$workflow_dbf_url = rawurlencode("C:\inetpub\wwwroot\domyweb/gepterem_komm/gepterem/workflow.dbf") ;
		$nyom_dbf_url = rawurlencode(Yii::app()->config->get('NyomDbfPath'));
		$workflow_dbf_url = rawurlencode(Yii::app()->config->get('WorkflowDbfPath'));
		
		$model = $this -> loadModel($munka_id) ;		
		$megrendeles_tetel = MegrendelesTetelek::model()->with('termek')->findByPk($model->megrendeles_tetel_id);
//		print_r($megrendeles_tetel) ;
			
		$parameters = array() ;
		$parameters[] = array("field"=>"TSZAM", "value"=>rawurlencode($model->taskaszam), "op"=>"=") ;
		$query_url = "http://" . $_SERVER["HTTP_HOST"] . "/gepterem_komm/dbfcomm.php?mode=select&dbf=" . $nyom_dbf_url . "&filter=" . json_encode($parameters) ;
		$result = unserialize(Utils::httpGet($query_url)) ;
		if (count($result) == 0) {
			//Hozzáadjuk a nyom.dbf-hez az új rekordot
			$criteria=new CDBCriteria;
			$criteria->select= 'cegnev, cegnev_teljes';
			$criteria->join= 'join dom_megrendelesek on (t.id = dom_megrendelesek.ugyfel_id) join dom_megrendeles_tetelek on (dom_megrendelesek.id = dom_megrendeles_tetelek.megrendeles_id)' ;
			$criteria->addCondition("dom_megrendeles_tetelek.id = :megrendeles_tetel_id") ;
			$criteria->params = array(':megrendeles_tetel_id' => $model->megrendeles_tetel_id) ;
			$ugyfel_adatok = Ugyfelek::model()->find($criteria) ;
			$ugyfel_nev = $ugyfel_adatok->cegnev ;
			if ($ugyfel_adatok->cegnev_teljes != "") {
				$ugyfel_nev = $ugyfel_adatok->cegnev_teljes ;
			}
			$szin_c = $model->szin_c_elo + $model->szin_c_hat ;
			if ($szin_c > 0) {
				$szin_c = "TRUE" ;  
			}
			else
			{
				$szin_c = "0" ;  
			}
			$szin_m = $model->szin_m_elo + $model->szin_m_hat ;
			if ($szin_m > 0) {
				$szin_m = "TRUE" ;  
			}
			else
			{
				$szin_m = "0" ;  
			}
			$szin_y = $model->szin_y_elo + $model->szin_y_hat ;
			if ($szin_y > 0) {
				$szin_y = "TRUE" ;  
			}
			else
			{
				$szin_y = "0" ;  
			}
			$szin_k = $model->szin_k_elo + $model->szin_k_hat ;
			if ($szin_k > 0) {
				$szin_k = "TRUE" ;  
			}
			else
			{
				$szin_k = "0" ;  
			}
			$mutacio = "0" ;
			if ($model->szin_mutaciok > 0) {
				$mutacio = "TRUE" ;	
			}
			$forditott_levezetes = "0" ;
			if ($model->forditott_levezetes > 0) {
				$forditott_levezetes = "TRUE" ;	
			}
			$ctp = "0" ;
			if ($model->ctp > 0) {
				$ctp = "TRUE" ;	
			}	
			$kifutos = "0" ;
			if ($model->kifutos > 0) {
				$kifutos = "TRUE" ;	
			}				
			
			$parameters = array() ;
			$nyomasi_kategoria = Utils::NyomasiKategoriaSzamol($model->megrendeles_tetel->displayTermekSzinekSzama, $model->megrendeles_tetel->darabszam, $megrendeles_tetel->termek->tipus,$model->kifutos) ; 
			$parameters[] = array("TSZAM"=>rawurlencode($model->taskaszam),
								  "CEGNEV"=>rawurlencode($ugyfel_nev),
								  "MUNEV"=>rawurlencode(mb_strtoupper($model->megrendeles_tetel->munka_neve, "UTF-8")),
								  "NEV"=>rawurlencode($model->megrendeles_tetel->termek->displayTermekTeljesNev),
								  "DARAB"=>$model->megrendeles_tetel->darabszam,
								  "SZIN"=>rawurlencode($model->megrendeles_tetel->displayTermekSzinekSzama),
								  "PANTON"=>rawurlencode($model->pantone),
								  "TASKKI"=>date("Y-m-d", strtotime($model->taska_kiadasi_datum)),
								  "TASKKISE"=>rawurlencode(date("H,i", strtotime($model->taska_kiadasi_datum))),
								  "GEP"=>$model->gep_id,
								  "LEMEZ"=>$model->szin_c_elo + $model->szin_m_elo + $model->szin_y_elo + $model->szin_k_elo + $model->szin_c_hat + $model->szin_m_hat + $model->szin_y_hat + $model->szin_k_hat,
								  "DOMYFILM"=>"0",
								  "NYOMKAT"=>$nyomasi_kategoria,
								  "NYOMKATU"=>$nyomasi_kategoria,
								  "C"=>$szin_c,
								  "M"=>$szin_m,
								  "Y"=>$szin_y,
								  "K"=>$szin_k,
								  "MUTACIO"=>$mutacio,
								  "MUTSZIN"=>$model->szin_mutaciok_szam,
								  "FORDLEV"=>$forditott_levezetes,
								  "CTP"=>$ctp,
								  "KIFUT"=>$kifutos) ;
			$query_url = "http://" . $_SERVER["HTTP_HOST"] . "/gepterem_komm/dbfcomm.php?mode=insert&dbf=" . $nyom_dbf_url . "&fields=" . json_encode($parameters) ;
			$result = unserialize(Utils::httpGet($query_url)) ;
			if (is_numeric($result)) {
				$return["status"] = "inserted" ;
				$return["message"] = "Géptermi adatbázisba mentve!" ;
			}
			else
			{
				$return["status"] = "failed" ;
				$return["message"] = "Géptermi adatbázis mentése sikertelen!" ;	
			}
			echo json_encode($return) ;
		}
		else
		{
			//Visszaadjuk a keszido és keszsec mezők tartalmát, illetve a workflow dbf-ből az esetleges műveletet és műveletre vonatkozó időpontot
			$parameters = array() ;
			$parameters[] = array("field"=>"TSZAM", "value"=>rawurlencode($model->taskaszam), "op"=>"=") ;
			$query_url = "http://" . $_SERVER["HTTP_HOST"] . "/gepterem_komm/dbfcomm.php?mode=select&dbf=" . $workflow_dbf_url . "&filter=" . json_encode($parameters) ;
			$result = unserialize(Utils::httpGet($query_url)) ;
			$return["nyomas_kezdes"] = Utils::w1250_to_utf8($result[0]["KEZD"]);
			$return["muvelet"] = Utils::w1250_to_utf8($result[0]["MEGJ"]);			
			$return["muvelet_vege"] = "0000-00-00 00:00:00" ;
			if ($result[0]["VEGEDATE"] != "") {
				$return["muvelet_vege"] = mb_convert_encoding(str_replace(".", "-", $result[0]["VEGEDATE"]) . " " . str_replace(",", ":", $result[0]["VEGEIDO"]) . ":00",'UTF-8','UTF-8');
			}
			
			$parameters = array() ;
			$parameters[] = array("field"=>"TSZAM", "value"=>rawurlencode($model->taskaszam), "op"=>"=") ;
			$query_url = "http://" . $_SERVER["HTTP_HOST"] . "/gepterem_komm/dbfcomm.php?mode=select&dbf=" . $nyom_dbf_url . "&filter=" . json_encode($parameters) ;
			$result = unserialize(Utils::httpGet($query_url)) ;
			$return["nyomas_kesz"] = "0000-00-00 00:00:00" ;
			if ($result[0]["KESZIDO"] != "") {
				$kesz_ev = substr($result[0]["KESZIDO"], 0,4) ;
				$kesz_honap = substr($result[0]["KESZIDO"], 4,2) ;
				$kesz_nap = substr($result[0]["KESZIDO"], 6,2) ;
				$return["nyomas_kesz"] = mb_convert_encoding("$kesz_ev-$kesz_honap-$kesz_nap " . str_replace(",", ":", $result[0]["KESZSEC"]) . ":00",'UTF-8','UTF-8');
			}
			if ($return["nyomas_kesz"] !=  "0000-00-00 00:00:00") {
				$model->elkeszulesi_datum = $return["nyomas_kesz"] ;
				$return["muvelet"] = "Nyomás kész!" ;				
				$model->save() ;
			}
			$return["status"] = "ok" ;
//			print_r($return) ;
			echo json_encode($return) ;
		}
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Nyomdakonyv the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Nyomdakonyv::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Nyomdakonyv $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='nyomdakonyv-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

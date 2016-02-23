<?php

class NyomdakonyvController extends Controller
{
	
	public $aktualis_workflow_dbf_tartalom ; 
	
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

		if ($model->elkeszulesi_datum == "0000-00-00 00:00:00") {
				//Szinkronizálunk a géptermi program adatbázisával, hátha van már elkészülési dátum
//				$this->actionGepteremHivas($id) ;
		}
		
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
				
				Utils::goToPrevPage("nyomdakonyvIndex");
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
		Utils::saveCurrentPage("nyomdakonyvIndex");
		
		$model=new Nyomdakonyv('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Nyomdakonyv']))
			$model->attributes=$_GET['Nyomdakonyv'];
		
//		$this->NyitottNyomdakonyvAdatszinkron() ;
		
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
			// növeljük eggyel a megfelelő, nyomtatást számláló mezőt
			if (isset($_GET['isCtp']) && ($_GET['isCtp'] == 1) ) {
				// CTP táska nyomtatása történik
				$model->nyomtatva_ctp_taska = $model->nyomtatva_ctp_taska + 1;
			} else if (isset($_GET['isCtp']) && ($_GET['isCtp'] == 0) ) {
				// táska nyomtatása történik
				$model->nyomtatva_taska = $model->nyomtatva_taska + 1;
			}
			
			$model->save(false);
			
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
	public function actionGepteremHivas($munka_id, $showmessage = true) {
//		$nyom_dbf_url = rawurlencode("C:\inetpub\wwwroot\domyweb/gepterem_komm/gepterem/NYOM.dbf") ;
//		$workflow_dbf_url = rawurlencode("C:\inetpub\wwwroot\domyweb/gepterem_komm/gepterem/workflow.dbf") ;
		$nyom_dbf_url = rawurlencode(Yii::app()->config->get('NyomDbfPath'));
//		$workflow_dbf_url = rawurlencode(Yii::app()->config->get('WorkflowDbfPath'));
		
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
								  "CEGNEV"=>rawurlencode(addslashes(preg_replace( "/\r|\n/", "", $ugyfel_nev))),
								  "MUNEV"=>rawurlencode(preg_replace( "/\r|\n/", "", mb_strtoupper($model->megrendeles_tetel->munka_neve, "UTF-8"))),
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
//			echo $query_url . "<br /><br />\n\n" ;
			if (preg_replace( "/\r|\n/", "", $ugyfel_nev) != "" && $model->megrendeles_tetel->munka_neve != "") {
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
			}
			else
			{
				$return["status"] = "failed" ;
				$return["message"] = "Nem található munka ehhez a táskaszámhoz: " . $model->taskaszam ;					
			}
			if ($showmessage) {
				echo json_encode($return) ;
			}
		}
		else
		{
			//Visszaadjuk a keszido és keszsec mezők tartalmát, illetve a workflow dbf-ből az esetleges műveleteket és műveletekre vonatkozó időpontot
/*			$parameters = array() ;
			$parameters[] = array("field"=>"TSZAM", "value"=>rawurlencode($model->taskaszam), "op"=>"=") ;
			$query_url = "http://" . $_SERVER["HTTP_HOST"] . "/gepterem_komm/dbfcomm.php?mode=select&dbf=" . $workflow_dbf_url . "&filter=" . json_encode($parameters) ;
			echo $query_url ;
			$result = unserialize(Utils::httpGet($query_url)) ;		
			print_r($result) ;*/
			$muveletek = array() ;
			if (count($this->aktualis_workflow_dbf_tartalom) > 0) {
				foreach ($this->aktualis_workflow_dbf_tartalom as $aktualis_muvelet) {
					if ($aktualis_muvelet["TSZAM"] == $model->taskaszam) {
						$muveletek[] = $aktualis_muvelet ;	
					}
				}
			}
			$return["nyomas_kezdes"] = Utils::w1250_to_utf8($result[0]["KEZD"]);
			$return["muvelet"] = Utils::w1250_to_utf8($result[0]["MEGJ"]);			
			$return["muvelet_vege"] = "0000-00-00 00:00:00" ;
			$elso_kezd_idopont = "0000-00-00 00:00:00" ;
			$utolso_vege_idopont = "0000-00-00 00:00:00" ;
			if (count($muveletek) > 0) {
//				print_r($muveletek) ;
//				die("aaaa: " . count($muveletek)) ;
				foreach ($muveletek as $muvelet) {
					if ($elso_kezd_idopont == "0000-00-00 00:00:00" || $muvelet["KEZD"] < $elso_kezd_idopont) {
						$elso_kezd_idopont = Utils::w1250_to_utf8($muvelet["KEZD"]);
					}
					if ($muvelet["VEGE"] == "" || $muvelet["VEGE"] > $utolso_vege_idopont) {
						$utolso_vege_idopont = Utils::w1250_to_utf8($muvelet["VEGE"]);
					}		
					$nyomda_feladat = NyomdaFeladatok::model()->findByAttributes(array('taskaszam'=>$model->taskaszam, 'muvelet_id'=>$muvelet["WFKOD"], 'muvelet_kezd_idopont'=>$muvelet["KEZD"])) ;
					if ($nyomda_feladat == null) {
						//felvesszük a műveletet a nyomda_feladatokhoz
						$domy_user = User::model()->findByAttributes(array('gepterem_dolgkod'=>Utils::w1250_to_utf8($muvelet["DOLGKOD"])));
						$domy_dolgkod = "" ;
						if ($domy_user != null)
							$domy_dolgkod = $domy_user->id ;
						$kezd_idopont = substr($muvelet["KEZDDATE"], 0, 4) . "-" . substr($muvelet["KEZDDATE"], 4, 2) . "-" . substr($muvelet["KEZDDATE"], 6, 2) . " " . substr($muvelet["KEZDIDO"], 0, 2) . ":" . substr($muvelet["KEZDIDO"], 3, 2) . ":00" ;
						$vege_idopont = "0000-00-00 00:00:00" ;
						if ($muvelet["VEGEDATE"] > "") {
							$vege_idopont = substr($muvelet["VEGEDATE"], 0, 4) . "-" . substr($muvelet["VEGEDATE"], 4, 2) . "-" . substr($muvelet["VEGEDATE"], 6, 2) . " " . substr($muvelet["VEGEIDO"], 0, 2) . ":" . substr($muvelet["VEGEIDO"], 3, 2) . ":00" ;
						}
						if ($muvelet["MENNY"] == "") {
							$muvelet["MENNY"] = 0 ;	
						}
						$muvelet["MENNY"] = intval($muvelet["MENNY"]) ;
						$nyomda_feladat = new NyomdaFeladatok() ;
						$nyomda_feladat->taskaszam = Utils::w1250_to_utf8($muvelet["TSZAM"]);
						$nyomda_feladat->user_id = $domy_dolgkod ;
						$nyomda_feladat->muvelet_id = Utils::w1250_to_utf8($muvelet["WFKOD"]);
						$nyomda_feladat->muvelet_kezd_idopont = $kezd_idopont;
						$nyomda_feladat->muvelet_vege_idopont = $vege_idopont;
						$nyomda_feladat->gep_id = Utils::w1250_to_utf8($muvelet["GEPKOD"]);
						$nyomda_feladat->mennyiseg = $muvelet["MENNY"];
						$nyomda_feladat->selejt_mennyiseg = Utils::w1250_to_utf8($muvelet["SMENNY"]);
						$nyomda_feladat->megjegyzes = Utils::w1250_to_utf8($muvelet["MEGJ"]);
						$nyomda_feladat->dijo = Utils::w1250_to_utf8($muvelet["DIJO"]);
						$nyomda_feladat->torolt = 0 ;
						$nyomda_feladat->save() ;
					}
					else
					{
						//Frissítjük az adatokat	
						$vege_idopont = "0000-00-00 00:00:00" ;
						if ($muvelet["VEGEDATE"] > "") {
							$vege_idopont = substr($muvelet["VEGEDATE"], 0, 4) . "-" . substr($muvelet["VEGEDATE"], 4, 2) . "-" . substr($muvelet["VEGEDATE"], 6, 2) . " " . substr($muvelet["VEGEIDO"], 0, 2) . ":" . substr($muvelet["VEGEIDO"], 3, 2) . ":00" ;
						}
						$nyomda_feladat->muvelet_vege_idopont = $vege_idopont;
						$nyomda_feladat->megjegyzes = Utils::w1250_to_utf8($muvelet["MEGJ"]);
						$nyomda_feladat->dijo = Utils::w1250_to_utf8($muvelet["DIJO"]);
						$nyomda_feladat->save() ;
					}
				}
			}
			$return["nyomas_kezdes"] = $elso_kezd_idopont ;
			$return["muvelet_vege"] = $utolso_vege_idopont ;
/*			if ($result[0]["VEGEDATE"] != "") {
				$return["muvelet_vege"] = mb_convert_encoding(str_replace(".", "-", $result[0]["VEGEDATE"]) . " " . str_replace(",", ":", $result[0]["VEGEIDO"]) . ":00",'UTF-8','UTF-8');
			}*/
			
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
			if ($showmessage) {
				echo json_encode($return) ;
			}
		}
	}
	
	// Ütemezés listát előállító action.
	public function actionUtemezes()
	{
/*		$model=new Nyomdakonyv('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Nyomdakonyv']))
			$model->attributes=$_GET['Nyomdakonyv'];
*/

		$dataProvider=new CActiveDataProvider('Nyomdakonyv', array(
			'criteria'=>array(
				'condition'=>'t.torolt=0 and t.sztornozva=0 and t.elkeszulesi_datum=\'0000-00-00 00:00:00\' and t.hatarido>\'0000-00-00 00:00:00\'',
				'order'=>'hatarido, ugyfel_id',
				'with'=>array('megrendeles_tetel', 'megrendeles_tetel.megrendeles', 'megrendeles_tetel.megrendeles.ugyfel'),
			),
			'countCriteria'=>array(
				'condition'=>'t.torolt=0 and t.sztornozva=0 and elkeszulesi_datum=\'0000-00-00 00:00:00\' and t.hatarido>\'0000-00-00 00:00:00\'',
				// 'order' and 'with' clauses have no meaning for the count query
			),
			'sort'=> false,
			'pagination'=>array(
				'pageSize'=>20,
			),
		));
		
		$this->render('utemezes',array(
			'dataProvider'=>$dataProvider,
		));		
	}	
	
	// Ütemezés lista PDF-et előállító action.
	public function actionPrintUtemezes()
	{
		$dataProvider=new CActiveDataProvider('Nyomdakonyv', array(
			'criteria'=>array(
				'condition'=>'t.torolt=0 and t.sztornozva=0 and t.elkeszulesi_datum=\'0000-00-00 00:00:00\' and t.hatarido>\'0000-00-00 00:00:00\'',
				'order'=>'hatarido, ugyfel_id',
				'with'=>array('megrendeles_tetel', 'megrendeles_tetel.megrendeles', 'megrendeles_tetel.megrendeles.ugyfel'),
			),
			'countCriteria'=>array(
				'condition'=>'t.torolt=0 and t.sztornozva=0 and elkeszulesi_datum=\'0000-00-00 00:00:00\' and t.hatarido>\'0000-00-00 00:00:00\'',
				// 'order' and 'with' clauses have no meaning for the count query
			),
			'sort'=> false,
			'pagination'=>false,
		));
			
		if ($dataProvider != null) {
			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();

			$mPDF1->SetHtmlHeader("Nyomdakönyv ütemezés");

			# render
			$mPDF1->WriteHTML($this->renderPartial("printUtemezes", array('dataProvider' => $dataProvider), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
/*			$this->render('printUtemezes',array(
				'dataProvider'=>$dataProvider,
			));*/	
		}
		
	}	
	
	// panton színkódok előregépelős beajánlásának keresője
	public function actionSearchPantones ($term)
	{
		if(Yii::app()->request->isAjaxRequest && !empty($term))
        {
              $variants = array();
              $criteria = new CDbCriteria;
              $criteria->select='nev';
              $criteria->addSearchCondition('nev',$term.'%',false);
              $szinkodok = PantonSzinkodok::model()->findAll($criteria);
              if(!empty($szinkodok))
              {
                foreach($szinkodok as $szinkod)
                {
                    $variants[] = $szinkod->attributes['nev'];
                }
              }
              echo CJSON::encode($variants);
        }
        else
            throw new CHttpException(400,'Hibás kérés.');
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

	/**
	 * A workflow.dbf-ből beolvassa a nyomdakönyvi munkafolyamatok adatait egy tömbbe a megadott paraméterek szerint, és azt adja vissza
	 * A paraméterek a dbfcomm.php hívásának megfelelő paraméterezésből kell, hogy álljon, tehát egy tömb, amelyben megadjuk a mezőt, ami szerint szűrünk, az értéket, aminek az adott mező meg kell, hogy feleljen (vagy éppen nem szabad megfelelnie), illetve az operátort (pl.: =, <, >, stb.)
	 * Példa: $parameters[] = array("field"=>"KEZDDATE", "value"=>rawurlencode($datum_mettol), "op"=>">=") ;
	 */
	private function workflowDbfBeolvas($parameterek) {
		$workflow_dbf_url = rawurlencode(Yii::app()->config->get('WorkflowDbfPath'));
		$query_url = "http://" . $_SERVER["HTTP_HOST"] . "/gepterem_komm/dbfcomm.php?mode=select&dbf=" . $workflow_dbf_url . "&filter=" . json_encode($parameterek) ;
//		echo $query_url ;
		$result = unserialize(Utils::httpGet($query_url)) ;	
		return $result ;		
	}
	
	//A nyitott nyomdakönyv rekordokhoz letölti a géptermi program adatbázisából a legfrissebb adatokat
	protected function NyitottNyomdakonyvAdatszinkron() {
		$datum_mettol = date("Y-m-d", mktime(0, 0, 0, date("m"),   date("d"),   date("Y")-1));
		$parameters = array() ;
		$parameters[] = array("field"=>"KEZDDATE", "value"=>rawurlencode($datum_mettol), "op"=>">=") ;	
		$result = $this->workflowDbfBeolvas($parameters) ;
		if (count($result) > 0) {
			$this->aktualis_workflow_dbf_tartalom = $result ; 
		}
		
		$nyitott_munkak = Nyomdakonyv::model()->findAllByAttributes(array(),"elkeszulesi_datum = '0000-00-00 00:00:00'");
	 	if ($nyitott_munkak != null) {
	 		foreach ($nyitott_munkak as $munka) {
	 			$this->actionGepteremHivas($munka->id, false) ;
	 		}
	 	}
	}
}

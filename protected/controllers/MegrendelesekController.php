<?php

class MegrendelesekController extends Controller
{

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights'
		);
	}
	
	public function allowedActions() {
	  return 'megrendelesKeszites, megrendelesEredmeny';
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->checkSzamlaSorszam($id) ;
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
		$model=new Megrendelesek;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Megrendelesek']))
		{
			$model->attributes=$_POST['Megrendelesek'];
			if($model->save())
				$this->redirect(array('index'));
		} else {
			// LI : új árajánlat létrehozásánál beállítjuk az alapértelmezettnek beállított ÁFA kulcsot
			$afaKulcs = AfaKulcsok::model()->findByAttributes(array('alapertelmezett'=> 1));

			if ($afaKulcs != null) {
				$model -> afakulcs_id = $afaKulcs -> id;
			}
			
			$model->rendeles_idopont = date('Y-m-d H:i:s');		
			$model -> sorszam = $this->ujMegrendelesIdGeneralas();
			
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
		$this->checkSzamlaSorszam($id) ;		
		$model=$this->loadModel($id);

		/*
		if ($model->nyomdakonyv_munka_id != 0 || $model->proforma_szamla_sorszam != "") {
			throw new CHttpException(403, "Hozzáférés megtagadva!, a megrendelés már a nyomdakönyvbe került.");
		}
		*/
		
		/*
		if ($model -> van_megrendeles == 1 && !Yii::app()->user->checkAccess("Admin"))
		{
			throw new CHttpException(403, "Hozzáférés megtagadva!, nincs jogosultsága a kért lap megtekintéséhez.");
		}			
		*/

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Megrendelesek']))
		{
			$model->attributes=$_POST['Megrendelesek'];
			if($model->save())
				Utils::goToPrevPage("megrendelesekIndex");
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
		$model->save();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

   /**
	* Létrehozzuk a nyomdakönyvbe a munkákat a megrendelés tételeiből.
	*/
	public function actionMunkakGeneralasaMegrendelesbol($id) {
		$megrendeles = $this->loadModel($id);

		// ha létezik a megrendelés és még nincsenek a tételei a nyomdakönyvbe rakva
		if ($megrendeles != null && $megrendeles->nyomdakonyv_munka_id == 0) {
			foreach ($megrendeles -> tetelek as $tetel) {
				if ($tetel->szinek_szama1 + $tetel->szinek_szama2 > 0) {
					$nyomdakonyv = new Nyomdakonyv;
					$nyomdakonyv->taskaszam = $this->ujTaskaszamGeneralas ();
					$nyomdakonyv->megrendeles_tetel_id = $tetel->id;
					
					// a választható CTP vagy Film közül a deault a CTP
					$nyomdakonyv->ctp = 1;
					
					// az ofszet festék és a vágójel szerinti pipáló mezők automatikusan legyenek pipálva
					$nyomdakonyv->ofszet_festek = 1;
					$nyomdakonyv->nyomas_vagojel_szerint = 1;
					
					// beállítjuk az alapértelmezett gépet a munkához, ha van
					$gep = Nyomdagepek::model()->findByAttributes(array('alapertelmezett'=> 1));
					if ($gep != null) {
						$nyomdakonyv -> gep_id = $gep -> id;
					}
	
					// beállítjuk az alapértelmezett munkatípust a munkához, ha van
					$darabszam = $tetel->darabszam;
					$szinek_szama1 = $tetel->szinek_szama1;
					$szinek_szama2 = $tetel->szinek_szama2;		
					$termek_id = $tetel->termek_id;
					
					$defaultMunkatipus = Utils::getDefaultMunkatipusToNyomdakonyv ($darabszam, $szinek_szama1, $szinek_szama2, $termek_id );
	
					if ($defaultMunkatipus != null) {
						$nyomdakonyv -> munkatipus_id = $defaultMunkatipus;
					}
					
//					print_r($nyomdakonyv) ;
					
					$nyomdakonyv -> save(false);
				}
			}
//			$megrendeles->nyomdakonyv_munka_id = $nyomdakonyv->id;
			$megrendeles->nyomdakonyv_munka_id = 1;	//Mivel az egyes tételek kerülnek a nyomdakönyvbe önálló munkákként, nincs értelme egy nyomdakönyv azonosítót letárolni egy megrendeléshez, csak annyit, hogy be vannak-e rakva nyomdakönyvbe a cuccok
			$megrendeles->save(false);
		}
		
		Yii::app()->user->setFlash('success', "A tételek a nyomdakönyvbe kerültek!");
		Utils::goToPrevPage("megrendelesekIndex");
	}
	
	 /**
	 * Új táskaszám generálása nyomdakönyvbe kerülő megrendelési tételhez
	 */
	 private function ujTaskaszamGeneralas() {
		$criteria = new CDbCriteria;
		$criteria->select = 'max(id) AS id';
		$row = Nyomdakonyv::model() -> find ($criteria);
		$utolsoMunka = $row['id'];
		$sorszam = "MT" . date("Y") . str_pad( ($utolsoMunka != null) ? ($utolsoMunka + 1) : "000001", 6, '0', STR_PAD_LEFT );
		
	 	return $sorszam ;
	 }
	 
	/**
	 * Új megrendeléshez ID generálás
	 */
	 private function ujMegrendelesIdGeneralas() {
		$criteria = new CDbCriteria;
		$criteria->select = 'max(id) AS id';
		$row = Megrendelesek::model() -> find ($criteria);
		$utolsoMegrendeles = $row['id'];
		$sorszam = "MR" . date("Y") . str_pad( ($utolsoMegrendeles != null) ? ($utolsoMegrendeles + 1) : "000001", 6, '0', STR_PAD_LEFT );
	 	return $sorszam ;
	 }

	/**
	 * Új proforma sorszám generálás
	 */
	 private function ujProformaSorszamGeneralas($model) {
		return "PF" . date("Y") . str_pad($model -> id, 6, '0', STR_PAD_LEFT );
	 }
	 
	/**
	 * Rögzítünk egy xml-ben megkapott megrendelést.
	 * @param SimpleXMLElement $xml a megrendelés adatait tartalmazó objektum
	 */
	public function insertMegrendelesFromXml($xml, $forras) {
//		print_r($xml) ;
		$tomb = array() ;
		$tomb["megrendeles_forras_id"] = $forras->id ;
		$tomb["megrendeles_forras_megrendeles_id"] = (string)$xml->orderhead_code ;
		
/* Itt egyelőre az alapértelmezett áfakulcsot használjuk, mert úgyis minden ugyanazzal az áfával megy, legalább a webáruházakban nem lehet elrontani... */		
		$afaKulcs = AfaKulcsok::model()->findByAttributes(array('alapertelmezett'=> 1));
		if ($afaKulcs != null) {
			$tomb["afakulcs_id"] = $afaKulcs->id;
		}		
		$tomb["rendeles_idopont"] = (string)$xml->orderhead_timestamp;		
		$tomb["sorszam"] = $this->ujMegrendelesIdGeneralas();
		
/* Ügyfél lekérése az adatbázisból a megkapott adatok alapján */		
		$criteria=new CDbCriteria();
		$criteria->select='id, arkategoria';
		$criteria->condition="cegnev=:cegnev";
		$criteria->addCondition("cegnev_teljes=:cegnev_teljes",'OR');
		$criteria->addCondition("ugyvezeto_email=:email",'OR');
		$criteria->params=array(":cegnev"=>urldecode((string)$xml->orderhead_partner_name),":cegnev_teljes"=>urldecode((string)$xml->orderhead_partner_name),":email"=>(string)$xml->orderhead_partner_email);
		
		$ugyfel = Ugyfelek::model()->find($criteria) ;
		if ($ugyfel != null) {
			$tomb["ugyfel_id"] = $ugyfel->id ;
			$tomb["ugyfel_arkategoria_id"] = $ugyfel->arkategoria ;
		}
		else
		{
/* Ha még nem szerepel az adatbázisban az ügyfél, létrehozzuk */			
			$ugyfel_adatok = array() ;
			$ugyfel_adatok["cegnev"] = urldecode((string)$xml->orderhead_partner_name) ;
			$ugyfel_adatok["irsz"] = (string)$xml->orderhead_partner_zip ;
			$ugyfel_adatok["telepules"] = (string)$xml->orderhead_partner_city ;
			$ugyfel_adatok["cim"] = (string)$xml->orderhead_partner_address ;
			$ugyfel_adatok["orszag"] = (string)$xml->orderhead_partner_country ;
			$ugyfel_adatok["email"] = (string)$xml->orderhead_partner_email ;
			$ugyfel_adatok["telefon"] = (string)$xml->orderhead_partner_phone ;
			$ugyfel_adatok["fax"] = (string)$xml->orderhead_partner_fax ;
			$ugyfel_adatok["adoszam"] = (string)$xml->orderhead_partner_vatnumber ;
			$ugyfel_adatok["arkategoria_id"] = (string)$forras->arkategoria_id ;
			$ugyfel_adatok["elso_vasarlas_datum"] = (string)$xml->orderhead_timestamp ;
			$ugyfel_adatok["szallitasi_irsz"] = (string)$xml->orderhead_shipping_zip ;
			$szallitasi_varos_nev = (string)$xml->orderhead_shipping_city ;
			if ($szallitasi_varos_nev != "") {
				$varos_model = Varosok::model()->findByAttributes(array('varosnev' => $szallitasi_varos_nev)) ;
				if ($varos_model == null) {
					$varos_model = new Varosok;
					$varos_model->iranyitoszam = $ugyfel_adatok["szallitasi_irsz"] ;
					$varos_model->varosnev = $szallitasi_varos_nev ;
					$varos_model->save() ;
				}
				$ugyfel_adatok["szallitasi_varos"] = $varos_model->id ;
			}
			$ugyfel_adatok["szallitasi_orszag"] = (string)$xml->orderhead_partner_country ;
			$ugyfel_adatok["szallitasi_cim"] = (string)$xml->orderhead_shipping_address ;
			$tomb["ugyfel_id"] = Ugyfelek::model()->insertUgyfelFromArray($ugyfel_adatok) ;
			$tomb["ugyfel_arkategoria_id"] = $ugyfel_adatok["arkategoria_id"];
		}
//		print_r($tomb) ;
//		die() ;

/* A megrendelés létrehozása az adatbázisban */		
		if (count($xml->orderitems->orderitem) > 0) {
			$checked_order_id = Megrendelesek::model()->findByAttributes(array('megrendeles_forras_megrendeles_id' => $tomb["megrendeles_forras_megrendeles_id"])) ;
			/* Csak akkor rögzítjük a megrendelést, ha az még nem volt rögzítve korábban */
			if ($checked_order_id == null) {
				$model=new Megrendelesek;
				
				$afaKulcs = AfaKulcsok::model()->findByAttributes(array('alapertelmezett'=> 1));
				$model->sorszam = $tomb["sorszam"] ;
	
				if ($afaKulcs != null) {
					$model -> afakulcs_id = $afaKulcs -> id;
				}
				
				$model->rendeles_idopont = date('Y-m-d H:i:s', strtotime((string)$xml->orderhead_timestamp));		
	
				$model->ugyfel_id = $tomb["ugyfel_id"] ;
				$model->arkategoria_id = $tomb["ugyfel_arkategoria_id"] ;
				$model->sztornozva = "0" ;
				$model->torolt = "0" ;		
				$model->megrendeles_forras_id = $tomb["megrendeles_forras_id"] ;
				$model->megrendeles_forras_megrendeles_id = $tomb["megrendeles_forras_megrendeles_id"] ;
				$fizmod = (string)$xml->orderhead_payment_mode ;
				$model->proforma_fizetesi_mod = $fizmod ;
				$model -> save(false);	
				$megrendeles_id = $model->id ;			
				for ($i = 0; $i < count($xml->orderitems->orderitem); $i++) {
					$termek = $xml->orderitems->orderitem[$i] ;
					$termek_adatok = Termekek::model()->findByAttributes(array('cikkszam'=>(string)$termek->orderitem_model)) ;
//					print_r($termek_adatok) ;
					if ($termek_adatok != null) {
						$szinekszama1 = $szinekszama2 = 0 ;
						if (preg_match('/(\d)\+(\d)/', (string)$termek->orderitem_name, $matches)) {
							$szinekszama1 = $matches[1] ;
							$szinekszama2 = $matches[2] ;
						}
						$megrendeles_tetel = new MegrendelesTetelek;
						$megrendeles_tetel -> megrendeles_id = $megrendeles_id;
						$megrendeles_tetel -> termek_id = $termek_adatok->id;
						$megrendeles_tetel -> szinek_szama1 = $szinekszama1;
						$megrendeles_tetel -> szinek_szama2 = $szinekszama2;
						$megrendeles_tetel -> darabszam = (int)$termek -> orderitem_qty;
						$megrendeles_tetel -> netto_darabar = (string)$termek -> orderitem_price;				
						$megrendeles_tetel ->save (false);
					}
					else
					{
						/* Ha nincs az adott cikkszámmal termék a domy programban, akkor mit csináljunk a termékkel? */						
					}
					
				}
				for ($i = 0; $i < count($xml->services->service); $i++) {
					$szolgaltatas = $xml->services->service[$i] ;
					$szolgaltatas_adatok = Termekek::model()->findByAttributes(array('cikkszam'=>(string)$szolgaltatas->service_model)) ;
//					print_r($termek_adatok) ;
					if ($szolgaltatas_adatok != null) {
						$megrendeles_tetel = new MegrendelesTetelek;
						$megrendeles_tetel -> megrendeles_id = $megrendeles_id;
						$megrendeles_tetel -> termek_id = $szolgaltatas_adatok->id;
						$megrendeles_tetel -> darabszam = (int)$szolgaltatas -> service_qty;
						$megrendeles_tetel -> netto_darabar = (string)$szolgaltatas -> service_price;				
						$megrendeles_tetel ->save (false);
					}
					else
					{
						/* Ha nincs az adott cikkszámmal termék a domy programban, akkor mit csináljunk a termékkel? */						
					}
					
				}				
			}
		}
	}
	 
	 
	/**
	 * Importáljuk a webáruházakból a megrendeléseket
	 */
	 public function webaruhazMegrendelesekBegyujt() {
	 	 $webaruhazak = Aruhazak::model()->findAllByAttributes(array(),"aruhaz_megrendelesek_xml_url != ''");
	 	 if ($webaruhazak != null) {
	 	 		foreach ($webaruhazak as $webaruhaz) {
	 	 			try {
						$xml_string = @file_get_contents($webaruhaz->aruhaz_megrendelesek_xml_url);
						if (!empty($xml_string)) {
							$xml = new SimpleXMLElement($xml_string);
							if ($xml->count() > 0) {
								foreach ($xml->children() as $megrendeles) {
									$this->insertMegrendelesFromXml($megrendeles, $webaruhaz) ;
		//							die() ;
								}
							}
						}
					} catch (Exception $e) {
						//	
					}
	 	 		}
	 	 }
	 }
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		Utils::saveCurrentPage("megrendelesekIndex");
		
		$this->webaruhazMegrendelesekBegyujt() ;
		$model=new Megrendelesek('search');
		$model->unsetAttributes();
		if(isset($_GET['Megrendelesek']))
			$model->attributes=$_GET['Megrendelesek'];
	 	
		$dataProvider=new CActiveDataProvider('Megrendelesek',
			Yii::app()->user->checkAccess('Admin') ? array('criteria'=>array('order'=>"rendeles_idopont DESC",),) : array( 'criteria'=>array('condition'=>"torolt = 0 ",),)
		);
		
		//send model object for search
		$this->render('index',array(
			'model'=>$model)
		);

	}

	public function actionPrintProforma()
	{
		if (isset($_GET['id'])) {
			$model = $this -> loadModel($_GET['id']);
		}
		
		if ($model != null) {
			// még nincs nyomdakönyvben, így nem engedjük a visszaigazolás nyomtatását
/*			if ($model->nyomdakonyv_munka_id == 0) {
				Yii::app()->user->setFlash('error', "A megrendelés nincs a nyomdakönyvbe felvéve!");
				$this->redirect(Yii::app()->request->urlReferrer);
			}*/
			
			//ha nincs még proforma számla sorszám generálva a megrendeléshez, most megtesszük
			// ha első nyomtatás, akkor beállítjuk a proforma számlára vonatkozó default értékeket
			if ($model -> proforma_szamla_sorszam == '') {
				$model -> proforma_szamla_sorszam = $this -> ujProformaSorszamGeneralas($model );
				
				// lekérdezzük az alapértelmezett fizetési módot és a hozzá tartozó fizetési határidőt (napokban)
				$fizetesiHatarido = 0;

				$alapertelmezettFizetesiModId = Yii::app()->config->get('AlapertelmezettFizetesiMod');
//				$alapertelmezettFizetesiMod = FizetesiModok::model()->findByPk ($alapertelmezettFizetesiModId);
				
				if ($model->proforma_fizetesi_mod <= 0) {
					$model->proforma_fizetesi_mod = $alapertelmezettFizetesiModId ;
				}
				$valasztottFizetesiMod = FizetesiModok::model()->findByPk ($model->proforma_fizetesi_mod);
				
/*				if ($alapertelmezettFizetesiMod != null) {
					$fizetesiHatarido = $alapertelmezettFizetesiMod->fizetesi_hatarido;
				}*/
				$fizetesiHatarido = $valasztottFizetesiMod->fizetesi_hatarido ;
				
				
				$model -> proforma_kiallitas_datum = new CDbExpression('NOW()');
				$model -> proforma_teljesites_datum = new CDbExpression('NOW()');
				$model -> proforma_fizetesi_hatarido = new CDbExpression('NOW() + INTERVAL ' . $fizetesiHatarido . ' DAY');
				if ($alapertelmezettFizetesiModId != null) {
					$model -> proforma_fizetesi_mod = $alapertelmezettFizetesiMod->id;
				}
				
				$model -> save(false);
				$model -> refresh() ;
			}
			
			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();

			$mPDF1->SetHtmlHeader("Megrendelés #" . $model->sorszam);
			
			# render
			$mPDF1->WriteHTML($this->renderPartial("printProforma", array('model' => $model), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
		}
		
	}
	
	public function actionPrintVisszaigazolas()
	{
		if (isset($_GET['id'])) {
			$model = $this -> loadModel($_GET['id']);
		}
		
		if ($model != null) {
			// még nincs nyomdakönyvben, így nem engedjük a visszaigazolás nyomtatását
			if ($model->nyomdakonyv_munka_id == 0) {
				Yii::app()->user->setFlash('error', "A megrendelés nincs a nyomdakönyvbe felvéve!");
				$this->redirect(Yii::app()->request->urlReferrer);
			}
			
			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();

			$mPDF1->SetHtmlHeader("Visszaigazolás #" . $model->sorszam);
			
			# render
			$mPDF1->WriteHTML($this->renderPartial("printVisszaigazolas", array('model' => $model), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
		}
		
	}	
	
	public function actionSzamlageneralas()
	{
		if (is_numeric($_GET['id'])) {
			$model = $this -> loadModel($_GET['id']);
		}
		
		if ($model != null) {
			Utils::szamla_letrehozasa($_GET['id']) ;
		}		
	}	
		
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Megrendelesek('search');
		$model->unsetAttributes();  // clear any default values
		
		if (isset($_GET['Megrendelesek']))
			$model->attributes=$_GET['Megrendelesek'];

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
		// LI: megrendelést tudunk árajánlatból az admin felületről is csinálni ill. e-mail-es megrendelésből is: ebben a flag-ben tároljuk, hogy honnan hívtuk meg
		$createMegrendelesFromEmail = isset($_POST['createMegrendelesFromEmail']) ? $_POST['createMegrendelesFromEmail'] : '';
		
		if ( isset($_POST['arajanlat_id']) && (isset($_POST['selected_tetel_list']) && strlen($_POST['selected_tetel_list']) > 0)) {
			$arajanlat_id = $_POST['arajanlat_id'];
			$selected_tetels = $_POST['selected_tetel_list'];
			
			$selected_tetel_list = array ();
			if (strlen($selected_tetels) > 0) {
				$selected_tetel_list = explode (',', $selected_tetels);
			}

			$arajanlat = Arajanlatok::model() -> with('tetelek') -> findByPk ($arajanlat_id);
			$megrendeles = new Megrendelesek;
			
			if ( Utils::reachedUgyfelLimit ($arajanlat->id) )
			{
				throw new CHttpException(403, "Elérte az ügyfélhez tartozó rendelési limitet., így nincs jogosultsága a funkció használatához!");
			}
			
			// megkeressük a legutóbb felvett megrendelést és az ID-jához egyet hozzáadva beajánljuk az újonnan létrejött sorszámának
			// formátum: RE201500001, ahol az évszám után 000001 a rekord ID-ja 6 jeggyel reprezentálva, balról 0-ákkal feltöltve
			$criteria = new CDbCriteria;
			$criteria->select = 'max(id) AS id';
			$row = Megrendelesek::model() -> find ($criteria);
			$utolsoMegrendeles = $row['id'];

			$megrendeles -> sorszam = "MR" . date("Y") . str_pad( ($utolsoMegrendeles != null) ? ($utolsoMegrendeles + 1) : "000001", 6, '0', STR_PAD_LEFT );
			
			// alapadatok átvétele
			$megrendeles -> ugyfel_id = $arajanlat -> ugyfel_id;
			$megrendeles -> cimzett = $arajanlat -> cimzett;
			$megrendeles -> arkategoria_id = $arajanlat -> arkategoria_id;
			$megrendeles -> afakulcs_id = $arajanlat -> afakulcs_id;
			$megrendeles -> ugyfel_tel = $arajanlat -> ugyfel_tel;
			$megrendeles -> ugyfel_fax = $arajanlat -> ugyfel_fax;
			$megrendeles -> visszahivas_jegyzet = $arajanlat -> visszahivas_jegyzet;
			$megrendeles -> jegyzet = $arajanlat -> jegyzet;
			$megrendeles -> reklamszoveg = $arajanlat -> reklamszoveg;
			$megrendeles -> egyeb_megjegyzes = $arajanlat -> egyeb_megjegyzes;

			$megrendeles -> arajanlat_id = $arajanlat -> id;
			$megrendeles -> rendelest_rogzito_user_id = Yii::app()->user->getId();
			$megrendeles -> rendeles_idopont = date('Y-m-d H:i:s');
			$alap_fizmod = Yii::app()->config->get('AlapertelmezettFizetesiMod');
			if (!is_numeric($alap_fizmod)) {
				$alap_fizmod = 3 ;	
			}
			$megrendeles -> proforma_fizetesi_mod = 3 ;		//Alapértelmezetten az átutalás kerül be, ha átállítják és mentik, úgyis felülírja

			// elmentjük a modelt, hogy legyen model id a kezünkben
			$megrendeles -> save(false);

			// az árajánlatnál beállítjuk, hogy van már hozzá megrendelés
			$arajanlat -> van_megrendeles = 1;
			$arajanlat -> save(false);
			
			// az árajánlathoz felvett termékek átmásolása az újonnan létrejövő megrendelésre
			// ha volt kiválasztva valami a léterhozás előtt, akkor csak azokat visszük ár,
			// egyébként az összeset
			foreach ($arajanlat -> tetelek as $termek) {
				if ( empty($selected_tetel_list) || (in_array($termek -> id, $selected_tetel_list)) ) {
					$megrendeles_tetel = new MegrendelesTetelek;
					$megrendeles_tetel -> megrendeles_id = $megrendeles -> id;
					$megrendeles_tetel -> termek_id = $termek -> termek_id;
					$megrendeles_tetel -> szinek_szama1 = $termek -> szinek_szama1;
					$megrendeles_tetel -> szinek_szama2 = $termek -> szinek_szama2;
					
					// LI: ha nincs színszám az adott tételnél, akkor automatikusan a 'boríték eladás' szöveg kerül a munka nevébe
					if ($termek -> szinek_szama1 == 0 && $termek -> szinek_szama2 == 0) {
						$megrendeles_tetel -> munka_neve = 'BORÍTÉK ELADÁS';
					}
					
					$megrendeles_tetel -> darabszam = $termek -> darabszam;
					$megrendeles_tetel -> netto_darabar = $termek -> netto_darabar;
					$megrendeles_tetel -> megjegyzes = $termek -> megjegyzes;
					$megrendeles_tetel -> mutacio = $termek -> mutacio;
					$megrendeles_tetel -> hozott_boritek = $termek -> hozott_boritek;
					$megrendeles_tetel -> egyedi_ar = $termek -> egyedi_ar;

					// az árajánlatból létrehozott tételeket külön jelezzük, mert azoknak az adatai nem szerkeszthettők többé
					$megrendeles_tetel -> arajanlatbol_letrehozva = 1;
					$megrendeles_tetel -> arajanlat_tetel_id = $termek -> id ;
	
					
					$megrendeles_tetel ->save (false);
				}
			}
			
			// frissítjük az egyedi ár flag-et a megrendelésen
			Utils::isEgyediArMegrendelesArajanlat ($megrendeles -> id, true);

			if ($createMegrendelesFromEmail == 1) {
				return true;
			} else {
				$this->redirect(array('megrendelesek/update', 'id' => $megrendeles -> id,));
			}
		}
		
		return false;
	}

		// LI: levélben kapott árajánlatból megrendelést előkészítő kód (levélben linket kap a felhasználó, amit 
	//	   megnyitva egy felületet kap, ahol összekattoghatja a megrendelését).
	public function actionMegrendelesKeszites ($token) {
		if (isset($token)) {
			$arajanlat = Arajanlatok::model()->findByAttributes(array("email_verification_code" => $token));
			
			if ($arajanlat != null) {
				$this->render('_megrendelesKeszites',array(
					'model'=>$arajanlat,)
				);
			} else echo 'Hiba!';
		} else echo 'Hiba!';
	}

	// LI: levélben kapott árajánlatból megrendelést készítő kód. Itt a felhaználó már kiválasztotta, hogy mit szeretne megrendelni,
	//	   így itt már a tényleges megrendelés készül el.
	public function actionMegrendelesEredmeny () {
		$resultText = 'A megrendelés nem sikerült. Kérjük próbálkozzon újra!';
		$arajanlatId = $_POST['arajanlat_id'];
		$showBackButton = true;
		
		if ((isset($_POST['selected_tetel_list']) && trim($_POST['selected_tetel_list']) != '') && (isset($arajanlatId))) {
			$arajanlat = Arajanlatok::model()->findByPk($arajanlatId);
			if ($arajanlat != null) {
				$_POST['createMegrendelesFromEmail'] = 1;
				$result = $this->actionCreateFromArajanlat();

				if ($result) {
					$arajanlat->email_verification_code = '';
					$arajanlat->save(false);

					$resultText = 'Megrendelésének feldolgozását megkezdte rendszerünk. Köszönjük vásárlását!';
					$showBackButton = false;
				}
			}
		}
		
		$this->render('_megrendelesEredmeny',array(
			'resultText' => $resultText,
			'showBackButton' => $showBackButton,
			)
		);
	}
	
	/**
	 * Megrendelés sztornózása.
	 */
	public function actionStorno ()
	{
		if ( isset($_POST['megrendeles_id']) ) {
			$model_id = $_POST['megrendeles_id'];
			$storno_ok = isset($_POST['selected_storno']) ? $_POST['selected_storno'] : '';
			
			$megrendeles = Megrendelesek::model() -> findByPk ($model_id);

			if ($megrendeles != null) {
				$megrendeles -> sztornozas_oka = $storno_ok;
				$megrendeles -> sztornozva = 1;
				
				$megrendeles -> save(false);
			}
		}
		
		$this->redirect(array('megrendelesek/index'));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Megrendelesek the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Megrendelesek::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Megrendelesek $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='arajanlatok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Ellenőrizzük, hogy a paraméterben kapott azonosítójú megrendeléshez van-e letárolva számla sorszám, 
	 * ha nincs, megnézzük, hogy az ACTUAL adatbázisban van-e, ha ott van, akkor beírjuk a számla sorszámot a saját adatbázisunkba a megrendeléshez.
	 */
	public function checkSzamlaSorszam($id) {
		$megrendeles = $this->loadModel($id);
		if ($megrendeles != null && (empty($megrendeles->szamla_sorszam) || $megrendeles->szamla_sorszam == 0)) {			
			$szamla_sorszam = Utils::szamla_sorszam_beolvas($id) ;
			if (!is_numeric($szamla_sorszam) || $szamla_sorszam > 0) {
				$megrendeles->setAttribute("szamla_sorszam", $szamla_sorszam);
				$megrendeles->save();
				
				// átbillentjük a megrendeléshez tartozó ügyfél típusát 'vasarlo'-ra
				$ugyfel = Ugyfelek::model()->findByPk ($megrendeles->ugyfel_id);
				if ($ugyfel != null) {
					$ugyfel->ugyfel_tipus = 'vasarlo';
					$ugyfel->save();
				}
			}
		}
	}
	
}

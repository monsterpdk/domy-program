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
			// formátum: AJ2015000001, ahol az évszám után 000001 a rekord ID-ja 6 jeggyel reprezentálva, balról 0-ákkal feltöltve
			$criteria = new CDbCriteria;
			$criteria->select = 'max(id) AS id';
			$row = Arajanlatok::model() -> find ($criteria);
			$utolsoArajanlat = $row['id'];

			$model -> sorszam = "AJ" . date("Y") . str_pad( ($utolsoArajanlat != null) ? ($utolsoArajanlat + 1) : "000001", 6, '0', STR_PAD_LEFT );
				
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
				Utils::goToPrevPage("arajanlatokIndex");
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
		Utils::saveCurrentPage("arajanlatokIndex");
		
		$model=new Arajanlatok('search');
		$model->unsetAttributes();
		if(isset($_GET['Arajanlatok']))
			$model->attributes=$_GET['Arajanlatok'];
	 	
		$dataProvider=new CActiveDataProvider('Arajanlatok',
			Yii::app()->user->checkAccess('Admin') ? array('criteria'=>array('order'=>'ajanlat_datum DESC',),) : array('criteria'=>array('condition'=>"torolt = 0 ",'order'=>'ajanlat_datum DESC',),)
		);
		
		//send model object for search
		$this->render('index',array(
			'model'=>$model,)
		);
	}
	
	/**
	 * Árajánlatok, amelyek kapcsán vissza kell hívni az ügyfelelt a belépett adminnak
	 */
	public function actionVisszahivasok() {
		$model=new Arajanlatok('search');
		$model->unsetAttributes();
				 
		$this->render('visszahivasok', array(
			'model'=>$model,)
		);
	}

	public function actionPrintPDF()
	{
		if (isset($_GET['id'])) {
			$model = $this -> loadModel($_GET['id']);
		}
		
		if ($model != null) {
			$this->generatePdf($model) ;
/*			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf('', 'A4', 0, '', 15, 15, 15, 35, '', '', 'P');

			$mPDF1->SetHtmlHeader("Árajánlat #" . $model->sorszam);

			// a content ne lógjon rá a header-re sem pedig a footer-re
			$mPDF1->setAutoTopMargin 	= 'stretch';
			$mPDF1->setAutoBottomMargin = 'stretch';
			
			# render
			$mPDF1->WriteHTML($this->renderPartial("printArajanlat", array('model' => $model), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();*/
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
	
	public function actionArajanlatTetelElozmenyek($ugyfel_id, $grid_id) {
		if (is_numeric($ugyfel_id) && $ugyfel_id > 0) {
						
			$termek_ajanlatok = Yii::app()->db->createCommand()
												->select('arajanlat_tetelek.id as tetel_id, arajanlat_tetelek.termek_id, arajanlat_tetelek.netto_darabar, arajanlat_tetelek.darabszam, termekek.nev as termeknev, arajanlatok.sorszam as ajanlat_sorszam, arajanlatok.ajanlat_datum, megrendeles_tetelek.arajanlatbol_letrehozva')
												->from('dom_arajanlatok arajanlatok')
												->join('dom_arajanlat_tetelek as arajanlat_tetelek','arajanlatok.id = arajanlat_tetelek.arajanlat_id')
												->leftJoin('dom_termekek termekek','arajanlat_tetelek.termek_id = termekek.id')
												->leftJoin('dom_megrendeles_tetelek megrendeles_tetelek', 'megrendeles_tetelek.arajanlat_tetel_id = arajanlat_tetelek.id')
												->where('arajanlatok.ugyfel_id=:ugyfel_id', array(':ugyfel_id'=>$ugyfel_id))
												->queryAll();

			$count=Yii::app()->db->createCommand()
												->select('count(*)')
												->from('dom_arajanlatok arajanlatok')
												->join('dom_arajanlat_tetelek as arajanlat_tetelek','arajanlatok.id = arajanlat_tetelek.arajanlat_id')
												->where('arajanlatok.ugyfel_id=:ugyfel_id', array(':ugyfel_id'=>$ugyfel_id))			
												->queryScalar();		
/*			$dataProvider=new CSqlDataProvider($termek_ajanlatok, array(
				'totalItemCount'=>$count,
				'keyField' => 'tetel_id',
				'sort'=>array(
					'attributes'=>array(
						 'ajanlat_datum desc',
					),
				),
				'pagination'=>array(
					'pageSize'=>30,
				),
			));*/
			
			$dataProvider=new CArrayDataProvider($termek_ajanlatok, array(
				'keyField' => 'tetel_id',
				'sort'=>array(
					'attributes'=>array(
						 'ajanlat_datum',
					),
				),
				'pagination'=>array(
					'pageSize'=>10,
				),
			));			
			
						
			if (Yii::app()->request->isAjaxRequest)
			{
				// Stop jQuery from re-initialization
				Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
				Yii::app()->clientScript->scriptMap['*.css'] = false;
			
				echo CJSON::encode(array(
					'status'=>'failure', 
					'div'=>$this->renderPartial('tetel_elozmenyek_view', array('dataProvider'=>$dataProvider, 'grid_id'=>$grid_id, 'ugyfel_id'=>$ugyfel_id), true, true)));
				exit;               
			}
			else {
				$this->render('tetel_elozmenyek_view', array('dataProvider'=>$dataProvider));
			}
		
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
				$ugyintezok = UgyfelUgyintezok::model()->findAll(array("condition"=>"torolt=0 AND ugyfel_id = " . $ugyfel->id));
				$ugyintezokSelect = "";
				foreach($ugyintezok as $ugyintezo) {
					$ugyintezokSelect .= CHtml::tag('option', array('value'=>$ugyintezo->id),CHtml::encode($ugyintezo->nev), true);
				}
				
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
					'ugyintezok'=>$ugyintezokSelect,
					'id'=>$ugyfel->id,
					);      
			}
		}
		
		echo CJSON::encode($arr);
	}

	/**
	 * Az előregépelős ügyfélkiválasztóban a kiválasztást követően frissíteni kell az ügyfél statisztikáit.
	 */
	public function actionGetUgyfelStat ($ugyfelId)
	{
		$autocomplete_arajanlat_osszes_darabszam = 0;
		$autocomplete_arajanlat_osszes_ertek = 0;
		$autocomplete_arajanlat_osszes_tetel = 0;
		$autocomplete_megrendeles_osszes_darabszam = 0;
		$autocomplete_megrendeles_osszes_ertek = 0;
		$autocomplete_megrendeles_osszes_tetel = 0;
		$autocomplete_arajanlat_megrendeles_elfogadas = 0;
		
		if (isset($ugyfelId)) {
			// árajánlat és megrendelés statisztikák kiszámolása
			$osszesArajanlat = Utils::getUgyfelOsszesArajanlatErteke($ugyfelId);
			$osszesArajanlatDarab = Utils::getUgyfelOsszesArajanlatDarab($ugyfelId);
			$autocomplete_arajanlat_osszes_darabszam = $osszesArajanlatDarab;
			$autocomplete_arajanlat_osszes_ertek = $osszesArajanlat != null ? $osszesArajanlat['arajanlat_netto_osszeg'] : 0;
			$autocomplete_arajanlat_osszes_tetel = $osszesArajanlat != null ? $osszesArajanlat['tetel_darabszam'] : 0;

			$osszesMegrendeles = Utils::getUgyfelOsszesMegrendelesErteke($ugyfelId);
			$osszesMegrendelesDarab = Utils::getUgyfelOsszesMegrendelesDarab($ugyfelId);
			$autocomplete_megrendeles_osszes_darabszam = $osszesMegrendelesDarab;
			$autocomplete_megrendeles_osszes_ertek = $osszesMegrendeles != null ? $osszesMegrendeles['megrendeles_netto_osszeg'] : 0;
			$autocomplete_megrendeles_osszes_tetel = $osszesMegrendeles != null ? $osszesMegrendeles['tetel_darabszam'] : 0;
			
			$autocomplete_arajanlat_megrendeles_elfogadas = ($autocomplete_megrendeles_osszes_tetel != 0 && $autocomplete_arajanlat_osszes_tetel != 0) ?
																	(number_format((float)$autocomplete_megrendeles_osszes_tetel / $autocomplete_arajanlat_osszes_tetel * 100, 2, '.', '')) : 0;
		}
		
		echo CJSON::encode(array(
			'status'=>isset($ugyfelId) ? 'success' : 'failed',

			'autocomplete_arajanlat_osszes_darabszam' => $autocomplete_arajanlat_osszes_darabszam,
			'autocomplete_arajanlat_osszes_ertek' => $autocomplete_arajanlat_osszes_ertek,
			'autocomplete_arajanlat_osszes_tetel' => $autocomplete_arajanlat_osszes_tetel,
			'autocomplete_megrendeles_osszes_darabszam' => $autocomplete_megrendeles_osszes_darabszam,
			'autocomplete_megrendeles_osszes_ertek' => $autocomplete_megrendeles_osszes_ertek,
			'autocomplete_megrendeles_osszes_tetel' => $autocomplete_megrendeles_osszes_tetel,
			'autocomplete_arajanlat_megrendeles_elfogadas' => $autocomplete_arajanlat_megrendeles_elfogadas,
			));
		exit;
	}
	
	/* Árajánlat kiküldése e-mailen */
	public function actionsendViaEmail($id) {
		$status = "failed" ;
		if (is_numeric($id)) {
			$model=$this->loadModel($id);		
			
			$validator = new CEmailValidator;
			$ugyfel_email = $model->ugyintezo->email ;
			if (!$validator->validateValue($ugyfel_email)) {
				$ugyfel_email = $model->ugyfel->ceg_email ;
			}
			
 
            if($validator->validateValue($ugyfel_email)) {								
				$ArajanlatKuldoEmail = Yii::app()->config->get('ArajanlatKuldoEmail');
				$ArajanlatKuldoHost = Yii::app()->config->get('ArajanlatKuldoHost');
				$ArajanlatKuldoPort = Yii::app()->config->get('ArajanlatKuldoPort');
				$ArajanlatKuldoTitkositas = Yii::app()->config->get('ArajanlatKuldoTitkositas');
				$ArajanlatKuldoSMTP = Yii::app()->config->get('ArajanlatKuldoSMTP');
				if ($ArajanlatKuldoSMTP == 1)
					$ArajanlatKuldoSMTP = true ;
				else
					$ArajanlatKuldoSMTP = false ;
				
				$ArajanlatKuldoSMTPUser = Yii::app()->config->get('ArajanlatKuldoSMTPUser');
				$ArajanlatKuldoSMTPPassword = Yii::app()->config->get('ArajanlatKuldoSMTPPassword');
				$ArajanlatKuldoFromName = Yii::app()->config->get('ArajanlatKuldoFromName');
				$ArajanlatKuldoAlapertelmezettSubject = Yii::app()->config->get('ArajanlatKuldoAlapertelmezettSubject');
				
				
				$ajanlat_mailer = Yii::app()->mailer ;			
				$ajanlat_mailer ->Host = $ArajanlatKuldoHost;		//Az smtp szerver címe	-> admin beállításokból
				$ajanlat_mailer ->From = $ArajanlatKuldoEmail;		//A küldő e-mail címe	-> admin beállításokból
				$ajanlat_mailer ->Port = $ArajanlatKuldoPort;		//Az smtp szerver portja -> admin beállításokból
				$ajanlat_mailer ->FromName = $ArajanlatKuldoFromName;		//A küldő neve -> admin beállításokból
				$ajanlat_mailer ->AddReplyTo($ArajanlatKuldoEmail);		//A válasz e-mail cím, alapból a feladó e-mail címe lesz, ami az admin beállításokból jön
//				$ajanlat_mailer ->AddAddress($ugyfel_email);	// Ide jön az ügyfél e-mail címe -> ügyfél adatokból
				$ajanlat_mailer ->AddAddress("toth.arpad@pdk.hu");	// Ide jön az ügyfél e-mail címe -> ügyfél adatokból
				$ajanlat_mailer ->isHTML(true);
				if ($ArajanlatKuldoSMTP) {
					$ajanlat_mailer ->IsSMTP();
					$ajanlat_mailer ->SMTPAuth=$ArajanlatKuldoSMTP;
					$ajanlat_mailer ->SMTPSecure = $ArajanlatKuldoTitkositas;                            // Enable TLS encryption, `ssl` also accepted			
					$ajanlat_mailer ->Username = $ArajanlatKuldoSMTPUser;		//Az smtp bejelentkezéshez a usernév (e-mail cím) -> admin beállításokból
					$ajanlat_mailer ->Password = $ArajanlatKuldoSMTPPassword;		//Az smtp bejelentkezéshez a jelszó -> admin beállításokból				
				}
				$ajanlat_mailer ->CharSet = "utf-8";			
				$ajanlat_mailer ->Subject = $ArajanlatKuldoAlapertelmezettSubject;
				
				$ajanlat_file_url = Yii::app() -> getBasePath() . "/../uploads/ajanlatok/" . $model->sorszam . ".pdf" ;
				$this->generatePdf($model, $ajanlat_file_url) ;
				$ajanlat_mailer -> AddAttachment($ajanlat_file_url,"Árajánlat", "base64", "application/pdf");
				
				$email_body = $this->renderPartial("arajanlat_email_body", array('model'=>$model), true);
				$ajanlat_mailer ->Body = $email_body;
				
				if ($ajanlat_mailer ->Send())
					$status = "ok" ;	
				unlink(Yii::app() -> getBasePath() . "/../uploads/ajanlatok/" . $model->sorszam . ".pdf") ;
			}
		}
		echo CJSON::encode(array(
			'status' => $status,
		));		
/*		$model=new Arajanlatok('search');
		$model->unsetAttributes();
		if(isset($_GET['Arajanlatok']))
			$model->attributes=$_GET['Arajanlatok'];
	 	
		$dataProvider=new CActiveDataProvider('Arajanlatok',
			Yii::app()->user->checkAccess('Admin') ? array('criteria'=>array('order'=>'ajanlat_datum DESC',),) : array('criteria'=>array('condition'=>"torolt = 0 ",'order'=>'ajanlat_datum DESC',),)
		);
		
		//send model object for search
		$this->render('index',array(
			'model'=>$model,)
		);*/
	}	
	
	
	public function generatePdf($model, $file_url = "") {
		if ($model != null) {		
			$mPDF1 = Yii::app()->ePdf->mpdf('', 'A4', 0, '', 15, 15, 15, 35, '', '', 'P');

			$mPDF1->SetHtmlHeader("Árajánlat #" . $model->sorszam);

			// a content ne lógjon rá a header-re sem pedig a footer-re
			$mPDF1->setAutoTopMargin 	= 'stretch';
			$mPDF1->setAutoBottomMargin = 'stretch';
			
			# render
			$mPDF1->WriteHTML($this->renderPartial("printArajanlat", array('model' => $model), true));
	 
			# Outputs ready PDF
			if ($file_url != "") {
				$mPDF1->Output($file_url,'F');
			}
			else
			{
				$mPDF1->Output();
			}
			return true ;
		}
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

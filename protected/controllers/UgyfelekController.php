<?php

class UgyfelekController extends Controller
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

	// LI : varosok előregépeléséhez
	public function actionAutocomplete(){
		$term = Yii::app()->request->getQuery('term');
		
		$match = addcslashes($term, '%_'); // escape LIKE's special characters
		$q = new CDbCriteria( array(
			'condition' => "varosnev LIKE :term AND torolt = 0",
			'params'    => array(':term' => "$term%")
		) );
        $countries = Varosok::model()->findAll($q);

        $lists = array();
		
        foreach($countries as $country) {
            $lists[] = array(
                'id' => $country->id,
                'varosnev' => $country->varosnev,
            );
        }
        echo json_encode($lists);
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
	    $model = new Ugyfelek;

		// lekérdezzük és beállítjuk az alapértelmezett rendelés tartozás limitet
		$defaultTartozasiLimit = Yii::app()->config->get('alapertelmezettRendelesTartozasLimit');
		if ($defaultTartozasiLimit != null)
			$model -> rendelesi_tartozasi_limit = $defaultTartozasiLimit;
		
		// székhely és szállítási ország alapértelmezettként 'Magyarország' legyen
		$modelOrszag = Orszagok::model()->findByAttributes(array('nev' => 'Magyarország'));
		if ($modelOrszag != null) {
			$model->szekhely_orszag = $modelOrszag->id;
			$model->posta_orszag = $modelOrszag->id;;
		}
 
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
 
        if (isset($_POST['Ugyfelek']))
        {
            $model->attributes = $_POST['Ugyfelek'];
 
            if (isset($_POST['UgyfelUgyintezok']))
            {
                $model->ugyfelUgyintezo = $_POST['UgyfelUgyintezok'];
            }
            if ($model->saveWithRelated('ugyfelUgyintezo'))
				$this->redirect(array('index'));
                //$this->redirect(array('view', 'id' => $model->id));
            else
                $model->addError('ugyfelUgyintezo', 'Hiba történt az ügyintéző mentése közben.');
        }
 
        $this->render('create', array(
            'model' => $model,
        ));
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
 
        if (isset($_POST['Ugyfelek']))
        {
            $model->attributes = $_POST['Ugyfelek'];
            if (isset($_POST['UgyfelUgyintezok']))
            {
                $model->ugyfelUgyintezo = $_POST['UgyfelUgyintezok'];
                $kapcsolattarto = "" ;
                for ($i = 0; $i < count($_POST['UgyfelUgyintezok']); $i++) {
                	if ($_POST['UgyfelUgyintezok'][$i]["alapertelmezett_kapcsolattarto"] == 1) {
                		$kapcsolattarto = $i ;
                	}
                }
                if ($kapcsolattarto != "") {
                	$model->kapcsolattarto_nev = $_POST['UgyfelUgyintezok'][$kapcsolattarto]["nev"] ;
                	$model->kapcsolattarto_telefon = $_POST['UgyfelUgyintezok'][$kapcsolattarto]["telefon"] ;
                	$model->kapcsolattarto_email = $_POST['UgyfelUgyintezok'][$kapcsolattarto]["email"] ;
                }
            }
            if ($model->saveWithRelated('ugyfelUgyintezo'))
				$this->redirect(array('index'));
//              $this->redirect(array('view', 'id' => $model->id));
            else
                $model->addError('ugyfelUgyintezo', 'Hiba történt az ügyfélügyintéző mentése közben.');
        }
 
        $this->render('update', array(
            'model' => $model,
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Ugyfelek('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ugyfelek']))
			$model->attributes=$_GET['Ugyfelek'];
	 	
		$dataProvider=new CActiveDataProvider('Ugyfelek',
			Yii::app()->user->checkAccess('Admin') ? array() : array( 'criteria'=>array('condition'=>"torolt = 0 ",),)
		);
		
		// LI : exporthoz kell ez a blokk
		 if ($this->isExportRequest()) {
			//nagy adathalmaz export-ja esetén érdemes bekapcsolni:
            //set_time_limit(0);
            $this->exportCSV(array(), null, false);
			
			// mindig az aktuális
            $this->exportCSV($dataProvider, array('id', 'ugyfel_tipus', 'cegnev', 'cegnev_teljes', 'szekhely_irsz', 'szekhely_orszag', 'szekhely_varos', 'szekhely_cim', 'posta_irsz', 'posta_orszag', 'posta_varos', 'posta_cim', 'ugyvezeto_nev', 'ugyvezeto_telefon', 'ugyvezeto_email', 'kapcsolattarto_nev', 'kapcsolattarto_telefon', 'kapcsolattarto_email', 'ceg_telefon', 'ceg_fax', 'ceg_email', 'ceg_honlap', 'cegforma', 'szamlaszam1', 'szamlaszam2', 'display_ugyfel_ugyintezok', 'adoszam', 'eu_adoszam', 'teaor', 'tevekenysegi_kor', 'arbevetel', 'foglalkoztatottak_szama', 'adatforras', 'besorolas', 'megjegyzes', 'fontos_megjegyzes', 'fizetesi_felszolitas_volt', 'ugyvedi_felszolitas_volt', 'levelezes_engedelyezett', 'email_engedelyezett', 'kupon_engedelyezett', 'egyedi_kuponkedvezmeny', 'elso_vasarlas_datum', 'utolso_vasarlas_datum', 'fizetesi_hatarido', 'max_fizetesi_keses', 'atlagos_fizetesi_keses', 'rendelesi_tartozasi_limit', 'fizetesi_moral', 'adatok_egyeztetve_datum', 'archiv', 'archivbol_vissza_datum', 'felvetel_idopont', 'torolt'));
        }
		
		//send model object for search
		$this->render('index',array(
			'model'=>$model)
		); 
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Ugyfelek('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ugyfelek']))
			$model->attributes=$_GET['Ugyfelek'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	// LI : export-hoz kell
	public function behaviors() {
		return array(
        'exportableGrid' => array(
            'class' => 'application.components.ExportableGridBehavior',
            'filename' => 'termekek.csv',
            'csvDelimiter' => ";", // i.e. Excel friendly csv delimiter
            ));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Ugyfelek the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Ugyfelek::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Ugyfelek $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ugyfelek-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	    public function actionLoadUgyfelUgyintezoByAjax($index)
    {
        $model = new UgyfelUgyintezok;
        $this->renderPartial('ugyfelUgyintezok/_form', array(
            'model' => $model,
            'index' => $index,
//            'display' => 'block',
        ), false, true);
    }
}

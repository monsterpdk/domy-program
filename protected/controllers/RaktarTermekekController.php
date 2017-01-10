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
		$model=new RaktarTermekek('search');
		$model->unsetAttributes();
		if(isset($_GET['RaktarTermekek']))
			$model->attributes=$_GET['RaktarTermekek'];
	 	
		$dataProvider=new CActiveDataProvider('RaktarTermekek',
			array('criteria'=>array('order'=>'raktarhely_id ASC',), 'pagination'=>array('pageSize'=>10000))
		);
		
		//send model object for search
		$this->render('index',array(
			'model'=>$model,)
		);
	}

	public function actionPrintRaktarkeszlet()
	{
		$model=new RaktarTermekek('search');
		$model->unsetAttributes();
		
		if(isset($_GET['RaktarTermekek']))
			$model->attributes=$_GET['RaktarTermekek'];

		$dataProvider=$model -> search();
		
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
	
	// cikkszámok szerint csoportosított raktárösszesítés nyomtatása
	public function actionPrintRaktarkeszletByCikkszam($cikkszamok)
	{
		$criteria=new CDbCriteria;
		
		$criteria->together = true;
		$criteria->with = array('termek', 'termek.gyarto');
		
		$criteria->select = 'gyarto.cegnev as gyarto, termek.cikkszam as cikkszam, sum(osszes_db) as osszes_db, sum(foglalt_db) as foglalt_db, sum(elerheto_db) as elerheto_db';
		$criteria->group = 'cikkszam, gyarto';

		// minden szóköz, tab, új sor karakter törlése
		if (isset($cikkszamok)) {
			$cikkszamok = preg_replace('/\s+/S', '', $cikkszamok);
		}
		
		$cikkszamokList = (isset($cikkszamok)) ? explode(",", $cikkszamok) : array();
		
		if (count($cikkszamokList)) {
			foreach ($cikkszamokList as $cikkszam) {
				if (strlen($cikkszam) > 0) {
					$criteria->compare('termek.cikkszam', $cikkszam, false, 'OR');
				}
			}
		}
		
		$criteria->order = 'cikkszam ASC';

		$dataProvider = new CActiveDataProvider('RaktarTermekek', array(
			'criteria' => $criteria,
			'pagination'=>array('pageSize'=>100000,)
		));

		if ($dataProvider != null) {			
			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();
	
			$mPDF1->SetHtmlHeader("Raktárkészlet cikkszámok szerint");
			
			# render
			$mPDF1->WriteHTML($this->renderPartial("printRaktarkeszletByCikkszam", array('dataProvider' => $dataProvider), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
		}		
	}	
	
	// termékcsoport szerint csoportosított raktárösszesítés nyomtatása
	public function actionPrintRaktarkeszletByTermekcsoport($termekcsoportok)
	{
		$criteria=new CDbCriteria;
		
		$criteria->together = true;
		$criteria->with = array('termek', 'termek.termekcsoport', 'termek.gyarto');
		
		$criteria->select = 'gyarto.cegnev as gyarto, termek.cikkszam as cikkszam, termek.nev as termeknev, sum(osszes_db) as osszes_db, sum(foglalt_db) as foglalt_db, sum(elerheto_db) as elerheto_db';
		$criteria->group = 'cikkszam, gyarto';

		$termekcsoportokList = (isset($termekcsoportok)) ? explode(",", $termekcsoportok) : array();
		
		if (count($termekcsoportokList)) {
			foreach ($termekcsoportokList as $termekcsoport) {
				$termekcsoport = trim($termekcsoport);
				if (strlen($termekcsoport) > 0) {
					$criteria->compare('termekcsoport.nev', $termekcsoport, false, 'OR');
				}
			}
		}
		
		$criteria->order = 'termeknev ASC';

		$dataProvider = new CActiveDataProvider('RaktarTermekek', array(
			'criteria' => $criteria,
			'pagination'=>array('pageSize'=>100000,)
		));

		if ($dataProvider != null) {			
			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();
	
			$mPDF1->SetHtmlHeader("Raktárkészlet cikkszámok szerint");
			
			# render
			$mPDF1->WriteHTML($this->renderPartial("printRaktarkeszletByTermekcsoport", array('dataProvider' => $dataProvider), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
		}		
	}
	
	// egyik raktárból egy másikba áthelyező dialog feldobását rakja össze
	public function actionTermekAthelyez ($id, $grid_id) {
		$raktarTermek = RaktarTermekek::model() -> findByPk ($id);
		if ($raktarTermek == null) {
			return null;
		}
		
		$model = new TermekAthelyezForm;
		
		if (isset($_POST['TermekAthelyezForm']))
		{
			$model->attributes=$_POST['TermekAthelyezForm'];
			$model->raktarTermekId=$_POST['TermekAthelyezForm']['raktarTermekId'];
			$model->forrasRaktarHelyId=$_POST['TermekAthelyezForm']['forrasRaktarHelyId'];
			$model->forrasElerhetoDb=$_POST['TermekAthelyezForm']['forrasElerhetoDb'];
			$model->forrasFoglaltDb=$_POST['TermekAthelyezForm']['forrasFoglaltDb'];
		} else {
			$model->celElerhetoDb = 0;
			$model->celFoglaltDb = 0;
		}
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'termek-athelyez-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (Yii::app()->request->isAjaxRequest)
        {			
			$model->raktarTermekId = $id;
			$model->termekId = $raktarTermek->termek->id;
			$model->termekNevDsp = $raktarTermek->termek->displayTermekTeljesNev;
			$model->forrasRaktarHelyId = $raktarTermek->raktarhely_id;
			$model->forrasElerhetoDb = $raktarTermek->elerheto_db;
			$model->forrasFoglaltDb = $raktarTermek->foglalt_db;
			
			// Stop jQuery from re-initialization
			Yii::app()->clientScript->scriptMap['*.js'] = false;
			Yii::app()->clientScript->scriptMap['*.css'] = false;
		
			$status = $model -> validate() ? 'success' : 'failure';
			
			// rendben lefutott a validáció és az 'Áthelyez' gombot nyomtuk, akkor végrehajtjuk a tényleges termékáthelyezést
			// ha a forrás és cél megegyezik, akkor nem hajtjuk végre az áthelyezést, mert duplázódnának a darabszámok
			if ($status == 'success' && isset($_GET['form']) && $model->forrasRaktarHelyId != $model->celRaktarHelyId) {
				// megnézzük van-e már egyező beszállításból származó bejegyzése az adott terméknek
				// ha van, odaírjuk az új darabszámokat, ha nincs, akkor létrehozunk egy új rekordot rá
				$ujRaktarTermek = RaktarTermekek::model()->findByAttributes(
					array('termek_id'=>$raktarTermek->termek_id, 'anyagbeszallitas_id'=>$raktarTermek->anyagbeszallitas_id, 'raktarhely_id'=>$model->celRaktarHelyId)
				);
				
				$raktarTermek -> foglalt_db -= $model -> celFoglaltDb;
				$raktarTermek -> osszes_db -= $model -> celFoglaltDb;
				
				$raktarTermek -> elerheto_db -= $model -> celElerhetoDb;
				$raktarTermek -> osszes_db -= $model -> celElerhetoDb;

				$raktarTermek -> save (false);
				
				// összerakjuk és elmentjük a forrás raktártermék rekordot
				if ($ujRaktarTermek == null) {
					$ujRaktarTermek = new RaktarTermekek;
					$ujRaktarTermek -> termek_id = $raktarTermek -> termek_id;
					$ujRaktarTermek -> anyagbeszallitas_id = $raktarTermek -> anyagbeszallitas_id;
					$ujRaktarTermek -> raktarhely_id = $model->celRaktarHelyId;
					$ujRaktarTermek -> osszes_db = 0;
					$ujRaktarTermek -> foglalt_db = 0;
					$ujRaktarTermek -> elerheto_db = 0;
				}
				
				$ujRaktarTermek->osszes_db += $model -> celElerhetoDb;
				$ujRaktarTermek->elerheto_db += $model -> celElerhetoDb;
				
				$ujRaktarTermek->osszes_db += $model -> celFoglaltDb;
				$ujRaktarTermek->foglalt_db += $model -> celFoglaltDb;
				
				$ujRaktarTermek -> save (false);
			}
			
			echo CJSON::encode(array(
				'status'=>$status, 
				'div'=>$this->renderPartial('_termekAthelyez', array('model' => $model, 'grid_id' => $grid_id), true, true)));
			exit;  
        }

	}
	
	// adott termék foglalásának listáját rakja össze
	public function actionFoglaltDbLista ($id, $reszletes, $grid_id) {
		$criteria=new CDbCriteria;
		
		$criteria->together = true;
		$criteria->with = array('termek');

		// ezen lehet finomítani, egyelőre minden oszlop jön, amíg nem fixálódik, hogy pontosan mi kell
		$criteria->select = '*';
		
		$criteria->order = 'termek.cikkszam ASC';
		
		if ($reszletes) {
			// ilyenkor csak 1 db RaktarTermek rekord is lehet
			$criteria->compare('t.id', $id, false);
		} else {
			$raktarTermek = RaktarTermekek::model()->findByPk($id);

			if ($raktarTermek != null) {
				// ilyenkor akár több RaktarTermek rekord is lehet
				$criteria->compare('termek.cikkszam', $raktarTermek -> termek -> cikkszam, false);
			}
		}
		
		$dataProvider = new CActiveDataProvider('RaktarTermekek', array(
			'criteria' => $criteria,
			'pagination' => array('pageSize'=>Utils::getIndexPaginationNumber(),)
		));
		
		echo CJSON::encode(array(
				'status'=>'success', 
				'div'=>$this->renderPartial('_foglaltDbLista', array('dataProvider' => $dataProvider, 'grid_id' => $grid_id), true, true)));
			exit;
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
<?php

class AnyagbeszallitasTermekekController extends Controller
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
	public function actionCreate($id, $gyarto_id, $anyagrendeles_id, $bizonylatszam, $grid_id)
	{
		if ($gyarto_id == null) return null;

	    $model=new AnyagbeszallitasTermekek;
		
		if ($id != null) {
			$model -> anyagbeszallitas_id = $id;
			
			// ha van anyagrendelés id, akkor rámentjük a modelre, különben pl. létrehozáskor
			// nem kerül bele kiválasztás után a modelbe, ezért a termék hozzáadásakor az
			// anyagrendelés id null lesz és rossz helyre mentődik
			//
			// ugyanezt tesszük a bizonylatszám mezővel is
			if ($anyagrendeles_id != null && $anyagrendeles_id != "") {
				$anyagbeszallitas = Anyagbeszallitasok::model() -> findByPk ($id);
				$anyagbeszallitas -> anyagrendeles_id = $anyagrendeles_id;
				
				// bizonylatszám
				if ($bizonylatszam != null && $bizonylatszam != "" && $bizonylatszam != "undefined")
					$anyagbeszallitas -> bizonylatszam = $bizonylatszam;
					
				$anyagbeszallitas -> save();
			}
		}
		
		// Keresés esetén visszaadjuk a szűrt listát és kilépünk a metódusból
		$termek=new Termekek('search');
		$termek->unsetAttributes();  // clear any default values
		$termek->gyarto_id = $gyarto_id;
		
		if (isset($_GET['ajax']) && strpos($_GET['ajax'], 'termekek-grid') !== FALSE) {
			if(isset($_GET['Termekek'])) {
				$termek->attributes=$_GET['Termekek'];
			}
			
			// Stop jQuery from re-initialization
			Yii::app()->clientScript->scriptMap['*.js'] = false;
			Yii::app()->clientScript->scriptMap['*.css'] = false;
			
			$this->renderPartial('_form', array('model'=>$model, 'termek' => $termek, 'grid_id' => $grid_id), false, true);
			exit;
		}
		
		// LI : beállítjuk a termékmodelt, ami egy dataprovider, ami a termékek listáját tartalmazza
		//$termek_model=new CActiveDataProvider('Termekek',
		//	array( 'criteria'=>array('order'  => 'nev ASC',),
		//	)
		//);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
 
        if(isset($_POST['AnyagbeszallitasTermekek']))
        {
            $model->attributes=$_POST['AnyagbeszallitasTermekek'];
            if($model->save())
            {
                if (Yii::app()->request->isAjaxRequest)
                {
					// Stop jQuery from re-initialization
					Yii::app()->clientScript->scriptMap['*.js'] = false;
					Yii::app()->clientScript->scriptMap['*.css'] = false;
		
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        'div'=>""
                        ));
                    exit;               
                }
                else {
                    $this->redirect(array('view','id'=>$model->id));
				}
            }
        }
 
		// Stop jQuery from re-initialization
		Yii::app()->clientScript->scriptMap['*.js'] = false;
		Yii::app()->clientScript->scriptMap['*.css'] = false;

		echo CJSON::encode(array(
			'status'=>'failure', 
			'div'=>$this->renderPartial('_form', array('model'=>$model, 'termek' => $termek, 'grid_id' => $grid_id), true, true)
			)
		);
		
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id, $gyarto_id, $grid_id)
	{
	    $model = $this->loadModel($id);

		// Keresés esetén visszaadjuk a szűrt listát és kilépünk a metódusból
		$termek=new Termekek('search');
		$termek->unsetAttributes();  // clear any default values
		$termek->gyarto_id = $gyarto_id;
		
		if (isset($_GET['ajax']) && strpos($_GET['ajax'], 'termekek-grid') !== FALSE) {
			if(isset($_GET['Termekek'])) {
				$termek->attributes=$_GET['Termekek'];
			}
			
			// Stop jQuery from re-initialization
			Yii::app()->clientScript->scriptMap['*.js'] = false;
			Yii::app()->clientScript->scriptMap['*.css'] = false;
			
			$this->renderPartial('_form', array('model'=>$model, 'termek' => $termek, 'grid_id' => $grid_id), false, true);
			exit;
		}
		
		if ($id == null || $gyarto_id == null) return null;
		
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
 
        if(isset($_POST['AnyagbeszallitasTermekek']))
        {
            $model->attributes=$_POST['AnyagbeszallitasTermekek'];
			$model->id = $id;

            if($model->save())
            {
                if (Yii::app()->request->isAjaxRequest)
                {
					// Stop jQuery from re-initialization
					Yii::app()->clientScript->scriptMap['*.js'] = false;
					Yii::app()->clientScript->scriptMap['*.css'] = false;
		
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        'div'=>""
                        ));
                    exit;               
                }
                else {
                    $this->redirect(array('view','id'=>$model->id));
				}
            }
        }
 
        if (Yii::app()->request->isAjaxRequest)
        {
			// Stop jQuery from re-initialization
			Yii::app()->clientScript->scriptMap['*.js'] = false;
			Yii::app()->clientScript->scriptMap['*.css'] = false;

            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_form', array('model'=>$model, 'termek' => $termek, 'grid_id' => $grid_id), true, true)));
            exit;               
        }
        else {
            //$this->render('create',array('model'=>$model, 'termek_model' => $termek_model,));
		}
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
		$dataProvider=new CActiveDataProvider('AnyagbeszallitasTermekek');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionCalculateNettoDarabAr ($ugyfel_id, $termek_id, $darabszam) {
			if (isset($termek_id)) {
				$result = Utils::getActiveTermekar($termek_id, $darabszam);

				echo ($result != null && is_array($result)) ? $result['db_beszerzesi_ar'] : 0;
				die();
			}

			echo 0;
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AnyagbeszallitasTermekek('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AnyagbeszallitasTermekek']))
			$model->attributes=$_GET['AnyagbeszallitasTermekek'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AnyagbeszallitasTermekek the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AnyagbeszallitasTermekek::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AnyagbeszallitasTermekek $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='anyagbeszallitas-termekek-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

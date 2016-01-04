<?php

class NyomdakonyvLejelentesController extends Controller
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
	public function actionCreate ($id)
	{
		$model = new NyomdakonyvLejelentes;
		$nyomdakonyv_model = Nyomdakonyv::model()->findByPk($id) ;

		if ($id != null) {
			$model -> nyomdakonyv_id = $id;
		}

//Ez a rész átgondolandó, hogy kell-e. A régi progiban a kézi lejelentésbe nem húzta be a géptermi programból az adatokat		
		$workflow_dbf_url = rawurlencode(Yii::app()->config->get('WorkflowDbfPath'));
		$parameters = array() ;
		$parameters[] = array("field"=>"TSZAM", "value"=>rawurlencode($nyomdakonyv_model->taskaszam), "op"=>"=") ;
		$query_url = "http://" . $_SERVER["HTTP_HOST"] . "/gepterem_komm/dbfcomm.php?mode=select&dbf=" . $workflow_dbf_url . "&filter=" . json_encode($parameters) ;
		$result = unserialize(Utils::httpGet($query_url)) ;
		if (count($result) == 0) {
//Ide jön az, hogy kiolvassuk a workflow-ból az adott munkához a termelési adatokat, utána lementjük a dom_nyomda_munka_teljesitmeny a melósonkénti teljesítményt és a dom_nyomdakonyv-be a jó, selejt, vissza adatokat
		}
//Géptermi programból a termelési adatok beolvasása eddig.		
			
		if(isset($_POST['NyomdakonyvLejelentes']))
        {
            $model->attributes=$_POST['NyomdakonyvLejelentes'];
			
            if($model->save())
            {
                if (Yii::app()->request->isAjaxRequest)
                {
					// Stop jQuery from re-initialization
//					Yii::app()->clientScript->scriptMap['*.js'] = false;
//					Yii::app()->clientScript->scriptMap['*.css'] = false;
		
                    echo CJSON::encode(array(
                        'status'=>'success',
                        'div'=>$this->renderPartial('_form', array('model'=>$model, 'nyomdakonyv_model'=>$nyomdakonyv_model), true, true)				                        
                        ));
                    exit;               
                }
                else {
                    $this->redirect(array('view', 'id'=>$model->id));
				}
            }
        }
		
        if (Yii::app()->request->isAjaxRequest)
        {
			// Stop jQuery from re-initialization
//			Yii::app()->clientScript->scriptMap['*.js'] = false;
//			Yii::app()->clientScript->scriptMap['*.css'] = false;
		
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_form', array('model'=>$model, 'nyomdakonyv_model'=>$nyomdakonyv_model), true, true)));
            exit;               
        }
        else {
            $this->render('create',array('model'=>$model, 'nyomdakonyv_model'=>$nyomdakonyv_model));
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
		$nyomdakonyv_model = Nyomdakonyv::model()->findByPk($model->nyomdakonyv_id) ;
	
		if(isset($_POST['NyomdakonyvLejelentes']))
        {
            $model->attributes=$_POST['NyomdakonyvLejelentes'];
			
            if($model->save())
            {			
                if (Yii::app()->request->isAjaxRequest)
                {
					// Stop jQuery from re-initialization
//					Yii::app()->clientScript->scriptMap['*.js'] = false;
//					Yii::app()->clientScript->scriptMap['*.css'] = false;
		
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        'div'=>$this->renderPartial('_form', array('model'=>$model, 'nyomdakonyv_model'=>$nyomdakonyv_model), true, true)				                        
			           ));
                    exit;               
                }
                else {
                    $this->redirect(array('view', 'id'=>$model->id, 'nyomdakonyv_model'=>$nyomdakonyv_model));
				}
            }
        }
		
        if (Yii::app()->request->isAjaxRequest)
        {
			// Stop jQuery from re-initialization
//			Yii::app()->clientScript->scriptMap['*.js'] = false;
//			Yii::app()->clientScript->scriptMap['*.css'] = false;
		
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_form', array('model'=>$model, 'nyomdakonyv_model'=>$nyomdakonyv_model), true, true)));
            exit;               
        }
        else {
            
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$nyomdakonyv_model = Nyomdakonyv::model()->findByPk($model->nyomdakonyv_id) ;
		$model->delete();
		$model = new NyomdakonyvLejelentes;
		
		

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		} else {
			echo CJSON::encode(array(
				'status'=>'success',
                'div'=>$this->renderPartial('_form', array('model'=>$model, 'nyomdakonyv_model'=>$nyomdakonyv_model), true, true)				
			));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('NyomdakonyvLejelentes');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new NyomdakonyvLejelentes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['NyomdakonyvLejelentes']))
			$model->attributes=$_GET['NyomdakonyvLejelentes'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Az előregépelős termékkiválasztóhoz kell.
	 */
/*	public function actionAutoCompleteTermek ()
	{
		$arr = array();
		if ($_GET['term']) {
			$match = addcslashes($_GET['term'], '%_');
			$q = new CDbCriteria( array(
				'condition' => "nev LIKE :match",
				'params'    => array(':match' => "%$match%")
			) );
			 
			$termekek = Termekek::model()->findAll( $q );

			foreach($termekek as $termek) {
				$termekAr = Utils::getActiveTermekar ($termek->id);
				$ar = ($termekAr == 0) ? 0 : $termekAr["db_eladasi_ar"];
				
				$arr[] = array(
					'label'=>$termek->nev,
					'value'=>$termek->nev,
					'ar'=>$ar,
					'id'=>$termek->id,
					);      
			}
		}
		echo CJSON::encode($arr);
	}	*/
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MegrendelesTetelek the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=NyomdakonyvLejelentes::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param NyomdakonyvLejelentes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='nyomdakonyv-lejelentes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}	
}
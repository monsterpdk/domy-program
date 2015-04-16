<?php

class ArajanlatTetelekController extends Controller
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
	public function actionCreate ($id, $arkategoria_id)
	{
		$model = new ArajanlatTetelek;

		if ($id != null) {
			$model -> arajanlat_id = $id;
		}
		
		// beállítjuk a kiválasztott áruházhoz tartózó szorzót,
		// ezzel tudunk majd árat beajánlani a termékkiválasztást követően
		$szorzo_tetel_arhoz = 1;
		if ($arkategoria_id != null) {
			$aruhaz = Aruhazak::model() -> findByPk ($arkategoria_id);
			
			if ($aruhaz != null) {
				$szorzo_tetel_arhoz = $aruhaz -> arkategoria -> szorzo;
			}
		}
		$model -> szorzo_tetel_arhoz = $szorzo_tetel_arhoz;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ArajanlatTetelek']))
        {
            $model->attributes=$_POST['ArajanlatTetelek'];
			
            if($model->save())
            {
				// megnézzük, hogy egyedi árról van-e szó
				$egyedi = Utils::isEgyediAr ($model->arajanlat_id, false);
				
                if (Yii::app()->request->isAjaxRequest)
                {
					// Stop jQuery from re-initialization
					Yii::app()->clientScript->scriptMap['*.js'] = false;
					Yii::app()->clientScript->scriptMap['*.css'] = false;
		
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        'egyedi'=> ($egyedi ? '1' : '0')
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
			Yii::app()->clientScript->scriptMap['*.js'] = false;
			Yii::app()->clientScript->scriptMap['*.css'] = false;
		
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_form', array('model'=>$model,), true, true)));
            exit;               
        }
        else {
            $this->render('create',array('model'=>$model,));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id, $arkategoria_id)
	{
		$model = $this->loadModel($id);

		// beállítjuk a kiválasztott áruházhoz tartózó szorzót,
		// ezzel tudunk majd árat beajánlani a termékkiválasztást követően
		$szorzo_tetel_arhoz = 1;
		if ($arkategoria_id != null) {
			$aruhaz = Aruhazak::model() -> findByPk ($arkategoria_id);
			
			if ($aruhaz != null) {
				$szorzo_tetel_arhoz = $aruhaz -> arkategoria -> szorzo;
			}
		}
		$model -> szorzo_tetel_arhoz = $szorzo_tetel_arhoz;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ArajanlatTetelek']))
        {
            $model->attributes=$_POST['ArajanlatTetelek'];
			
            if($model->save())
            {
				// megnézzük, hogy egyedi árról van-e szó
				$egyedi = Utils::isEgyediAr ($model->arajanlat_id, false);
				
                if (Yii::app()->request->isAjaxRequest)
                {
					// Stop jQuery from re-initialization
					Yii::app()->clientScript->scriptMap['*.js'] = false;
					Yii::app()->clientScript->scriptMap['*.css'] = false;
		
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        'egyedi'=> ($egyedi ? '1' : '0')
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
			Yii::app()->clientScript->scriptMap['*.js'] = false;
			Yii::app()->clientScript->scriptMap['*.css'] = false;
		
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_form', array('model'=>$model,), true, true)));
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
		$arajanlat_id = $model->arajanlat_id;
		$model->delete();
		
		$egyedi = Utils::isEgyediAr ($arajanlat_id, false);
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		} else {
			echo CJSON::encode(array(
				'status'=>'success', 
				'egyedi'=> ($egyedi ? '1' : '0')
			));
		}

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ArajanlatTetelek');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ArajanlatTetelek('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ArajanlatTetelek']))
			$model->attributes=$_GET['ArajanlatTetelek'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Az előregépelős termékkiválasztóhoz kell.
	 */
	public function actionAutoCompleteTermek ()
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
	}	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ArajanlatTetelek the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ArajanlatTetelek::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ArajanlatTetelek $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='arajanlat-tetelek-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

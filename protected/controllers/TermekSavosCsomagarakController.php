<?php

class TermekSavosCsomagarakController extends Controller
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
	public function actionCreate ($id, $grid_id)
	{
		$model = new TermekSavosCsomagarak;

		if ($id != null) {
			$model -> termek_ar_id = $id;
		}
		
		
		if(isset($_POST['TermekSavosCsomagarak']))
        {
            $model->attributes=$_POST['TermekSavosCsomagarak'];
			
            if($model->save())
            {
                if (Yii::app()->request->isAjaxRequest)
                {
					// Stop jQuery from re-initialization
					Yii::app()->clientScript->scriptMap['*.js'] = false;
					Yii::app()->clientScript->scriptMap['*.css'] = false;
		
                    echo CJSON::encode(array(
                        'status'=>'success',
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
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
			Yii::app()->clientScript->scriptMap['*.css'] = false;
		
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_form', array('model'=>$model, 'grid_id'=>$grid_id), true, true)));
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
	public function actionUpdate($id, $grid_id)
	{
		$model = $this->loadModel($id);
		
		$sav=new TermekSavosCsomagarak('search');
		$sav->unsetAttributes();  // clear any default values
		
		if (isset($_GET['ajax']) && strpos($_GET['ajax'], 'visszahivasok-grid') !== FALSE) {
			if(isset($_GET['Savok'])) {
				$savok->attributes=$_GET['Savok'];
			}
			
			// Stop jQuery from re-initialization
			Yii::app()->clientScript->scriptMap['*.js'] = false;
			Yii::app()->clientScript->scriptMap['*.css'] = false;
			
			$this->renderPartial('_form', array('model'=>$model, 'sav' => $sav, 'grid_id'=>$grid_id), false, true);
			exit;
		}
		
		if(isset($_POST['TermekSavosCsomagarak']))
        {
            $model->attributes=$_POST['TermekSavosCsomagarak'];
			
            if($model->save())
            {
                if (Yii::app()->request->isAjaxRequest)
                {
					// Stop jQuery from re-initialization
					Yii::app()->clientScript->scriptMap['*.js'] = false;
					Yii::app()->clientScript->scriptMap['*.css'] = false;
		
                    echo CJSON::encode(array(
                        'status'=>'success', 
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
                'div'=>$this->renderPartial('_form', array('model'=>$model, 'visszahivas' => $visszahivas, 'grid_id'=>$grid_id), true, true)));
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
//		$termek_id = $model->termek_id;
		$model->delete();
				
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		} else {
			echo CJSON::encode(array(
				'status'=>'success', 
			));
		}

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('TermekSavosCsomagarak');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TermekSavosCsomagarak('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TermekSavosCsomagarak']))
			$model->attributes=$_GET['TermekSavosCsomagarak'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TermekSavosCsomagarak the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TermekSavosCsomagarak::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TermekSavosCsomagarak $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='savos-csomagarak-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
}
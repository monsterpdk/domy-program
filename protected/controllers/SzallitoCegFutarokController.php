<?php

class SzallitoCegFutarokController extends Controller
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
	public function actionCreate($id, $szallito_ceg_id, $grid_id)
	{
		if ($szallito_ceg_id == null) return null;

		$model = new SzallitoCegFutarok;
		$model -> szallito_ceg_id = $szallito_ceg_id;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['SzallitoCegFutarok']))
		{
			$model->attributes=$_POST['SzallitoCegFutarok'];
			
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
                'div'=>$this->renderPartial('_form', array('model'=>$model, 'grid_id'=>$grid_id), true, true)));
            exit;               
        }
        else {
            $this->render('create',array('model'=>$model, 'grid_id'=>$grid_id,));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id, $szallito_ceg_id, $grid_id)
	{
		$model = $this->loadModel($id);

		if ($id == null || $szallito_ceg_id == null) return null;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SzallitoCegFutarok']))
		{
			$model->attributes=$_POST['SzallitoCegFutarok'];
			$model->szallito_ceg_id = $szallito_ceg_id;
			
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
                'div'=>$this->renderPartial('_form', array('model'=>$model, 'grid_id'=>$grid_id), true, true)));
            exit;               
        }
        else {
            $this->render('create',array('model'=>$model, 'grid_id'=>$grid_id,));
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
		$dataProvider=new CActiveDataProvider('SzallitoCegFutarok');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new RaktarHelyek('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SzallitoCegFutarok']))
			$model->attributes=$_GET['SzallitoCegFutarok'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return RaktarHelyek the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SzallitoCegFutarok::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param RaktarHelyek $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='szallito-ceg-futar-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/* Ha kiválasztották a futárcéget a futárlevél készítésnél, ez a függvény adja vissza az adott céghez felvett futárokat a futáros lenyílóba */
	public function actionFutarlistaAjax() {
		$ceg_id = $_POST['futarceg_id'];
		
		$futarok = SzallitoCegFutarok::model()->findAllByAttributes(array('szallito_ceg_id'=>$ceg_id));
		if (count($futarok) > 0) {
			foreach ($futarok as $futar) {
				echo CHtml::tag('option', array('value'=>$futar->id),CHtml::encode($futar->nev),true);
			}
		}
	}
}

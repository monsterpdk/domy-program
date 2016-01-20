<?php

class AnyagrendelesTermekekController extends Controller
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
	public function actionCreate($id, $gyarto_id, $grid_id)
	{
		if ($gyarto_id == null) return null;
		
		$model=new AnyagrendelesTermekek;		
		
		if ($id != null) {
			$model -> anyagrendeles_id = $id;
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
			
			$this->renderPartial('_form', array('model'=>$model, 'termek' => $termek, 'grid_id'=>$grid_id), false, true);
			exit;
		}
 
		// LI : beállítjuk a termékmodelt, ami egy dataprovider, ami a termékek listáját tartalmazza a megfelelő gyártóra szűrve
		$termek_model=new CActiveDataProvider('Termekek',
			array( 'criteria'=>array('condition'=>"gyarto_id = " . $gyarto_id, 'order'  => 'nev ASC',),

			)
		);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
 
        if(isset($_POST['AnyagrendelesTermekek']))
        {
            $model->attributes=$_POST['AnyagrendelesTermekek'];
			
			$termek_id = $model ->termek_id;
			if (is_numeric ($termek_id)) {
				$termek = Termekek::model() -> findByPk ($termek_id);
				
				if ($termek != null) {
					$model -> autocomplete_termek_name = $termek ->nev;
				}
			}
			
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
                'div'=>$this->renderPartial('_form', array('model'=>$model, 'termek' => $termek, 'grid_id'=>$grid_id), true, true)));
            exit;               
        }
        else {
            $this->render('create',array('model'=>$model, 'termek' => $termek, 'grid_id'=>$grid_id,));
		}

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
			
			$this->renderPartial('_form', array('model'=>$model, 'termek' => $termek, 'grid_id'=>$grid_id), false, true);
			exit;
		}
		
		if ($id == null || $gyarto_id == null) return null;
		
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
		
        if(isset($_POST['AnyagrendelesTermekek']))
        {
            $model->attributes=$_POST['AnyagrendelesTermekek'];

			$termek_id = $model->termek_id;
			if (is_numeric ($termek_id)) {
				$termek = Termekek::model() -> findByPk ($termek_id);
				
				if ($termek != null) {
					$model -> autocomplete_termek_name = $termek ->nev;
				}
			}

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
                'div'=>$this->renderPartial('_form', array('model'=>$model, 'termek' => $termek, 'grid_id'=>$grid_id), true, true)));
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
		$dataProvider=new CActiveDataProvider('AnyagrendelesTermekek');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AnyagrendelesTermekek('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AnyagrendelesTermekek']))
			$model->attributes=$_GET['AnyagrendelesTermekek'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function setFlash( $key, $value, $defaultValue = null )
	{
	  Yii::app()->user->setFlash( $key, $value, $defaultValue );
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AnyagrendelesTermekek the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AnyagrendelesTermekek::model()->findByPk($id);
		
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AnyagrendelesTermekek $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='anyagrendeles-termekek-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

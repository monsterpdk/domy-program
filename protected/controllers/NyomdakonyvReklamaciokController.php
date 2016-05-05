<?php

class NyomdakonyvReklamaciokController extends Controller
{

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new NyomdakonyvReklamaciok;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['NyomdakonyvReklamaciok']))
		{
			$model->attributes=$_POST['NyomdakonyvReklamaciok'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['NyomdakonyvReklamaciok']))
		{
			$model->attributes=$_POST['NyomdakonyvReklamaciok'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	// a reklamációhoz szükséges adatokat és form-ot rakja össze és adja vissza JSON-ben
	public function actionReklamacio ($id)
	{

		if (isset($_POST['NyomdakonyvReklamaciok']))
		{
			$reklamacio = NyomdakonyvReklamaciok::model()->findByAttributes(array('nyomdakonyv_id'=>$id)) ;
			
			$model = $reklamacio != null ? $reklamacio : new NyomdakonyvReklamaciok; 
			$model->attributes=$_POST['NyomdakonyvReklamaciok'];
			
			$model -> datum = new CDbExpression('NOW()');

			if (!$model->validate()) {
				echo CJSON::encode(array(
					'status' => 'failure',
					'div' => $model->getErrors()
				));
			}	
				
			if (isset($_GET['form']) && $model->save()) {
				echo CJSON::encode(array(
					'status' => 'success',
				));
			} else {
			}
		} else if(Yii::app()->request->isAjaxRequest && !empty($id))
        {
			// ha van már létező reklamáció, akkor azt töltjük be, ha nincs, akkor egy újat hozunk létre
			$nyomdakonyv = Nyomdakonyv::model() ->findByPk ($id);
			
			if ($nyomdakonyv != null) {
				$reklamacio = NyomdakonyvReklamaciok::model()->findByAttributes(array('nyomdakonyv_id'=>$nyomdakonyv -> id)) ;
				if ($reklamacio != null) {
					$model = $reklamacio;
				} else {
					$model = new NyomdakonyvReklamaciok;
					$model -> nyomdakonyv_id = $id;
				}
			} else {
				$model = new NyomdakonyvReklamaciok;
				$model -> nyomdakonyv_id = $id;
			}
			
			Yii::app()->clientScript->scriptMap['*.js'] = false;
			Yii::app()->clientScript->scriptMap['*.css'] = false;

			echo CJSON::encode(array(
				'status' => 'success',
				'div'=>$this->renderPartial('_form', array('model'=>$model,), true, true),
			));
        }
            
    }
	
	// a felhasználók (felelősök) előregépelős beajánlásának keresője
	public function actionSearchFelelosok ($term)
	{
		if(Yii::app()->request->isAjaxRequest && !empty($term))
        {
              $variants = array();
              $criteria = new CDbCriteria;
              $criteria->select='fullname';
              $criteria->addSearchCondition('fullname',$term.'%',false);
              $users = User::model()->findAll($criteria);
			  
              if(!empty($users))
              {
                foreach($users as $user)
                {
                    $variants[] = $user->attributes['fullname'];
                }
              }
			  
              echo CJSON::encode($variants);
        }
        else
            throw new CHttpException(400, 'Hibás kérés.');
    }
	
	// egy reklamáció PDF-re történő konvertálását végzi (nyomtatás funkcióhoz)
	public function actionPrintPDF()
	{
		if (isset($_GET['id'])) {
			$model = $this->loadModel($_GET['id']);
		}
		
		if ($model != null) {
			# mPDF
			$mPDF1 = Yii::app()->ePdf->mpdf();

			$mPDF1->SetHtmlHeader("Reklamáció #" . $model->id);
			
			# render
			$mPDF1->WriteHTML($this->renderPartial('printReklamacio', array('model' => $model), true));
	 
			# Outputs ready PDF
			$mPDF1->Output();
		}
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return NyomdakonyvReklamaciok the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=NyomdakonyvReklamaciok::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param NyomdakonyvReklamaciok $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='nyomdakonyv-reklamaciok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

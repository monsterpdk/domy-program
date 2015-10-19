<?php

class NyomdaMunkatipusTermekekController extends Controller
{
	
	public function actionCreate($id, $grid_id)
	{
		if ($id != null) {
			$model = NyomdaMunkatipusok::model()->findByPk($id);
		} else exit();
		
		// Keresés esetén visszaadjuk a szűrt listát és kilépünk a metódusból
		$termek=new Termekek('search');
		$termek->unsetAttributes();  // clear any default values
		
		if (isset($_GET['ajax']) && strpos($_GET['ajax'], 'nyomda-munkatipus-termek-grid') !== FALSE) {
			if(isset($_GET['Termekek'])) {
				$termek->attributes=$_GET['Termekek'];
			}
			
			// Stop jQuery from re-initialization
			Yii::app()->clientScript->scriptMap['*.js'] = false;
			Yii::app()->clientScript->scriptMap['*.css'] = false;
			
			$this->renderPartial('_form', array('model' => $model, 'termek' => $termek, 'grid_id'=>$grid_id), false, true);
			
			exit;
		}
		
		if (Yii::app()->request->isAjaxRequest)
        {
			// Stop jQuery from re-initialization
			Yii::app()->clientScript->scriptMap['*.js'] = false;
			Yii::app()->clientScript->scriptMap['*.css'] = false;
		
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_form', array('model' => $model, 'termek' => $termek, 'grid_id'=>$grid_id), true, true)));
            exit;               
        }
        else {
            $this->render('create',array('termek'=>$termek,));
		}
		
	}

	public function actionDelete($id)
	{
		$model=$this->loadModel($id);
		$model->delete();
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionAssignTermekToMunkatipus ($id, $termek_id) {
		if ($id != null & $termek_id != null) {
			$munkatipus = NyomdaMunkatipusok::model() -> findByPk($id);
			$termek = Termekek::model() -> findByPk($id);
			
			if ($munkatipus != null && $termek != null) {
				$munkatipusTermek = new NyomdaMunkatipusTermekek ();
				$munkatipusTermek->munkatipus_id = $id;
				$munkatipusTermek->termek_id = $termek_id;
				$munkatipusTermek->save();
				
				echo CJSON::encode(array(
					'status'=>'success', 
					'div'=>''));
				exit;
			}
		}
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return NyomdaMunkatipusTermekek the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=NyomdaMunkatipusTermekek::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param NyomdaMunkatipusTermekek $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='nyomda-munkatipusok-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NyomdaMunkatipusok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
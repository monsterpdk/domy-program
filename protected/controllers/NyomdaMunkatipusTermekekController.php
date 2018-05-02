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

	public function actionCreateCsoport($id, $grid_id) {
		if ($id != null) {
			$model = NyomdaMunkatipusok::model()->findByPk($id);
		} else exit();

		// Keresés esetén visszaadjuk a szűrt listát és kilépünk a metódusból
		$termekcsoport=new Termekcsoportok('search');
		$termekcsoport->unsetAttributes();  // clear any default values

		if (isset($_GET['ajax']) && strpos($_GET['ajax'], 'nyomda-munkatipus-termekcsoport-grid') !== FALSE) {
			if(isset($_GET['Termekcsoportok'])) {
				$termekcsoport->attributes=$_GET['Termekcsoportok'];
			}

			// Stop jQuery from re-initialization
			Yii::app()->clientScript->scriptMap['*.js'] = false;
			Yii::app()->clientScript->scriptMap['*.css'] = false;

			$this->renderPartial('_csoportform', array('model' => $model, 'termekcsoport' => $termekcsoport, 'grid_id'=>$grid_id), false, true);

			exit;
		}

		if (Yii::app()->request->isAjaxRequest)
		{
			// Stop jQuery from re-initialization
			Yii::app()->clientScript->scriptMap['*.js'] = false;
			Yii::app()->clientScript->scriptMap['*.css'] = false;

			echo CJSON::encode(array(
				'status'=>'failure',
				'div'=>$this->renderPartial('_csoportform', array('model' => $model, 'termekcsoport' => $termekcsoport, 'grid_id'=>$grid_id), true, true)));
			exit;
		}
		else {
			$this->render('create',array('termekcsoport'=>$termekcsoport,));
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

	public function actionAssignTermekcsoportToMunkatipus ($id, $termekcsoport_id) {
		if ($id != null & $termekcsoport_id != null) {
			$munkatipus = NyomdaMunkatipusok::model() -> findByPk($id);
			$termekek = Termekek::model() -> findAllByAttributes(array("termekcsoport_id"=>$termekcsoport_id));
			$hibasak = 0 ;
			foreach ($termekek as $termek) {
				if ($munkatipus != null && $termek != null) {
					if (NyomdaMunkatipusTermekek::model() -> findByAttributes(array("munkatipus_id"=>$id, "termek_id"=>$termek->id)) == null) {
						$munkatipusTermek = new NyomdaMunkatipusTermekek ();
						$munkatipusTermek->munkatipus_id = $id;
						$munkatipusTermek->termek_id = $termek->id;
						$munkatipusTermek->save();
					}
				}
				else
				{
					$hibasak++ ;
				}
			}
			$status = "success" ;
			if ($hibasak > 0) {
				$status = "error" ;
			}
			echo CJSON::encode(array(
				'status' => $status,
				'div' => ''));
			exit;
		}
	}

	public function actionRemoveTermekcsoportFromMunkatipus ($id, $termekcsoport_id) {
		if ($id != null & $termekcsoport_id != null) {
			Yii::app()->db->createCommand('delete dom_nyomda_munkatipus_termekek.* from dom_nyomda_munkatipus_termekek left join dom_termekek on (dom_nyomda_munkatipus_termekek.termek_id = dom_termekek.id) where munkatipus_id = :id and dom_termekek.termekcsoport_id = :termekcsoport_id')->bindValue('id',$id)->bindValue('termekcsoport_id',$termekcsoport_id)->query();
			$status = "success" ;
			echo CJSON::encode(array(
				'status' => $status,
				'div' => ''));
			exit;
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
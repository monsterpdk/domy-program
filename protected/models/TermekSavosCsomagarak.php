<?php

/**
 * This is the model class for table "dom_termek_ar_savos_csomagarak".
 *
 * The followings are the available columns in table 'dom_termek_ar_savos_csomagarak':
 * @property string $id
 * @property string $termek_ar_id
 * @property integer $csomagszam_tol
 * @property integer $csomagszam_ig
 * @property float $csomag_ar_szamolashoz
 * @property float $csomag_ar_nyomashoz
 * @property float $csomag_eladasi_ar
 * @property integer $torolt
 */
class TermekSavosCsomagarak extends CActiveRecord
{
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_termek_ar_savos_csomagarak';
	}

	public function getClassName ()
	{
		return "Termék sávos csomag árak";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('termek_ar_id, csomagszam_tol, csomagszam_ig, csomag_ar_szamolashoz, csomag_ar_nyomashoz, csomag_eladasi_ar', 'required'),
			array('termek_ar_id, csomagszam_tol, csomagszam_ig, torolt', 'numerical', 'integerOnly'=>true),
			array('csomag_ar_szamolashoz, csomag_ar_nyomashoz, csomag_eladasi_ar', 'numerical'),
			array('csomagszam_tol, csomagszam_ig', 'savhoz_tartozik_e'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, termek_ar_id, csomagszam_tol, csomagszam_ig, csomag_ar_szamolashoz, csomag_ar_nyomashoz, csomag_eladasi_ar, torolt', 'safe', 'on'=>'search'),
		);
	}
	
	public function savhoz_tartozik_e ($attribute)
	{
		$criteria = new CDbCriteria();
		if (is_numeric($this->id)) { 
			$criteria->condition = "termek_ar_id = :termek_ar_id and ((csomagszam_tol <= :csomagszam_tol and csomagszam_ig >= :csomagszam_ig) or (csomagszam_tol <= :csomagszam_tol and csomagszam_ig >= :csomagszam_tol) or (csomagszam_tol >= :csomagszam_tol and csomagszam_ig >= :csomagszam_ig) ) and id != :id";
			$criteria->params = array(':termek_ar_id' => $this->termek_ar_id, ':csomagszam_tol' => $this->csomagszam_tol, ':csomagszam_ig' => $this->csomagszam_ig, ':id' => $this->id);
		}
		else
		{
			$criteria->condition = "termek_ar_id = :termek_ar_id and ((csomagszam_tol <= :csomagszam_tol and csomagszam_ig >= :csomagszam_ig) or (csomagszam_tol <= :csomagszam_tol and csomagszam_ig >= :csomagszam_tol) or (csomagszam_tol >= :csomagszam_tol and csomagszam_ig >= :csomagszam_ig) )";
			$criteria->params = array(':termek_ar_id' => $this->termek_ar_id, ':csomagszam_tol' => $this->csomagszam_tol, ':csomagszam_ig' => $this->csomagszam_ig);			
		}
		$beleeso_savok = TermekSavosCsomagarak::model()->findAll($criteria);
		if ($beleeso_savok != null)
			$this->addError($attribute, 'A megadott tól-ig darabszám intervallumába beleesik egy már megadott sáv. Nem lehetnek átfedések a sávok között!');
	}
	

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'termek_ar' => array(self::BELONGS_TO, 'TermekArak', 'termek_ar_id'),
		);
	}

	public function behaviors() {
		return array( 'LoggableBehavior'=> 'application.modules.auditTrail.behaviors.LoggableBehavior', );
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Tétel ID',
			'termek_ar_id' => 'Termék ár ID',
			'csomagszam_tol' => 'Ennyi csomagtól',
			'csomagszam_ig' => 'Ennyi csomagig',
			'csomag_ar_szamolashoz' => 'Csomag ár számoláshoz (Ft)',
			'csomag_ar_nyomashoz' => 'Csomag ár nyomáshoz (Ft)',
			'csomag_eladasi_ar' => 'Csomag eladasi ár (Ft)',
			'torolt' => 'Törölt',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('termek_ar_id',$this->termek_ar_id,true);
		$criteria->compare('csomagszam_tol',$this->csomagszam_tol);
		$criteria->compare('csomagszam_ig',$this->csomagszam_ig);
		$criteria->compare('csomag_ar_szamolashoz',$this->csomag_ar_szamolashoz);
		$criteria->compare('csomag_ar_nyomashoz',$this->csomag_ar_nyomashoz);
		$criteria->compare('csomag_eladasi_ar',$this->csomag_eladasi_ar);
		$criteria->compare('torolt',$this->torolt);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TermekSavosCsomagarak the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}

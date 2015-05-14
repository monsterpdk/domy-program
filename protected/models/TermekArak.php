<?php

/**
 * This is the model class for table "dom_termek_arak".
 *
 * The followings are the available columns in table 'dom_termek_arak':
 * @property string $id
 * @property string $termek_id
 * @property double $csomag_beszerzesi_ar
 * @property double $db_beszerzesi_ar
 * @property double $csomag_ar_szamolashoz
 * @property double $csomag_ar_nyomashoz
 * @property double $db_ar_nyomashoz
 * @property double $csomag_eladasi_ar
 * @property double $db_eladasi_ar
 * @property double $csomag_ar2
 * @property double $db_ar2
 * @property double $csomag_ar3
 * @property double $db_ar3
 * @property string $datum_mettol
 * @property string $datum_meddig
 * @property integer $torolt
 */
class TermekArak extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_termek_arak';
	}

	public function getClassName ()
	{
		return 'Termékár';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('termek_id, csomag_beszerzesi_ar, db_beszerzesi_ar, csomag_ar_szamolashoz, csomag_ar_nyomashoz, db_ar_nyomashoz, csomag_eladasi_ar, db_eladasi_ar, csomag_ar2, db_ar2, csomag_ar3, db_ar3, datum_mettol, datum_meddig', 'required'),
			array('torolt', 'numerical', 'integerOnly'=>true),
			array('csomag_beszerzesi_ar, db_beszerzesi_ar, csomag_ar_szamolashoz, csomag_ar_nyomashoz, db_ar_nyomashoz, csomag_eladasi_ar, db_eladasi_ar, csomag_ar2, db_ar2, csomag_ar3, db_ar3', 'numerical'),
            array('datum_mettol, datum_meddig', 'type', 'type' => 'date', 'message' => '{attribute}: nem megfelelő formátumú!', 'dateFormat' => 'yyyy-MM-dd'),
			
			array('datum_mettol', 'isIntervalOverlap'),
			
			array('termek_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, termek_id, csomag_beszerzesi_ar, db_beszerzesi_ar, csomag_ar_szamolashoz, csomag_ar_nyomashoz, db_ar_nyomashoz, csomag_eladasi_ar, db_eladasi_ar, csomag_ar2, db_ar2, csomag_ar3, db_ar3, datum_mettol, datum_meddig, torolt', 'safe', 'on'=>'search'),
		);
	}

	public function isIntervalOverlap ()
	{
		$idCheck = $this->isNewRecord ? "" : " AND (id != $this->id)";
		
		$rawData = Yii::app() -> db -> createCommand  ("SELECT id FROM dom_termek_arak WHERE
														(datum_mettol BETWEEN '$this->datum_mettol' AND '$this->datum_meddig' OR
														'$this->datum_mettol' BETWEEN datum_mettol AND datum_meddig) AND (termek_id = $this->termek_id AND torolt = 0)" . $idCheck) -> queryAll();
		
		if (count($rawData) > 0)
			$this -> addError('datum_mettol', 'A termékár érvényességi dátuma már létező termékárba ütközik!');
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'termek'    => array(self::BELONGS_TO, 'Termekek', 'termek_id'),
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
			'id' => 'Termékár ID',
			'termek_id' => 'Termék',
			'csomag_beszerzesi_ar' => 'Csomag beszerzési ár (Ft)',
			'db_beszerzesi_ar' => 'Db beszerzési ár (Ft)',
			'csomag_ar_szamolashoz' => 'Csomag ár számoláshoz (Ft)',
			'csomag_ar_nyomashoz' => 'Csomag ár nyomáshoz (Ft)',
			'db_ar_nyomashoz' => 'Db ár nyomáshoz (Ft)',
			'csomag_eladasi_ar' => 'Csomag eladasi ár (Ft)',
			'db_eladasi_ar' => 'Db eladási ár (Ft)',
			'csomag_ar2' => 'Csomag ár 2 (Ft)',
			'db_ar2' => 'Db ár 2 (Ft)',
			'csomag_ar3' => 'Csomag ár 3 (Ft)',
			'db_ar3' => 'Db ár 3 (Ft)',
			'datum_mettol' => 'Dátum mettől',
			'datum_meddig' => 'Dátum meddig',
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
		$criteria->compare('termek_id',$this->termek_id,true);
		$criteria->compare('csomag_beszerzesi_ar',$this->csomag_beszerzesi_ar);
		$criteria->compare('db_beszerzesi_ar',$this->db_beszerzesi_ar);
		$criteria->compare('csomag_ar_szamolashoz',$this->csomag_ar_szamolashoz);
		$criteria->compare('csomag_ar_nyomashoz',$this->csomag_ar_nyomashoz);
		$criteria->compare('db_ar_nyomashoz',$this->db_ar_nyomashoz);
		$criteria->compare('csomag_eladasi_ar',$this->csomag_eladasi_ar);
		$criteria->compare('db_eladasi_ar',$this->db_eladasi_ar);
		$criteria->compare('csomag_ar2',$this->csomag_ar2);
		$criteria->compare('db_ar2',$this->db_ar2);
		$criteria->compare('csomag_ar3',$this->csomag_ar3);
		$criteria->compare('db_ar3',$this->db_ar3);
		$criteria->compare('datum_mettol',$this->datum_mettol,true);
		$criteria->compare('datum_meddig',$this->datum_meddig,true);

		// LI: logikailag törölt sorok ne jelenjenek meg, ha a belépett user nem az 'Admin'
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->condition=" torolt = '0'";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function afterFind(){
		parent::afterFind();
		$this -> datum_mettol = date('Y-m-d', strtotime(str_replace("-", "", $this->datum_mettol)));
		$this -> datum_meddig = date('Y-m-d', strtotime(str_replace("-", "", $this->datum_meddig)));
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TermekArak the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

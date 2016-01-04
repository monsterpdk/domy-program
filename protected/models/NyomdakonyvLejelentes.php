<?php

/**
 * This is the model class for table "dom_nyomda_munka_teljesitmeny".
 *
 * The followings are the available columns in table 'dom_nyomda_munka_teljesitmeny':
 * @property integer $id
 * @property integer $nyomdakonyv_id
 * @property integer $user_id
 * @property float $teljesitmeny_szazalek
 * @property integer $torolt 
 */
class NyomdakonyvLejelentes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_nyomda_munka_teljesitmeny';
	}

	public function getClassName ()
	{
		return "Nyomdakönyv munka teljesítmény lejelentés";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nyomdakonyv_id, user_id, teljesitmeny_szazalek', 'required'),
			array('nyomdakonyv_id, user_id, torolt', 'numerical', 'integerOnly'=>true),
			array('teljesitmeny_szazalek', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nyomdakonyv_id, user_id, torolt, teljesitmeny_szazalek', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'nyomdakonyv' => array(self::BELONGS_TO, 'Nyomdakonyv', 'nyomdakonyv_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
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
			'nyomdakonyv_id' => 'Munka ID',
			'user_id' => 'Felhasználó ID',
			'fullname' => 'Dolgozó',
			'teljesitmeny_szazalek' => 'Teljesítmény %',
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
		$criteria->compare('nyomdakonyv_id',$this->nyomdakonyv_id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('torolt',$this->torolt);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

/*	protected function afterFind(){
		parent::afterFind();

		// autocomplete mező esetén a termék ID van csak tárolva, így a beszédes
		// terméknevet kézzel kell kitöltenünk
		$this -> autocomplete_termek_name = $this -> termek -> nev;
		if ($this -> hozott_boritek == true) {
			$this -> termek -> nev = "Hozott " . $this -> termek -> nev ;
		}		
	}*/	
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArajanlatTetelek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}
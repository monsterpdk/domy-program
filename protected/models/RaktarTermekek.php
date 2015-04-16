<?php

/**
 * This is the model class for table "dom_raktar_termekek".
 *
 * The followings are the available columns in table 'dom_raktar_termekek':
 * @property string $id
 * @property string $termek_id
 * @property string $raktar_id
 * @property integer $osszes_db
 * @property integer $foglalt_db
 * @property integer $elerheto_db
 */
class RaktarTermekek extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_raktar_termekek';
	}

	public function getClassName ()
	{
		return "Raktár termék";
	}	
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('termek_id, raktar_id', 'required'),
			array('osszes_db, foglalt_db, elerheto_db', 'numerical', 'integerOnly'=>true),
			array('termek_id, raktar_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, termek_id, raktar_id, osszes_db, foglalt_db, elerheto_db', 'safe', 'on'=>'search'),
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
			'termek'    => array(self::BELONGS_TO, 'Termekek', 'termek_id'),
			'raktar'    => array(self::BELONGS_TO, 'Raktarak', 'raktar_id'),
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
			'id' => 'Raktár termék ID',
			'termek_id' => 'Termék ID',
			'raktar_id' => 'Raktár ID',
			'osszes_db' => 'Összes db',
			'foglalt_db' => 'Foglalt db',
			'elerheto_db' => 'Elérhető db',
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
		$criteria->compare('raktar_id',$this->raktar_id,true);
		$criteria->compare('osszes_db',$this->osszes_db);
		$criteria->compare('foglalt_db',$this->foglalt_db);
		$criteria->compare('elerheto_db',$this->elerheto_db);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RaktarTermekek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

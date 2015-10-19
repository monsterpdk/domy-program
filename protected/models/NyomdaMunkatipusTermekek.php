<?php

/**
 * This is the model class for table "dom_nyomda_munkatipus_termekek".
 *
 * The followings are the available columns in table 'dom_nyomda_munkatipus_termekek':
 * @property string $id
 * @property string $munkatipus_id
 * @property string $termek_id
 */
class NyomdaMunkatipusTermekek extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_nyomda_munkatipus_termekek';
	}

	public function getClassName ()
	{
		return "Nyomdakönyvi munkatípus termékek";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('munkatipus_id, termek_id', 'required'),
			array('munkatipus_id, termek_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, munkatipus_id, termek_id', 'safe', 'on'=>'search'),
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
			'munkatipus'    => array(self::BELONGS_TO, 'NyomdaMunkatipusok', 'munkatipus_id'),
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
			'id' => 'ID',
			'munkatipus_id' => 'Munkatípus ID',
			'termek_id' => 'Termék ID',
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
		$criteria->compare('munkatipus_id',$this->munkatipus_id,true);
		$criteria->compare('termek_id',$this->termek_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NyomdaMunkatipusTermekek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

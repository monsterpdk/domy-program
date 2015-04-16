<?php

/**
 * This is the model class for table "dom_orszagok".
 *
 * The followings are the available columns in table 'dom_orszagok':
 * @property string $id
 * @property string $nev
 * @property string $hosszu_nev
 * @property string $iso2
 * @property string $iso3
 * @property integer $torolt
 */
class Orszagok extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_orszagok';
	}

	public function getClassName ()
	{
		return "Ország";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('torolt', 'numerical', 'integerOnly'=>true),
			array('nev', 'length', 'max'=>47),
			array('hosszu_nev', 'length', 'max'=>122),
			array('iso2', 'length', 'max'=>2),
			array('iso3', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nev, hosszu_nev, iso2, iso3, torolt', 'safe', 'on'=>'search'),
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
			'id' => 'Ország ID',
			'nev' => 'Országnév',
			'hosszu_nev' => 'Hosszú név',
			'iso2' => 'Iso2',
			'iso3' => 'Iso3',
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
		$criteria->compare('nev',$this->nev,true);
		$criteria->compare('hosszu_nev',$this->hosszu_nev,true);
		$criteria->compare('iso2',$this->iso2,true);
		$criteria->compare('iso3',$this->iso3,true);
		
		// LI: logikailag törölt sorok ne jelenjenek meg
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->condition=" torolt = '0'";
			
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orszagok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

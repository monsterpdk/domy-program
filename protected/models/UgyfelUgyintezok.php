<?php

/**
 * This is the model class for table "dom_ugyfel_ugyintezok".
 *
 * The followings are the available columns in table 'dom_ugyfel_ugyintezok':
 * @property string $id
 * @property string $ugyfel_id
 * @property string $nev
 * @property string $telefon
 * @property string $email
 * @property integer $alapertelmezett_kapcsolattarto
 * @property integer $torolt
 */
class UgyfelUgyintezok extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_ugyfel_ugyintezok';
	}

	public function getClassName ()
	{
		return "Ügyfélügyintéző";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ugyfel_id, nev, telefon, email', 'required'),
			array('torolt, alapertelmezett_kapcsolattarto', 'numerical', 'integerOnly'=>true),
			array('ugyfel_id', 'length', 'max'=>10),
			array('nev, email', 'length', 'max'=>127),
			array('telefon', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ugyfel_id, nev, telefon, email, alapertelmezett_kapcsolattarto, torolt', 'safe', 'on'=>'search'),
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
            'ugyfel' => array(self::BELONGS_TO, 'Ugyfelek', 'ugyfel_id'),
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
			'id' => 'Ügyfélügyintéő ID',
			'ugyfel_id' => 'Ügyfél',
			'nev' => 'Név',
			'telefon' => 'Telefon',
			'email' => 'Email',
			'alapertelmezett_kapcsolattarto' => 'Alapértelmezett kapcsolattartó',
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
		$criteria->compare('ugyfel_id',$this->ugyfel_id,true);
		$criteria->compare('nev',$this->nev,true);
		$criteria->compare('telefon',$this->telefon,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('alapertelmezett_kapcsolattarto', $this->alapertelmezett_kapcsolattarto,true) ;
		
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
	 * @return UgyfelUgyintezok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

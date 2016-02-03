<?php

/**
 * This is the model class for table "dom_fizetesi_modok".
 *
 * The followings are the available columns in table 'dom_fizetesi_modok':
 * @property string $id
 * @property string $nev
 * @property string $szamlazo_azonosito
 * @property integer $fizetesi_hatarido
 * @property integer $torolt
 */
class FizetesiModok extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_fizetesi_modok';
	}

	public function getClassName ()
	{
		return "Fizetési mód";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nev, szamlazo_azonosito', 'required'),
			array('fizetesi_hatarido, torolt', 'numerical', 'integerOnly'=>true),
			array('nev', 'length', 'max'=>30),
			array('szamlazo_azonosito', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nev, szamlazo_azonosito, fizetesi_hatarido, torolt', 'safe', 'on'=>'search'),
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
			'id' => 'Fizetési mód ID',
			'nev' => 'Név',
			'szamlazo_azonosito' => 'Szamlázó programbeli azonosító',
			'fizetesi_hatarido' => 'Fizetési határidő (nap)',
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
		$criteria->compare('szamlazo_azonosito',$this->szamlazo_azonosito,true);
		$criteria->compare('fizetesi_hatarido',$this->fizetesi_hatarido);

		// LI: logikailag törölt sorok ne jelenjenek meg
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->compare('torolt', 0, false);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FizetesiModok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

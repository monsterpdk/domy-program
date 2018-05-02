<?php

/**
 * This is the model class for table "dom_szallitas_futarlevel_tetelek".
 *
 * The followings are the available columns in table 'dom_szallitas_futarlevel_tetelek':
 * @property integer $id
 * @property integer $futarlevel_id
 * @property string $megnevezes
 * @property integer $darab
 * @property string $megjegyzes
 */
class SzallitoFutarlevelTetelek extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_szallitas_futarlevel_tetelek';
	}

	public function getClassName ()
	{
		return "Futárlevél tételek";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('futarlevel_id, megnevezes, darab', 'required'),
			array('futarlevel_id', 'length', 'max'=>10),
			array('megnevezes', 'length', 'max'=>100),
			array('torolt', 'darab', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, futarlevel_id, megnevezes, darab, megjegyzes', 'safe', 'on'=>'search'),
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
			'futarlevel'    => array(self::BELONGS_TO, 'SzallitoFutarlevelek', 'futarlevel_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'futarlevel_id' => 'Futárlevél ID',
			'megnevezes' => 'Megnevezés',
			'darab' => 'Db',
			'megjegyzes' => 'Megjegyzés',
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
		$criteria->compare('futarlevel_id',$this->futarlevel_id,true);
		$criteria->compare('megnevezes',$this->megnevezes,true);
		$criteria->compare('darab',$this->darab,true);
		$criteria->compare('megjegyzes',$this->megjegyzes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
                        'defaultOrder'=>'nev ASC',
                    ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RaktarHelyek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}

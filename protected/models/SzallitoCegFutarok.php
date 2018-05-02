<?php

/**
 * This is the model class for table "dom_szallito_futarok".
 *
 * The followings are the available columns in table 'dom_szallito_futarok':
 * @property string $id
 * @property string $szallito_ceg_id
 * @property string $nev
 * @property string $telefon
 * @property string $rendszam
 */
class SzallitoCegFutarok extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_szallito_futarok';
	}

	public function getClassName ()
	{
		return "Futár";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('szallito_ceg_id, nev, telefon, rendszam', 'required'),
			array('szallito_ceg_id', 'length', 'max'=>10),
			array('nev', 'length', 'max'=>100),
			array('telefon', 'length', 'max'=>30),
			array('rendszam', 'length', 'max'=>10),
			array('torolt', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, szallito_ceg_id, nev, telefon, rendszam', 'safe', 'on'=>'search'),
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
			'szallito_ceg'    => array(self::BELONGS_TO, 'SzallitoCegek', 'szallito_ceg_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'szallito_ceg_id' => 'Szállító cég ID',
			'nev' => 'Futár neve',
			'telefon' => 'Telefonszám',
			'rendszam' => 'Rendszám',
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
		$criteria->compare('szallito_ceg_id',$this->raktar_id,true);
		$criteria->compare('nev',$this->nev,true);
		$criteria->compare('telefon',$this->telefon,true);
		$criteria->compare('rendszam',$this->rendszam,true);

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

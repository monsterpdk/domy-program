<?php

/**
 * This is the model class for table "dom_raktarkiadasok".
 *
 * The followings are the available columns in table 'dom_raktarkiadasok':
 * @property string $id
 * @property string $termek_id
 * @property string $darabszam
 * @property string $nyomdakonyv_id
 * @property integer $sztornozva
 */
class RaktarKiadasok extends CActiveRecord
{
	public $autocomplete_termek_name;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_raktarkiadasok';
	}

	public function getClassName ()
	{
		return "Raktár kiadás";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('termek_id, darabszam, nyomdakonyv_id', 'required'),
			array('darabszam, sztornozva', 'numerical', 'integerOnly'=>true),
			array('termek_id, darabszam, nyomdakonyv_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, termek_id, darabszam, nyomdakonyv_id, sztornozva', 'safe', 'on'=>'search'),
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
			'nyomdakonyv'    => array(self::BELONGS_TO, 'Nyomdakonyv', 'nyomdakonyv_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Raktár kiadás ID',
			'termek_id' => 'Termék',
			'darabszam' => 'Darabszám',
			'nyomdakonyv_id' => 'Nyomdakönyv',
			'sztornozva' => 'Sztornózva',
			
			'autocomplete_termek_name' => 'Termék neve',
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
		$criteria->compare('darabszam',$this->darabszam,true);
		$criteria->compare('nyomdakonyv_id',$this->nyomdakonyv_id,true);
		$criteria->compare('sztornozva',$this->sztornozva);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function afterFind(){
		parent::afterFind();

		// autocomplete mező esetn cska a termék ID van tárolva, így ki kel keresnünk a hozzá kapcsolódó terméknevet
		$this -> autocomplete_termek_name = $this -> termek -> DisplayTermekTeljesNev;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RaktarKiadasok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

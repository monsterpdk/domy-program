<?php

/**
 * This is the model class for table "dom_raktar_eltereslista".
 *
 * The followings are the available columns in table 'dom_raktar_eltereslista':
 * @property string $id
 * @property string $anyagrendeles_id
 * @property string $termek_id
 * @property integer $rendeleskor_leadott_db
 * @property integer $iroda_altal_atvett_db
 * @property integer $raktar_altal_atvett_db
 */
class RaktarEltereslista extends DomyModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_raktar_eltereslista';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rendeleskor_leadott_db, iroda_altal_atvett_db, raktar_altal_atvett_db', 'numerical', 'integerOnly'=>true),
			array('anyagrendeles_id, anyagbeszallitas_id, termek_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, anyagrendeles_id, termek_id, rendeleskor_leadott_db, iroda_altal_atvett_db, raktar_altal_atvett_db', 'safe', 'on'=>'search'),
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
			'anyagrendeles'    => array(self::BELONGS_TO, 'Anyagrendelesek', 'anyagrendeles_id'),
			'anyagbeszallitas'    => array(self::BELONGS_TO, 'Anyagbeszallitasok', 'anyagbeszallitas_id'),
			'termek'    => array(self::BELONGS_TO, 'Termekek', 'termek_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'anyagrendeles_id' => 'Anyagrendelés ID',
			'anyagbeszallitas' => 'Anyagrendelés ID',
			'termek_id' => 'Termék ID',
			'rendeleskor_leadott_db' => 'Rendéleskor leadott db',
			'iroda_altal_atvett_db' => 'Iroda által átvett db',
			'raktar_altal_atvett_db' => 'Raktár által átvett db',
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
		$criteria->compare('anyagrendeles_id',$this->anyagrendeles_id,true);
		$criteria->compare('anyagbeszallitas_id',$this->anyagbeszallitas_id,true);
		$criteria->compare('termek_id',$this->termek_id,true);
		$criteria->compare('rendeleskor_leadott_db',$this->rendeleskor_leadott_db);
		$criteria->compare('iroda_altal_atvett_db',$this->iroda_altal_atvett_db);
		$criteria->compare('raktar_altal_atvett_db',$this->raktar_altal_atvett_db);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RaktarEltereslista the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

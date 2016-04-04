<?php

/**
 * This is the model class for table "dom_raktar_termekek_tranzakciok".
 *
 * The followings are the available columns in table 'dom_raktar_termekek_tranzakciok':
 * @property string $id
 * @property string $termek_id
 * @property string $anyagbeszallitas_id
 * @property string $raktar_id
 * @property strin szallitolevel_nyomdakonyv_id
 * @property integer $foglal_darabszam
 * @property integer $betesz_kivesz_darabszam
 * @property string $tranzakcio_datum
 */
class RaktarTermekekTranzakciok extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_raktar_termekek_tranzakciok';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('termek_id, anyagbeszallitas_id, raktar_id, szallitolevel_nyomdakonyv_id, foglal_darabszam, betesz_kivesz_darabszam, tranzakcio_datum', 'required'),
			array('foglal_darabszam, betesz_kivesz_darabszam', 'numerical', 'integerOnly'=>true),
			array('termek_id, anyagbeszallitas_id, raktar_id, szallitolevel_nyomdakonyv_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, termek_id, anyagbeszallitas_id, raktar_id, szallitolevel_nyomdakonyv_id, foglal_darabszam, betesz_kivesz_darabszam, tranzakcio_datum', 'safe', 'on'=>'search'),
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'termek_id' => 'Termek',
			'anyagbeszallitas_id' => 'Anyagbeszallitas',
			'raktar_id' => 'Raktar',
			'szallitolevel_nyomdakonyv_id' => 'Kapcsolódó szállítólevél/nyomdakönyv ID',
			'foglal_darabszam' => 'Foglal darabszám',
			'betesz_kivesz_darabszam' => 'Betesz/kivesz darabszám',
			'tranzakcio_datum' => 'Tranzakcio Datum',
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
		$criteria->compare('anyagbeszallitas_id',$this->anyagbeszallitas_id,true);
		$criteria->compare('raktar_id',$this->raktar_id,true);
		$criteria->compare('szallitolevel_nyomdakonyv_id',$this->szallitolevel_nyomdakonyv_id,true);
		$criteria->compare('foglal_darabszam',$this->foglal_darabszam);
		$criteria->compare('betesz_kivesz_darabszam',$this->betesz_kivesz_darabszam);
		$criteria->compare('tranzakcio_datum',$this->tranzakcio_datum,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RaktarTermekekTranzakciok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

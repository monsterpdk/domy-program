<?php

/**
 * This is the model class for table "dom_megrendeles_tetelek".
 *
 * The followings are the available columns in table 'dom_megrendeles_tetelek':
 * @property string $id
 * @property string $megrendeles_id
 * @property integer $termek_id
 * @property integer $szinek_szama1
 * @property integer $szinek_szama2
 * @property string $darabszam
 * @property double $netto_darabar
 * @property string $megjegyzes
 * @property string $munka_neve
  * @property integer $mutacio
 * @property integer $hozott_boritek
 * @property integer $torolt
 * @property integer $anyag_foglalva
 * @property integer $egyedi_ar 
 */
class MegrendelesTetelek extends CActiveRecord
{

	public $autocomplete_termek_name;
	public $szorzo_tetel_arhoz;
	public $netto_ar;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_megrendeles_tetelek';
	}

	public function getClassName ()
	{
		return "Árajánlat tétel";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('megrendeles_id, termek_id, darabszam, netto_darabar', 'required'),
			array('termek_id, darabszam, szinek_szama1, szinek_szama2, mutacio, hozott_boritek, torolt, egyedi_ar', 'numerical', 'integerOnly'=>true),
			array('netto_darabar', 'numerical'),
			array('megrendeles_id, darabszam', 'length', 'max'=>10),
			array('megjegyzes, munka_neve', 'length', 'max'=>127),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, megrendeles_id, termek_id, szinek_szama1, szinek_szama2, darabszam, netto_darabar, munka_neve, megjegyzes, mutacio, hozott_boritek, torolt, egyedi_ar', 'safe', 'on'=>'search'),
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
			'termek' => array(self::BELONGS_TO, 'Termekek', 'termek_id'),
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
			'id' => 'Tétel ID',
			'megrendeles_id' => 'Megrendelés ID',
			'termek_id' => 'Termék',
			'szinek_szama1' => 'Színek (előold.) db',
			'szinek_szama2' => 'Színek (hátold.) db',
			'darabszam' => 'Darabszám',
			'netto_darabar' => 'Nettó darabár',
			'megjegyzes' => 'Megjegyzés',
			'munka_neve' => 'Munka neve',
			'mutacio' => 'Mutáció',
			'hozott_boritek' => 'Hozott boríték',
			'torolt' => 'Törölt',
			'anyag_foglalva' => 'Anyag foglalva',
			'egyedi_ar' => 'Egyedi ár',
			
			'netto_ar' => 'Nettó ár',
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
		$criteria->compare('megrendeles_id',$this->megrendeles_id,true);
		$criteria->compare('termek_id',$this->termek_id);
		$criteria->compare('szinek_szama1',$this->szinek_szama1);
		$criteria->compare('szinek_szama2',$this->szinek_szama2);
		$criteria->compare('darabszam',$this->darabszam,true);
		$criteria->compare('netto_darabar',$this->netto_darabar);
		$criteria->compare('megjegyzes',$this->megjegyzes,true);
		$criteria->compare('munka_neve',$this->munka_neve,true);
		$criteria->compare('mutacio',$this->mutacio);
		$criteria->compare('hozott_boritek',$this->hozott_boritek);
		$criteria->compare('torolt',$this->torolt);
		$criteria->compare('egyedi_ar',$this->egyedi_ar);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function afterFind(){
		parent::afterFind();

		// autocomplete mező esetén a termék ID van csak tárolva, így a beszédes
		// terméknevet kézzel kell kitöltenünk
		$this -> autocomplete_termek_name = $this -> termek -> nev;
	}	
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArajanlatTetelek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getSzorzo_tetel_arhoz () {
		return $szorzo_tetel_arhoz;
	}
}

<?php

/**
 * This is the model class for table "dom_raktar_termekek".
 *
 * The followings are the available columns in table 'dom_raktar_termekek':
 * @property string $id
 * @property string $termek_id
 * @property string $anyagbeszallitas_id
 * @property string $raktarhely_id
 * @property integer $osszes_db
 * @property integer $foglalt_db
 * @property integer $elerheto_db
 */
class RaktarTermekek extends CActiveRecord
{
	public $raktar_search;
	public $raktar_hely_search;
	public $termek_search;
	public $cikkszam_search;
	public $is_atmozgatas;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_raktar_termekek';
	}

	public function getClassName ()
	{
		return "Raktár termék";
	}	
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('termek_id, anyagbeszallitas_id, raktarhely_id', 'required'),
			array('osszes_db, foglalt_db, elerheto_db', 'numerical', 'integerOnly'=>true),
			array('termek_id, raktarhely_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, termek_id, anyagbeszallitas_id, raktarhely_id, osszes_db, foglalt_db, elerheto_db, raktar_search, raktar_hely_search, termek_search, cikkszam_search, is_atmozgatas', 'safe', 'on'=>'search'),
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
			'termek'    		=> array(self::BELONGS_TO, 'Termekek', 'termek_id'),
			'anyagbeszallitas'	=> array(self::BELONGS_TO, 'AnyagBeszallitasok', 'anyagbeszallitas_id'),
			'raktarHelyek'		=> array(self::BELONGS_TO, 'RaktarHelyek', 'raktarhely_id'),
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
			'id' => 'Raktár termék ID',
			'termek_id' => 'Termék ID',
			'anyagbeszallitas_id' => 'Beszállítás ID',
			'raktarhely_id' => 'Raktárhely ID',
			'osszes_db' => 'Összes db',
			'foglalt_db' => 'Foglalt db',
			'elerheto_db' => 'Elérhető db',
			
			'raktar_search' => 'Raktárnév',
			'raktar_hely_search' => 'Rakárhely neve',
			'termek_search' => 'Termék neve',
			'cikkszam_search' => 'Cikkszám',
			'is_atmozgatas' => 'Részletes lista',
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
		
		$criteria->together = true;
		$criteria->with = array('termek', 'raktarHelyek', 'raktarHelyek.raktar');
		
		// itt vizsgáljuk, hogy a keresés blokkban a részletes lista kapcsoló milyen állásban van
		$reszletesLista = false;
		if (isset($_GET['RaktarTermekek'])) {
			if ($_GET['RaktarTermekek']['is_atmozgatas']) {
				$reszletesLista = $_GET['RaktarTermekek']['is_atmozgatas'] == 1;
			}
		}
		
		// ez a blokk ahhoz a nézethez kell, ahol a termékeket összesítve, raktárhelyenként, group-olva jelenítjük meg, nem egyesével, anyagrendelésenként
		if (!$reszletesLista) {
			$criteria->select = '*, sum(osszes_db) as osszes_db, sum(foglalt_db) as foglalt_db, sum(elerheto_db) as elerheto_db';
			$criteria->group = 'termek_id, raktarhely_id';
		}
		//
		
		$criteria->compare('id',$this->id,true);
		$criteria->compare('termek_id',$this->termek_id,true);
		$criteria->compare('anyagbeszallitas_id',$this->anyagbeszallitas_id,true);		
		$criteria->compare('raktarhely_id',$this->raktarhely_id,true);
		$criteria->compare('osszes_db',$this->osszes_db);
		$criteria->compare('foglalt_db',$this->foglalt_db);
		$criteria->compare('elerheto_db',$this->elerheto_db);
		
		$criteria->compare('raktar.nev',$this->raktar_search,true);
		$criteria->compare('raktarHelyek.nev',$this->raktar_hely_search,true);
		$criteria->compare('termek.nev',$this->termek_search,true);
		$criteria->compare('termek.cikkszam',$this->cikkszam_search,false);
		
		$criteria->order = 'raktarhely_id ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RaktarTermekek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

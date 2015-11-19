<?php

/**
 * This is the model class for table "dom_zuh".
 *
 * The followings are the available columns in table 'dom_zuh':
 * @property string $id
 * @property string $nyomasi_kategoria
 * @property string $db_tol
 * @property string $db_ig
 * @property string $szin_1_db
 * @property string $szin_2_db
 * @property string $szin_3_db
 * @property string $tobb_szin_db
 * @property double $szin_1_szazalek
 * @property double $szin_2_szazalek
 * @property double $szin_3_szazalek
 * @property double $tobb_szin_szazalek
 * @property integer $aruhaz_id
 * @property string $megjegyzes
 */
class Zuh extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_zuh';
	}

	public function getClassName ()
	{
		return 'ZUH';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('db_tol, db_ig', 'required'),
			array('aruhaz_id, szin_1_szazalek, szin_2_szazalek, szin_3_szazalek, tobb_szin_szazalek', 'numerical'),
			array('nyomasi_kategoria', 'length', 'max'=>6),
			array('szin_1_db, szin_2_db, szin_3_db, tobb_szin_db', 'length', 'max'=>6),
			array('aruhaz_id, db_tol, db_ig', 'length', 'max'=>10),
			array('megjegyzes', 'length', 'max'=>127),
			
			array('db_tol', 'fromTo'),
			array('szin_1_szazalek', 'szin1Szazalek'),
			array('szin_2_szazalek', 'szin2Szazalek'),
			array('szin_3_szazalek', 'szin3Szazalek'),
			array('tobb_szin_szazalek', 'szinTobbSzazalek'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nyomasi_kategoria, db_tol, db_ig, szin_1_db, szin_2_db, szin_3_db, tobb_szin_db, szin_2_szazalek, szin_3_szazalek, tobb_szin_szazalek, aruhaz_id, megjegyzes', 'safe', 'on'=>'search'),
		);
	}

	// a példányszám-TÓL ne lehessen nagyobb, mint a példányszám-IG
	public function fromTo ($attribute)
	{
		if ($this->db_tol != null && $this->db_ig != null) {
			if ($this->db_tol >= $this->db_ig) {
				$this->addError($attribute, 'A \'példányszám-tól\' értéknek  kisebbnek kell lennie a \'példányszám-ig\' értéknél!');
			}
		}
		
		return true;
	}
	
	// a szín 1 százalék 0 és 100 % között kell legyen
	public function szin1Szazalek ($attribute)
	{
		if ($this->szin_1_szazalek != null) {
			if ($this->szin_1_szazalek == 0 || $this->szin_1_szazalek > 99.99) {
				$this->addError($attribute, 'A \'szín 1 százalék\' értéknek 0 és 100% közé kell esnie!');
			}
		}
		
		return true;
	}
	
	// a szín 2 százalék 0 és 100 % között kell legyen
	public function szin2Szazalek ($attribute)
	{
		if ($this->szin_2_szazalek != null) {
			if ($this->szin_2_szazalek == 0 || $this->szin_2_szazalek > 99.99) {
				$this->addError($attribute, 'A \'szín 2 százalék\' értéknek 0 és 100% közé kell esnie!');
			}
		}
		
		return true;
	}

	// a szín 3 százalék 0 és 100 % között kell legyen
	public function szin3Szazalek ($attribute)
	{
		if ($this->szin_3_szazalek != null) {
			if ($this->szin_3_szazalek == 0 || $this->szin_3_szazalek > 99.99) {
				$this->addError($attribute, 'A \'szín 3 százalék\' értéknek 0 és 100% közé kell esnie!');
			}
		}
		
		return true;
	}

	// a több szín százalék 0 és 100 % között kell legyen
	public function szinTobbSzazalek ($attribute)
	{
		if ($this->tobb_szin_szazalek != null) {
			if ($this->tobb_szin_szazalek == 0 || $this->tobb_szin_szazalek > 99.99) {
				$this->addError($attribute, 'A \'több szín százalék\' értéknek 0 és 100% közé kell esnie!');
			}
		}
		
		return true;
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'aruhaz'	=> array(self::BELONGS_TO, 'Aruhazak', 'aruhaz_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Zuh ID',
			'nyomasi_kategoria' => 'Nyomási kategória',
			'db_tol' => 'Példányszám -tól',
			'db_ig' => 'Példányszám -ig',
			'szin_1_db' => '1 szín db',
			'szin_2_db' => '2 szín db',
			'szin_3_db' => '3 szín db',
			'tobb_szin_db' => 'Több szín db',
			'szin_1_szazalek' => '1 szín százalék',
			'szin_2_szazalek' => '2 szín százalék',
			'szin_3_szazalek' => '3 szín százalék',
			'tobb_szin_szazalek' => 'Több szín százalék',
			'aruhaz_id' => 'Áruház',
			'megjegyzes' => 'Megjegyzés',
		);
	}

	public function behaviors() {
		return array( 'LoggableBehavior'=> 'application.modules.auditTrail.behaviors.LoggableBehavior', );
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
		$criteria->compare('nyomasi_kategoria',$this->nyomasi_kategoria,true);
		$criteria->compare('db_tol',$this->db_tol,true);
		$criteria->compare('db_ig',$this->db_ig,true);
		$criteria->compare('szin_1_db',$this->szin_1_db,true);
		$criteria->compare('szin_2_db',$this->szin_2_db,true);
		$criteria->compare('szin_3_db',$this->szin_3_db,true);
		$criteria->compare('tobb_szin_db',$this->tobb_szin_db,true);
		$criteria->compare('szin_1_szazalek',$this->szin_1_szazalek);
		$criteria->compare('szin_2_szazalek',$this->szin_2_szazalek);
		$criteria->compare('szin_3_szazalek',$this->szin_3_szazalek);
		$criteria->compare('tobb_szin_szazalek',$this->tobb_szin_szazalek);
		$criteria->compare('aruhaz_id',$this->aruhaz_id,true);
		$criteria->compare('megjegyzes',$this->megjegyzes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Zuh the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

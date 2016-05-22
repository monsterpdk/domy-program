<?php

/**
 * This is the model class for table "dom_anyagrendelesek".
 *
 * The followings are the available columns in table 'dom_anyagrendelesek':
 * @property string $id
 * @property int $gyarto_id
 * @property string $bizonylatszam
 * @property string $rendeles_datum
 * @property string $megjegyzes
 * @property integer $user_id
 * @property integer $sztornozva
 * @property integer $lezarva
 */
class Anyagrendelesek extends CActiveRecord
{
	// a lenyíló listákban a bizonylatszám és rendelés dátuma egyszerre jelenjen meg
	private $displayBizonylatszamDatum;
	
	// LI: anyagbeszállítás ID tárolására
	private $anyagbeszallitas_id;
	
	// összérték tárolására
	private $displayOsszertek;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_anyagrendelesek';
	}

	public function getClassName ()
	{
		return "Anyagrendelés";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, gyarto_id, rendeles_datum', 'required'),
			array('user_id, gyarto_id, sztornozva, lezarva', 'numerical', 'integerOnly'=>true),
			array('bizonylatszam', 'length', 'max'=>16),
			array('megjegyzes', 'length', 'max'=>255),
			array('rendeles_datum', 'type', 'type' => 'date', 'message' => '{attribute}: nem megfelelő formátumú!', 'dateFormat' => 'yyyy-MM-dd'),
			
			array('rendeles_datum', 'checkBeszallitasDate'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gyarto_id, bizonylatszam, rendeles_datum, megjegyzes, user_id, sztornozva, lezarva', 'safe', 'on'=>'search'),
		);
	}

	// LI : ne engedjen későbbi dátummal megrendelést menteni, mint ahogy a beszállítás dátuma van.
	public function checkBeszallitasDate ($attribute)
	{
		$anyagbeszallitas = Anyagbeszallitasok::model() -> findByAttributes( array('anyagrendeles_id' => $this -> id) );
		
		if ($anyagbeszallitas != null) {
			try {
				if ( strtotime($anyagbeszallitas -> beszallitas_datum) < strtotime($this -> rendeles_datum) ) {
						$this->addError($attribute, 'A megrendelés dátuma nem lehet későbbi, mint a beszállítás dátuma!');
				}
			} catch (Exception $e) {}
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
			'user'    => array(self::BELONGS_TO, 'User', 'user_id'),
			'gyarto'    => array(self::BELONGS_TO, 'Gyartok', 'gyarto_id'),
			'termekek' => array(self::HAS_MANY, 'AnyagrendelesTermekek', 'anyagrendeles_id'),
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
			'id' => 'Anyagrendelés ID',
			'gyarto_id' => 'Gyártó',
			'displayBizonylatszamDatum' => 'Kapcsolt anyagrendelés<br />(bizonylatszám - rendelés dátuma)',
			'bizonylatszam' => 'Bizonylatszám',
			'rendeles_datum' => 'Rendelés dátuma',
			'megjegyzes' => 'Megjegyzés',
			'user_id' => 'Felhasználó',
			'sztornozva' => 'Sztornózva',
			'lezarva' => 'Lezárva',
			'displayOsszertek' => 'Összérték (Ft)',
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
		$criteria->compare('gyarto_id',$this->gyarto_id,true);
		$criteria->compare('bizonylatszam',$this->bizonylatszam,true);
		$criteria->compare('rendeles_datum',$this->rendeles_datum,true);
		$criteria->compare('megjegyzes',$this->megjegyzes,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('sztornozva',$this->sztornozva);
		$criteria->compare('lezarva',$this->lezarva);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
                        'defaultOrder'=>'t.id DESC, rendeles_datum DESC',
                    ),						
		));
	}

	
	protected function afterFind(){
		parent::afterFind();
		
		$this -> rendeles_datum = date('Y-m-d', strtotime(str_replace("-", "", $this->rendeles_datum)));
		$this -> anyagbeszallitas_id = 0;
		
		// LI: ha van anyagbeszállítás beírjuk az ID-ját
		$anyagbeszallitas = Anyagbeszallitasok::model()->findByAttributes(array('anyagrendeles_id' => $this->id));
		if ($anyagbeszallitas != null) {
			$this -> anyagbeszallitas_id = $anyagbeszallitas -> id;
		}
		
		$this->recalculateOsszertek ();
	}
	
	public function recalculateOsszertek () {
		// a rendelésen lévő termékek értékének összegzése
		$osszertek = 0;
		foreach ($this -> termekek as $termek) {
			$osszertek +=  $termek->rendelt_darabszam * $termek->rendeleskor_netto_darabar;
		}
		
		$this->displayOsszertek = $osszertek;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Anyagrendelesek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getDisplayBizonylatszamDatum () {
		return $this->bizonylatszam . ' - ' . date('Y.m.d', strtotime($this->rendeles_datum));
	}

	public function getDisplayOsszertek () {
		return $this->displayOsszertek;
	}
	
	public function getAnyagbeszallitas_id () {
		return $this->anyagbeszallitas_id;
	}
	
	//Új bizonylatszámot generál, ha még nem volt bizonylatszáma az anyagrendelésnek, és vissza adja a beállított bizonylatszámot
	public function getNewBizonylatszam() {
		// megkeressük a legutóbb felvett árajánlatot és az ID-jához egyet hozzáadva beajánljuk az újonnan létrejött sorszámának
		// formátum: AJ2015000001, ahol az évszám után 000001 a rekord ID-ja 6 jeggyel reprezentálva, balról 0-ákkal feltöltve
		$criteria = new CDbCriteria;
		$criteria->select = 'max(id) AS id';
		$row = Anyagrendelesek::model() -> find ($criteria);
		$utolsoAnyagrendeles = $row['id'];
		if ($this->bizonylatszam == "") {
			$this->bizonylatszam = "TM" . date("Y") . str_pad( ($utolsoAnyagrendeles != null) ? ($utolsoAnyagrendeles + 1) : "000001", 6, '0', STR_PAD_LEFT );
		}
		return $this->bizonylatszam ;
	}
	
}

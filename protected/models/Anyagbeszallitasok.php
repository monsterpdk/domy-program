<?php

/**
 * This is the model class for table "dom_anyagbeszallitasok".
 *
 * The followings are the available columns in table 'dom_anyagbeszallitasok':
 * @property string $id
 * @property int $gyarto_id
 * @property string $bizonylatszam
 * @property string $beszallitas_datum
 * @property string $kifizetes_datum
 * @property string $megjegyzes
 * @property integer $user_id
 * @property string $anyagrendeles_id
 * @property integer $lezarva 
 */
class Anyagbeszallitasok extends DomyModel
{
	// a lenyíló listákban a bizonylatszám és beszállítás dátuma egyszerre jelenjen meg
	private $displayBizonylatszamDatum;
	
	// összérték tárolására (iroda)
	private $displayOsszertekIroda;
	
	// összérték tárolására (raktár)
	private $displayOsszertekRaktar;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_anyagbeszallitasok';
	}

	public function getClassName ()
	{
		return "Anyagbeszállítás";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('beszallitas_datum, gyarto_id, user_id', 'required'),
			array('user_id, gyarto_id, lezarva', 'numerical', 'integerOnly'=>true),
			array('bizonylatszam, anyagrendeles_id', 'length', 'max'=>12),
			array('megjegyzes', 'length', 'max'=>255),
			array('beszallitas_datum, kifizetes_datum', 'type', 'type' => 'date', 'message' => '{attribute}: nem megfelelő formátumú!', 'dateFormat' => 'yyyy-MM-dd'),
			
			array('bizonylatszam', 'uniqueBizonylatszamOrNull'),
			array('beszallitas_datum', 'checkMegrendelesDate'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gyarto_id, bizonylatszam, beszallitas_datum, kifizetes_datum, megjegyzes, user_id, anyagrendeles_id, lezarva', 'safe', 'on'=>'search'),
		);
	}

	// LI : alapvetően UNIQUE-ként volt adatbázisszinten megjelölve a mező, de mivel nem kötelező a kitöltése,
	//		így üres értékkel is lehetett menteni, ami viszont sértette a UNIQUE megszorítást. Ezért szerver
	//		oldalon ellenőrzöm, hogy van-e már ilyen bizonylatszámmal anyagbeszállítás felvéve (az üres bizonylatszámúakat nem számolom).
	public function uniqueBizonylatszamOrNull($attribute)
	{
		if ($this->bizonylatszam != "") {
			$anyagbeszallitasok = Anyagbeszallitasok::model()->findAllByAttributes(array('bizonylatszam' => $this->bizonylatszam));
			
			if (count($anyagbeszallitasok) > 0) {
				$anyagbeszallitas = $anyagbeszallitasok[0];

				if ($anyagbeszallitas -> id != $this -> id)
					$this->addError($attribute, 'Van már ilyen bizonylatszámmal anyagrendelés a rendszerben!');
			}
		}

		return true;
	}
	
	// LI : ne engedjen korábbi dátummal beszállítást menteni, mint ahogy a megrendelés dátuma van.
	public function checkMegrendelesDate ($attribute)
	{
		if ($this -> anyagrendeles_id != null && $this -> anyagrendeles_id != 0) {
			$anyagrendeles = Anyagrendelesek::model() -> findByPk ($this -> anyagrendeles_id);
			
			if ($anyagrendeles != null) {
				try {
					if ( strtotime($anyagrendeles -> rendeles_datum) > strtotime($this -> beszallitas_datum) ) {
							$this->addError($attribute, 'A beszállítás dátuma nem lehet korábbi, mint a megrendelés dátuma!');
					}
				} catch (Exception $e) {}
			}

			return true;
		}
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
			'anyagrendeles'    => array(self::BELONGS_TO, 'Anyagrendelesek', 'anyagrendeles_id'),
			'termekek' => array(self::HAS_MANY, 'AnyagbeszallitasTermekek', 'anyagbeszallitas_id'),
			'termekekIroda' => array(self::HAS_MANY, 'AnyagbeszallitasTermekekIroda', 'anyagbeszallitas_id'),
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
			'id' => 'Anyagbeszállítás ID',
			'gyarto_id' => 'Gyártó',
			'bizonylatszam' => 'Bizonylatszám',
			'displayBizonylatszamDatum' => 'Anyagbeszállítás<br />(bizonylatszám - beszállítás dátuma)',
			'beszallitas_datum' => 'Beszállítás dátuma',
			'kifizetes_datum' => 'Kifizetés dátuma',
			'megjegyzes' => 'Megjegyzés',
			'user_id' => 'Ügyintéző',
			'anyagrendeles_id' => 'Anyagrendelés',
			'lezarva' => 'Lezárva',
			'displayOsszertekIroda' => 'Összérték, iroda (Ft)',
			'displayOsszertekRaktar' => 'Összérték, raktár (Ft)',
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
		$criteria->compare('beszallitas_datum',$this->beszallitas_datum,true);
		$criteria->compare('kifizetes_datum',$this->kifizetes_datum,true);
		$criteria->compare('megjegyzes',$this->megjegyzes,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('anyagrendeles_id',$this->anyagrendeles_id,true);
		$criteria->compare('lezarva',$this->lezarva);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function afterFind(){
		parent::afterFind();
		$this -> beszallitas_datum = date('Y-m-d', strtotime(str_replace("-", "", $this->beszallitas_datum)));
		
		if ($this->kifizetes_datum != null && $this->kifizetes_datum != ""&& $this->kifizetes_datum != "0000-00-00 00:00:00")
			$this -> kifizetes_datum = date('Y-m-d', strtotime(str_replace("-", "", $this->kifizetes_datum)));
		else $this -> kifizetes_datum = null;
		
		$this -> recalculateOsszertek ();
	}

	public function recalculateOsszertek () {
		// a beszállításon lévő termékek értékének összegzése (iroda)
		$osszertekIroda = 0;

		// a beszállításon lévő termékek értékének összegzése (raktár)
		$osszertekRaktar = 0;
		
		foreach ($this -> termekek as $termek) {
			$osszertekIroda +=  $termek->darabszam * $termek->netto_darabar;
		}
		foreach ($this -> termekekIroda as $termek) {
			$osszertekRaktar +=  $termek->darabszam * $termek->netto_darabar;
		}
		
		$this -> displayOsszertekIroda = $osszertekIroda;
		$this -> displayOsszertekRaktar = $osszertekRaktar;
	}
	
	// sikeres mentés után frissítjük a raktár eltérés lista megfelelő sorát arra az esetre, hogy
	// ha anyagrendelés kapcsolása után vagyunk, mert akkor anyagrendelés id nélkül léteztek eddig a rekordok,
	// frissíteni kell őket immár az anyagrendelés id-val
	public function afterSave() {
		if (array_key_exists ('anyagrendeles_id', $this -> OldAttributes) && isset($this -> anyagrendeles_id) && $this -> OldAttributes['anyagrendeles_id'] != $this -> anyagrendeles_id) {
			
			$raktarSorok = RaktarEltereslista::model() -> findAllByAttributes( array('anyagbeszallitas_id' => $this -> id, 'anyagrendeles_id' => 0) );
			foreach ($raktarSorok as $raktarSor) {
				$veglegesRaktarSor = RaktarEltereslista::model() -> findByAttributes( array('anyagbeszallitas_id' => 0, 'anyagrendeles_id' => $this -> anyagrendeles_id, 'termek_id' => $raktarSor -> termek_id) );
			
				if ($veglegesRaktarSor == null)
					$veglegesRaktarSor = new RaktarElteresLista;
					
				$veglegesRaktarSor -> anyagbeszallitas_id = $this -> id;
				$veglegesRaktarSor -> anyagrendeles_id = $this -> anyagrendeles_id;
				$veglegesRaktarSor -> termek_id = $raktarSor -> termek_id;
				
				$veglegesRaktarSor -> rendeleskor_leadott_db += $raktarSor -> rendeleskor_leadott_db;
				$veglegesRaktarSor -> iroda_altal_atvett_db += $raktarSor -> iroda_altal_atvett_db;
				$veglegesRaktarSor -> raktar_altal_atvett_db += $raktarSor -> raktar_altal_atvett_db;
				
				$veglegesRaktarSor -> save ();
				
				$raktarSor -> delete ();
			}
			
		}

		return parent::afterSave();
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Anyagbeszallitasok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getDisplayBizonylatszamDatum () {
		return $this->bizonylatszam . ' - ' . date('Y.m.d', strtotime($this->beszallitas_datum));
	}
	
	public function getDisplayOsszertekIroda () {
		return $this->displayOsszertekIroda;
	}
	
	public function getDisplayOsszertekRaktar () {
		return $this->displayOsszertekRaktar;
	}
	
}

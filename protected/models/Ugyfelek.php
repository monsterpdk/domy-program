<?php

/**
 * This is the model class for table "dom_ugyfelek".
 *
 * The followings are the available columns in table 'dom_ugyfelek':
 * @property string $id
 * @property string $ugyfel_tipus
 * @property string $cegnev
 * @property string $cegnev_teljes
 * @property string $szekhely_irsz
 * @property string $szekhely_orszag
 * @property string $szekhely_varos
 * @property string $szekhely_cim
 * @property string $posta_irsz
 * @property string $posta_orszag
 * @property string $posta_varos
 * @property string $posta_cim
 * @property string $szallitasi_irsz
 * @property string $szallitasi_orszag
 * @property string $szallitasi_varos
 * @property string $szallitasi_cim
 * @property string $ugyvezeto_nev
 * @property string $ugyvezeto_telefon
 * @property string $ugyvezeto_email
 * @property string $kapcsolattarto_nev
 * @property string $kapcsolattarto_telefon
 * @property string $kapcsolattarto_email
 * @property string $ceg_telefon
 * @property string $ceg_fax
 * @property string $ceg_email
 * @property string $ceg_honlap
 * @property integer $cegforma
 * @property string $szamlaszam1
 * @property string $szamlaszam2
 * @property string $adoszam
 * @property string $eu_adoszam
 * @property string $teaor
 * @property string $tevekenysegi_kor
 * @property string $arbevetel
 * @property string $foglalkoztatottak_szama
 * @property integer $adatforras
 * @property integer $arkategoria
 * @property integer $besorolas
 * @property string $megjegyzes
 * @property string $fontos_megjegyzes
 * @property integer $fizetesi_felszolitas_volt
 * @property integer $ugyvedi_felszolitas_volt
 * @property integer $levelezes_engedelyezett
 * @property integer $email_engedelyezett
 * @property integer $kupon_engedelyezett
 * @property integer $egyedi_kuponkedvezmeny
 * @property string $elso_vasarlas_datum
 * @property string $utolso_vasarlas_datum
 * @property integer $fizetesi_hatarido
 * @property integer $max_fizetesi_keses
 * @property integer $atlagos_fizetesi_keses
 * @property string $rendelesi_tartozasi_limit
 * @property integer $fizetesi_moral
 * @property string $adatok_egyeztetve_datum
 * @property integer $archiv
 * @property string $archivbol_vissza_datum
 * @property string $felvetel_idopont
 * @property integer $kiemelt
 * @property integer $torolt
 *
 * The followings are the available model relations:
 * @property UgyfelUgyintezok[] $ugyfelUgyintezok
 */
class Ugyfelek extends DomyModel
{

	// LI az ügyfél összes ügyintézőjét tárolom benne, vesszővel elválasztva
	private $display_ugyfel_ugyintezok;

	// LI az ügyfél teljes címe 1 string-ben
	private $display_ugyfel_cim;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_ugyfelek';
	}

	public function getClassName ()
	{
		return "Ügyfél";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cegnev, szekhely_irsz, szekhely_orszag, szekhely_varos, szekhely_cim, cegforma, arkategoria, rendelesi_tartozasi_limit', 'required'),
			array('cegforma, adatforras, arkategoria, besorolas, fizetesi_felszolitas_volt, ugyvedi_felszolitas_volt, levelezes_engedelyezett, email_engedelyezett, kupon_engedelyezett, egyedi_kuponkedvezmeny, fizetesi_hatarido, max_fizetesi_keses, atlagos_fizetesi_keses, fizetesi_moral, archiv, kiemelt, torolt', 'numerical', 'integerOnly'=>true),
			array('ugyfel_tipus', 'length', 'max'=>9),
			array('cegnev, ugyvezeto_nev, ugyvezeto_email, kapcsolattarto_nev, kapcsolattarto_email, ceg_email, tevekenysegi_kor', 'length', 'max'=>127),
			array('cegnev_teljes, posta_cim, szekhely_cim, szallitasi_cim, megjegyzes, fontos_megjegyzes', 'length', 'max'=>255),
			array('szekhely_irsz, posta_irsz, szallitasi_irsz', 'length', 'max'=>6),
			array('fizetesi_hatarido', 'length', 'max'=>6),
			array('szekhely_orszag, posta_orszag, szallitasi_orszag', 'length', 'max'=>3),
			array('rendelesi_tartozasi_limit', 'length', 'max'=>10),
			array('ugyvezeto_telefon, kapcsolattarto_telefon, ceg_telefon, ceg_fax, szamlaszam1, szamlaszam2, arbevetel, foglalkoztatottak_szama', 'length', 'max'=>30),
			array('ceg_honlap', 'length', 'max'=>60),
			array('adoszam, eu_adoszam, teaor', 'length', 'max'=>15),
			
			array('adoszam', 'uniqueAdoszam'),
			array('adoszam', 'checkAdoszam'),
			
			array('elso_vasarlas_datum, utolso_vasarlas_datum, adatok_egyeztetve_datum, archivbol_vissza_datum', 'type', 'type' => 'date', 'message' => '{attribute}: nem megfelelő formátumú!', 'dateFormat' => 'yyyy-MM-dd'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ugyfel_tipus, cegnev, cegnev_teljes, szekhely_irsz, szekhely_orszag, szekhely_varos, szekhely_cim, posta_irsz, posta_orszag, posta_varos, posta_cim, szallitasi_irsz, szallitasi_orszag, szallitasi_varos, szallitasi_cim, ugyvezeto_nev, ugyvezeto_telefon, ugyvezeto_email, kapcsolattarto_nev, kapcsolattarto_telefon, kapcsolattarto_email, ceg_telefon, ceg_fax, ceg_email, ceg_honlap, cegforma, szamlaszam1, szamlaszam2, adoszam, eu_adoszam, teaor, tevekenysegi_kor, arbevetel, foglalkoztatottak_szama, adatforras, arkategoria, besorolas, megjegyzes, fontos_megjegyzes, fizetesi_felszolitas_volt, ugyvedi_felszolitas_volt, levelezes_engedelyezett, email_engedelyezett, kupon_engedelyezett, egyedi_kuponkedvezmeny, elso_vasarlas_datum, utolso_vasarlas_datum, fizetesi_hatarido, max_fizetesi_keses, atlagos_fizetesi_keses, rendelesi_tartozasi_limit, fizetesi_moral, adatok_egyeztetve_datum, archiv, archivbol_vissza_datum, felvetel_idopont, kiemelt, torolt', 'safe', 'on'=>'search'),
		);
	}

	// LI : UNIQUE adószám ellenőrzése mentés előtt
	public function uniqueAdoszam ($attribute)
	{
		if ($this->adoszam != "") {
			$ugyfelek = Ugyfelek::model()->findAllByAttributes (array('adoszam' => $this->adoszam));

			if (count($ugyfelek) > 0) {
				$ugyfel = $ugyfelek[0];

				if ($ugyfel -> id != $this -> id)
					$this->addError($attribute, 'Található már ilyen adószámmal ügyfél!');
			}
		}

		return true;
	}	

	// LI : adószám ellenőrzése
	public function checkAdoszam ($attribute)
	{
		$adoszam = $this->adoszam;
		if ($this->cegnev != "" && $adoszam != "") {
			$pattern = "/^(\d{7})(\d)\-([1-5])\-(0[2-9]|[13][0-9]|2[02-9]|4[0-4]|51)$/";
	
			$result = preg_match ($pattern, $adoszam, $matches);
	
			if ($result == 1) {
				$mul = array (9, 7, 3, 1, 9, 7, 3);
				$base = str_split($matches[1]);
	
				$check = $matches[2];
				$sum = 0;
				
				for ($i = 0; $i < 7; $i++) {
					$sum += $base[$i] * $mul[$i];
				}
				
				$last = $sum % 10;
				if ($last > 0) { $last = 10 - $last; }
	
				if ($last != $check) {
					$this->addError($attribute, 'Hibás az adószám formátuma!');
				}
	
				return $last == $check;
			}
	
			$this->addError($attribute, 'Hibás az adószám formátuma!');
			
			return false;
		}
		else
		{
			return true ;	
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
			'adatforras_dsp'    => array(self::BELONGS_TO, 'Adatforrasok', 'adatforras'),
			'arkategoria_dsp'    => array(self::BELONGS_TO, 'Arkategoriak', 'arkategoria'),
			'besorolas_dsp'    => array(self::BELONGS_TO, 'Besorolasok', 'besorolas'),
			'cegforma_dsp'    => array(self::BELONGS_TO, 'Cegformak', 'cegforma'),
			'szekhely_orszag_dsp'    => array(self::BELONGS_TO, 'Orszagok', 'szekhely_orszag'),
			'posta_orszag_dsp'    => array(self::BELONGS_TO, 'Orszagok', 'posta_orszag'),
			'szallitasi_orszag_dsp'    => array(self::BELONGS_TO, 'Orszagok', 'szallitasi_orszag'),
			'szekhely_varos_dsp'    => array(self::BELONGS_TO, 'Varosok', 'szekhely_varos'),
			'posta_varos_dsp'    => array(self::BELONGS_TO, 'Varosok', 'posta_varos'),
			'szallitasi_varos_dsp'    => array(self::BELONGS_TO, 'Varosok', 'szallitasi_varos'),
			
            'ugyfelUgyintezo' => array(self::HAS_MANY, 'UgyfelUgyintezok', 'ugyfel_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Ügyfél ID',
			'ugyfel_tipus' => 'Ügyfél típus',
			'cegnev' => 'Cégnév',
			'cegnev_teljes' => 'Teljes cégnév',
			'szekhely_irsz' => 'Székhely irányítószám',
			'szekhely_orszag' => 'Székhely ország',
			'szekhely_varos' => 'Székhely város',
			'szekhely_cim' => 'Székhely cím utca, házszám',
			'posta_irsz' => 'Postázási cím irányítószám',
			'posta_orszag' => 'Postázási ország',
			'posta_varos' => 'Postázási cím város',
			'posta_cim' => 'Postázási cím utca, házszám',
			'szallitasi_irsz' => 'Szállítási cím irányítószám',
			'szallitasi_orszag' => 'Szállítási ország',
			'szallitasi_varos' => 'Szállítási cím város',
			'szallitasi_cim' => 'Szállítási cím utca, házszám',
			'ugyvezeto_nev' => 'Ügyvezető név',
			'ugyvezeto_telefon' => 'Ügyvezető telefonszám',
			'ugyvezeto_email' => 'Ügyvezető email',
			'kapcsolattarto_nev' => 'Kapcsolattartó név',
			'kapcsolattarto_telefon' => 'Kapcsolattartó telefon',
			'kapcsolattarto_email' => 'Kapcsolattartó email',
			'ceg_telefon' => 'Cég telefonszám',
			'ceg_fax' => 'Cég fax',
			'ceg_email' => 'Cég email',
			'ceg_honlap' => 'Cég honlap',
			'cegforma' => 'Cégforma',
			'szamlaszam1' => 'Számlaszám #1',
			'szamlaszam2' => 'Számlaszám #2',
			'display_ugyfel_ugyintezok' => 'Ügyintézők',
			'display_ugyfel_cim' => 'Ügyfél címe',
			'adoszam' => 'Adószám',
			'eu_adoszam' => 'Eu adószám',
			'teaor' => 'TEÁOR',
			'tevekenysegi_kor' => 'Tevékenységi kör',
			'arbevetel' => 'Árbevétel (eFt)',
			'foglalkoztatottak_szama' => 'Foglalkoztatottak száma',
			'adatforras' => 'Adatforrás',
			'arkategoria' => 'Árkategória',
			'besorolas' => 'Besorolás',
			'megjegyzes' => 'Megjegyzés',
			'fontos_megjegyzes' => 'Fontos megjegyzés',
			'fizetesi_felszolitas_volt' => 'Fizetési felszólítás volt',
			'ugyvedi_felszolitas_volt' => 'Ügyvédi felszólítás volt',
			'levelezes_engedelyezett' => 'Levelezés engedélyezett',
			'email_engedelyezett' => 'Email engedélyezett',
			'kupon_engedelyezett' => 'Kupon engedélyezett',
			'egyedi_kuponkedvezmeny' => 'Egyedi kuponkedvezmény',
			'elso_vasarlas_datum' => 'Első vásárlás dátum',
			'utolso_vasarlas_datum' => 'Utolsó vásárlás dátum',
			'fizetesi_hatarido' => 'Fizetési határidő (napok száma)',
			'max_fizetesi_keses' => 'Max. fizetési késés',
			'atlagos_fizetesi_keses' => 'Átlagos fizetési késés',
			'rendelesi_tartozasi_limit' => 'Rendelési tartozási limit (Ft)',
			'fizetesi_moral' => 'Fizetési morál',
			'adatok_egyeztetve_datum' => 'Adatok egyeztetve dátum',
			'archiv' => 'Archív',
			'archivbol_vissza_datum' => 'Archívból vissza dátum',
			'felvetel_idopont' => 'Felvétel időpont',
			'kiemelt' => 'Kiemelt',
			'torolt' => 'Törölt',
		);
	}

	public function behaviors() {
		return array(
			'LoggableBehavior'=> 'application.modules.auditTrail.behaviors.LoggableBehavior',
			'ESaveRelatedBehavior' => array('class' => 'application.components.ESaveRelatedBehavior'),
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
	//print($this->ugyfel_tipus);
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;

		$criteria->compare('ugyfel_tipus', $this->ugyfel_tipus, true);
		$criteria->compare('archiv', $this->archiv);
		$criteria->compare('cegnev', $this->cegnev, true);
		$criteria->compare('adoszam', $this->adoszam, true);
		$criteria->compare('kapcsolattarto_nev', $this->kapcsolattarto_nev, true);

		// LI: logikailag törölt sorok ne jelenjenek meg, ha a belépett user nem az 'Admin'
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->compare('torolt', 0, false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),)
		));
	}

	protected function afterFind(){
		// első és utolsó vásárlási dátumot mindig frissítjük az adott ügyfél 'megnyitásakor'
		 $megrendeles_datumok = Yii::app()->db->createCommand()
			->select('min(rendeles_idopont) AS elso_vasarlas, max(rendeles_idopont) AS utolso_vasarlas')
			->from('dom_megrendelesek')
			->where('ugyfel_id = :ugyfel_id', array(':ugyfel_id' => $this -> id))
			->queryAll();

		$this -> elso_vasarlas_datum = date('Y-m-d', strtotime(str_replace("-", "", $megrendeles_datumok[0]["elso_vasarlas"])));
		$this -> utolso_vasarlas_datum = date('Y-m-d', strtotime(str_replace("-", "", $megrendeles_datumok[0]["utolso_vasarlas"])));
		$this -> adatok_egyeztetve_datum = date('Y-m-d', strtotime(str_replace("-", "", $this->adatok_egyeztetve_datum)));
		$this -> archivbol_vissza_datum = date('Y-m-d', strtotime(str_replace("-", "", $this->archivbol_vissza_datum)));
		
		if ($this -> elso_vasarlas_datum == '1970-01-01')
			$this -> elso_vasarlas_datum = '';
		
		if ($this -> utolso_vasarlas_datum == '1970-01-01')
			$this -> utolso_vasarlas_datum = '';
		
		if ($this -> adatok_egyeztetve_datum == '1970-01-01')
			$this -> adatok_egyeztetve_datum = '';
		
		if ($this -> archivbol_vissza_datum == '1970-01-01')
			$this -> archivbol_vissza_datum = '';
		
		// $this -> felvetel_idopont = date('Y-m-d H:m:s', strtotime(str_replace("-", "", $this->felvetel_idopont)));
		
		// LI: mivel a városokhoz ID-t (key) kell tárolnunk, az előregépelős mezőben viszont
		// szöveg van (value), ezért itt meg kell cserélnünk őket
		if ($this -> szekhely_varos != null) {
			$check_szekhely_varos = Varosok::model()->findByPk($this -> szekhely_varos);
			if ($check_szekhely_varos != null)
				$this -> szekhely_varos = $check_szekhely_varos -> varosnev;
		}
				
		if ($this -> posta_varos != null) {
			$check_posta_varos = Varosok::model()->findByPk($this -> posta_varos);
			if ($check_posta_varos != null)
				$this -> posta_varos = $check_posta_varos -> varosnev;
		}

		if ($this -> szallitasi_varos != null) {
			$check_szallitasi_varos = Varosok::model()->findByPk($this -> szallitasi_varos);
			if ($check_szallitasi_varos != null)
				$this -> szallitasi_varos = $check_szallitasi_varos -> varosnev;
		}
		
		parent::afterFind();
	}
	
	// LI : a 'felvetel_idopont' mezőt automatikusan kitöltjük létrehozáskor
	public function beforeSave() {
		if ($this->isNewRecord)
			$this->felvetel_idopont = new CDbExpression('NOW()');
	 
		// LI: mivel a városokhoz ID-t (key) kell tárolnunk, az előregépelős mezőben viszont
		// szöveg van (value), ezért itt meg kell cserélnünk őket
		$szekhely_varos = $this -> szekhely_varos;
		$posta_varos = $this -> posta_varos;
		$szallitasi_varos = $this -> szallitasi_varos;
		
		$q = new CDbCriteria( array(
			'condition' => "varosnev = :szekhely_varos AND torolt = 0",
			'params'    => array(':szekhely_varos' => "$szekhely_varos")
		) );
        $check_szekhely_varos = Varosok::model()->find($q);
		if ($check_szekhely_varos != null)
			$this -> szekhely_varos = $check_szekhely_varos -> id;

		$q = new CDbCriteria( array(
			'condition' => "varosnev = :posta_varos AND torolt = 0",
			'params'    => array(':posta_varos' => "$posta_varos")
		) );
        $check_posta_varos = Varosok::model()->find($q);
		if ($check_posta_varos != null)
			$this -> posta_varos = $check_posta_varos -> id;

		$q = new CDbCriteria( array(
			'condition' => "varosnev = :szallitasi_varos AND torolt = 0",
			'params'    => array(':szallitasi_varos' => "$szallitasi_varos")
		) );
        $check_szallitasi_varos = Varosok::model()->find($q);
		if ($check_szallitasi_varos != null)
			$this -> szallitasi_varos = $check_szallitasi_varos -> id;

		
		return parent::beforeSave();
	}
	
	// LI : városok ellenőrzésére, ha valamelyik (székhely/posta város) nem létezik a db-ben, akkor felvesszük
	public function beforeValidate() {
		$szekhely_varos = $this -> szekhely_varos;
		$posta_varos = $this -> posta_varos;
		$szallitasi_varos = $this -> szallitasi_varos;
//		die($posta_varos . " -----" . $this -> szallitasi_varos) ;
		
		$match1 = addcslashes($szekhely_varos, '%_'); // escape LIKE's special characters
		$q = new CDbCriteria( array(
			'condition' => "varosnev = :szekhely_varos",
			'params'    => array(':szekhely_varos' => "$match1")
		) );
        $szekhely_varosok = Varosok::model()->findAll($q);
		
		$match2 = addcslashes($posta_varos, '%_'); // escape LIKE's special characters
		$q = new CDbCriteria( array(
			'condition' => "varosnev = :posta_varos",
			'params'    => array(':posta_varos' => "$match2")
		) );
        $posta_varosok = Varosok::model()->findAll($q);

		$match3 = addcslashes($szallitasi_varos, '%_'); // escape LIKE's special characters
		$q = new CDbCriteria( array(
			'condition' => "varosnev = :szallitasi_varos",
			'params'    => array(':szallitasi_varos' => "$match3")
		) );
        $szallitasi_varosok = Varosok::model()->findAll($q);
        
		
		// LI: ha nem létezik még ilyen város felvesszük
		if (count($szekhely_varosok) == 0) {
			$uj_varos = new Varosok;
			$uj_varos -> varosnev = $match1;
			$uj_varos -> save();
		}
			
		// LI: ha nem létezik még ilyen város felvesszük
		if (count($posta_varosok) == 0) {
			$uj_varos = new Varosok;
			$uj_varos -> varosnev = $match2;
			$uj_varos -> save();
		}

		if (count($szallitasi_varosok) == 0) {
			$uj_varos = new Varosok;
			$uj_varos -> varosnev = $match3;
			$uj_varos -> save();
		}
		
		
		// LI: mivel a városokhoz ID-t (key) kell tárolnunk, az előregépelős mezőben viszont
		// szöveg van (value), ezért itt meg kell cserélnünk őket
		$q = new CDbCriteria( array(
			'condition' => "varosnev = :szekhely_varos AND torolt = 0",
			'params'    => array(':szekhely_varos' => "$szekhely_varos")
		) );
        $check_szekhely_varos = Varosok::model()->find($q);
		if ($check_szekhely_varos != null)
			$this -> szekhely_varos = $check_szekhely_varos -> id;

		$q = new CDbCriteria( array(
			'condition' => "varosnev = :posta_varos AND torolt = 0",
			'params'    => array(':posta_varos' => "$posta_varos")
		) );
        $check_posta_varos = Varosok::model()->find($q);
		if ($check_posta_varos != null)
			$this -> posta_varos = $check_posta_varos -> id;

		$q = new CDbCriteria( array(
			'condition' => "varosnev = :szallitasi_varos AND torolt = 0",
			'params'    => array(':szallitasi_varos' => "$szallitasi_varos")
		) );
        $check_szallitasi_varos = Varosok::model()->find($q);
		if ($check_szallitasi_varos != null)
			$this -> szallitasi_varos = $check_szallitasi_varos -> id;
		
		
		return parent::beforeValidate();
	}

	public function afterValidate() {
		// LI: mivel a városokhoz ID-t (key) kell tárolnunk, az előregépelős mezőben viszont
		// szöveg van (value), ezért itt meg kell cserélnünk őket
		if ($this -> szekhely_varos != null) {
			$check_szekhely_varos = Varosok::model()->findByPk($this -> szekhely_varos);
			if ($check_szekhely_varos != null)
				$this -> szekhely_varos = $check_szekhely_varos -> varosnev;
		}
				
		if ($this -> posta_varos != null) {
			$check_posta_varos = Varosok::model()->findByPk($this -> posta_varos);
			if ($check_posta_varos != null)
				$this -> posta_varos = $check_posta_varos -> varosnev;
		}

		if ($this -> szallitasi_varos != null) {
			$check_szallitasi_varos = Varosok::model()->findByPk($this -> szallitasi_varos);
			if ($check_szallitasi_varos != null)
				$this -> szallitasi_varos = $check_szallitasi_varos -> varosnev;
		}
		
		return parent::afterValidate();
	}
	
	/**
	 * LI
	 * A nézetben meg kell jelenjen az adott ügyfél összes, hozzá felvett ügyintézője.
	 * Őket itt szedem össze is adom vissza.
	 * TÁ: Bővítettem az ugyintezo_id paraméterrel, mert pl. a szállítólevélen csak annak az ügyintézőnek kell szerepelni, amelyik meg lett adva az árajánlatnál, mint ügyintéző
	 * 	   Ha nincs megadva ügyintéző, akkor az összeset visszaadja, ha van megadva, akkor csak azt az egyet.
	 * TÁ: Bővítettem az $alapertelmezett_ugyintezo paraméterrel, ha az true, akkor csak az alapértelmezett ügyintézőt adja vissza
	 */
	public function getDisplay_ugyfel_ugyintezok ($ugyintezo_id = 0, $alapertelmezett_ugyintezo = false)
	{
		$result = '';
		
		foreach ($this -> ugyfelUgyintezo as $ugyintezo) {
			if ($ugyintezo_id == 0 || $ugyintezo->id == $ugyintezo_id) {
				if (!$alapertelmezett_ugyintezo || $ugyintezo->alapertelmezett_kapcsolattarto == true) {
					$result .= (strlen($result) > 0 ? ', ' : '') . $ugyintezo -> nev;
				}
			}
		}

		if ($result == "" && count($this -> ugyfelUgyintezo) > 0) {
			foreach ($this -> ugyfelUgyintezo as $ugyintezo) {
				$result .= (strlen($result) > 0 ? ', ' : '') . $ugyintezo -> nev;
			}
		}

		return $result;
	}
	
	/**
	 * LI
	 * Ügyfélhez tartozó cím összerakása 1 string-be.
	 */
	public function getDisplay_ugyfel_cim ()
	{
		$szekhely_orszag = Orszagok::model() -> findByPk ($this -> szekhely_orszag);
		$szekhely_orszag = ($szekhely_orszag == null) ? "" : $szekhely_orszag -> nev;
		return
			$szekhely_orszag . (strlen($szekhely_orszag) > 0 ? ", " : "") .
			$this -> szekhely_irsz . (strlen($this -> szekhely_irsz) > 0 ? " " : "") .
			$this -> szekhely_varos . (strlen($this -> szekhely_varos) > 0 ? ", " : "") .
			$this -> szekhely_cim;
	}
	
	/**
	 * TÁ
	 * Ügyfélhez tartozó szállítási cím összerakása 1 string-be.
	 */
	public function getDisplay_ugyfel_szallitasi_cim ()
	{
		$return = "" ;
		$szallitasi_orszag = $szallitasi_irsz = $szallitasi_varosnev = $szallitasi_cim = "" ;
		if ($this -> szallitasi_orszag != null && $this -> szallitasi_orszag > 0) { 
			$szallitasi_orszag = Orszagok::model() -> findByPk ($this -> szallitasi_orszag);
			$szallitasi_orszag = ($szallitasi_orszag == null) ? "" : $szallitasi_orszag -> nev;
		}
		if ($this -> szallitasi_varos != null && $this -> szallitasi_varos != '') {
			$szallitasi_varos = Varosok::model() -> findByAttributes(array('varosnev' => $this -> szallitasi_varos)) ;
			$szallitasi_varosnev = $this -> szallitasi_varos;
			$szallitasi_irsz = $szallitasi_varos -> iranyitoszam;	
		}
		if ($this -> szallitasi_irsz != "") {
			$szallitasi_irsz = $this -> szallitasi_irsz ;
		}
		if ($this -> szallitasi_cim != "") {
			$szallitasi_cim = $this -> szallitasi_cim ;
		}
		$return = $szallitasi_orszag . (strlen($szallitasi_orszag) > 0 ? ", " : "") . $szallitasi_irsz . (strlen($szallitasi_irsz) > 0 ? " " : "") . $szallitasi_varosnev . (strlen($szallitasi_varosnev) > 0 ? ", " : "") . $szallitasi_cim;
		return $return ;
	}	

	/**
	 * TÁ
	 * Ügyfél létrehozása tömbből. A webáruházakból a megrendelések beimportálásánál kerülhet felhasználásra, ha még a rendszerben nem szerepelt a megrendelő ügyfélként, létre kell hozni.
	 * Annyi adattal, amennyi a webáruházból rendelkezésre áll
	 * @param array $ugyfel_adatok A létrehozandó ügyfél adatait tartalmazó tömb
	 * @return a létrejött ügyfél id-je
	 */
	 public function insertUgyfelFromArray($ugyfel_adatok) {
	 	$model = new Ugyfelek;
		// lekérdezzük és beállítjuk az alapértelmezett rendelés tartozás limitet
		$defaultTartozasiLimit = Yii::app()->config->get('alapertelmezettRendelesTartozasLimit');
		if ($defaultTartozasiLimit != null)
			$model -> rendelesi_tartozasi_limit = $defaultTartozasiLimit;
	
		$modelOrszag = Orszagok::model()->findByAttributes(array('iso2' => $ugyfel_adatok["orszag"]));
		if ($modelOrszag != null) {
			$model->szekhely_orszag = $modelOrszag->id;
			$model->posta_orszag = $modelOrszag->id;;
			$model->szallitasi_orszag = $modelOrszag->id;;
		}
		if ($ugyfel_adatok["cegnev"] != "") {
			$cegforma_string = substr($ugyfel_adatok["cegnev"] , strrpos($ugyfel_adatok["cegnev"], " ") + 1) ;
			
			$match = trim($cegforma_string);
			$match = addcslashes($match, '%_');
			$q = new CDbCriteria( array(
				'condition' => "cegforma LIKE :match",
				'params'    => array(':match' => "%$match%")
			) );
			$cegforma = Cegformak::model()->find( $q );

			if ($cegforma != null) {
				$model->cegforma = (int)$cegforma->id ;
				$model->cegnev = substr($ugyfel_adatok["cegnev"] , 0,  strrpos($ugyfel_adatok["cegnev"], " ")) ;
			}
			else
			{
				$model->cegnev = $ugyfel_adatok["cegnev"] ;				
			}
			$model->cegnev_teljes = $model->cegnev ;
		}
		
		$model->ugyfel_tipus = "vasarlo" ;
		$model->kapcsolattarto_nev = "Nincs megadva" ;
		$model->kapcsolattarto_telefon = $ugyfel_adatok["telefon"] ;
		$model->kapcsolattarto_email = $ugyfel_adatok["email"] ;
		$model->cegforma = 3 ;	//3 = nincs megadva. Mivel a webáruházakban nem kérünk be külön cégformát, ezt onnan nem lehet egyértelműen kinyerni.
		$model->max_fizetesi_keses = 10 ;	//Nem tudom mennyi lesz az alapértelmezett, most 10-re állítom
		$model->atlagos_fizetesi_keses = 0 ;
		$model->rendelesi_tartozasi_limit = 500000 ;
		$model->fizetesi_moral = 5 ;	//Mivel webáruházas, nagy valószínűséggel azonnal fizet
		$model->szekhely_irsz = $ugyfel_adatok["irsz"] ;	 	
		$model->szekhely_varos = $ugyfel_adatok["telepules"] ;	 	
		$model->szekhely_cim = $ugyfel_adatok["cim"] ;	 	
		$model->posta_irsz = $ugyfel_adatok["irsz"] ;	 	
		$model->posta_varos = $ugyfel_adatok["telepules"] ;	 	
		$model->posta_cim = $ugyfel_adatok["cim"] ;	 	
		$model->szallitasi_irsz = $ugyfel_adatok["szallitasi_irsz"] ;	 	
		$model->szallitasi_varos = $ugyfel_adatok["szallitasi_varos"] ;	 	
		$model->szallitasi_cim = $ugyfel_adatok["szallitasi_cim"] ;	 	
		$model->ceg_telefon = $ugyfel_adatok["telefon"] ;	 	
		$model->ceg_fax = $ugyfel_adatok["fax"] ;	 	
		$model->ceg_email = $ugyfel_adatok["email"] ;	 	
		$model->adoszam = $ugyfel_adatok["adoszam"] ;	 	
		$model->arkategoria = $ugyfel_adatok["arkategoria_id"] ;	 	
		$model->elso_vasarlas_datum = substr($ugyfel_adatok["elso_vasarlas_datum"],0,10) ;
		$model->felvetel_idopont = date("Y-m-d H:i:s") ;
		$model->save() ;	 	
//		print_r($model) ;
	 	$ugyfel_id = $model->id ;
	 	return $ugyfel_id ;
	 }
	
	 /**
	  * TÁ
	  * Ügyfél átlagos fizetési késés értékét számolja újra és rögzíti
	  */
	 public function updateAtlagosFizetesiKeses() {
	 	$ugyfel_megrendelesek = Megrendelesek::model()->findAllByAttributes(array("ugyfel_id" => $this->id, "torolt" => "0", "sztornozva" => "0")) ;
	 	if ($this->max_fizetesi_keses > 0) {
			$megrendelesszam = 1 ;
			$kesett_napok_szama = $this->max_fizetesi_keses ;
			$atlagos_keses = $this->max_fizetesi_keses ;
			$max_keses = $this->max_fizetesi_keses;	 		
	 	}
	 	else
	 	{
			$megrendelesszam = 0 ;
			$kesett_napok_szama = 0 ;
			$atlagos_keses = 0 ;
			$max_keses = 0;
		}
	 	if ($ugyfel_megrendelesek != null) {
	 		foreach ($ugyfel_megrendelesek as $megrendeles) {
				if ($megrendeles->szamla_fizetesi_hatarido != "0000-00-00" && $megrendeles->szamla_kiegyenlites_datum != "0000-00-00") {
					$ts1 = strtotime($megrendeles->szamla_fizetesi_hatarido);
					$ts2 = strtotime($megrendeles->szamla_kiegyenlites_datum);
					
					$seconds_diff = $ts2 - $ts1;
					$days_diff =  $seconds_diff / 86400 ;
					
					if ($days_diff > $max_keses) {
						$max_keses = $days_diff ;	
					}
					
					$megrendelesszam++ ;
					$kesett_napok_szama += $days_diff ;
				}
	 		}
	 		if ($megrendelesszam > 0) {
				$atlagos_keses = round($kesett_napok_szama / $megrendelesszam) ;
	
				if ($max_keses < 3) {
					$moral = 5 ;
				}
				else if ($max_keses < 8) {
					$moral = 4 ;	
				}
				else if ($max_keses < 13) {
					$moral = 3 ;	
				}
				else if ($max_keses < 23) {
					$moral = 2 ;	
				}
				else { 
					$moral = 1 ;
				}
				
				$this->atlagos_fizetesi_keses = $atlagos_keses ;
				$this->fizetesi_moral = $moral ;
				$this->max_fizetesi_keses = $max_keses ;
				$this->save() ;
			}
				
			if ($this->ugyvedi_felszolitas_volt == 1) {
				$this->fizetesi_moral = 1 ;
				$this->save() ;
			}
			
	 	}
	 }
	  
	 /* Visszaadja az ügyfélnek adott ajánlatok számát */
	 public function getAjanlatszam($datum) {
	 	return Arajanlatok::model()->countByAttributes(array('ugyfel_id'=> $this->id), 'ajanlat_datum<=:date', array(':date'=>$datum));
	 }

	 /* Visszaadja az ügyfél megrendeléseinek számát */
	 public function getMegrendelesszam($datum) {
	 	return Megrendelesek::model()->countByAttributes(array('ugyfel_id'=> $this->id), 'rendeles_idopont<=:date', array(':date'=>$datum . " 00:00:00"));
	 }

	 /* Visszaadja az ügyfél első megrendelésének adatait */
	 public function getElsoRendelesDatum() {
		$criteria = new CDbCriteria();
		$criteria->select = 'rendeles_idopont';
		$criteria->condition  = "ugyfel_id=:uid and torolt='0'";
		$criteria->order = "rendeles_idopont";
		$criteria->limit = 1;		
		$criteria->params = array(':uid' => $this->id);
		$megrendeles = Megrendelesek::model()->find($criteria);
	 	return $megrendeles->rendeles_idopont ;	 		 
	 }
	 
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ugyfelek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

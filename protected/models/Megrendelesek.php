<?php

/**
 * This is the model class for table "dom_megrendelesek".
 *
 * The followings are the available columns in table 'dom_megrendelesek':
 * @property string $id
 * @property string $sorszam
 * @property string $ugyfel_id
 * @property string $cimzett
 * @property string $arkategoria_id
 * @property integer $egyedi_ar
 * @property string $rendeles_idopont
 * @property string $rendelest_rogzito_user_id
 * @property string $rendelest_lezaro_user_id
 * @property integer $afakulcs_id
 * @property string $arajanlat_id
 * @property string $proforma_szamla_sorszam
 * @property integer $proforma_szamla_fizetve
 * @property string $proforma_kiallitas_datum
 * @property string $proforma_teljesites_datum
 * @property string $proforma_fizetesi_hatarido
 * @property integer $proforma_fizetesi_mod
 * @property string $szamla_sorszam
 * @property string $szamla_kiallitas_datum
 * @property string $szamla_fizetesi_hatarido
 * @property integer $szamla_fizetve
 * @property string $szamla_kiegyenlites_datum
 * @property integer $ugyvednek_atadva
 * @property integer $behajto_cegnek_atadva
 * @property string $ugyfel_tel
 * @property string $ugyfel_fax
 * @property string $visszahivas_jegyzet
 * @property string $jegyzet
 * @property string $reklamszoveg
 * @property string $egyeb_megjegyzes
 * @property string $sztornozas_oka
 * @property string $megrendeles_forras_id
 * @property string $megrendeles_forras_megrendeles_id
 * @property string $nyomdakonyv_munka_id
 * @property integer $sztornozva
 * @property integer $torolt
 */
class Megrendelesek extends CActiveRecord
{
	public $autocomplete_ugyfel_name;
	public $autocomplete_ugyfel_cim;

	public $autocomplete_ugyfel_adoszam;
	public $autocomplete_ugyfel_fizetesi_moral;
	public $autocomplete_ugyfel_max_fizetesi_keses;
	public $autocomplete_ugyfel_atlagos_fizetesi_keses;
	public $autocomplete_ugyfel_rendelesi_tartozas_limit;
	public $autocomplete_ugyfel_fontos_megjegyzes;
	
	public $netto_ar;
	public $brutto_ar;
	public $arajanlat_sorszam;
	

	// az olyan jellegű keresésekhez, amiknél id-t tárolunk, de névre keresünk
	public $cegnev_search;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_megrendelesek';
	}

	public function getClassName ()
	{
		return "Megrendelés";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sorszam, ugyfel_id, arkategoria_id, rendeles_idopont, proforma_kiallitas_datum, proforma_teljesites_datum, proforma_fizetesi_hatarido, proforma_fizetesi_mod, sztornozva, torolt', 'required'),
			array('egyedi_ar, afakulcs_id, proforma_szamla_fizetve, szamla_fizetve, ugyvednek_atadva, behajto_cegnek_atadva, sztornozva, nyomdakonyv_munka_id, torolt', 'numerical', 'integerOnly'=>true),
			array('sorszam, ugyfel_id, arkategoria_id, rendelest_rogzito_user_id, rendelest_lezaro_user_id, arajanlat_id, megrendeles_forras_id, megrendeles_forras_megrendeles_id, nyomdakonyv_munka_id', 'length', 'max'=>12),
			array('cimzett, jegyzet', 'length', 'max'=>255),
			array('proforma_szamla_sorszam, szamla_sorszam', 'length', 'max'=>15),
			array('ugyfel_tel, ugyfel_fax', 'length', 'max'=>30),
			array('visszahivas_jegyzet, reklamszoveg, egyeb_megjegyzes', 'length', 'max'=>127),
			array('sztornozas_oka', 'length', 'max'=>255),
			
			array('ugyfel_id', 'isUgyfelEmpty'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sorszam, ugyfel_id, cimzett, arkategoria_id, egyedi_ar, rendeles_idopont, rendelest_rogzito_user_id, rendelest_lezaro_user_id, afakulcs_id, arajanlat_id, proforma_szamla_sorszam, proforma_szamla_fizetve, szamla_fizetesi_hatarido, szamla_fizetve, szamla_sorszam, szamla_kiegyenlites_datum, ugyfel_tel, ugyfel_fax, visszahivas_jegyzet, jegyzet, reklamszoveg, egyeb_megjegyzes, sztornozas_oka, megrendeles_forras_id, megrendeles_forras_megrendeles_id, nyomdakonyv_munka_id, sztornozva, cegnev_search, proforma_kiallitas_datum, proforma_teljesites_datum, proforma_fizetesi_hatarido, proforma_fizetesi_mod, torolt', 'safe', 'on'=>'search'),
		);
	}

	public function isUgyfelEmpty ($attribute)
	{
		if ($this -> ugyfel_id == null || $this -> ugyfel_id == 0)
			$this->addError($attribute, 'Az ügyél megadása kötelező!');
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'ugyfel'    => array(self::BELONGS_TO, 'Ugyfelek', 'ugyfel_id'),
			'arkategoria'    => array(self::BELONGS_TO, 'Arkategoriak', 'arkategoria_id'),
			'afakulcs'    => array(self::BELONGS_TO, 'AfaKulcsok', 'afakulcs_id'),
			'ajanlat'    => array(self::BELONGS_TO, 'Ajanlatok', 'ajanlat_id'),
			'rendelest_rogzito_user'    => array(self::BELONGS_TO, 'User', 'rendelest_rogzito_user_id'),
			'rendelest_lezaro_user'    	=> array(self::BELONGS_TO, 'User', 'rendelest_lezaro_user_id'),
			'megrendeles_forras'    	=> array(self::BELONGS_TO, 'Aruhazak', 'megrendeles_forras_id'),
			'fizetesi_mod'				=> array(self::BELONGS_TO, 'FizetesiModok', 'proforma_fizetesi_mod'),

			'szallitolevel'				=> array(self::HAS_MANY, 'Szallitolevelek', 'megrendeles_id'),						
			'tetelek' 					=> array(self::HAS_MANY, 'MegrendelesTetelek', 'megrendeles_id'),
			'negativ_tetelek'			=> array(self::HAS_MANY, 'RaktarTermekekNegativ', 'megrendeles_id'),
			'penzugyi_tranzakciok'		=> array(self::HAS_MANY, 'PenzugyiTranzakciok', 'megrendeles_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Megrendelés ID',
			'sorszam' => 'Sorszám',
			'arajanlat_sorszam' => 'Árajánlat sorszám',
			'ugyfel_id' => 'Ügyfél',
			'autocomplete_ugyfel_cim' => 'Cím',
			'cimzett' => 'Címzett',
			'autocomplete_ugyfel_adoszam' => 'Adószám',
			'autocomplete_ugyfel_fizetesi_moral' => 'Fizetési morál',
			'autocomplete_ugyfel_max_fizetesi_keses' => 'Max. fizetési késés',
			'autocomplete_ugyfel_atlagos_fizetesi_keses' => 'Átlagos fizetési késés',
			'autocomplete_ugyfel_rendelesi_tartozas_limit' => 'Rendelési tartozási limit (Ft)',
			'autocomplete_ugyfel_fontos_megjegyzes' => 'Fontos megjegyzés',
			'arkategoria_id' => 'Áruház árkategória beajánláshoz',
			'egyedi_ar' => 'Egyedi ár',
			'rendeles_idopont' => 'Rendelés időpontja',
			'rendelest_rogzito_user_id' => 'Rendelést rögzítette',
			'rendelest_lezaro_user_id' => 'Rendelést lezárta',
			'afakulcs_id' => 'Áfakulcs (%)',
			'arajanlat_id' => 'Árajánlat',
			'proforma_szamla_sorszam' => 'Proforma számla sorszáma',
			'proforma_szamla_fizetve' => 'Proforma számla fizetve',
			'proforma_kiallitas_datum' => 'Proforma kiállítás dátuma',
			'proforma_teljesites_datum' => 'Proforma teljesítés dátuma',
			'proforma_fizetesi_hatarido' => 'Proforma fizetési határidő',
			'proforma_fizetesi_mod' => 'Proforma fizetési mód',
			'szamla_sorszam' => 'Számla sorszáma',
			'szamla_kiallitas_datum' => 'Számla kiállítás dátuma',
			'szamla_fizetve' => 'Számla kiegyenlítve',
			'szamla_kiegyenlites_datum' => 'Számla kiegyenlítés dátuma',
			'szamla_fizetesi_hatarido' => 'Számla fizetési határidő',
			'ugyvednek_atadva' => 'Ügyvédnek átadva',
			'behajto_cegnek_atadva' => 'Behajtó cégnek átadva',
			'ugyfel_tel' => 'Ügyfél telefon',
			'ugyfel_fax' => 'Ügyfél fax',
			'visszahivas_jegyzet' => 'Visszahívás jegyzet',
			'jegyzet' => 'Jegyzet',
			'reklamszoveg' => 'Reklámszöveg',
			'egyeb_megjegyzes' => 'Egyéb megjegyzés',
			'sztornozas_oka' => 'Sztornózás oka',
			'megrendeles_forras_id' => 'Megrendelés forrása',
			'megrendeles_forras_megrendeles_id' => 'Megrendelés forrásban (webáruházban) a megrendelés azonosítója',
			'nyomdakonyv_munka_id' => 'Nyomdakönyv munka',
			'sztornozva' => 'Sztornözva',
			'torolt' => 'Törölt',
			
			'netto_ar' => 'Nettó összeg',
			'brutto_ar' => 'Bruttó összeg',
			
			'cegnev_search' => 'Cégnév',
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

		$criteria->select .= "t.id, t.sorszam, arajanlat.sorszam as arajanlat_sorszam, cimzett, rendeles_idopont, sztornozva, nyomdakonyv_munka_id, t.torolt, proforma_szamla_sorszam, proforma_szamla_fizetve, ROUND(SUM(tetelek.netto_darabar * tetelek.darabszam)) as netto_ar, ROUND(SUM(tetelek.netto_darabar * tetelek.darabszam) * (1 + (27 / 100))) as brutto_ar" ; 
		$criteria->together = true;
		$criteria->with = array('ugyfel');
		$criteria->join = "LEFT JOIN dom_arajanlatok as arajanlat ON (t.arajanlat_id = arajanlat.id)" ;
		$criteria->join .= "LEFT JOIN dom_megrendeles_tetelek as tetelek ON (t.id = tetelek.megrendeles_id)" ;
		$criteria->join .= "LEFT JOIN dom_afakulcsok as afakulcsok ON (t.afakulcs_id = afakulcsok.id)" ;
		$criteria->group = "t.id" ;
		
		
		$criteria->together = true;
		$criteria->with = array('ugyfel');
		
		$criteria->compare('id',$this->id,true);
		$criteria->compare('t.sorszam',$this->sorszam,true);
		$criteria->compare('arajanlat_sorszam',$this->arajanlat_sorszam,true);
		$criteria->compare('ugyfel_id',$this->ugyfel_id,true);
		$criteria->compare('cimzett',$this->cimzett,true);
		$criteria->compare('arkategoria_id',$this->arkategoria_id,true);
		$criteria->compare('egyedi_ar',$this->egyedi_ar);
		$criteria->compare('rendeles_idopont',$this->rendeles_idopont,true);
		$criteria->compare('rendelest_rogzito_user_id',$this->rendelest_rogzito_user_id,true);
		$criteria->compare('rendelest_lezaro_user_id',$this->rendelest_lezaro_user_id,true);
		$criteria->compare('afakulcs_id',$this->afakulcs_id);
		$criteria->compare('arajanlat_id',$this->arajanlat_id,true);
		$criteria->compare('proforma_szamla_sorszam',$this->proforma_szamla_sorszam,true);
		$criteria->compare('proforma_szamla_fizetve',$this->proforma_szamla_fizetve);
		$criteria->compare('proforma_kiallitas_datum',$this->proforma_kiallitas_datum);
		$criteria->compare('proforma_teljesites_datum',$this->proforma_teljesites_datum);
		$criteria->compare('proforma_fizetesi_hatarido',$this->proforma_fizetesi_hatarido);
		$criteria->compare('proforma_fizetesi_mod',$this->proforma_fizetesi_mod);
		$criteria->compare('szamla_sorszam',$this->szamla_sorszam,true);
		$criteria->compare('szamla_fizetve',$this->szamla_fizetve,true);
		$criteria->compare('szamla_fizetesi_hatarido',$this->szamla_fizetesi_hatarido,true);
		$criteria->compare('szamla_kiegyenlites_datum',$this->szamla_kiegyenlites_datum,true);
		$criteria->compare('ugyvednek_atadva',$this->ugyvednek_atadva,true);
		$criteria->compare('behajto_cegnek_atadva',$this->behajto_cegnek_atadva,true);
		$criteria->compare('ugyfel_tel',$this->ugyfel_tel,true);
		$criteria->compare('ugyfel_fax',$this->ugyfel_fax,true);
		$criteria->compare('visszahivas_jegyzet',$this->visszahivas_jegyzet,true);
		$criteria->compare('jegyzet',$this->jegyzet,true);
		$criteria->compare('reklamszoveg',$this->reklamszoveg,true);
		$criteria->compare('egyeb_megjegyzes',$this->egyeb_megjegyzes,true);
		$criteria->compare('sztornozas_oka',$this->sztornozas_oka,true);
		$criteria->compare('megrendeles_forras_id',$this->megrendeles_forras_id,true);
		$criteria->compare('megrendeles_forras_megrendeles_id',$this->megrendeles_forras_megrendeles_id,true);
		$criteria->compare('nyomdakonyv_munka_id',$this->nyomdakonyv_munka_id,true);
		$criteria->compare('sztornozva',$this->sztornozva);

		$criteria->compare('ugyfel.cegnev', $this->cegnev_search, true );
				
		// LI: logikailag törölt sorok ne jelenjenek meg, ha a belépett user nem az 'Admin'
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->compare('t.torolt', 0, false);
			
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
                        'defaultOrder'=>'t.id DESC, rendeles_idopont DESC',
                    ),
			'pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),)
		));
	}

	protected function afterFind(){
		parent::afterFind();

		if ($this -> rendeles_idopont != null)
			$this -> rendeles_idopont = date('Y-m-d H:i:s', strtotime(str_replace("-", "", $this->rendeles_idopont)));
		
		if (!is_numeric($this -> netto_ar)) {
			$this -> netto_ar = 0;	
		}

		if (!is_numeric($this -> brutto_ar)) {
			$this -> brutto_ar = 0;	
		}
		
		// autocomplete mező esetén az ügyfél ID van csak meg, így a beszédes
		// cégnevet, címet kézzel kell kitöltenünk
		if ($this -> ugyfel != null) {
			$this -> autocomplete_ugyfel_name = $this -> ugyfel -> cegnev;
			$this -> autocomplete_ugyfel_cim = $this -> ugyfel -> display_ugyfel_cim;

			$this -> autocomplete_ugyfel_adoszam = $this -> ugyfel -> adoszam;
			$this -> autocomplete_ugyfel_fizetesi_moral = $this -> ugyfel -> fizetesi_moral;
			$this -> autocomplete_ugyfel_max_fizetesi_keses = $this -> ugyfel -> max_fizetesi_keses;
			$this -> autocomplete_ugyfel_atlagos_fizetesi_keses = $this -> ugyfel -> atlagos_fizetesi_keses;
			$this -> autocomplete_ugyfel_rendelesi_tartozas_limit = $this -> ugyfel -> rendelesi_tartozasi_limit;
			$this -> autocomplete_ugyfel_fontos_megjegyzes = $this -> ugyfel -> fontos_megjegyzes;
		}
	}	

	// LI : a 'datum' mezőt automatikusan kitöltjük létrehozáskor
	public function beforeSave() {
		if ($this->isNewRecord) {
			$this->rendeles_idopont = new CDbExpression('NOW()');
		}
	 
		return parent::beforeSave();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Megrendelesek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getAutocomplete_ugyfel_name () {
		return $this -> autocomplete_ugyfel_name;
	}
	
	// TÁ: A megrendelések listázásánál a sorok css classát adja vissza, mivel eltérő színezést kell kapniuk attól függően, hogy van-e szállítólevél, minden termék szállítón van-e, stb.
    public function getCssClass() {
        $class = "" ;
    	$szallitolevelek = Szallitolevelek::model()->findAllByAttributes(array('megrendeles_id' => $this->id, 'sztornozva' => 0, 'torolt' => 0));
    	if ($szallitolevelek != null) {
			$class = "megrendeles_minden_szalliton" ;
			$ossz_szallito_termekszam = 0 ;
			$ossz_megrendeles_termekszam = 0 ;
			foreach($szallitolevelek as $szallito) {
				$szallito_db = $szallito->getTermekekDarabszamOsszesen() ;
				$ossz_szallito_termekszam += $szallito_db ;
			}
			$megrendeles_tetelek = MegrendelesTetelek::model()->findAllByAttributes(array('megrendeles_id' => $this->id)) ;
			foreach($megrendeles_tetelek as $megrendeles_tetel) {
				if ($megrendeles_tetel->termek->tipus != "Szolgáltatás") {
					$ossz_megrendeles_termekszam += $megrendeles_tetel -> darabszam ;
				}
			}
			if ($ossz_szallito_termekszam < $ossz_megrendeles_termekszam) {
				$class = "megrendeles_resszallitos" ;	
			}
		}
        return $class;
        
    }	
    
    // TÁ: A megrendelések listázásánál ha már van nyomtatva szállítólevél a megrendeléshez, másik ikont kell megjeleníteni, ezt dönti el ez a függvény, és visszaadja az eredményt
    public function getSzallitoNyomtatva() {
    	$return = 0 ;	
    	$szallitolevelek = Szallitolevelek::model()->findAllByAttributes(array('megrendeles_id' => $this->id));
    	foreach ($szallitolevelek as $szallito) {
    		if ($szallito->nyomtatva == 1) {
    			$return = 1 ;	
    		}
    	}
    	return $return ;
    }
    
    // TÁ: Visszaadja a megrendelés nettó és bruttó összegét
    public function getMegrendelesOsszeg() {
    	$netto_osszeg = 0;
    	$brutto_osszeg = 0;
    	$tetelek = MegrendelesTetelek::model()->findAllByAttributes(array('megrendeles_id' => $this->id)) ;
    	if (count($tetelek) > 0) {
    		foreach ($tetelek as $tetel) {
    			$netto_osszeg += $tetel->getNettoAr() ;
    			$brutto_osszeg += $tetel->getBruttoAr() ;
    		}
    	}
    	return array("netto_osszeg" => $netto_osszeg, "brutto_osszeg" => $brutto_osszeg) ;
    }
}

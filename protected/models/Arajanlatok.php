<?php

/**
 * This is the model class for table "dom_arajanlatok".
 *
 * The followings are the available columns in table 'dom_arajanlatok':
 * @property string $id
 * @property string $sorszam
 * @property string $ugyfel_id
 * @property string $cimzett
 * @property string $arkategoria_id
 * @property string $ajanlat_datum
 * @property string $ervenyesseg_datum
 * @property string $hatarido
 * @property integer $afakulcs_id
 * @property integer $ugyintezo_id
 * @property string $kovetkezo_hivas_ideje
 * @property integer $visszahivas_lezarva
 * @property string $ugyfel_tel
 * @property string $ugyfel_fax
 * @property string $visszahivas_jegyzet
 * @property string $jegyzet
 * @property string $reklamszoveg
 * @property string $egyeb_megjegyzes
 * @property integer $van_megrendeles
 * @property integer $torolt
 * @property integer $email_verification_code;
 * @property integer $admin_id
 */
class Arajanlatok extends CActiveRecord
{
	public $autocomplete_ugyfel_name;
	public $autocomplete_ugyfel_cim;

	public $autocomplete_ugyfel_adoszam;
	public $autocomplete_ugyfel_fizetesi_moral;
	public $autocomplete_ugyfel_max_fizetesi_keses;
	public $autocomplete_ugyfel_atlagos_fizetesi_keses;
	public $autocomplete_ugyfel_rendelesi_tartozas_limit;
	public $autocomplete_ugyfel_fontos_megjegyzes;

	public $autocomplete_arajanlat_osszes_darabszam;
	public $autocomplete_arajanlat_osszes_ertek;
	public $autocomplete_arajanlat_osszes_tetel;
	public $autocomplete_megrendeles_osszes_darabszam;
	public $autocomplete_megrendeles_osszes_ertek;
	public $autocomplete_megrendeles_osszes_tetel;
	public $autocomplete_arajanlat_megrendeles_elfogadas;
	
	public $netto_ar;
	public $brutto_ar;
	
	// az olyan jellegű keresésekhez, amiknél id-t tárolunk, de névre keresünk
	public $cegnev_search;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_arajanlatok';
	}
	
	public function getClassName ()
	{
		return "Árajánlat";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sorszam, ugyfel_id, arkategoria_id, ajanlat_datum, ervenyesseg_datum, torolt', 'required'),
			array('afakulcs_id, ugyintezo_id, visszahivas_lezarva, egyedi_ar, torolt', 'numerical', 'integerOnly'=>true),
			array('sorszam, ugyfel_id, arkategoria_id, ugyintezo_id', 'length', 'max'=>12),
			array('hatarido', 'length', 'max'=>15),
			array('ugyfel_tel, ugyfel_fax', 'length', 'max'=>30),
			array('visszahivas_jegyzet, reklamszoveg, egyeb_megjegyzes', 'length', 'max'=>127),
			array('jegyzet, cimzett', 'length', 'max'=>255),
			
			array('ugyfel_id', 'isUgyfelEmpty'),
			
			array('ajanlat_datum, ervenyesseg_datum, kovetkezo_hivas_ideje', 'type', 'type' => 'date', 'message' => '{attribute}: nem megfelelő formátumú!', 'dateFormat' => 'yyyy-MM-dd'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, admin_id, sorszam, ugyfel_id, cimzett, arkategoria_id, ajanlat_datum, ervenyesseg_datum, hatarido, afakulcs_id, ugyintezo_id, kovetkezo_hivas_ideje, visszahivas_lezarva, ugyfel_tel, ugyfel_fax, visszahivas_jegyzet, jegyzet, reklamszoveg, egyeb_megjegyzes, cegnev_search, email_verification_code, torolt', 'safe', 'on'=>'search'),
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
			'ugyintezo'    => array(self::BELONGS_TO, 'UgyfelUgyintezok', 'ugyintezo_id'),
			
			'tetelek' => array(self::HAS_MANY, 'ArajanlatTetelek', 'arajanlat_id'),
			'visszahivasok' => array(self::HAS_MANY, 'ArajanlatVisszahivasok', 'arajanlat_id'),			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Árajánlat ID',
			'sorszam' => 'Sorszám',
			'ugyfel_id' => 'Ügyfél',
			'arkategoria_id' => 'Áruház árkategória beajánláshoz',
			'ajanlat_datum' => 'Ajánlat dátuma',
			'ervenyesseg_datum' => 'Érvényesség dátuma',
			'hatarido' => 'Határidő (nap)',
			'afakulcs_id' => 'Áfakulcs (%)',
			'ugyintezo_id' => 'Ügyintéző',
			'kovetkezo_hivas_ideje' => 'Következő hívás ideje',
			'visszahivas_lezarva' => 'Visszahívás lezárva',
			'ugyfel_tel' => 'Ügyfél telefon',
			'ugyfel_fax' => 'Ügyfél fax',
			'egyedi_ar' => 'Egyedi ár',
			'visszahivas_jegyzet' => 'Visszahívás jegyzet',
			'jegyzet' => 'Jegyzet',
			'reklamszoveg' => 'Reklámszöveg',
			'egyeb_megjegyzes' => 'Egyéb megjegyzés',
			'van_megrendeles' => 'Megrendelve',
			'torolt' => 'Törölt',
			
			'autocomplete_ugyfel_cim' => 'Cím',
			'cimzett' => 'Címzett',
			
			'autocomplete_ugyfel_adoszam' => 'Adószám',
			'autocomplete_ugyfel_fizetesi_moral' => 'Fizetési morál',
			'autocomplete_ugyfel_max_fizetesi_keses' => 'Max. fizetési késés',
			'autocomplete_ugyfel_atlagos_fizetesi_keses' => 'Átlagos fizetési késés',
			'autocomplete_ugyfel_rendelesi_tartozas_limit' => 'Rendelési tartozási limit (Ft)',
			'autocomplete_ugyfel_fontos_megjegyzes' => 'Fontos megjegyzés',

			'autocomplete_arajanlat_osszes_darabszam' => 'Összes árajánlat száma (db)',
			'autocomplete_arajanlat_osszes_ertek' => 'Összes árajánlat értéke (nettó)',
			'autocomplete_arajanlat_osszes_tetel' => 'Összes árajánlat tétel (db)',
			'autocomplete_megrendeles_osszes_darabszam' => 'Összes megrendelés száma (db)',
			'autocomplete_megrendeles_osszes_ertek' => 'Összes megrendelés értéke (nettó)',
			'autocomplete_megrendeles_osszes_tetel' => 'Összes megrendelés tétel (db)',
			'autocomplete_arajanlat_megrendeles_elfogadas' => 'Elfogadási arány (%)',
			
			'netto_ar' => 'Nettó összeg',
			'brutto_ar' => 'Bruttó összeg',
			
			'cegnev_search' => 'Cégnév',
		);
	}

	public function behaviors() {
		return array( 'LoggableBehavior'=> 'application.modules.auditTrail.behaviors.LoggableBehavior', );
	}

	public function visszahivasok_search() {
		$belepett_admin = Yii::app()->user->getId();
		$criteria=new CDbCriteria;

		$criteria->select = "t.id, sorszam, cimzett, kovetkezo_hivas_ideje, ugyfel_tel, ajanlat_datum, t.torolt" ; 
		$criteria->condition = "admin_id = '" . $belepett_admin . "' and kovetkezo_hivas_ideje >= CURDATE() and visszahivas_lezarva = 0";
		
		$criteria->compare('admin_id',$this->admin_id);
		
		// LI: logikailag törölt sorok ne jelenjenek meg, ha a belépett user nem az 'Admin'
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->compare('t.torolt', 0, false);
			
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
                        'defaultOrder'=>'kovetkezo_hivas_ideje DESC',
                    ),
			'pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),)
		));		
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

		$criteria->select .= "t.id, sorszam, cimzett, kovetkezo_hivas_ideje, ugyfel_tel, ajanlat_datum, hatarido, van_megrendeles, t.torolt, ROUND(SUM(tetelek.netto_darabar * tetelek.darabszam)) as netto_ar, ROUND(SUM(tetelek.netto_darabar * tetelek.darabszam) * (1 + (27 / 100))) as brutto_ar" ; 
		$criteria->together = true;
		$criteria->with = array('ugyfel');
		$criteria->join = "LEFT JOIN dom_arajanlat_tetelek as tetelek ON (t.id = tetelek.arajanlat_id)" ;
		$criteria->join .= "LEFT JOIN dom_afakulcsok as afakulcsok ON (t.afakulcs_id = afakulcsok.id)" ;
		$criteria->group = "t.id" ;
		
		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('sorszam',$this->sorszam,true);
		$criteria->compare('ugyfel_id',$this->ugyfel_id,true);
		$criteria->compare('cimzett',$this->cimzett,true);
		$criteria->compare('arkategoria_id',$this->arkategoria_id,true);
		$criteria->compare('ajanlat_datum',$this->ajanlat_datum,true);
		$criteria->compare('ervenyesseg_datum',$this->ervenyesseg_datum,true);
		$criteria->compare('hatarido',$this->hatarido,true);
		$criteria->compare('afakulcs_id',$this->afakulcs_id);
		$criteria->compare('ugyintezo_id',$this->ugyintezo_id);
		$criteria->compare('kovetkezo_hivas_ideje',$this->kovetkezo_hivas_ideje,true);
		$criteria->compare('visszahivas_lezarva',$this->visszahivas_lezarva);
		$criteria->compare('ugyfel_tel',$this->ugyfel_tel,true);
		$criteria->compare('ugyfel_fax',$this->ugyfel_fax,true);
		$criteria->compare('t.egyedi_ar',$this->egyedi_ar);
		$criteria->compare('visszahivas_jegyzet',$this->visszahivas_jegyzet,true);
		$criteria->compare('jegyzet',$this->jegyzet,true);
		$criteria->compare('reklamszoveg',$this->reklamszoveg,true);
		$criteria->compare('egyeb_megjegyzes',$this->egyeb_megjegyzes,true);

		$criteria->compare('ugyfel.cegnev', $this->cegnev_search, true );
		
		// LI: logikailag törölt sorok ne jelenjenek meg, ha a belépett user nem az 'Admin'
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->compare('t.torolt', 0, false);
			
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
                        'defaultOrder'=>'ajanlat_datum desc, t.id DESC',
                    ),
			'pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),)
		));
	}

	protected function afterFind(){
		parent::afterFind();

		if ($this -> ajanlat_datum != null)
			$this -> ajanlat_datum = date('Y-m-d', strtotime(str_replace("-", "", $this->ajanlat_datum)));
			
		if ($this -> ervenyesseg_datum != null)
			$this -> ervenyesseg_datum = date('Y-m-d', strtotime(str_replace("-", "", $this->ervenyesseg_datum)));
		
		if ($this -> kovetkezo_hivas_ideje != null)
			$this -> kovetkezo_hivas_ideje = date('Y-m-d', strtotime(str_replace("-", "", $this->kovetkezo_hivas_ideje)));
		
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
			
			// árajánlat és megrendelés statisztikák kiszámolása
			$osszesArajanlat = Utils::getUgyfelOsszesArajanlatErteke($this -> ugyfel -> id);
			$osszesArajanlatDarab = Utils::getUgyfelOsszesArajanlatDarab($this -> ugyfel -> id);
			$this -> autocomplete_arajanlat_osszes_darabszam = $osszesArajanlatDarab != null ? $osszesArajanlatDarab : 0;
			$this -> autocomplete_arajanlat_osszes_ertek = Utils::OsszegFormazas ($osszesArajanlat != null ? $osszesArajanlat['arajanlat_netto_osszeg'] : 0, 0);
			$this -> autocomplete_arajanlat_osszes_tetel = $osszesArajanlat != null ? $osszesArajanlat['tetel_darabszam'] : 0;

			$osszesMegrendeles = Utils::getUgyfelOsszesMegrendelesErteke($this -> ugyfel -> id);
			$osszesMegrendelesDarab = Utils::getUgyfelOsszesMegrendelesDarab($this -> ugyfel -> id);
			$this -> autocomplete_megrendeles_osszes_darabszam = $osszesMegrendeles != null ? $osszesMegrendelesDarab : 0;
			$this -> autocomplete_megrendeles_osszes_ertek = Utils::OsszegFormazas ($osszesMegrendeles != null ? $osszesMegrendeles['megrendeles_netto_osszeg'] : 0, 0);
			$this -> autocomplete_megrendeles_osszes_tetel = $osszesMegrendeles != null ? $osszesMegrendeles['tetel_darabszam'] : 0;
			
			$this -> autocomplete_arajanlat_megrendeles_elfogadas = ($this -> autocomplete_megrendeles_osszes_tetel != 0 && $this -> autocomplete_arajanlat_osszes_tetel != 0) ?
																	(number_format((float)$this -> autocomplete_megrendeles_osszes_tetel / $this -> autocomplete_arajanlat_osszes_tetel * 100, 2, '.', '')) : 0;
																	
		}
	}

	// LI : a 'datum' mezőt automatikusan kitöltjük létrehozáskor
	public function beforeSave() {
		if ($this->isNewRecord) {
			$this->ajanlat_datum = new CDbExpression('NOW()');
			$this->ervenyesseg_datum = new CDbExpression('NOW()+ INTERVAL 8 DAY');
			$this->kovetkezo_hivas_ideje = new CDbExpression('NOW()');
			$this->admin_id = Yii::app()->user->getId();
			
			// default-ból a reklámbox-ban egy előre beállított szöveg szerepel, amit a felhasználó felülírhat
			if ($this->isNewRecord) {
				$this->reklamszoveg = "Kezében tartja a lehetőséget, csak élni kell vele!";
			}
		}
	 
		return parent::beforeSave();
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Arajanlatok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getAutocomplete_ugyfel_name () {
		return $this -> autocomplete_ugyfel_name;
	}
/*	
	public function arajanlat_tetel_elozmenyek($ugyfel_id) {
		if (is_numeric($ugyfel_id) && $ugyfel_id > 0) {
			
			$termek_ajanlatok = Yii::app()->db->createCommand()
												->select('arajanlat_tetelek.termek_id, termekek.nev as termeknev, arajanlatok.sorszam as ajanlat_sorszam, arajanlatok.ajanlat_datum, megrendeles_tetelek.arajanlatbol_letrehozva')
												->from('dom_arajanlatok arajanlatok')
												->join('dom_arajanlat_tetelek as arajanlat_tetelek','arajanlatok.id = arajanlat_tetelek.arajanlat_id')
												->leftJoin('dom_termekek termekek','arajanlat_tetelek.termek_id = termekek.id')
												->leftJoin('dom_megrendeles_tetelek megrendeles_tetelek', 'megrendeles_tetelek.arajanlat_tetel_id = arajanlat_tetelek.id')
												->where('arajanlatok.ugyfel_id=:ugyfel_id', array(':ugyfel_id'=>$ugyfel_id))
												->queryAll();
			return new CActiveDataProvider($termek_ajanlatok, array(
				'criteria'=>$criteria,
				'sort'=>array(
							'defaultOrder'=>'ajanlat_datum DESC',
						),						
			));
		
		}		
	}
*/	
}

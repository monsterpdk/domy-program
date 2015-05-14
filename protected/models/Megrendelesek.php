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
 * @property string $szamla_sorszam
 * @property string $ugyfel_tel
 * @property string $ugyfel_fax
 * @property string $visszahivas_jegyzet
 * @property string $jegyzet
 * @property string $reklamszoveg
 * @property string $egyeb_megjegyzes
 * @property string $sztornozas_oka
 * @property string $megrendeles_forras_id
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
			array('sorszam, ugyfel_id, arkategoria_id, rendeles_idopont, sztornozva, torolt', 'required'),
			array('egyedi_ar, afakulcs_id, proforma_szamla_fizetve, sztornozva, torolt', 'numerical', 'integerOnly'=>true),
			array('sorszam, ugyfel_id, arkategoria_id, rendelest_rogzito_user_id, rendelest_lezaro_user_id, arajanlat_id, megrendeles_forras_id, nyomdakonyv_munka_id', 'length', 'max'=>10),
			array('cimzett, jegyzet', 'length', 'max'=>255),
			array('proforma_szamla_sorszam, szamla_sorszam', 'length', 'max'=>15),
			array('ugyfel_tel, ugyfel_fax', 'length', 'max'=>30),
			array('visszahivas_jegyzet, reklamszoveg, egyeb_megjegyzes', 'length', 'max'=>127),
			array('sztornozas_oka', 'length', 'max'=>255),
			
			array('ugyfel_id', 'isUgyfelEmpty'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sorszam, ugyfel_id, cimzett, arkategoria_id, egyedi_ar, rendeles_idopont, rendelest_rogzito_user_id, rendelest_lezaro_user_id, afakulcs_id, arajanlat_id, proforma_szamla_sorszam, proforma_szamla_fizetve, szamla_sorszam, ugyfel_tel, ugyfel_fax, visszahivas_jegyzet, jegyzet, reklamszoveg, egyeb_megjegyzes, sztornozas_oka, megrendeles_forras_id, nyomdakonyv_munka_id, sztornozva, torolt', 'safe', 'on'=>'search'),
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
			'rendelest_lezaro_user'    => array(self::BELONGS_TO, 'User', 'rendelest_lezaro_user_id'),
			'megrendeles_forras'    => array(self::BELONGS_TO, 'Aruhazak', 'megrendeles_forras_id'),
			
			'tetelek' => array(self::HAS_MANY, 'MegrendelesTetelek', 'megrendeles_id'),
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
			'szamla_sorszam' => 'Számla sorszáma',
			'ugyfel_tel' => 'Ügyfél telefon',
			'ugyfel_fax' => 'Ügyfél fax',
			'visszahivas_jegyzet' => 'Visszahívás jegyzet',
			'jegyzet' => 'Jegyzet',
			'reklamszoveg' => 'Reklámszöveg',
			'egyeb_megjegyzes' => 'Egyéb megjegyzés',
			'sztornozas_oka' => 'Sztornózás oka',
			'megrendeles_forras_id' => 'Megrendelés forrása',
			'nyomdakonyv_munka_id' => 'Nyomdakönyv munka',
			'sztornozva' => 'Sztornözva',
			'torolt' => 'Törölt',
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
		$criteria->compare('sorszam',$this->sorszam,true);
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
		$criteria->compare('szamla_sorszam',$this->szamla_sorszam,true);
		$criteria->compare('ugyfel_tel',$this->ugyfel_tel,true);
		$criteria->compare('ugyfel_fax',$this->ugyfel_fax,true);
		$criteria->compare('visszahivas_jegyzet',$this->visszahivas_jegyzet,true);
		$criteria->compare('jegyzet',$this->jegyzet,true);
		$criteria->compare('reklamszoveg',$this->reklamszoveg,true);
		$criteria->compare('egyeb_megjegyzes',$this->egyeb_megjegyzes,true);
		$criteria->compare('sztornozas_oka',$this->sztornozas_oka,true);
		$criteria->compare('megrendeles_forras_id',$this->megrendeles_forras_id,true);
		$criteria->compare('nyomdakonyv_munka_id',$this->nyomdakonyv_munka_id,true);
		$criteria->compare('sztornozva',$this->sztornozva);

		// LI: logikailag törölt sorok ne jelenjenek meg, ha a belépett user nem az 'Admin'
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->condition=" torolt = '0'";
			
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function afterFind(){
		parent::afterFind();

		if ($this -> rendeles_idopont != null)
			$this -> rendeles_idopont = date('Y-m-d', strtotime(str_replace("-", "", $this->rendeles_idopont)));
		
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
	
}

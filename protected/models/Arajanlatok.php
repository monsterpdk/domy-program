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
 */
class Arajanlatok extends CActiveRecord
{
	public $autocomplete_ugyfel_name;
	public $autocomplete_ugyfel_cim;

	public $autocomplete_ugyfel_adoszam;
	public $autocomplete_ugyfel_fizetesi_moral;
	public $autocomplete_ugyfel_atlagos_fizetesi_keses;
	public $autocomplete_ugyfel_fontos_megjegyzes;
	
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
			array('afakulcs_id, visszahivas_lezarva, egyedi_ar, torolt', 'numerical', 'integerOnly'=>true),
			array('sorszam, ugyfel_id, arkategoria_id', 'length', 'max'=>10),
			array('hatarido', 'length', 'max'=>15),
			array('ugyfel_tel, ugyfel_fax', 'length', 'max'=>30),
			array('visszahivas_jegyzet, reklamszoveg, egyeb_megjegyzes', 'length', 'max'=>127),
			array('jegyzet, cimzett', 'length', 'max'=>255),
			
			array('ugyfel_id', 'isUgyfelEmpty'),
			
			array('ajanlat_datum, ervenyesseg_datum, kovetkezo_hivas_ideje', 'type', 'type' => 'date', 'message' => '{attribute}: nem megfelelő formátumú!', 'dateFormat' => 'yyyy-MM-dd'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sorszam, ugyfel_id, cimzett, arkategoria_id, ajanlat_datum, ervenyesseg_datum, hatarido, afakulcs_id, kovetkezo_hivas_ideje, visszahivas_lezarva, ugyfel_tel, ugyfel_fax, visszahivas_jegyzet, jegyzet, reklamszoveg, egyeb_megjegyzes, torolt', 'safe', 'on'=>'search'),
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
			
			'tetelek' => array(self::HAS_MANY, 'ArajanlatTetelek', 'arajanlat_id'),
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
			'autocomplete_ugyfel_atlagos_fizetesi_keses' => 'Átlagos fizetési késés',
			'autocomplete_ugyfel_fontos_megjegyzes' => 'Fontos megjegyzés',
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
		$criteria->compare('ajanlat_datum',$this->ajanlat_datum,true);
		$criteria->compare('ervenyesseg_datum',$this->ervenyesseg_datum,true);
		$criteria->compare('hatarido',$this->hatarido,true);
		$criteria->compare('afakulcs_id',$this->afakulcs_id);
		$criteria->compare('kovetkezo_hivas_ideje',$this->kovetkezo_hivas_ideje,true);
		$criteria->compare('visszahivas_lezarva',$this->visszahivas_lezarva);
		$criteria->compare('ugyfel_tel',$this->ugyfel_tel,true);
		$criteria->compare('ugyfel_fax',$this->ugyfel_fax,true);
		$criteria->compare('egyedi_ar',$this->egyedi_ar);
		$criteria->compare('visszahivas_jegyzet',$this->visszahivas_jegyzet,true);
		$criteria->compare('jegyzet',$this->jegyzet,true);
		$criteria->compare('reklamszoveg',$this->reklamszoveg,true);
		$criteria->compare('egyeb_megjegyzes',$this->egyeb_megjegyzes,true);

		// LI: logikailag törölt sorok ne jelenjenek meg, ha a belépett user nem az 'Admin'
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->condition=" torolt = '0'";
			
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
		
		// autocomplete mező esetén az ügyfél ID van csak meg, így a beszédes
		// cégnevet, címet kézzel kell kitöltenünk
		if ($this -> ugyfel != null) {
			$this -> autocomplete_ugyfel_name = $this -> ugyfel -> cegnev;
			$this -> autocomplete_ugyfel_cim = $this -> ugyfel -> display_ugyfel_cim;
			
			$this -> autocomplete_ugyfel_adoszam = $this -> ugyfel -> adoszam;
			$this -> autocomplete_ugyfel_fizetesi_moral = $this -> ugyfel -> fizetesi_moral;
			$this -> autocomplete_ugyfel_atlagos_fizetesi_keses = $this -> ugyfel -> atlagos_fizetesi_keses;
			$this -> autocomplete_ugyfel_fontos_megjegyzes = $this -> ugyfel -> fontos_megjegyzes;
		}
	}

	// LI : a 'datum' mezőt automatikusan kitöltjük létrehozáskor
	public function beforeSave() {
		if ($this->isNewRecord) {
			$this->ajanlat_datum = new CDbExpression('NOW()');
			$this->ervenyesseg_datum = new CDbExpression('NOW()');
			$this->kovetkezo_hivas_ideje = new CDbExpression('NOW()');
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
	
}

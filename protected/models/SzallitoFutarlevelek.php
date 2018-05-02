<?php

/**
 * This is the model class for table "dom_szallitas_futarlevelek".
 *
 * The followings are the available columns in table 'dom_szallitas_futarlevelek':
 * @property string $id
 * @property string $szallitolevel_szam
 * @property string $szamla_sorszam
 * @property integer $szallito_ceg
 * @property integer $szallito_futar
 * @property string $felvetel_helye
 * @property string $felvetel_ideje
 * @property string $szallitas_cegnev
 * @property string $szallitas_cim
 * @property string $szallitas_telefonszam
 * @property integer $fizetesi_mod
 * @property float $utanvet_osszeg
 * @property float $szallitas_dij
 * @property string $egyeb_info
 * @property string $utanvet_visszahozas_datum
 * @property string $bizonylatszam
 */
class SzallitoFutarlevelek extends CActiveRecord
{

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_szallitas_futarlevelek';
	}

	public function getClassName ()
	{
		return "Fuvarlevelek";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('szallito_ceg, szallito_futar, felvetel_helye, felvetel_ideje, szallitas_cegnev, szallitas_cim, szallitas_telefonszam, fizetesi_mod, szallitas_dij', 'required'),
			array('szallito_ceg, szallito_futar, fizetesi_mod', 'numerical', 'integerOnly'=>true),
			array('utanvet_osszeg, szallitas_dij', 'numerical'),
			array('szallitolevel_szam, szamla_sorszam', 'length', 'max'=>20),
			array('szallitas_cim, egyeb_info', 'length', 'max'=>255),
			array('felvetel_helye, szallitas_cegnev', 'length', 'max'=>100),
			array('felvetel_ideje', 'type', 'type' => 'date', 'message' => '{attribute}: nem megfelelő formátumú!', 'dateFormat' => 'yyyy-MM-dd HH:mm:ss'),
			
			array('szallitolevel_szam', 'uniqueSzallitolevelszamOrNull'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('szallitolevel_szam, szamla_sorszam, szallito_ceg, szallito_futar, felvetel_helye, felvetel_ideje, szallitas_cegnev, szallitas_cim, szallitas_telefonszam, fizetesi_mod, utanvet_osszeg, szallitas_dij, egyeb_info, utanvet_visszahozas_datum, bizonylatszam', 'safe', 'on'=>'search'),
		);
	}

	public function uniqueSzallitolevelszamOrNull($attribute)
	{
		if ($this->szallitolevel_szam != "") {
			$futarlevelek = SzallitoFutarlevelek::model()->findAllByAttributes(array('szallitolevel_szam' => $this->szallitolevel_szam));
			
			if (count($futarlevelek) > 0) {
				$futarlevelek = $futarlevelek[0];

				if ($futarlevelek -> id != $this -> id)
					$this->addError($attribute, 'Van már ilyen szállítólevél számmal fuvarlevél a rendszerben!');
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
			'szallito_ceg_rel'    => array(self::BELONGS_TO, 'SzallitoCegek', 'szallito_ceg'),
			'szallito_futar_rel'    => array(self::BELONGS_TO, 'SzallitoCegFutarok', 'szallito_futar'),
			'fizetesi_mod_rel'    => array(self::BELONGS_TO, 'FizetesiModok', 'fizetesi_mod'),

			'tetelek' => array(self::HAS_MANY, 'SzallitoFutarlevelTetelek', 'futarlevel_id'),
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
			'id' => 'Futárlevél ID',
			'szallitolevel_szam' => 'Szállítólevél szám',
			'szamla_sorszam' => 'Számla sorszám',
			'szallito_ceg' => 'Szállító cég',
			'szallito_futar' => 'Futár neve',
			'felvetel_helye' => 'Felvétel helye',
			'felvetel_ideje' => 'Felvétel ideje',
			'szallitas_cegnev' => 'Cég neve',
			'szallitas_cim' => 'Szállítási cím',
			'szallitas_telefonszam' => 'Telefonszám',
			'fizetesi_mod' => 'Fizetési mód',
			'utanvet_osszeg' => 'Utánvét összeg',
			'szallitas_dij' => 'Szállítási díj',
			'egyeb_info' => 'Egyéb információk',
			'utanvet_visszahozas_datum' => 'Visszahozás dátuma',
			'bizonylatszam' => 'Bizonylatszám',
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
		$criteria->compare('szallitolevel_szam',$this->szallitolevel_szam,true);
		$criteria->compare('szamla_sorszam',$this->szamla_sorszam,true);
		$criteria->compare('szallito_ceg',$this->szallito_ceg,true);
		$criteria->compare('szallito_futar',$this->szallito_futar,true);
		$criteria->compare('felvetel_helye',$this->felvetel_helye,true);
		$criteria->compare('felvetel_ideje',$this->felvetel_ideje);
		$criteria->compare('szallitas_cegnev',$this->szallitas_cegnev,true);
		$criteria->compare('szallitas_cim',$this->szallitas_cim);
		$criteria->compare('szallitas_telefonszam',$this->szallitas_telefonszam);
		$criteria->compare('fizetesi_mod',$this->fizetesi_mod);
		$criteria->compare('utanvet_osszeg',$this->utanvet_osszeg);
		$criteria->compare('szallitas_dij',$this->szallitas_dij);
		$criteria->compare('egyeb_info',$this->egyeb_info);
		$criteria->compare('utanvet_visszahozas_datum',$this->utanvet_visszahozas_datum);
		$criteria->compare('bizonylatszam',$this->bizonylatszam);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
	
/*	public function getDisplayBizonylatszamDatum () {
		return $this->bizonylatszam . ' - ' . date('Y.m.d', strtotime($this->beszallitas_datum));
	}
	
	public function getDisplayOsszertekIroda () {
		return Utils::OsszegFormazas($this->displayOsszertekIroda);
	}
	
	public function getDisplayOsszertekRaktar () {
		return Utils::OsszegFormazas($this->displayOsszertekRaktar);
	}
	*/
}

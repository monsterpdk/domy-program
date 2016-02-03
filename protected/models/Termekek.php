<?php

/**
 * This is the model class for table "dom_termekek".
 *
 * The followings are the available columns in table 'dom_termekek':
 * @property string $id
 * @property string $nev
 * @property string $tipus
 * @property string $kodszam
 * @property string $cikkszam
 * @property integer $meret_id
 * @property integer $suly
 * @property integer $zaras_id
 * @property integer $ablakmeret_id
 * @property integer $ablakhely_id
 * @property integer $papir_id
 * @property integer $afakulcs_id
 * @property string $redotalp
 * @property string $gyarto_id
 * @property string $ksh_kod
 * @property string $csom_egys
 * @property string $minimum_raktarkeszlet
 * @property string $maximum_raktarkeszlet
 * @property double $doboz_suly
 * @property string $raklap_db
 * @property double $doboz_hossz
 * @property double $doboz_szelesseg
 * @property double $doboz_magassag
 * @property string $megjegyzes
 * @property string $megjelenes_mettol - egyelőre nem használjuk, de még nem törlöm ki, hátha meggondolják magukat
 * @property string $megjelenes_meddig - egyelőre nem használjuk, de még nem törlöm ki, hátha meggondolják magukat
 * @property string $felveteli_datum
 * @property string $datum
 * @property integer $torolt
 * @property integer $belesnyomott
 *
 * virtual property string displayTermeknev (kódszám + terméknév)
 */
class Termekek extends CActiveRecord
{
	// az olyan jellegű keresésekhez, amiknél id-t tárolunk, de névre keresünk
	public $zaras_search;
	public $ablakhely_search;
	public $ablakmeret_search;
	public $meret_search;
	public $gyarto_search;
	public $papirtipus_search;
	public $termekcsoport_search;
	
	// LI amikor valamelyik űrlapról terméket tallózunk, akkor kódszám+terméknév formában jelenítjük meg a termékeket
	private $displayTermeknev;
	
	// LI a termék összes adata 1 string-be: részletek lent a 'getDisplayTermekTeljesNev' metódusban
	private $displayTermekTeljesNev;

	private $activeTermekAr;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_termekek';
	}

	
	public function getClassName ()
	{
		return "Termék";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nev, tipus, kodszam, cikkszam, afakulcs_id, gyarto_id, csom_egys, doboz_suly, felveteli_datum, termekcsoport_id', 'required'),
			array('meret_id, zaras_id, ablakmeret_id, ablakhely_id, papir_id, afakulcs_id, torolt, belesnyomott', 'numerical', 'integerOnly'=>true),
			array('doboz_suly, suly, doboz_hossz, doboz_szelesseg, doboz_magassag', 'numerical'),
			array('nev', 'length', 'max'=>127),
			array('kodszam', 'length', 'max'=>15),
			array('cikkszam', 'length', 'max'=>30),
			array('redotalp', 'length', 'max'=>50),
			array('kategoria_tipus', 'length', 'max'=>1),
			array('gyarto_id, ksh_kod, csom_egys, minimum_raktarkeszlet, maximum_raktarkeszlet, raklap_db', 'length', 'max'=>10),
			array('felveteli_datum', 'type', 'type' => 'date', 'message' => '{attribute}: nem megfelelő formátumú!', 'dateFormat' => 'yyyy-MM-dd'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nev, tipus, kodszam, cikkszam, meret_id, meret_search, suly, zaras_id, zaras_search, ablakhely_search, ablakmeret_search, ablakmeret_id, ablakhely_id, papir_id, papirtipus_search, termekcsoport_search, afakulcs_id, redotalp, kategoria_tipus, gyarto_id, gyarto_search, ksh_kod, csom_egys, minimum_raktarkeszlet, maximum_raktarkeszlet, doboz_suly, raklap_db, doboz_hossz, doboz_szelesseg, doboz_magassag, megjegyzes, felveteli_datum, datum, torolt, belesnyomott', 'safe', 'on'=>'search'),
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
			'meret'   		=> array(self::BELONGS_TO, 'TermekMeretek', 'meret_id'),
			'zaras'    		=> array(self::BELONGS_TO, 'TermekZarasiModok', 'zaras_id'),
			'ablakmeret'    => array(self::BELONGS_TO, 'TermekAblakMeretek', 'ablakmeret_id'),
			'ablakhely'    	=> array(self::BELONGS_TO, 'TermekAblakHelyek', 'ablakhely_id'),
			'papirtipus'    => array(self::BELONGS_TO, 'PapirTipusok', 'papir_id'),
			'afakulcs'    	=> array(self::BELONGS_TO, 'AfaKulcsok', 'afakulcs_id'),
			'gyarto'    	=> array(self::BELONGS_TO, 'Gyartok', 'gyarto_id'),
			'termekcsoport'	=> array(self::BELONGS_TO, 'Termekcsoportok', 'termekcsoport_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Termék ID',
			'nev' => 'Terméknév',
			'tipus' => 'Típus',
			'kodszam' => 'Kódszám',
			'cikkszam' => 'Cikkszám',
			'meret_id' => 'Méret',
			'suly' => 'Súly (kg)',
			'zaras_id' => 'Zárás',
			'ablakmeret_id' => 'Ablakméret',
			'ablakhely_id' => 'Ablakhely',
			'papir_id' => 'Papír',
			'afakulcs_id' => 'ÁFA kulcs',
			'redotalp' => 'Redőtalp',
			'kategoria_tipus' => 'Kategóriatípus',
			'gyarto_id' => 'Gyártó',
			'ksh_kod' => 'KSH Kód',
			'csom_egys' => 'Csomag egység (db)',
			'minimum_raktarkeszlet' => 'Minimum raktárkészlet (db)',
			'maximum_raktarkeszlet' => 'Maximum raktárkészlet (db)',
			'doboz_suly' => 'Doboz súlya (kg)',
			'raklap_db' => 'Raklap (db)',
			'doboz_hossz' => 'Doboz hossza (mm)',
			'doboz_szelesseg' => 'Doboz szélessége (mm)',
			'doboz_magassag' => 'Doboz magassága (mm)',
			'megjegyzes' => 'Megjegyzés',
			'megjelenes_mettol' => 'Megjelenés mettől',
			'megjelenes_meddig' => 'Megjelenés meddig',
			'felveteli_datum' => 'Felvételi dátum',
			'termekcsoport_id' =>'Termékcsoport',
			'datum' => 'Dátum',
			'torolt' => 'Törölt',
			'belesnyomott' => 'Bélésnyomott',
			
			'DisplayTermekTeljesNev' => 'Termék',
			'zaras_search' => 'Zárásmód',
			'ablakhely_search' => 'Ablakhely',
			'ablakmeret_search' => 'Ablakméret',
			'meret_search' => 'Méret',
			'gyarto_search' => 'Cégnév',
			'papirtipus_search' => 'Papírtípus',
			'termekcsoport_search' => 'Termékcsoport'
			
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

		$criteria->together = true;
		$criteria->with = array('zaras', 'ablakhely', 'meret', 'gyarto', 'papirtipus', 'ablakmeret', 'termekcsoport');				
		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.nev',$this->nev,true);
		$criteria->compare('tipus',$this->tipus,true);
		$criteria->compare('kodszam',$this->kodszam,true);
		$criteria->compare('cikkszam',$this->cikkszam,true);
		$criteria->compare('meret_id',$this->meret_id);
		$criteria->compare('t.suly',$this->suly);
		$criteria->compare('zaras_id',$this->zaras_id);
		
		$criteria->compare('zaras.nev', $this->zaras_search, true );
		$criteria->compare('ablakhely.nev', $this->ablakhely_search, true );
		$criteria->compare('ablakmeret.nev', $this->ablakmeret_search, true );
		$criteria->compare('meret.nev', $this->meret_search, true );
		$criteria->compare('gyarto.cegnev', $this->gyarto_search, true );
		$criteria->compare('papirtipus.nev', $this->papirtipus_search, true );
		$criteria->compare('termekcsoport.nev', $this->termekcsoport_search, true );
		
		$criteria->compare('ablakmeret_id',$this->ablakmeret_id);
		$criteria->compare('ablakhely_id',$this->ablakhely_id);
		$criteria->compare('papir_id',$this->papir_id);
		$criteria->compare('afakulcs_id',$this->afakulcs_id);
		$criteria->compare('redotalp',$this->redotalp,true);
		$criteria->compare('kategoria_tipus',$this->kategoria_tipus,true);
		$criteria->compare('gyarto_id',$this->gyarto_id,true);
		$criteria->compare('ksh_kod',$this->ksh_kod,true);
		$criteria->compare('csom_egys',$this->csom_egys,true);
		$criteria->compare('minimum_raktarkeszlet',$this->minimum_raktarkeszlet,true);
		$criteria->compare('maximum_raktarkeszlet',$this->maximum_raktarkeszlet,true);
		$criteria->compare('doboz_suly',$this->doboz_suly);
		$criteria->compare('raklap_db',$this->raklap_db,true);
		$criteria->compare('doboz_hossz',$this->doboz_hossz);
		$criteria->compare('doboz_szelesseg',$this->doboz_szelesseg);
		$criteria->compare('doboz_magassag',$this->doboz_magassag);
		$criteria->compare('megjegyzes',$this->megjegyzes,true);
		$criteria->compare('felveteli_datum',$this->felveteli_datum,true);
		$criteria->compare('datum',$this->datum,true);
		$criteria->compare('belesnyomott',$this->belesnyomott, true) ;

		// LI: logikailag törölt sorok ne jelenjenek meg, ha a belépett user nem az 'Admin'
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->compare('t.torolt', 0, false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
                        'defaultOrder'=>'t.nev ASC',
                    ),						
		));
	}

	protected function afterFind(){
		parent::afterFind();
		
		//$this -> megjelenes_mettol = date('Y-m-d', strtotime(str_replace("-", "", $this->megjelenes_mettol)));
		//$this -> megjelenes_meddig = date('Y-m-d', strtotime(str_replace("-", "", $this->megjelenes_meddig)));
		$this -> felveteli_datum = date('Y-m-d', strtotime(str_replace("-", "", $this->felveteli_datum)));
		
		// beírjuk a model-be az aktív termékárat
		$termekAr = Utils::getActiveTermekar ($this->id);
		$this->activeTermekAr = ($termekAr == 0) ? 0 : $termekAr["db_eladasi_ar"];
	}

	// LI : a 'datum' mezőt automatikusan kitöltjük létrehozáskor
	public function beforeSave() {
		if ($this->isNewRecord)
			$this->datum = new CDbExpression('NOW()');
	 
		return parent::beforeSave();
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Termekek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getDisplayTermeknev()
	{
		return $this->kodszam . ' - ' . $this->nev;
	}

	// LI a termék összes adata 1 string-be: nev + zarasmod->nev + termek_meret->magassag x $termek_meret->szelesseg x $termek_meret->vastagsag + 
	//										 ablakhely->hely + ablakhely->x_pozicio_honnan + ablakhely->x_pozicio_mm + ablakhely->y_pozicio_honnan + ablakhely->y_pozicio_mm
	//										 ablakmeret->magassag + ablakmeret->szelesseg
	//										 $papirtipus->nev + $papirtipus->suly
	// TÁ: Kicsit szofisztikáltabban írjuk ki, mert sok termék lesz, aminél nincs ablak, papír, méret adat.
	public function getDisplayTermekTeljesNev()
	{
		$termek_teljes_nev = $this->nev ;
		$termek_teljes_nev .= ' ' . $this->zaras->nev ;
		$meret = "" ;
		if ($this->meret != null && $this->meret->szelesseg > 0) {
			$meret .= ' ' . $this->meret->szelesseg ;
		}
		if ($this->meret != null && $this->meret->magassag > 0) {
			if ($meret != "") {
				$meret .= "x" ;	
			}
			else
			{
				$meret .= " " ;	
			}
			$meret .= $this->meret->magassag ;
		}
		if ($this->meret != null && $this->meret->vastagsag > 0) {
			if ($meret != "") {
				$meret .= "x" ;	
			}
			else
			{
				$meret .= " " ;	
			}
			$meret .= $this->meret->vastagsag ;
		}
		if ($meret != "") {
			$meret . ", " ;	
		}
		$termek_teljes_nev .= $meret ;
		$termek_teljes_nev .= ' ' . $this->ablakhely->nev ;
/*		$termek_teljes_nev .= ' ' . $this->ablakhely->hely ;
		if ($this->ablakhely->x_pozicio_honnan != '' && $this->ablakhely->x_pozicio_mm > 0) {
			$termek_teljes_nev .= ' ' . $this->ablakhely->x_pozicio_honnan . $this->ablakhely->x_pozicio_mm . $this->ablakhely->y_pozicio_honnan . $this->ablakhely->y_pozicio_mm ;
		}*/
		if ($this->ablakmeret->nev != "") {
			$termek_teljes_nev .= ' ' . $this->ablakmeret->nev ;	
		}
		if ($this->ablakmeret->magassag > 0) {
			$termek_teljes_nev .= ' ' . $this->ablakmeret->magassag . 'x' . $this->ablakmeret->szelesseg . ' mm ' ;
		}
		if ($this->papirtipus->suly != 0 && $this->papirtipus->suly != "") {
			$termek_teljes_nev .= ' ' . $this->papirtipus->nev . ' ' . $this->papirtipus->suly . 'gr' ;
		}
		
		return $termek_teljes_nev;
	}

	public function getActiveTermekAr ()
	{
		return $this->activeTermekAr;
	}

}

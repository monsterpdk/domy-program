<?php

/**
 * This is the model class for table "dom_szallitolevelek".
 *
 * The followings are the available columns in table 'dom_szallitolevelek':
 * @property string $id
 * @property string $sorszam
 * @property string $megrendeles_id
 * @property string $datum
 * @property string $megjegyzes
 * @property string $egyeb
 * @property integer $sztornozva
 * @property integer $torolt
*/
class Szallitolevelek extends CActiveRecord
{

	public $szallito_darabszamok;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_szallitolevelek';
	}

	public function getClassName ()
	{
		return "Szállítólevél";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('szallito_darabszamok, sorszam, megrendeles_id', 'required'),
			array('sztornozva, torolt', 'numerical', 'integerOnly'=>true),
			array('sorszam, megrendeles_id', 'length', 'max'=>12),
			array('megjegyzes, egyeb', 'length', 'max'=>127),
			
			array('megrendeles_id', 'isMegrendelesEmpty'),
			array('szallito_darabszamok', 'checkDarabszamOnSzallito'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sorszam, megrendeles_id, datum, sztornozva, torolt, szallito_darabszamok', 'safe', 'on'=>'search'),
		);
	}
	
	public function isMegrendelesEmpty ($attribute)
	{
		if ($this -> megrendeles_id == null || $this -> megrendeles_id == 0)
			$this->addError($attribute, 'A kapcsolódó megrendelés megadása kötelező!');
	}

	// LI: szerver oldalon is végigmegyünk a a szállítólevélre felvett darabszámokon,
	// hátha kliens oldalon valaki bűvészkedett a bevitt adatokkal
	public function checkDarabszamOnSzallito ($attribute)
	{
		if ($this -> megrendeles_id == null || $this -> megrendeles_id == 0)
			$this->addError($attribute, 'A kapcsolódó megrendelés megadása kötelező!');
		else {
			$tetelekAMegrendelon = Utils::getSzallitolevelTetelToMegrendeles($this -> megrendeles_id, $this -> id);
			$tetelekASzallitolevelen = explode('$#$', $this -> szallito_darabszamok);
			
			if (count($tetelekAMegrendelon) != count($tetelekASzallitolevelen) ) {
				$this->addError($attribute, 'Hiba a darabszám ellenőrzése során, ellenőrizze a kiválasztott tételeket!');
			} else
				for ($i = 0; $i < count($tetelekAMegrendelon); $i++) {
					if ( !is_numeric($tetelekASzallitolevelen[$i]) ) {
						$this->addError($attribute, 'Hiba a bevitt darabszámokban, ellenőrizze a kiválasztott tételeket!');
						break;
					}
					
					if (is_numeric($tetelekASzallitolevelen[$i]) && ($tetelekASzallitolevelen[$i] < 0 || $tetelekASzallitolevelen[$i] > $tetelekAMegrendelon[$i]->darabszam) ) {
						$this->addError($attribute, 'Csak 0, vagy annál nagyobb érték írható be, de kisebb kell legyen, mint a megrendelésen lévő darabszám!');
						break;
					}
				}
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
			'megrendeles' => array(self::BELONGS_TO, 'Megrendelesek', 'megrendeles_id'),
			
			'tetelek' => array(self::HAS_MANY, 'SzallitolevelTetelek', 'szallitolevel_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Szállítólevél ID',
			'sorszam' => 'Sorszám',
			'megrendeles_id' => 'Megrendelés',
			'datum' => 'Készítés időpontja',
			'megjegyzes' => 'Megjegyzés',
			'szallito_darabszamok' => 'Szállítón lévő darabszám (db)',
			'egyeb' => 'Egyéb',
			'sztornozva' => 'Sztornózva',
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
		$criteria->compare('megrendeles_id',$this->megrendeles_id,true);
		$criteria->compare('datum',$this->datum,true);
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

		if ($this -> datum != null)
			$this -> datum = date('Y-m-d', strtotime(str_replace("-", "", $this->datum)));
		
	}	

	// LI : a 'datum' mezőt automatikusan kitöltjük létrehozáskor
	public function beforeSave() {
		if ($this->isNewRecord) {
			$this->datum = new CDbExpression('NOW()');
		}
	 
		return parent::beforeSave();
	}

	public function getSzallito_darabszamok () {
		return $this -> szallito_darabszamok;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Szállítólevelek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}

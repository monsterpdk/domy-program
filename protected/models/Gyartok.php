<?php

/**
 * This is the model class for table "dom_gyartok".
 *
 * The followings are the available columns in table 'dom_gyartok':
 * @property string $id
 * @property string $cegnev
 * @property string $kapcsolattarto
 * @property string $irsz
 * @property string $orszag
 * @property integer $varos
 * @property string $cim
 * @property string $telefon
 * @property string $fax
 * @property string $email
 * @property integer $netto_ar
 * @property integer $torolt
 */
class Gyartok extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_gyartok';
	}

	public function getClassName ()
	{
		return "Gyártó";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cegnev, kapcsolattarto, irsz, orszag, varos, cim, telefon, fax, netto_ar', 'required'),
			array('netto_ar, torolt', 'numerical', 'integerOnly'=>true),
			array('cegnev, kapcsolattarto, email', 'length', 'max'=>127),
			array('cim', 'length', 'max'=>255),
			array('telefon, fax', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cegnev, kapcsolattarto, irsz, orszag, varos, cim, telefon, fax, email, netto_ar, torolt', 'safe', 'on'=>'search'),
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
			'id' => 'Gyártó ID',
			'cegnev' => 'Cégnév',
			'kapcsolattarto' => 'Kapcsolattartó',
			'irsz' => 'Irányítószám',
			'orszag' => 'Ország',
			'varos' => 'Város',
			'cim' => 'Cím',
			'telefon' => 'Telefon',
			'fax' => 'Fax',
			'email' => 'E-mail',
			'netto_ar' => 'Nettó ár',
			'torolt' => 'Törölt',
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
		$criteria->compare('cegnev',$this->cegnev,true);
		$criteria->compare('kapcsolattarto',$this->kapcsolattarto,true);
		$criteria->compare('irsz',$this->irsz,true);
		$criteria->compare('orszag',$this->orszag,true);
		$criteria->compare('varos',$this->varos,true);
		$criteria->compare('cim',$this->cim,true);
		$criteria->compare('telefon',$this->telefon,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('netto_ar',$this->netto_ar);
		
		// LI: logikailag törölt sorok ne jelenjenek meg, ha a belépett user nem az 'Admin'
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->condition=" torolt = '0'";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function afterFind(){
		// LI: mivel a városokhoz ID-t (key) kell tárolnunk, az előregépelős mezőben viszont
		// szöveg van (value), ezért itt meg kell cserélnünk őket
		if ($this -> varos != null) {
			$check_varos = Varosok::model()->findByPk($this -> varos);
			if ($check_varos != null)
				$this -> varos = $check_varos -> varosnev;
		}

		parent::afterFind();
	}
	
	// LI : városok ellenőrzésére, ha valamelyik (székhely/posta város) nem létezik a db-ben, akkor felvesszük
	public function beforeValidate() {
		$varos = $this -> varos;
		
		$match1 = addcslashes($varos, '%_'); // escape LIKE's special characters
		$q = new CDbCriteria( array(
			'condition' => "varosnev = :varos",
			'params'    => array(':varos' => "$match1")
		) );
        $varosok = Varosok::model()->findAll($q);
		
		// LI: ha nem létezik még ilyen város felvesszük
		if (count($varosok) == 0) {
			$uj_varos = new Varosok;
			$uj_varos -> varosnev = $match1;
			$uj_varos -> save();
		}
		
		// LI: mivel a városokhoz ID-t (key) kell tárolnunk, az előregépelős mezőben viszont
		// szöveg van (value), ezért itt meg kell cserélnünk őket
		$q = new CDbCriteria( array(
			'condition' => "varosnev = :varos AND torolt = 0",
			'params'    => array(':varos' => "$varos")
		) );
		
		$check_varos = Varosok::model()->find($q);
		if ($check_varos != null)
			$this -> varos = $check_varos -> id;
			
		return parent::beforeValidate();
	}

	public function afterValidate() {
		if ($this -> varos != null) {
			$check_varos = Varosok::model()->findByPk($this -> varos);
			if ($check_varos != null)
				$this -> varos = $check_varos -> varosnev;
		}
		
		return parent::afterValidate();
	}
	
	public function beforeSave() {
		$varos = $this -> varos;
		
		$q = new CDbCriteria( array(
			'condition' => "varosnev = :varos AND torolt = 0",
			'params'    => array(':varos' => "$varos")
		) );
		
		$check_varos = Varosok::model()->find($q);
		if ($check_varos != null)
			$this -> varos = $check_varos -> id;
		
		return parent::beforeSave();
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Gyartok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	// LI : összefűzi 1 string-ként adja vissza a címhez tartozó mezőket
	public  function getTeljes_cim () {
		
		$orszag = Orszagok::model() -> findByPk ($this -> orszag);
		$orszag = ($orszag == null) ? "" : $orszag -> nev;
		return
			$orszag . (strlen($orszag) > 0 ? ", " : "") .
			$this -> irsz . (strlen($this -> irsz) > 0 ? " " : "") .
			$this -> varos . (strlen($this -> varos) > 0 ? ", " : "") .
			$this -> cim;
	}
	
}
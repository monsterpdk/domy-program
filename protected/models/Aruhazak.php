<?php

/**
 * This is the model class for table "dom_aruhazak".
 *
 * The followings are the available columns in table 'dom_aruhazak':
 * @property string $id
 * @property string $kod
 * @property string $aruhaz_nev
 * @property string $aruhaz_url
 * @property string $aruhaz_megrendelesek_xml_url
 * @property string aruhaz_megrendeles_order_prefix
 * @property string bankszamlaszam_proforman
 * @property integer $arkategoria_id
 * @property integer $ingyen_szallitas
 * @property integer $torolt
 */
class Aruhazak extends CActiveRecord
{
	private $display_aruhaz_arkategoria;
	private $display_aruhazkod_nev;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_aruhazak';
	}

	public function getClassName ()
	{
		return "Áruház";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kod, aruhaz_nev, aruhaz_url, arkategoria_id, ingyen_szallitas', 'required'),
			array('arkategoria_id, ingyen_szallitas, torolt', 'numerical', 'integerOnly'=>true),
			array('kod', 'length', 'max'=>2),
			array('aruhaz_nev', 'length', 'max'=>30),
			array('aruhaz_url', 'length', 'max'=>127),
			array('aruhaz_megrendelesek_xml_url', 'length', 'max'=>255),
			array('aruhaz_megrendeles_order_prefix', 'length', 'max'=>2),
			array('bankszamlaszam_proforman', 'length', 'max'=>40),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, kod, aruhaz_nev, aruhaz_url, arkategoria_id, ingyen_szallitas, torolt', 'safe', 'on'=>'search'),
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
			'arkategoria'    => array(self::BELONGS_TO, 'Arkategoriak', 'arkategoria_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Áruház ID',
			'kod' => 'Kód',
			'aruhaz_nev' => 'Áruház név',
			'aruhaz_url' => 'Áruház URL',
			'aruhaz_megrendelesek_xml_url' => 'Áruház megrendelések import XML URL',
			'aruhaz_megrendeles_order_prefix' => 'Megrendelés azonosító prefix',
			'bankszamlaszam_proforman' => 'Proformán megjelenő bankszámlaszám',
			'arkategoria_id' => 'Árkategória',
			'ingyen_szallitas' => 'Ingyen szállítás',
			'display_aruhazkod_nev' => 'Áruház',
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
		$criteria->compare('kod',$this->kod,true);
		$criteria->compare('aruhaz_nev',$this->aruhaz_nev,true);
		$criteria->compare('aruhaz_url',$this->aruhaz_url,true);
		$criteria->compare('aruhaz_megrendelesek_xml_url',$this->aruhaz_megrendelesek_xml_url,true);
		$criteria->compare('aruhaz_megrendeles_order_prefix',$this->aruhaz_megrendeles_order_prefix,true);
		$criteria->compare('bankszamlaszam_proforman',$this->bankszamlaszam_proforman,true);
		$criteria->compare('arkategoria_id',$this->arkategoria_id);
		$criteria->compare('ingyen_szallitas',$this->ingyen_szallitas);

		// LI: logikailag törölt sorok ne jelenjenek meg, ha a belépett user nem az 'Admin'
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->compare('torolt', 0, false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Aruhazak the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getDisplay_aruhaz_arkategoria () {
		return $this -> aruhaz_nev . ' - ' . $this -> arkategoria -> szorzo . ' szorzó';
	}
	
	public function getDisplay_aruhazkod_nev () {
		return $this -> kod . ' - ' . $this -> aruhaz_nev;
	}
	
}

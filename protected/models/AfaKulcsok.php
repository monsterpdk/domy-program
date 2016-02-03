<?php

/**
 * This is the model class for table "dom_afakulcsok".
 *
 * The followings are the available columns in table 'dom_afakulcsok':
 * @property integer $id
 * @property string $nev
 * @property integer $afa_szazalek
 * @property integer $alapertelmezett
 * @property integer $torolt
 */
class AfaKulcsok extends DomyModel
{
	// lenyíló listákhoz a következő formátumban:  'áfakulcs neve - áfa százalék'
	private $display_nev_szazalek;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_afakulcsok';
	}

	public function getClassName ()
	{
		return "ÁFA kulcs";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nev, afa_szazalek', 'required'),
			array('afa_szazalek, alapertelmezett, torolt', 'numerical', 'integerOnly'=>true),
			array('nev', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nev, afa_szazalek, alapertelmezett, torolt', 'safe', 'on'=>'search'),
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
			'id' => 'ÁFA kulcs ID',
			'nev' => 'ÁFA kulcs neve',
			'afa_szazalek' => 'ÁFA százalék (%)',
			'alapertelmezett' => 'Alapértelmezett',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('nev',$this->nev,true);
		$criteria->compare('afa_szazalek',$this->afa_szazalek);
		$criteria->compare('alapertelmezett',$this->alapertelmezett);

		// LI: logikailag törölt sorok ne jelenjenek meg
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->compare('torolt', 0, false);
			
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	// LI : megnézzük, hogy az új ÁFA kulcson kívül van-e még ÁFA kulcs,
	//		ha nincs, akkor automatikusan alapértelmezetté tesszük
	public function beforeSave() {
		if ($this->isNewRecord) {
			$afaKulcsok = AfaKulcsok::model()->findAll(array("condition"=>"torolt=0"));
			
			if (count($afaKulcsok) == 0) {
				$this -> alapertelmezett = 1;
			}	
		}
	 
		return parent::beforeSave();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AfaKulcsok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getDisplay_nev_szazalek () {
		return $this -> nev . ' - ' . $this -> afa_szazalek . '%';
	}
}

<?php

/**
 * This is the model class for table "dom_arajanlat_visszahivasok".
 *
 * The followings are the available columns in table 'dom_arajanlat_visszahivasok':
 * @property string $id
 * @property string $arajanlat_id
 * @property integer $user_id
 * @property integer $jegyzet
 * @property integer $idopont
 * @property integer $torolt
 */
class ArajanlatVisszahivasok extends CActiveRecord
{

	public $visszahivas_datum;
	public $visszahivas_idopont;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_arajanlat_visszahivasok';
	}

	public function getClassName ()
	{
		return "Árajánlat visszahívások";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('arajanlat_id, user_id, idopont', 'required'),
			array('arajanlat_id, user_id, torolt', 'numerical', 'integerOnly'=>true),
			array('jegyzet', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, arajanlat_id, user_id, jegyzet, torolt', 'safe', 'on'=>'search'),
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
			'arajanlat' => array(self::BELONGS_TO, 'Arajanlatok', 'arajanlat_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
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
			'id' => 'Tétel ID',
			'arajanlat_id' => 'Árajanlat ID',
			'user_id' => 'Felhasználó ID',
			'fullname' => 'Felhasználó',
			'jegyzet' => 'Jegyzet',
			'idopont' => 'Időpont',
			'torolt' => 'Törölt',
			'visszahivas_datum' => 'Visszahívás napja',
			'visszahivas_idopont' => 'Visszahívás pontos ideje'
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
		$criteria->compare('arajanlat_id',$this->arajanlat_id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('jegyzet',$this->jegyzet);
		$criteria->compare('idopont',$this->idopont);
		$criteria->compare('torolt',$this->torolt);
		$criteria->compare('egyedi_ar',$this->egyedi_ar);
		$criteria->with = array('User');
		$criteria->together = true;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeValidate() {
		$vars = (Yii::app()->request->getPost("ArajanlatVisszahivasok")) ;
		if (!preg_match('/^[1-2][0-9]:[0-5][0-9]$/', $vars["visszahivas_idopont"])) {
			$visszahivas_idopont = date('H:i:s') ;	
		}
		else
		{
			$visszahivas_idopont = 	$this->visszahivas_idopont ;
		}
		$this->idopont = $vars["visszahivas_datum"] . " " . $visszahivas_idopont ;
		
		return parent::beforeValidate();
	}	

	public function beforeSave() {
		if ($this->isNewRecord) {
			$this->user_id = Yii::app()->user->getId();
		}
	 
		return parent::beforeSave();
	}
	
	protected function afterFind(){
		parent::afterFind();
	}	
		
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArajanlatTetelek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}

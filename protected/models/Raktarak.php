<?php

/**
 * This is the model class for table "dom_raktarak".
 *
 * The followings are the available columns in table 'dom_raktarak':
 * @property string $id
 * @property string $nev
 * @property string $tipus
 * @property string $leiras
 * @property integer $torolt
 */
class Raktarak extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_raktarak';
	}

	public function getClassName ()
	{
		return "Raktár";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nev, tipus, leiras', 'required'),
			array('torolt', 'numerical', 'integerOnly'=>true),
			array('nev', 'length', 'max'=>50),
			array('tipus', 'length', 'max'=>7),
			array('leiras', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nev, tipus, leiras, torolt', 'safe', 'on'=>'search'),
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
			'termekek' => array(self::HAS_MANY, 'RaktarTermekek', 'raktar_id'),
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
			'id' => 'Raktár ID',
			'nev' => 'Raktárnév',
			'tipus' => 'Típus',
			'leiras' => 'Leírás',
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
		$criteria->compare('nev',$this->nev,true);
		$criteria->compare('tipus',$this->tipus,true);
		//$criteria->compare('leiras',$this->leiras,true);

		// LI: logikailag törölt sorok ne jelenjenek meg
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->condition=" torolt = '0'";
			
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Raktarak the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

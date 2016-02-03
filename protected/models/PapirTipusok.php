<?php

/**
 * This is the model class for table "dom_papir_tipusok".
 *
 * The followings are the available columns in table 'dom_papir_tipusok':
 * @property string $id
 * @property string $nev
 * @property integer $suly
 * @property integer $aktiv
 * @property integer $torolt
 */
class PapirTipusok extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_papir_tipusok';
	}

	public function getClassName ()
	{
		return "Papírtípus";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nev, suly', 'required'),
			array('aktiv, suly, torolt', 'numerical', 'integerOnly'=>true),
			array('nev', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nev, suly, aktiv', 'safe', 'on'=>'search'),
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
			'id' => 'Papírtípus ID',
			'nev' => 'Papírtípus neve',
			'suly' => 'Súly (g)',
			'aktiv' => 'Aktív',
			'torolt' => 'Törölt',
			'FullName' => 'Papírnév'
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
		$criteria->compare('suly',$this->suly,true);
		$criteria->compare('aktiv',$this->aktiv);

		// LI: logikailag törölt sorok ne jelenjenek meg
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
	 * @return PapirTipusok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	// A papír teljes nevét adja vissza: Név + súly;
	public function getFullName()
	{
		return $this->nev.' '.$this->suly.' gr';
	}	
}

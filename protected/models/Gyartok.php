<?php

/**
 * This is the model class for table "dom_gyartok".
 *
 * The followings are the available columns in table 'dom_gyartok':
 * @property string $id
 * @property string $cegnev
 * @property string $kapcsolattarto
 * @property string $cim
 * @property string $telefon
 * @property string $fax
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
			array('cegnev, kapcsolattarto, cim, telefon, fax, netto_ar', 'required'),
			array('netto_ar, torolt', 'numerical', 'integerOnly'=>true),
			array('cegnev, kapcsolattarto', 'length', 'max'=>127),
			array('cim', 'length', 'max'=>255),
			array('telefon, fax', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cegnev, kapcsolattarto, cim, telefon, fax, netto_ar, torolt', 'safe', 'on'=>'search'),
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
			'cim' => 'Cím',
			'telefon' => 'Telefon',
			'fax' => 'Fax',
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
		$criteria->compare('cim',$this->cim,true);
		$criteria->compare('telefon',$this->telefon,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('netto_ar',$this->netto_ar);
		
		// LI: logikailag törölt sorok ne jelenjenek meg, ha a belépett user nem az 'Admin'
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
	 * @return Gyartok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

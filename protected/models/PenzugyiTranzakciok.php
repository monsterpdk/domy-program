<?php

/**
 * This is the model class for table "dom_penzugyi_tranzakciok".
 *
 * The followings are the available columns in table 'dom_penzugyi_tranzakciok':
 * @property string $id
 * @property string $megrendeles_id
 * @property string $bizonylatszam
 * @property string $mode
 * @property string $osszeg
 * @property string $datum
 * @property integer $torolt
 */
class PenzugyiTranzakciok extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_penzugyi_tranzakciok';
	}

	public function getClassName ()
	{
		return "Pénzügyi tranzakciók";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('megrendeles_id, bizonylatszam, mode, osszeg, datum', 'required'),
			array('megrendeles_id, torolt', 'numerical', 'integerOnly'=>true),
			array('osszeg', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, megrendeles_id, bizonylatszam, mode, osszeg, datum, torolt', 'safe', 'on'=>'search'),
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
			'megrendeles' => array(self::BELONGS_TO, 'Megrendelesek', 'megrendeles_id'),
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
			'id' => 'Tranzakció ID',
			'megrendeles_id' => 'Megrendelés ID',
			'bizonylatszam' => 'Bizonylatszám',
			'mode' => 'Tranzakció módja',
			'osszeg' => 'Összeg',
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
		$criteria->compare('megrendeles_id',$this->megrendeles_id,true);
		$criteria->compare('bizonylatszam', $this->bizonylatszam,true);
		$criteria->compare('mode',$this->mode,true);
		$criteria->compare('osszeg',$this->osszeg,true);
		
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
	 * @return Orszagok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

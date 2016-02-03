<?php

/**
 * This is the model class for table "dom_termek_ablak_helyek".
 *
 * The followings are the available columns in table 'dom_termek_ablak_helyek':
 * @property integer $id
 * @property string $nev
 * @property string $hely
 * @property string $x_pozicio_honnan
 * @property integer $x_pozicio_mm
 * @property string $y_pozicio_honnan
 * @property integer $y_pozicio_mm
 * @property integer $aktiv
 * @property integer $torolt
 */
class TermekAblakHelyek extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_termek_ablak_helyek';
	}

	public function getClassName ()
	{
		return "Ablakhely";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nev', 'required'),
			array('x_pozicio_mm, y_pozicio_mm, aktiv, torolt', 'numerical', 'integerOnly'=>true),
			array('nev', 'length', 'max'=>30),
			array('hely', 'length', 'max'=>4),
			array('x_pozicio_honnan, y_pozicio_honnan', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nev, hely, x_pozicio_honnan, x_pozicio_mm, y_pozicio_honnan, y_pozicio_mm, aktiv', 'safe', 'on'=>'search'),
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
			'id' => 'Ablakhely ID',
			'nev' => 'Ablakhey neve',
			'hely' => 'Hely',
			'x_pozicio_honnan' => 'X pozíció honnan',
			'x_pozicio_mm' => 'X pozíció (mm)',
			'y_pozicio_honnan' => 'Y pozíció honnan',
			'y_pozicio_mm' => 'Y pozíció (mm)',
			'aktiv' => 'Aktív',
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
		$criteria->compare('hely',$this->hely,true);
		$criteria->compare('x_pozicio_honnan',$this->x_pozicio_honnan,true);
		$criteria->compare('x_pozicio_mm',$this->x_pozicio_mm);
		$criteria->compare('y_pozicio_honnan',$this->y_pozicio_honnan,true);
		$criteria->compare('y_pozicio_mm',$this->y_pozicio_mm);
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
	 * @return TermekAblakHelyek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

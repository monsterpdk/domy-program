<?php

/**
 * This is the model class for table "dom_fizetesi_moralok".
 *
 * The followings are the available columns in table 'dom_fizetesi_moralok':
 * @property string $id
 * @property integer $moral_szam
 * @property integer $keses_tol
 * @property integer $keses_ig
 * @property integer $torolt
 */
class FizetesiMoralok extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_fizetesi_moralok';
	}

	public function getClassName ()
	{
		return "Fizetési morál";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('moral_szam, keses_tol, keses_ig', 'required'),
			array('moral_szam, keses_tol, keses_ig, torolt', 'numerical', 'integerOnly'=>true),
			array('moral_szam', 'length', 'max'=>1),
			array('keses_tol', 'length', 'max'=>4),
			array('keses_ig', 'length', 'max'=>11),
			
			array('moral_szam', 'unique', 'className' => 'FizetesiMoralok',	'attributeName' => 'moral_szam', 'message'=>'Ehhez a morál számhoz már tartozik fizetési morál intervallum!'),
			array('keses_tol', 'isIntervalOverlap'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, moral_szam, keses_tol, keses_ig, torolt', 'safe', 'on'=>'search'),
		);
	}
	
	// ellenőrizzük, hogy van-e már ilyen késés -tól - késés -ig intervallum felvéve, vagy van-e valamilyen ütközés
	public function isIntervalOverlap ()
	{
		$idCheck = $this->isNewRecord ? "" : " AND (id != $this->id)";
	
		$rawData = Yii::app() -> db -> createCommand  ("SELECT id FROM dom_fizetesi_moralok WHERE
														(keses_tol BETWEEN '$this->keses_tol' AND '$this->keses_ig' OR
														'$this->keses_tol' BETWEEN keses_tol AND keses_ig) AND (torolt = 0)" . $idCheck) -> queryAll();
		
		if (count($rawData) > 0)
			$this -> addError('keses_tol', 'A fizetési morál késés tól-ig intervalluma  már létező intervallumba ütközik!');
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
			'id' => 'Fizetési morál ID',
			'moral_szam' => 'Morál szám',
			'keses_tol' => 'Késés -tól (nap)',
			'keses_ig' => 'Késés -ig (nap)',
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
		$criteria->compare('moral_szam',$this->moral_szam);
		$criteria->compare('keses_tol',$this->keses_tol);
		$criteria->compare('keses_ig',$this->keses_ig);

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
	 * @return FizetesiMoralok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

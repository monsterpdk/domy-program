<?php

/**
 * This is the model class for table "dom_nyomda_munkatipusok".
 *
 * The followings are the available columns in table 'dom_nyomda_munkatipusok':
 * @property string $id
 * @property string $munkatipus_nev
 * @property string $darabszam_tol
 * @property string $darabszam_ig
 * @property string $szinszam_tol_elo
 * @property string $szinszam_ig_elo
 * @property string $szinszam_tol_hat
 * @property string $szinszam_ig_hat
 * @property integer $torolt
 */
class NyomdaMunkatipusok extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_nyomda_munkatipusok';
	}

	public function getClassName ()
	{
		return "Nyomdakönyvi munkatípus";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('munkatipus_nev, darabszam_tol, darabszam_ig, szinszam_tol_elo, szinszam_ig_elo, szinszam_tol_hat, szinszam_ig_hat', 'required'),
			array('torolt', 'numerical', 'integerOnly'=>true),
			array('munkatipus_nev', 'length', 'max'=>50),
			array('darabszam_tol, darabszam_ig, szinszam_tol_elo, szinszam_ig_elo, szinszam_tol_elo, szinszam_ig_elo', 'length', 'max'=>10),
			
			array('szinszam_tol_elo', 'isIntervalCorrectElo'),
			array('szinszam_tol_hat', 'isIntervalCorrectHat'),
			array('darabszam_tol', 'isDarabszamIntervalCorrect'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, munkatipus_nev, darabszam_tol, darabszam_ig, szinszam_tol, szinszam_ig, torolt', 'safe', 'on'=>'search'),
		);
	}

	/**
	* Színszám-tól (előoldal) nem lehet nagyobb, mint a színszám-ig (előoldal) mező.
	*/
	public function isIntervalCorrectElo ()
	{
		if ($this->szinszam_tol_elo > $this->szinszam_ig_elo)
			$this -> addError('szinszam_tol_elo', 'A színszám-tól (előoldal) nem lehet nagyobb, mint a színszám-ig (előoldal) mező!');
	}

	/**
	* Színszám-tól (hátoldal) nem lehet nagyobb, mint a színszám-ig (hátoldal) mező.
	*/
	public function isIntervalCorrectHat ()
	{
		if ($this->szinszam_tol_hat > $this->szinszam_ig_hat)
			$this -> addError('szinszam_tol_hat', 'A színszám-tól (hátoldal) nem lehet nagyobb, mint a színszám-ig (hátoldal) mező!');
	}
	
	/**
	* Darabszám-tól nem lehet nagyobb, mint a darabszám-ig mező.
	*/
	public function isDarabszamIntervalCorrect ()
	{
		if ($this->darabszam_tol > $this->darabszam_ig)
			$this -> addError('darabszam_tol', 'A darabszám-tól nem lehet nagyobb, mint a darabszám-ig mező!');
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'muveletek' => array(self::HAS_MANY, 'NyomdaMunkatipusMuveletek', 'munkatipus_id'),
			'termekek' => array(self::HAS_MANY, 'NyomdaMunkatipusTermekek', 'munkatipus_id'),
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
			'id' => 'Munkatípus ID',
			'munkatipus_nev' => 'Munkatípus neve',
			'darabszam_tol' => 'Darabszám -tól',
			'darabszam_ig' => 'Darabszám -ig',
			'szinszam_tol_elo' => 'Színszám -tól (előoldal)',
			'szinszam_ig_elo' => 'Színszám -ig (előoldal)',
			'szinszam_tol_hat' => 'Színszám -tól (hátoldal)',
			'szinszam_ig_hat' => 'Színszám -ig (hátoldal)',
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
		$criteria->compare('munkatipus_nev',$this->munkatipus_nev,true);
		$criteria->compare('darabszam_tol',$this->darabszam_tol,true);
		$criteria->compare('darabszam_ig',$this->darabszam_ig,true);
		$criteria->compare('szinszam_tol_elo',$this->szinszam_tol_elo,true);
		$criteria->compare('szinszam_ig_elo',$this->szinszam_ig_elo,true);
		$criteria->compare('szinszam_tol_hat',$this->szinszam_tol_hat,true);
		$criteria->compare('szinszam_ig_hat',$this->szinszam_ig_hat,true);
		
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
	 * @return NyomdaMunkatipusok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

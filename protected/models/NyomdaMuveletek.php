<?php

/**
 * This is the model class for table "dom_nyomda_muveletek".
 *
 * The followings are the available columns in table 'dom_nyomda_muveletek':
 * @property string $id
 * @property string $gep_id
 * @property string $muvelet_nev
 * @property double $elokeszites_ido
 * @property double $muvelet_ido
 * @property integer $szinszam_tol
 * @property integer $szinszam_ig
 * @property string $megjegyzes
 * @property integer $torolt
 */
class NyomdaMuveletek extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_nyomda_muveletek';
	}

	public function getClassName ()
	{
		return "Nyomdakönyvi művelet";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gep_id, muvelet_nev, elokeszites_ido, muvelet_ido, szinszam_tol, szinszam_ig, torolt', 'required'),
			array('szinszam_tol, szinszam_ig, torolt', 'numerical', 'integerOnly'=>true),
			array('elokeszites_ido, muvelet_ido', 'numerical'),
			array('gep_id', 'length', 'max'=>10),
			array('muvelet_nev', 'length', 'max'=>50),
			array('megjegyzes', 'length', 'max'=>127),
			
			array('szinszam_tol', 'isIntervalCorrect'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gep_id, muvelet_nev, elokeszites_ido, muvelet_ido, szinszam_tol, szinszam_ig, megjegyzes, torolt', 'safe', 'on'=>'search'),
		);
	}

	/**
	* Színszám-tól nem lehet nagyobb, mint a szmszám-ig mező.
	*/
	public function isIntervalCorrect ()
	{
		if ($this->szinszam_tol > $this->szinszam_ig)
			$this -> addError('szinszam_tol', 'A színszám-tól nem lehet nagyobb, mint a színszám-ig mező!');
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'gep' => array(self::BELONGS_TO, 'Nyomdagepek', 'gep_id'),
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
			'id' => 'Nyomdakönyvi művelet ID',
			'gep_id' => 'Gép',
			'muvelet_nev' => 'Művelet neve',
			'elokeszites_ido' => 'Előkészítés idő',
			'muvelet_ido' => 'Művelet idő',
			'szinszam_tol' => 'Színszám -tól',
			'szinszam_ig' => 'Színszám -ig',
			'megjegyzes' => 'Megjegyzés',
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
		$criteria->compare('gep_id',$this->gep_id,true);
		$criteria->compare('muvelet_nev',$this->muvelet_nev,true);
		$criteria->compare('elokeszites_ido',$this->elokeszites_ido);
		$criteria->compare('muvelet_ido',$this->muvelet_ido);
		$criteria->compare('szinszam_tol',$this->szinszam_tol);
		$criteria->compare('szinszam_ig',$this->szinszam_ig);
		$criteria->compare('megjegyzes',$this->megjegyzes,true);

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
	 * @return NyomdaMuveletek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

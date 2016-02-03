<?php

/**
 * This is the model class for table "dom_nyomdagep_tipusok".
 *
 * The followings are the available columns in table 'dom_nyomdagep_tipusok':
 * @property string $id
 * @property string $gep_id
 * @property string $tipusnev
 * @property string $fordulat_kis_boritek
 * @property string $fordulat_nagy_boritek
 * @property string $fordulat_egyeb
 * @property integer $aktiv
 * @property integer $szinszam_tol
 * @property integer $szinszam_ig
 * @property integer $torolt
 */
class NyomdagepTipusok extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_nyomdagep_tipusok';
	}

	public function getClassName ()
	{
		return "Nyomdagép típus";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gep_id, tipusnev, fordulat_kis_boritek, fordulat_nagy_boritek, fordulat_egyeb, szinszam_tol, szinszam_ig, torolt', 'required'),
			array('aktiv, szinszam_tol, szinszam_ig, torolt', 'numerical', 'integerOnly'=>true),
			array('gep_id, fordulat_kis_boritek, fordulat_nagy_boritek, fordulat_egyeb', 'length', 'max'=>10),
			array('tipusnev', 'length', 'max'=>30),
			
			array('szinszam_tol', 'isIntervalCorrect'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gep_id, tipusnev, fordulat_kis_boritek, fordulat_nagy_boritek, fordulat_egyeb, aktiv, szinszam_tol, szinszam_ig, torolt', 'safe', 'on'=>'search'),
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
			'id' => 'Nyomdagép típus ID',
			'gep_id' => 'Gép',
			'tipusnev' => 'Típusnév',
			'fordulat_kis_boritek' => 'Fordulat kis boríték',
			'fordulat_nagy_boritek' => 'Fordulat nagy boríték',
			'fordulat_egyeb' => 'Fordulat egyéb',
			'aktiv' => 'Aktív',
			'szinszam_tol' => 'Színszám -tól',
			'szinszam_ig' => 'Színszám -ig',
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
		$criteria->compare('tipusnev',$this->tipusnev,true);
		$criteria->compare('fordulat_kis_boritek',$this->fordulat_kis_boritek,true);
		$criteria->compare('fordulat_nagy_boritek',$this->fordulat_nagy_boritek,true);
		$criteria->compare('fordulat_egyeb',$this->fordulat_egyeb,true);
		$criteria->compare('aktiv',$this->aktiv);
		$criteria->compare('szinszam_tol',$this->szinszam_tol);
		$criteria->compare('szinszam_ig',$this->szinszam_ig);
		
		// LI: logikailag törölt sorok ne jelenjenek meg, ha a belépett user nem az 'Admin'
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
	 * @return NyomdagepTipusok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "dom_nyomda_muvelet_normaarak".
 *
 * The followings are the available columns in table 'dom_nyomda_muvelet_normaarak':
 * @property string $id
 * @property string $muvelet_id
 * @property string $gep_id
 * @property string $oradij
 * @property integer $szazalek_tol
 * @property integer $szazalek_ig
 * @property integer $torolt
 */
class NyomdaMuveletNormaarak extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_nyomda_muvelet_normaarak';
	}

	public function getClassName ()
	{
		return "Nyomdakönyvi művelet ár";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('muvelet_id, gep_id, oradij, szazalek_tol, szazalek_ig', 'required'),
			array('szazalek_tol, szazalek_ig, torolt', 'numerical', 'integerOnly'=>true),
			array('muvelet_id, gep_id, oradij', 'length', 'max'=>10),
			
			array('szazalek_tol', 'isIntervalCorrect'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, muvelet_id, gep_id, oradij, szazalek_tol, szazalek_ig, torolt', 'safe', 'on'=>'search'),
		);
	}

	/**
	* Százalék-tól nem lehet nagyobb, mint a százalék-ig mező.
	*/
	public function isIntervalCorrect ()
	{
		if ($this->szazalek_tol > $this->szazalek_ig)
			$this -> addError('szazalek_tol', 'A százalék-tól nem lehet nagyobb, mint a százalék-ig mező!');
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'muvelet'    => array(self::BELONGS_TO, 'NyomdaMuveletek', 'muvelet_id'),
			'gep'    => array(self::BELONGS_TO, 'Nyomdagepek', 'gep_id'),
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
			'id' => 'Művelet ár ID',
			'muvelet_id' => 'Művelet ID',
			'gep_id' => 'Gép ID',
			'oradij' => 'Óradíj',
			'szazalek_tol' => 'Százalék -tól',
			'szazalek_ig' => 'Százalék -ig',
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
		$criteria->compare('muvelet_id',$this->muvelet_id,true);
		$criteria->compare('gep_id',$this->gep_id,true);
		$criteria->compare('oradij',$this->oradij,true);
		$criteria->compare('szazalek_tol',$this->szazalek_tol);
		$criteria->compare('szazalek_ig',$this->szazalek_ig);
		
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
	 * @return NyomdaMuveletNormaarak the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

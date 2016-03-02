<?php

/**
 * This is the model class for table "dom_nyomda_munka_feladatok".
 *
 * The followings are the available columns in table 'dom_nyomda_munka_feladatok':
 * @property integer $id
 * @property string $taskaszam
 * @property integer $gepterem_dolgkod
 * @property integer $muvelet_id
 * @property datetime $muvelet_kezd_idopont
 * @property datetime $muvelet_vege_idopont
 * @property integer $gep_id
 * @property integer $mennyiseg
 * @property integer $selejt_mennyiseg
 * @property string $megjegyzes
 * @property float $dijo
 * @property integer $torolt
 */
class NyomdaFeladatok extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_nyomda_munka_feladatok';
	}

	public function getClassName ()
	{
		return "Elvégzett nyomdai munkák a nyomdakönyvi feladatokhoz";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('taskaszam, gepterem_dolgkod, muvelet_id, muvelet_kezd_idopont, gep_id, mennyiseg, torolt', 'required'),
			array('gepterem_dolgkod, muvelet_id, gep_id, mennyiseg, selejt_mennyiseg, torolt', 'numerical', 'integerOnly'=>true),
			array('dijo', 'numerical'),
			array('megjegyzes', 'length', 'max'=>255),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, taskaszam, gepterem_dolgkod, muvelet_id, muvelet_kezd_idopont, muvelet_vege_idopont, gep_id, mennyiseg, selejt_mennyiseg, megjegyzes, dijo, torolt', 'safe', 'on'=>'search'),
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
			'gep' => array(self::BELONGS_TO, 'Nyomdakonyv', 'taskaszam'),
			'muvelet' => array(self::HAS_ONE, 'NyomdaMuveletek', 'muvelet_id'),
			'user' => array(self::HAS_ONE, 'User', 'gepterem_dolgkod'),
			'gep' => array(self::HAS_ONE, 'Nyomdagepek', 'gep_id'),
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
			'taskaszam' => 'Táskaszám',
			'gepterem_dolgkod' => 'Dolgozó kódja a géptermi programban',
			'muvelet_id' => 'Művelet ID',
			'muvelet_kezd_idopont' => 'Kezdés időpont',
			'muvelet_vege_idopont' => 'Befejezés időpont',
			'gep_id' => 'Gép ID',
			'mennyiseg' => 'Mennyiség',
			'selejt_mennyiseg' => 'Selejt mennyiség',
			'megjegyzes' => 'Megjegyzés',
			'dijo' => 'Munkadíj',
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
		$criteria->compare('taskaszam',$this->taskaszam,true);
		$criteria->compare('gepterem_dolgkod',$this->gepterem_dolgkod,true);
		$criteria->compare('muvelet_id',$this->muvelet_id,true);
		$criteria->compare('gep_id',$this->gep_id,true);
		$criteria->compare('muvelet_kezd_idopont',$this->muvelet_kezd_idopont,true);
		$criteria->compare('muvelet_vege_idopont',$this->muvelet_vege_idopont);
		$criteria->compare('mennyiseg',$this->mennyiseg);
		$criteria->compare('selejt_mennyiseg',$this->selejt_mennyiseg);
		$criteria->compare('dijo',$this->dijo);
		$criteria->compare('megjegyzes',$this->megjegyzes,true);

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
	 * @return NyomdaFeladatok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

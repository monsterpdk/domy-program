<?php

/**
 * This is the model class for table "dom_nyomdagepek".
 *
 * The followings are the available columns in table 'dom_nyomdagepek':
 * @property string $id
 * @property string $gepnev
 * @property string $max_fordulat
 * @property integer $alapertelmezett
 * @property integer $torolt
 */
class Nyomdagepek extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_nyomdagepek';
	}

	public function getClassName ()
	{
		return "Nyomdagép";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gepnev, max_fordulat', 'required'),
			array('alapertelmezett, torolt', 'numerical', 'integerOnly'=>true),
			array('gepnev', 'length', 'max'=>30),
			array('max_fordulat', 'length', 'max'=>10),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gepnev, max_fordulat, alapertelmezett, torolt', 'safe', 'on'=>'search'),
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
			'id' => 'Nyomdagép ID',
			'gepnev' => 'Gépnév',
			'max_fordulat' => 'Max. fordulat',
			'alapertelmezett' => 'Alapértelmezett',
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
		$criteria->compare('gepnev',$this->gepnev,true);
		$criteria->compare('max_fordulat',$this->max_fordulat,true);
		$criteria->compare('alapertelmezett',$this->alapertelmezett);
		
		// LI: logikailag törölt sorok ne jelenjenek meg, ha a belépett user nem az 'Admin'
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->condition=" torolt = '0'";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	// LI : megnézzük, hogy az új nyomdagépen kívül van-e még nyomdagép,
	//		ha nincs, akkor automatikusan alapértelmezetté tesszük
	public function beforeSave() {
		if ($this->isNewRecord) {
			$nyomdagepek = Nyomdagepek::model()->findAll(array("condition"=>"torolt=0"));
			
			if (count($nyomdagepek) == 0) {
				$this -> alapertelmezett = 1;
			}	
		}
	 
		return parent::beforeSave();
	}	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Nyomdagepek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

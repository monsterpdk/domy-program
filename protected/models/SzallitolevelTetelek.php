<?php

/**
 * This is the model class for table "dom_szallitolevel_tetelek".
 *
 * The followings are the available columns in table 'dom_szallitolevel_tetelek':
 * @property string $id
 * @property string $szallitolevel_id
 * @property integer $megrendeles_tetel_id
 * @property string $darabszam
 * @property integer $torolt
 */
class SzallitolevelTetelek extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_szallitolevel_tetelek';
	}

	public function getClassName ()
	{
		return "Szállítólevél tétel";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('szallitolevel_id, megrendeles_tetel_id, darabszam', 'required'),
			array('szallitolevel_id, darabszam, megrendeles_tetel_id, torolt', 'numerical', 'integerOnly'=>true),
			array('szallitolevel_id, megrendeles_tetel_id, darabszam', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, szallitolevel_id, megrendeles_tetel_id, torolt', 'safe', 'on'=>'search'),
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
			'megrendeles_tetel' => array(self::BELONGS_TO, 'MegrendelesTetelek', 'megrendeles_tetel_id'),
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
			'id' => 'Tétel ID',
			'szallitolevel_id' => 'Szállítólevél ID',
			'megrendeles_tetel_id' => 'Megrendelés tétel',
			'darabszam' => 'Darabszám',
			'torolt' => 'Törölt',
			
			'DarabszamFormazott' => 'Db',
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
		$criteria->compare('szallitolevel_id',$this->szallitolevel_id,true);
		$criteria->compare('megrendeles_tetel_id',$this->megrendeles_tetel_id);
		$criteria->compare('darabszam',$this->darabszam,true);
		$criteria->compare('torolt',$this->torolt);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function afterFind(){
		parent::afterFind();
	}	
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArajanlatTetelek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getDarabszamFormazott() {
		return number_format($this->darabszam, 0, ' ', ' ');	
	}
	
	
}

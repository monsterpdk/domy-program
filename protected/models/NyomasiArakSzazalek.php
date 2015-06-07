<?php

/**
 * This is the model class for table "dom_nyomasi_arak_szazalek".
 *
 * The followings are the available columns in table 'dom_nyomasi_arak_szazalek':
 * @property integer $id
 * @property integer $peldanyszam_tol
 * @property integer $peldanyszam_ig
 * @property double $alap
 * @property double $kp
 * @property double $utal
 * @property double $kis_tetel
 * @property double $nagy_tetel
 * @property integer $user_id 
 * @property integer $torolt
 */
class NyomasiArakSzazalek extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_nyomasi_arak_szazalek';
	}

	public function getClassName ()
	{
		return 'Nyomási ár %';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('peldanyszam_tol, peldanyszam_ig, user_id', 'required'),
			array('peldanyszam_tol, peldanyszam_ig, user_id, torolt', 'numerical', 'integerOnly'=>true),
			array('alap, kp, utal, kis_tetel, nagy_tetel, user_id', 'numerical'),
			
			array('peldanyszam_tol', 'fromTo'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, peldanyszam_tol, peldanyszam_ig, alap, kp, utal, kis_tetel, nagy_tetel, torolt', 'safe', 'on'=>'search'),
		);
	}

	// a példányszám-TÓL ne lehessen nagyobb, mint a példányszám-IG
	public function fromTo ($attribute)
	{

		if ($this->peldanyszam_tol != null && $this->peldanyszam_ig != null) {
			if ($this->peldanyszam_tol >= $this->peldanyszam_ig) {
				$this->addError($attribute, 'A \'példányszám-tól\' értéknek  kisebbnek kell lennie a \'példányszám-ig\' értéknél!');
			}
		}
		
		return true;
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user'    => array(self::BELONGS_TO, 'User', 'user_id'),
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
			'id' => 'Nyomási ár % ID',
			'peldanyszam_tol' => 'Példányszám-tól',
			'peldanyszam_ig' => 'Példányszám-ig',
			'alap' => 'Alap %',
			'kp' => 'Kp %',
			'utal' => 'Utal %',
			'kis_tetel' => 'Kis tétel %',
			'nagy_tetel' => 'Nagy tétel %',
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
		$criteria->compare('peldanyszam_tol',$this->peldanyszam_tol);
		$criteria->compare('peldanyszam_ig',$this->peldanyszam_ig);
		$criteria->compare('alap',$this->alap);
		$criteria->compare('kp',$this->kp);
		$criteria->compare('utal',$this->utal);
		$criteria->compare('kis_tetel',$this->kis_tetel);
		$criteria->compare('nagy_tetel',$this->nagy_tetel);
		
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
	 * @return NyomasiArakSzazalek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

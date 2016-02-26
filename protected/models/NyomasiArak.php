<?php

/**
 * This is the model class for table "dom_nyomasi_arak".
 *
 * The followings are the available columns in table 'dom_nyomasi_arak':
 * @property integer $id
 * @property string $kategoria_tipus
 * @property string $boritek_fajtak
 * @property string $lehetseges_szinek
 * @property integer $peldanyszam_tol
 * @property integer $peldanyszam_ig
 * @property double $szin_egy
 * @property double $szin_ketto
 * @property double $szin_harom
 * @property double $szin_tobb
 * @property string $grafika
 * @property string $grafika_roviden
 * @property string $megjegyzes
 * @property string $ervenyesseg_tol
 * @property integer $user_id
 * @property integer $torolt
 */
class NyomasiArak extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_nyomasi_arak';
	}

	public function getClassName ()
	{
		return 'Nyomási ár';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kategoria_tipus, boritek_fajtak, lehetseges_szinek, user_id', 'required'),
			array('peldanyszam_tol, peldanyszam_ig, user_id, torolt', 'numerical', 'integerOnly'=>true),
			array('szin_egy, szin_ketto, szin_harom, szin_tobb', 'numerical'),
			array('kategoria_tipus', 'length', 'max'=>32),
			array('boritek_fajtak, lehetseges_szinek', 'length', 'max'=>128),
			array('grafika, grafika_roviden, megjegyzes, ervenyesseg_tol', 'safe'),
			
			array('ervenyesseg_tol', 'type', 'type' => 'date', 'message' => '{attribute}: nem megfelelő formátumú!', 'dateFormat' => 'yyyy-MM-dd'),
			
			array('ervenyesseg_tol', 'fromTo'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, kategoria_tipus, boritek_fajtak, lehetseges_szinek, peldanyszam_tol, peldanyszam_ig, szin_egy, szin_ketto, szin_harom, szin_tobb, grafika, grafika_roviden, megjegyzes, ervenyesseg_tol, user_id', 'safe', 'on'=>'search'),
		);
	}

	// a példányszám-TÓL ne lehessen nagyobb, mint a példányszám-IG
	public function fromTo ($attribute)
	{

		if ($this->peldanyszam_tol != null && $this->peldanyszam_ig != null) {
			if ($this->peldanyszam_tol >= $this->peldanyszam_ig) {
				$this->addError($attribute, 'A \'példányszám-tól\' értéknek  nagyobbnak kell lennie a \'példányszám-ig\' értéknél!');
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
			'id' => 'Nyomási ár ID',
			'kategoria_tipus' => 'Kategóriatípus',
			'boritek_fajtak' => 'Borítékfajták',
			'lehetseges_szinek' => 'Lehetséges színek',
			'peldanyszam_tol' => 'Példányszám-tól',
			'peldanyszam_ig' => 'Példányszám-ig',
			'szin_egy' => 'Egy szín (Ft/db)',
			'szin_ketto' => 'Két szín (Ft/db)',
			'szin_harom' => 'Három szín (Ft/db)',
			'szin_tobb' => 'Több szín (Ft/db)',
			'grafika' => 'Grafika',
			'grafika_roviden' => 'Grafika röviden',
			'megjegyzes' => 'Megjegyzés',
			'ervenyesseg_tol' => 'Érvényesség-tól',
			'user_id' => 'Ügyintéző',
			'torolt' => 'Törölt',
			// csak szűréshez
			'tipus' => 'Típus',
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
	
		$criteria=new CDbCriteria;
		
		$criteria->compare('kategoria_tipus', $this->kategoria_tipus, true);
		
		if ( isset($_GET['tipus']) ) {
			$now = new CDbExpression("NOW()");

			if ($_GET['tipus'] == 'ervenyes') {
				$criteria->addCondition('ervenyesseg_tol > "'.$now.'" ');
				
			} else if ($_GET['tipus'] == 'inaktiv') {
				$criteria->addCondition('ervenyesseg_tol IS NULL');
				
			} else if ($_GET['tipus'] == 'archiv') {
				$criteria->addCondition('ervenyesseg_tol > "'.$now.'" ');
			}
			
		}
		
		// példányszám szerinti szűrés
		if ( $this -> peldanyszam_tol > 0) {
			$criteria->addCondition('peldanyszam_tol >= "' . $this -> peldanyszam_tol . '" ');
		}
		if ( $this -> peldanyszam_ig > 0) {
			$criteria->addCondition('peldanyszam_ig <= "' . $this -> peldanyszam_ig . '" ');
		}
		
		// LI: logikailag törölt sorok ne jelenjenek meg, ha a belépett user nem az 'Admin'
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->compare('torolt', 0, false);
	
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),)
		));
	}
	
	protected function afterFind() {
		parent::afterFind();	
		
		if ($this->ervenyesseg_tol != null && $this->ervenyesseg_tol != "" && $this->ervenyesseg_tol != "0000-00-00")
			$this -> ervenyesseg_tol = date('Y-m-d', strtotime(str_replace("-", "", $this->ervenyesseg_tol)));

	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NyomasiArak the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

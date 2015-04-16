<?php

/**
 * This is the model class for table "tbl_users".
 *
 * The followings are the available columns in table 'tbl_users':
 * @property integer $id
 * @property string $username
 * @property string $fullname
 * @property string $password
 * @property string $email
 */
class User extends CActiveRecord
{
	public $new_password;
	public $new_password_repeat;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_users';
	}

	public function getClassName ()
	{
		return "Felhasználó";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('username, fullname, new_password, new_password_repeat, email', 'required', 'on' => 'create'),
			array('fullname', 'length', 'max'=>256),
			array('username, email', 'length', 'max'=>128),
			array('id, username, fullname, email', 'safe', 'on'=>'search'),
			array('new_password, new_password_repeat', 'length', 'min'=>1, 'max'=>40),
			
			// új user létrehozása esetén mindenképpen ki kell tölteni a jelszó / jelszó újra mezőket
            array('username, fullname, new_password, new_password_repeat', 'required', 'on' => 'insert'),
            array('new_password', 'compare', 'on' => 'insert'),
            array('new_password_repeat', 'safe'),
			
			// létező user módosítása esetén csak akkor kell ellenőrizni, hogy a jelszó / jelszó újra mezők egyeznek-e,
			// ha nem üresek
			// ha üresek, akkor marad a jelszó változatlanul ami eddig is volt
			array('new_password', 'check_password_if_not_null', 'on' => 'update'),
		);
	}

	public function check_password_if_not_null ($attribute, $params)
	{
		if (trim($this -> new_password) != "") {
			if ( (trim($this -> new_password_repeat) == "") || ($this -> new_password != $this -> new_password_repeat) )
				$this -> addError('new_password_repeat', 'Ismételje meg pontosan a Jelszó mezőbe írtakat.');
		}
	}
	
	protected function beforeSave ()
	{
		if (trim($this -> new_password) != "") {
			$this -> password = sha1($this -> new_password);
		}
		
		return parent::beforeSave();
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
			'id' => 'Id',
			'username' => 'Felhasználónév',
			'fullname' => 'Név',
			'new_password' => 'Jelszó',
			'new_password_repeat' => 'Jelszó újra',
			'email' => 'E-mail',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
								//'pageSize' => $pagination,
							),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

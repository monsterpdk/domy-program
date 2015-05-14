<?php

/**
 * This is the model class for table "dom_anyagrendeles_termekek".
 *
 * The followings are the available columns in table 'dom_anyagrendeles_termekek':
 * @property string $id
 * @property string $anyagrendeles_id
 * @property string $termek_id
 * @property string $rendelt_darabszam
 * @property double $rendeleskor_netto_darabar
 */
class AnyagrendelesTermekek extends DomyModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_anyagrendeles_termekek';
	}

	public function getClassName ()
	{
		return "Anyagrendelés termék";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('anyagrendeles_id, termek_id, rendelt_darabszam, rendeleskor_netto_darabar', 'required'),
			array('rendeleskor_netto_darabar, rendelt_darabszam', 'numerical'),
			array('anyagrendeles_id, termek_id, rendelt_darabszam', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, anyagrendeles_id, termek_id, rendelt_darabszam, rendeleskor_netto_darabar', 'safe', 'on'=>'search'),
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
			'termek'    => array(self::BELONGS_TO, 'Termekek', 'termek_id'),
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
			'id' => 'Rendelt termék ID',
			'anyagrendeles_id' => 'Anyagrendelés ID',
			'termek_id' => 'Termék',
			'rendelt_darabszam' => 'Rendelt darabszám (db)',
			'rendeleskor_netto_darabar' => 'Rendeléskor nettó darabár (Ft)',
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
		$criteria->compare('anyagrendeles_id',$this->anyagrendeles_id,true);
		$criteria->compare('termek_id',$this->termek_id,true);
		$criteria->compare('rendelt_darabszam',$this->rendelt_darabszam,true);
		$criteria->compare('rendeleskor_netto_darabar',$this->rendeleskor_netto_darabar);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	// sikeres mentés után frissítjük a raktár eltérés lista megfelelő sorát a termék és darabszám adatokkal	
	public function afterSave() {
		$raktarSor = RaktarEltereslista::model()->findByAttributes( array('anyagrendeles_id' => $this->anyagrendeles_id, 'termek_id' => $this->termek_id) );
		
		if ($raktarSor == null) {
			// új tétel esetén felvesszük az eltérés táblába
			$raktarSor = new RaktarEltereslista;
			$raktarSor->anyagrendeles_id = $this->anyagrendeles_id;
			$raktarSor->termek_id = $this->termek_id;
			$raktarSor->rendeleskor_leadott_db = $this->rendelt_darabszam;
		} else {
			// meglévő esetén csak frissítjük a darabszámot (de úgy, hogy kivinjuk az előző darabszámot és hozzáadjuk az újat,
			// mert különben pl. 10 mentés esetén 10-szer hozzáadódna újra a darabszám, ha nincs előtte a régi érték törlése)
			$raktarSor->rendeleskor_leadott_db += ($this->rendelt_darabszam - ($this->isNewrecord ? 0 : $this->OldAttributes['rendelt_darabszam']));
		}
		$raktarSor->save();
		
		return parent::afterSave();
	}
	
	// sikeres törlés után frissítjük a raktár eltérés lista megfelelő sorát a termék és darabszám adatokkal	
	public function afterDelete() {
		$raktarSor = RaktarEltereslista::model()->findByAttributes( array('anyagrendeles_id' => $this->anyagrendeles_id, 'termek_id' => $this->termek_id) );
		
		if ($raktarSor != null) {
			// ha találtunk megfelelő bejegyzést az eltéréslistában, akkor ellenőrizzük, hogy használja-e az adott rekordot az iroda vagy a raktár vagy esetleg egy másik anyagrendelés bejegyzés:
			// ha igen, akkor frissítjük a darabszámot (csükkentjük), ha nem, akkor töröljük a rekordot
			
			if ($raktarSor -> iroda_altal_atvett_db == 0 && $raktarSor -> raktar_altal_atvett_db == 0 && $raktarSor -> rendeleskor_leadott_db == $this -> rendelt_darabszam) {
				$raktarSor -> delete();
			} else {
				$raktarSor -> rendeleskor_leadott_db -= $this -> rendelt_darabszam;
				$raktarSor -> save();
			}
		}
	
		return parent::afterDelete();
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AnyagrendelesTermekek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

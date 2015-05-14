<?php

/**
 * This is the model class for table "dom_anyagbeszallitas_termekek".
 *
 * The followings are the available columns in table 'dom_anyagbeszallitas_termekek':
 * @property string $id
 * @property string $anyagbeszallitas_id
 * @property string $termek_id
 * @property string $darabszam
 * @property double $netto_darabar
 */
class AnyagbeszallitasTermekek extends DomyModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_anyagbeszallitas_termekek';
	}

	public function getClassName ()
	{
		return "Anyagbeszállítás termék raktárba";
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('anyagbeszallitas_id, termek_id, darabszam, netto_darabar', 'required'),
			array('netto_darabar, darabszam', 'numerical'),
			array('anyagbeszallitas_id, termek_id, darabszam', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, anyagbeszallitas_id, termek_id, darabszam, netto_darabar', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'anyagbeszallitas_id' => 'Anyagbeszállítás ID',
			'termek_id' => 'Termék',
			'darabszam' => 'Darabszám',
			'netto_darabar' => 'Nettó darabár',
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
		$criteria->compare('anyagbeszallitas_id',$this->anyagbeszallitas_id,true);
		$criteria->compare('termek_id',$this->termek_id,true);
		$criteria->compare('darabszam',$this->darabszam,true);
		$criteria->compare('netto_darabar',$this->netto_darabar);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	// sikeres mentés után frissítjük a raktár eltérés lista megfelelő sorát a termék és darabszám adatokkal	
	public function afterSave() {
		$anyagbeszallitas = Anyagbeszallitasok::model()->findByPk($this->anyagbeszallitas_id);
		
		// ha össze van már kötve az anyagbeszállítás egy anyagrendeléssel
		if ($anyagbeszallitas -> anyagrendeles_id != null && $anyagbeszallitas -> anyagrendeles_id != "" && $anyagbeszallitas -> anyagrendeles_id != 0) {
			$raktarSor = RaktarEltereslista::model()->findByAttributes( array('anyagrendeles_id' => $anyagbeszallitas->anyagrendeles_id, 'termek_id' => $this->termek_id) );

			if ($raktarSor == null) {
				// új tétel esetén felvesszük az eltérés táblába
				$raktarSor = new RaktarEltereslista;
				$raktarSor->anyagrendeles_id = $anyagbeszallitas->anyagrendeles_id;
				$raktarSor->termek_id = $this->termek_id;
				$raktarSor->raktar_altal_atvett_db = $this->darabszam;
			} else {
				// meglévő esetén csak frissítjük a darabszámot (de úgy, hogy kivonjuk az előző darabszámot és hozzáadjuk az újat,
				// mert különben pl. 10 mentés esetén 10-szer hozzáadódna újra a darabszám, ha nincs előtte a régi érték törlése)
				$raktarSor->raktar_altal_atvett_db += ($this->darabszam - ($this->isNewrecord ? 0 : $this->OldAttributes['darabszam']));
			}
			$raktarSor->save();
		} else {
			// ha üres az anyagrendeles_id mező, akkor felvesszük anélkül ha nincs, ha van, akkro frissítjük a meglévő rekordot
			$raktarSor = RaktarEltereslista::model()->findByAttributes( array('anyagbeszallitas_id' => $anyagbeszallitas->id, 'termek_id' => $this->termek_id) );
			
			if ($raktarSor == null) {
				// új tétel esetén felvesszük az eltérés táblába
				$raktarSor = new RaktarEltereslista;
				$raktarSor->anyagbeszallitas_id = $anyagbeszallitas->id;
				$raktarSor->termek_id = $this->termek_id;
				$raktarSor->raktar_altal_atvett_db = $this->darabszam;
			} else {
				// meglévő esetén csak frissítjük a darabszámot (de úgy, hogy kivonjuk az előző darabszámot és hozzáadjuk az újat,
				// mert különben pl. 10 mentés esetén 10-szer hozzáadódna újra a darabszám, ha nincs előtte a régi érték törlése)
				$raktarSor->raktar_altal_atvett_db += ($this->darabszam - ($this->isNewrecord ? 0 : $this->OldAttributes['darabszam']));
			}
			$raktarSor->save();
		}
		
		return parent::afterSave();
	}
	
	// sikeres törlés után frissítjük a raktár eltérés lista megfelelő sorát a termék és darabszám adatokkal	
	public function afterDelete() {
		$anyagbeszallitas = Anyagbeszallitasok::model()->findByPk($this->anyagbeszallitas_id);

		if ($anyagbeszallitas != null && $anyagbeszallitas -> anyagrendeles_id != null && $anyagbeszallitas -> anyagrendeles_id != "") {
			$raktarSor = RaktarEltereslista::model()->findByAttributes( array('anyagrendeles_id' => $anyagbeszallitas->anyagrendeles_id, 'termek_id' => $this->termek_id) );			
			if ($raktarSor != null) {
				// ha találtunk megfelelő bejegyzést az eltéréslistában, akkor ellenőrizzük, hogy használja-e az adott rekordot az anyagrendelés vagy az iroda, esetleg egy másik raktárbejegyzés:
				// ha igen, akkor frissítjük a darabszámot (csükkentjük), ha nem, akkor töröljük a rekordot
				
				if ($raktarSor -> rendeleskor_leadott_db == 0 && $raktarSor -> iroda_altal_atvett_db == 0 && $raktarSor -> raktar_altal_atvett_db == $this -> darabszam) {
					$raktarSor -> delete();
				} else {
					$raktarSor -> raktar_altal_atvett_db -= $this -> darabszam;
					$raktarSor -> save();
				}
			}
		}
		
		return parent::afterDelete();
	}	
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AnyagbeszallitasTermekek the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

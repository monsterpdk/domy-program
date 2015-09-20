<?php

/**
 * This is the model class for table "dom_nyomdakonyv".
 *
 * The followings are the available columns in table 'dom_nyomdakonyv':
 * @property string $id
 * @property string $megrendeles_tetel_id
 * @property string $taskaszam
 * @property string $hatarido
 * @property string $pantone
 * @property string $munka_beerkezes_datum
 * @property string $taska_kiadasi_datum
 * @property string $elkeszulesi_datum
 * @property string $ertesitesi_datum
 * @property string $szallitolevel_sorszam
 * @property string $szallitolevel_datum
 * @property string $szamla_sorszam
 * @property string $szamla_datum
 * @property integer $sos
 * @property integer $szin_c
 * @property integer $szin_m
 * @property integer $szin_y
 * @property integer $szin_k
 * @property integer $szin_mutaciok
 * @property integer $kifuto_bal
 * @property integer $kifuto_fent
 * @property integer $kifuto_jobb
 * @property integer $kifuto_lent
 * @property integer $forditott_levezetes
 * @property integer $hossziranyu_levezetes
 * @property string $nyomas_tipus
 * @property string $utasitas_ctp_nek
 * @property string $utasitas_gepmesternek
 * @property string $kiszallitasi_informaciok
 * @property integer $gep_id
 * @property integer $kifutos
 * @property integer $fekete_flekkben_szin_javitando
 * @property integer $magas_szinterheles_nagy_feluleten
 * @property integer $magas_szinterheles_szovegben
 * @property integer $ofszet_festek
 * @property integer $nyomas_minta_szerint
 * @property integer $nyomas_vagojel_szerint
 * @property string $nyomas_specialis
 * @property integer $gepindulasra_jon_ugyfel
 * @property string $ctp_nek_atadas_datum
 * @property string $ctp_kezdes_datum
 * @property string $ctp_belenyulasok
 * @property string $ctp_hibalista
 * @property string $jovahagyas
 * @property string $ctp_kesz_datum
 * @property string $nyomas_kezdes_datum
 * @property string $raktarbol_kiadva_datum
 * @property string $kep_file_nev
 * @property integer $sztornozva
 * @property integer $torolt
 */
class Nyomdakonyv extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_nyomdakonyv';
	}
	
	public function getClassName ()
	{
		return 'Nyomdakönyv';
	}	

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('megrendeles_tetel_id, taskaszam, hatarido, pantone, munka_beerkezes_datum, taska_kiadasi_datum, elkeszulesi_datum, ertesitesi_datum, szallitolevel_sorszam, szallitolevel_datum, szamla_sorszam, szamla_datum, sos, szin_c, szin_m, szin_y, szin_k, szin_mutaciok, kifuto_bal, kifuto_fent, kifuto_jobb, kifuto_lent, forditott_levezetes, hossziranyu_levezetes, nyomas_tipus, utasitas_ctp_nek, utasitas_gepmesternek, kiszallitasi_informaciok, gep_id, kifutos, fekete_flekkben_szin_javitando, magas_szinterheles_nagy_feluleten, magas_szinterheles_szovegben, ofszet_festek, nyomas_minta_szerint, nyomas_vagojel_szerint, nyomas_specialis, gepindulasra_jon_ugyfel, ctp_nek_atadas_datum, ctp_kezdes_datum, ctp_belenyulasok, ctp_hibalista, jovahagyas, ctp_kesz_datum, nyomas_kezdes_datum, raktarbol_kiadva_datum, kep_file_nev, sztornozva, torolt', 'required'),
			array('sos, szin_c, szin_m, szin_y, szin_k, szin_mutaciok, kifuto_bal, kifuto_fent, kifuto_jobb, kifuto_lent, forditott_levezetes, hossziranyu_levezetes, gep_id, kifutos, fekete_flekkben_szin_javitando, magas_szinterheles_nagy_feluleten, magas_szinterheles_szovegben, ofszet_festek, nyomas_minta_szerint, nyomas_vagojel_szerint, gepindulasra_jon_ugyfel, sztornozva, torolt', 'numerical', 'integerOnly'=>true),
			array('megrendeles_tetel_id', 'length', 'max'=>10),
			array('taskaszam, szallitolevel_sorszam', 'length', 'max'=>12),
			array('pantone, utasitas_ctp_nek, utasitas_gepmesternek, kiszallitasi_informaciok, ctp_belenyulasok, ctp_hibalista, kep_file_nev', 'length', 'max'=>255),
			array('szamla_sorszam, jovahagyas', 'length', 'max'=>15),
			array('nyomas_tipus', 'length', 'max'=>29),
			array('nyomas_specialis', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, megrendeles_tetel_id, taskaszam, hatarido, pantone, munka_beerkezes_datum, taska_kiadasi_datum, elkeszulesi_datum, ertesitesi_datum, szallitolevel_sorszam, szallitolevel_datum, szamla_sorszam, szamla_datum, sos, szin_c, szin_m, szin_y, szin_k, szin_mutaciok, kifuto_bal, kifuto_fent, kifuto_jobb, kifuto_lent, forditott_levezetes, hossziranyu_levezetes, nyomas_tipus, utasitas_ctp_nek, utasitas_gepmesternek, kiszallitasi_informaciok, gep_id, kifutos, fekete_flekkben_szin_javitando, magas_szinterheles_nagy_feluleten, magas_szinterheles_szovegben, ofszet_festek, nyomas_minta_szerint, nyomas_vagojel_szerint, nyomas_specialis, gepindulasra_jon_ugyfel, ctp_nek_atadas_datum, ctp_kezdes_datum, ctp_belenyulasok, ctp_hibalista, jovahagyas, ctp_kesz_datum, nyomas_kezdes_datum, raktarbol_kiadva_datum, kep_file_nev, sztornozva, torolt', 'safe', 'on'=>'search'),
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
			'id' => 'Nyomdakönyv ID',
			'megrendeles_tetel_id' => 'Megrendelés tétel',
			'taskaszam' => 'Táskaszám',
			'hatarido' => 'Határidő',
			'pantone' => 'Pantone',
			'munka_beerkezes_datum' => 'Munka beerkezés dátum',
			'taska_kiadasi_datum' => 'Táska kiadási dátum',
			'elkeszulesi_datum' => 'Elkészülési dátum',
			'ertesitesi_datum' => 'Értesítési dátum',
			'szallitolevel_sorszam' => 'Szállitólevél sorszám',
			'szallitolevel_datum' => 'Szállitólevél dátum',
			'szamla_sorszam' => 'Számla sorszám',
			'szamla_datum' => 'Számla dátum',
			'sos' => 'SOS',
			'szin_c' => 'C',
			'szin_m' => 'M',
			'szin_y' => 'Y',
			'szin_k' => 'K (fekete)',
			'szin_mutaciok' => 'Mutáció',
			'kifuto_bal' => '',
			'kifuto_fent' => '',
			'kifuto_jobb' => '',
			'kifuto_lent' => '',
			'forditott_levezetes' => 'Fordított levezetés',
			'hossziranyu_levezetes' => 'Hosszirányú levezetés',
			'nyomas_tipus' => 'Nyomás típusa',
			'utasitas_ctp_nek' => 'Utasítás CTP-nek',
			'utasitas_gepmesternek' => 'Utasítás gépmesternek',
			'kiszallitasi_informaciok' => 'Kiszállítasi információk',
			'gep_id' => 'Gép',
			'kifutos' => 'Kifutós',
			'fekete_flekkben_szin_javitando' => 'Fekete flekkben szín javítandó',
			'magas_szinterheles_nagy_feluleten' => 'Magas színterhelés nagy felületen',
			'magas_szinterheles_szovegben' => 'Magas színterhelés szövegben',
			'ofszet_festek' => 'Ofszet festék',
			'nyomas_minta_szerint' => 'Nyomás minta szerint',
			'nyomas_vagojel_szerint' => 'Nyomás vágójel szerint',
			'nyomas_specialis' => 'Nyomás speciális',
			'gepindulasra_jon_ugyfel' => 'Gépindulásra jön az ügyfél',
			'ctp_nek_atadas_datum' => 'CTP-nek átadva',
			'ctp_kezdes_datum' => 'CTP-kezdés',
			'ctp_belenyulasok' => 'CTP-belenyúlások',
			'ctp_hibalista' => 'CTP-hibalista',
			'jovahagyas' => 'Jováhagyás jött',
			'ctp_kesz_datum' => 'CTP-kész',
			'nyomas_kezdes_datum' => 'Nyomás elkezdve',
			'raktarbol_kiadva_datum' => 'Raktárból kiadva',
			'kep_file_nev' => '',
			'sztornozva' => 'Sztornózva',
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
		$criteria->compare('megrendeles_tetel_id',$this->megrendeles_tetel_id,true);
		$criteria->compare('taskaszam',$this->taskaszam,true);
		$criteria->compare('hatarido',$this->hatarido,true);
		$criteria->compare('pantone',$this->pantone,true);
		$criteria->compare('munka_beerkezes_datum',$this->munka_beerkezes_datum,true);
		$criteria->compare('taska_kiadasi_datum',$this->taska_kiadasi_datum,true);
		$criteria->compare('elkeszulesi_datum',$this->elkeszulesi_datum,true);
		$criteria->compare('ertesitesi_datum',$this->ertesitesi_datum,true);
		$criteria->compare('szallitolevel_sorszam',$this->szallitolevel_sorszam,true);
		$criteria->compare('szallitolevel_datum',$this->szallitolevel_datum,true);
		$criteria->compare('szamla_sorszam',$this->szamla_sorszam,true);
		$criteria->compare('szamla_datum',$this->szamla_datum,true);
		$criteria->compare('sos',$this->sos);
		$criteria->compare('szin_c',$this->szin_c);
		$criteria->compare('szin_m',$this->szin_m);
		$criteria->compare('szin_y',$this->szin_y);
		$criteria->compare('szin_k',$this->szin_k);
		$criteria->compare('szin_mutaciok',$this->szin_mutaciok);
		$criteria->compare('kifuto_bal',$this->kifuto_bal);
		$criteria->compare('kifuto_fent',$this->kifuto_fent);
		$criteria->compare('kifuto_jobb',$this->kifuto_jobb);
		$criteria->compare('kifuto_lent',$this->kifuto_lent);
		$criteria->compare('forditott_levezetes',$this->forditott_levezetes);
		$criteria->compare('hossziranyu_levezetes',$this->hossziranyu_levezetes);
		$criteria->compare('nyomas_tipus',$this->nyomas_tipus,true);
		$criteria->compare('utasitas_ctp_nek',$this->utasitas_ctp_nek,true);
		$criteria->compare('utasitas_gepmesternek',$this->utasitas_gepmesternek,true);
		$criteria->compare('kiszallitasi_informaciok',$this->kiszallitasi_informaciok,true);
		$criteria->compare('gep_id',$this->gep_id);
		$criteria->compare('kifutos',$this->kifutos);
		$criteria->compare('fekete_flekkben_szin_javitando',$this->fekete_flekkben_szin_javitando);
		$criteria->compare('magas_szinterheles_nagy_feluleten',$this->magas_szinterheles_nagy_feluleten);
		$criteria->compare('magas_szinterheles_szovegben',$this->magas_szinterheles_szovegben);
		$criteria->compare('ofszet_festek',$this->ofszet_festek);
		$criteria->compare('nyomas_minta_szerint',$this->nyomas_minta_szerint);
		$criteria->compare('nyomas_vagojel_szerint',$this->nyomas_vagojel_szerint);
		$criteria->compare('nyomas_specialis',$this->nyomas_specialis,true);
		$criteria->compare('gepindulasra_jon_ugyfel',$this->gepindulasra_jon_ugyfel);
		$criteria->compare('ctp_nek_atadas_datum',$this->ctp_nek_atadas_datum,true);
		$criteria->compare('ctp_kezdes_datum',$this->ctp_kezdes_datum,true);
		$criteria->compare('ctp_belenyulasok',$this->ctp_belenyulasok,true);
		$criteria->compare('ctp_hibalista',$this->ctp_hibalista,true);
		$criteria->compare('jovahagyas',$this->jovahagyas,true);
		$criteria->compare('ctp_kesz_datum',$this->ctp_kesz_datum,true);
		$criteria->compare('nyomas_kezdes_datum',$this->nyomas_kezdes_datum,true);
		$criteria->compare('raktarbol_kiadva_datum',$this->raktarbol_kiadva_datum,true);
		$criteria->compare('kep_file_nev',$this->kep_file_nev,true);
		$criteria->compare('sztornozva',$this->sztornozva);

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
	 * @return Nyomdakonyv the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
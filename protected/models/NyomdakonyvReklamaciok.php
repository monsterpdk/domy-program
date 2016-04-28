<?php

/**
 * This is the model class for table "dom_nyomdakonyv_reklamacio".
 *
 * The followings are the available columns in table 'dom_nyomdakonyv_reklamacio':
 * @property string $id
 * @property string $nyomdakonyv_id
 * @property string $datum
 * @property string $selejt_leiras
 * @property string $aru_kiado
 * @property string $gepmester
 * @property string $kereszt_ellenor
 * @property string $felelosok
 * @property integer $selejt_oka_rossz_munka_kiadas
 * @property integer $selejt_oka_szin_hiba
 * @property integer $selejt_oka_passzer_hiba
 * @property integer $selejt_oka_hatarido_csuszas
 * @property integer $selejt_oka_peldanyszam_elteres
 * @property integer $selejt_oka_elhelyezes_hiba
 * @property integer $selejt_oka_hibas_boritek_valasztas
 * @property integer $selejt_oka_rossz_meret
 * @property integer $selejt_oka_rossz_ablak
 * @property integer $selejt_oka_rossz_rag_mod
 * @property integer $eszrevetel_helye_cegen_belul
 * @property integer $eszrevetel_helye_cegen_kivul
 * @property integer $ellenorzesi_pontok_iroda_munka_felvetel
 * @property integer $ellenorzesi_pontok_iroda_munka_kiadas
 * @property integer $ellenorzesi_pontok_raktari_kiadas
 * @property integer $ellenorzesi_pontok_gepmester_atvetel
 * @property integer $ellenorzesi_pontok_keresztellenor
 * @property integer $ellenorzesi_pontok_keszre_jelentes_gepmester
 * @property integer $ellenorzesi_pontok_keszre_jelentes_ellenor
 * @property integer $ellenorzesi_pontok_raktari_visszavet
 * @property integer $ellenorzesi_pontok_iroda_munka_atvetel
 * @property integer $ellenorzesi_pontok_ugyfel
 * @property integer $hiba_eszlelese_iroda_munka_felvetel
 * @property integer $hiba_eszlelese_iroda_munka_kiadas
 * @property integer $hiba_eszlelese_raktari_kiadas
 * @property integer $hiba_eszlelese_gepmester_atvetel
 * @property integer $hiba_eszlelese_keresztellenor
 * @property integer $hiba_eszlelese_keszre_jelentes_gepmester
 * @property integer $hiba_eszlelese_keszre_jelentes_ellenor
 * @property integer $hiba_eszlelese_raktari_visszavet
 * @property integer $hiba_eszlelese_iroda_munka_atvetel
 * @property integer $hiba_eszlelese_ugyfel
 * @property integer $javitasi_mod_ujra_nyomas
 * @property integer $javitasi_mod_felul_nyomas
 * @property integer $javitasi_mod_arcsokkentes
 * @property integer $javitasi_mod_reszleges_ujranyomas
 * @property integer $javitasi_mod_kompenzacio
 * @property string $egyeb
 * @property double $netto_kar
 */
class NyomdakonyvReklamaciok extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dom_nyomdakonyv_reklamacio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('selejt_oka_rossz_munka_kiadas, selejt_oka_szin_hiba, selejt_oka_passzer_hiba, selejt_oka_hatarido_csuszas, selejt_oka_peldanyszam_elteres, selejt_oka_elhelyezes_hiba, selejt_oka_hibas_boritek_valasztas, selejt_oka_rossz_meret, selejt_oka_rossz_ablak, selejt_oka_rossz_rag_mod, eszrevetel_helye_cegen_belul, eszrevetel_helye_cegen_kivul, ellenorzesi_pontok_iroda_munka_felvetel, ellenorzesi_pontok_iroda_munka_kiadas, ellenorzesi_pontok_raktari_kiadas, ellenorzesi_pontok_gepmester_atvetel, ellenorzesi_pontok_keresztellenor, ellenorzesi_pontok_keszre_jelentes_gepmester, ellenorzesi_pontok_keszre_jelentes_ellenor, ellenorzesi_pontok_raktari_visszavet, ellenorzesi_pontok_iroda_munka_atvetel, ellenorzesi_pontok_ugyfel, hiba_eszlelese_iroda_munka_felvetel, hiba_eszlelese_iroda_munka_kiadas, hiba_eszlelese_raktari_kiadas, hiba_eszlelese_gepmester_atvetel, hiba_eszlelese_keresztellenor, hiba_eszlelese_keszre_jelentes_gepmester, hiba_eszlelese_keszre_jelentes_ellenor, hiba_eszlelese_raktari_visszavet, hiba_eszlelese_iroda_munka_atvetel, hiba_eszlelese_ugyfel, javitasi_mod_ujra_nyomas, javitasi_mod_felul_nyomas, javitasi_mod_arcsokkentes, javitasi_mod_reszleges_ujranyomas, javitasi_mod_kompenzacio', 'numerical', 'integerOnly'=>true),
			array('netto_kar', 'numerical'),
			array('nyomdakonyv_id', 'length', 'max'=>10),
			array('felelosok, selejt_leiras, egyeb', 'length', 'max'=>255),
			array('aru_kiado, gepmester, kereszt_ellenor', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nyomdakonyv_id, datum, selejt_leiras, aru_kiado, gepmester, felelosok, kereszt_ellenor, selejt_oka_rossz_munka_kiadas, selejt_oka_szin_hiba, selejt_oka_passzer_hiba, selejt_oka_hatarido_csuszas, selejt_oka_peldanyszam_elteres, selejt_oka_elhelyezes_hiba, selejt_oka_hibas_boritek_valasztas, selejt_oka_rossz_meret, selejt_oka_rossz_ablak, selejt_oka_rossz_rag_mod, eszrevetel_helye_cegen_belul, eszrevetel_helye_cegen_kivul, ellenorzesi_pontok_iroda_munka_felvetel, ellenorzesi_pontok_iroda_munka_kiadas, ellenorzesi_pontok_raktari_kiadas, ellenorzesi_pontok_gepmester_atvetel, ellenorzesi_pontok_keresztellenor, ellenorzesi_pontok_keszre_jelentes_gepmester, ellenorzesi_pontok_keszre_jelentes_ellenor, ellenorzesi_pontok_raktari_visszavet, ellenorzesi_pontok_iroda_munka_atvetel, ellenorzesi_pontok_ugyfel, hiba_eszlelese_iroda_munka_felvetel, hiba_eszlelese_iroda_munka_kiadas, hiba_eszlelese_raktari_kiadas, hiba_eszlelese_gepmester_atvetel, hiba_eszlelese_keresztellenor, hiba_eszlelese_keszre_jelentes_gepmester, hiba_eszlelese_keszre_jelentes_ellenor, hiba_eszlelese_raktari_visszavet, hiba_eszlelese_iroda_munka_atvetel, hiba_eszlelese_ugyfel, javitasi_mod_ujra_nyomas, javitasi_mod_felul_nyomas, javitasi_mod_arcsokkentes, javitasi_mod_reszleges_ujranyomas, javitasi_mod_kompenzacio, egyeb, netto_kar', 'safe', 'on'=>'search'),
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
			'nyomdakonyv' => array(self::BELONGS_TO, 'Nyomdakonyv', 'nyomdakonyv_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nyomdakonyv_id' => 'Nyomdakönyv ID',
			'datum' => 'Dátum',
			'selejt_leiras' => 'Selejt leírás',
			'aru_kiado' => 'Áru kiadó',
			'gepmester' => 'Gépmester',
			'kereszt_ellenor' => 'Kereszt ellenőr',
			'felelosok' => 'Felelősök',
			'selejt_oka_rossz_munka_kiadas' => 'rossz munka kiadás',
			'selejt_oka_szin_hiba' => 'szín hiba',
			'selejt_oka_passzer_hiba' => 'passzer hiba',
			'selejt_oka_hatarido_csuszas' => 'határidő csúszás',
			'selejt_oka_peldanyszam_elteres' => 'példányszám eltérés',
			'selejt_oka_elhelyezes_hiba' => 'elhelyezés hiba',
			'selejt_oka_hibas_boritek_valasztas' => 'hibás boríték választás',
			'selejt_oka_rossz_meret' => 'rossz méret',
			'selejt_oka_rossz_ablak' => 'rossz ablak',
			'selejt_oka_rossz_rag_mod' => 'rossz rag. mód',
			'eszrevetel_helye_cegen_belul' => 'cégen belül',
			'eszrevetel_helye_cegen_kivul' => 'cégen kívül',
			'ellenorzesi_pontok_iroda_munka_felvetel' => '',
			'ellenorzesi_pontok_iroda_munka_kiadas' => '',
			'ellenorzesi_pontok_raktari_kiadas' => '',
			'ellenorzesi_pontok_gepmester_atvetel' => '',
			'ellenorzesi_pontok_keresztellenor' => '',
			'ellenorzesi_pontok_keszre_jelentes_gepmester' => '',
			'ellenorzesi_pontok_keszre_jelentes_ellenor' => '',
			'ellenorzesi_pontok_raktari_visszavet' => '',
			'ellenorzesi_pontok_iroda_munka_atvetel' => '',
			'ellenorzesi_pontok_ugyfel' => '',
			'hiba_eszlelese_iroda_munka_felvetel' => '',
			'hiba_eszlelese_iroda_munka_kiadas' => '',
			'hiba_eszlelese_raktari_kiadas' => '',
			'hiba_eszlelese_gepmester_atvetel' => '',
			'hiba_eszlelese_keresztellenor' => '',
			'hiba_eszlelese_keszre_jelentes_gepmester' => '',
			'hiba_eszlelese_keszre_jelentes_ellenor' => '',
			'hiba_eszlelese_raktari_visszavet' => '',
			'hiba_eszlelese_iroda_munka_atvetel' => '',
			'hiba_eszlelese_ugyfel' => '',
			'javitasi_mod_ujra_nyomas' => 'újra nyomás',
			'javitasi_mod_felul_nyomas' => 'felül nyomás',
			'javitasi_mod_arcsokkentes' => 'árcsökkentés',
			'javitasi_mod_reszleges_ujranyomas' => 'részleges újranyomás',
			'javitasi_mod_kompenzacio' => 'kompenzáció',
			'egyeb' => 'egyéb',
			'netto_kar' => 'Nettó kár',
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
		$criteria->compare('nyomdakonyv_id',$this->nyomdakonyv_id,true);
		$criteria->compare('datum',$this->datum,true);
		$criteria->compare('selejt_leiras',$this->selejt_leiras,true);
		$criteria->compare('aru_kiado',$this->aru_kiado,true);
		$criteria->compare('gepmester',$this->gepmester,true);
		$criteria->compare('kereszt_ellenor',$this->kereszt_ellenor,true);
		$criteria->compare('felelosok',$this->felelosok,true);
		$criteria->compare('selejt_oka_rossz_munka_kiadas',$this->selejt_oka_rossz_munka_kiadas);
		$criteria->compare('selejt_oka_szin_hiba',$this->selejt_oka_szin_hiba);
		$criteria->compare('selejt_oka_passzer_hiba',$this->selejt_oka_passzer_hiba);
		$criteria->compare('selejt_oka_hatarido_csuszas',$this->selejt_oka_hatarido_csuszas);
		$criteria->compare('selejt_oka_peldanyszam_elteres',$this->selejt_oka_peldanyszam_elteres);
		$criteria->compare('selejt_oka_elhelyezes_hiba',$this->selejt_oka_elhelyezes_hiba);
		$criteria->compare('selejt_oka_hibas_boritek_valasztas',$this->selejt_oka_hibas_boritek_valasztas);
		$criteria->compare('selejt_oka_rossz_meret',$this->selejt_oka_rossz_meret);
		$criteria->compare('selejt_oka_rossz_ablak',$this->selejt_oka_rossz_ablak);
		$criteria->compare('selejt_oka_rossz_rag_mod',$this->selejt_oka_rossz_rag_mod);
		$criteria->compare('eszrevetel_helye_cegen_belul',$this->eszrevetel_helye_cegen_belul);
		$criteria->compare('eszrevetel_helye_cegen_kivul',$this->eszrevetel_helye_cegen_kivul);
		$criteria->compare('ellenorzesi_pontok_iroda_munka_felvetel',$this->ellenorzesi_pontok_iroda_munka_felvetel);
		$criteria->compare('ellenorzesi_pontok_iroda_munka_kiadas',$this->ellenorzesi_pontok_iroda_munka_kiadas);
		$criteria->compare('ellenorzesi_pontok_raktari_kiadas',$this->ellenorzesi_pontok_raktari_kiadas);
		$criteria->compare('ellenorzesi_pontok_gepmester_atvetel',$this->ellenorzesi_pontok_gepmester_atvetel);
		$criteria->compare('ellenorzesi_pontok_keresztellenor',$this->ellenorzesi_pontok_keresztellenor);
		$criteria->compare('ellenorzesi_pontok_keszre_jelentes_gepmester',$this->ellenorzesi_pontok_keszre_jelentes_gepmester);
		$criteria->compare('ellenorzesi_pontok_keszre_jelentes_ellenor',$this->ellenorzesi_pontok_keszre_jelentes_ellenor);
		$criteria->compare('ellenorzesi_pontok_raktari_visszavet',$this->ellenorzesi_pontok_raktari_visszavet);
		$criteria->compare('ellenorzesi_pontok_iroda_munka_atvetel',$this->ellenorzesi_pontok_iroda_munka_atvetel);
		$criteria->compare('ellenorzesi_pontok_ugyfel',$this->ellenorzesi_pontok_ugyfel);
		$criteria->compare('hiba_eszlelese_iroda_munka_felvetel',$this->hiba_eszlelese_iroda_munka_felvetel);
		$criteria->compare('hiba_eszlelese_iroda_munka_kiadas',$this->hiba_eszlelese_iroda_munka_kiadas);
		$criteria->compare('hiba_eszlelese_raktari_kiadas',$this->hiba_eszlelese_raktari_kiadas);
		$criteria->compare('hiba_eszlelese_gepmester_atvetel',$this->hiba_eszlelese_gepmester_atvetel);
		$criteria->compare('hiba_eszlelese_keresztellenor',$this->hiba_eszlelese_keresztellenor);
		$criteria->compare('hiba_eszlelese_keszre_jelentes_gepmester',$this->hiba_eszlelese_keszre_jelentes_gepmester);
		$criteria->compare('hiba_eszlelese_keszre_jelentes_ellenor',$this->hiba_eszlelese_keszre_jelentes_ellenor);
		$criteria->compare('hiba_eszlelese_raktari_visszavet',$this->hiba_eszlelese_raktari_visszavet);
		$criteria->compare('hiba_eszlelese_iroda_munka_atvetel',$this->hiba_eszlelese_iroda_munka_atvetel);
		$criteria->compare('hiba_eszlelese_ugyfel',$this->hiba_eszlelese_ugyfel);
		$criteria->compare('javitasi_mod_ujra_nyomas',$this->javitasi_mod_ujra_nyomas);
		$criteria->compare('javitasi_mod_felul_nyomas',$this->javitasi_mod_felul_nyomas);
		$criteria->compare('javitasi_mod_arcsokkentes',$this->javitasi_mod_arcsokkentes);
		$criteria->compare('javitasi_mod_reszleges_ujranyomas',$this->javitasi_mod_reszleges_ujranyomas);
		$criteria->compare('javitasi_mod_kompenzacio',$this->javitasi_mod_kompenzacio);
		$criteria->compare('egyeb',$this->egyeb,true);
		$criteria->compare('netto_kar',$this->netto_kar);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NyomdakonyvReklamaciok the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

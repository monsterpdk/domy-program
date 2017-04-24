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
 * @property string $szin_pantone
 * @property string $munka_beerkezes_datum
 * @property string $taska_kiadasi_datum
 * @property string $elkeszulesi_datum
 * @property string $ertesitesi_datum
 * @property string $szallitolevel_sorszam
 * @property string $szallitolevel_datum
 * @property string $szamla_sorszam
 * @property string $szamla_datum
 * @property string $proforma_szama
 * @property string $proforma_datuma
 * @property integer $sos
 * @property integer $szin_c_elo
 * @property integer $szin_m_elo
 * @property integer $szin_y_elo
 * @property integer $szin_k_elo
 * @property integer $szin_c_hat
 * @property integer $szin_m_hat
 * @property integer $szin_y_hat
 * @property integer $szin_k_hat
 * @property integer $szin_mutaciok
 * @property integer $szin_mutaciok_szam
 * @property integer $kifuto_bal
 * @property integer $kifuto_fent
 * @property integer $kifuto_jobb
 * @property integer $kifuto_lent
 * @property integer $forditott_levezetes
 * @property integer $hossziranyu_levezetes
 * @property string $nyomas_tipus
 * @property string $utannyomas_valtoztatassal
 * @property string $utasitas_ctp_nek
 * @property string $utasitas_gepmesternek
 * @property string $kiszallitasi_informaciok
 * @property integer $gep_id
 * @property integer $munkatipus_id
 * @property integer $max_fordulat
 * @property string $erkezett
 * @property string $file_beerkezett
 * @property integer $kifutos
 * @property integer $fekete_flekkben_szin_javitando
 * @property integer $magas_szinterheles_nagy_feluleten
 * @property integer $magas_szinterheles_szovegben
 * @property integer $ofszet_festek
 * @property integer $nyomas_minta_szerint
 * @property integer $nyomas_vagojel_szerint
 * @property integer $nyomas_domy_szerint
 * @property string $nyomas_specialis
 * @property integer $gepindulasra_jon_ugyfel
 * @property string $ctp_nek_atadas_datum
 * @property string $ctp_kezdes_datum
 * @property string $ctp_belenyulasok
 * @property string $ctp_hibalista
 * @property string $jovahagyas
 * @property string $nyomhato
 * @property string $ctp_kesz_datum
 * @property string $nyomas_kezdes_datum
 * @property string $raktarbol_kiadva_datum
 * @property string $kep_file_nev
 * @property string $sztornozas_oka 
 * @property integer $sztornozva
 * @property integer $nyomtatva_taska
 * @property integer $nyomtatva_ctp_taska
 * @property integer $torolt
 */
class Nyomdakonyv extends CActiveRecord
{
	// keresésekhez, ahol nem a nyomdakönyv egy mezőjét, hanem valami kapcsolódó model mezőjét keressük
	public $munkanev_search;
	public $megrendelonev_search;
	public $boritek_tipus_search;
	public $darabszam_tol_search;
	public $darabszam_ig_search;
	public $szinszam1_tol_search;
	public $szinszam1_ig_search;
	public $szinszam2_tol_search;
	public $szinszam2_ig_search;
	public $folyamatban_levo_muvelet;
	public $varhato_befejezes;

	// automatikusan töltődő mezők (külső táblákból)
	public $dsp_szallitolevel_datum;
	public $dsp_szallitolevel_sorszam;
	public $dsp_szamla_datum;
	public $dsp_szamla_sorszam;
	public $dsp_proforma_datum;
	public $dsp_proforma_sorszam;

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
			array('megrendeles_tetel_id, taskaszam, hatarido, munka_beerkezes_datum, taska_kiadasi_datum, elkeszulesi_datum, ertesitesi_datum, nyomas_tipus, file_beerkezett, ctp_nek_atadas_datum, ctp_kezdes_datum, jovahagyas, ctp_kesz_datum, nyomas_kezdes_datum, raktarbol_kiadva_datum, szallitolevel_datum, szamla_datum, sztornozva, torolt', 'required'),
			array('ctp, film, sos, szin_c_elo, szin_m_elo, szin_y_elo, szin_k_elo, szin_c_hat, szin_m_hat, szin_y_hat, szin_k_hat, szin_mutaciok, szin_mutaciok_szam, kifuto_bal, kifuto_fent, kifuto_jobb, kifuto_lent, forditott_levezetes, hossziranyu_levezetes, gep_id, munkatipus_id, max_fordulat, kifutos, fekete_flekkben_szin_javitando, magas_szinterheles_nagy_feluleten, magas_szinterheles_szovegben, ofszet_festek, nyomas_minta_szerint, nyomas_vagojel_szerint, nyomas_domy_szerint, gepindulasra_jon_ugyfel, nyomhato sztornozva, nyomtatva_taska, nyomtatva_ctp_taska, torolt', 'numerical', 'integerOnly'=>true),
			array('megrendeles_tetel_id', 'length', 'max'=>10),
			array('taskaszam, szallitolevel_sorszam', 'length', 'max'=>12),
			array('kep_file_nev', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true, 'safe' => false),
			array('kep_file_nev', 'length', 'max'=>255, 'on'=>'insert,update'),
			array('pantone, szin_pantone, utannyomas_valtoztatassal, utasitas_ctp_nek, utasitas_gepmesternek, kiszallitasi_informaciok, ctp_belenyulasok, ctp_hibalista', 'length', 'max'=>255),
			array('szamla_sorszam, jovahagyas, erkezett', 'length', 'max'=>15),
			array('szin_mutaciok_szam', 'length', 'max'=>3),
			array('nyomas_tipus', 'length', 'max'=>29),
			array('nyomas_specialis', 'length', 'max'=>200),
			array('sztornozas_oka', 'length', 'max'=>255),
			
			array('szin_pantone', 'check_szinek_szama'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, megrendeles_tetel_id, taskaszam, hatarido, munka_beerkezes_datum, taska_kiadasi_datum, elkeszulesi_datum, ertesitesi_datum, szallitolevel_sorszam, szallitolevel_datum, szamla_sorszam, szamla_datum, sos, film, szin_mutaciok, kifuto_bal, kifuto_fent, kifuto_jobb, kifuto_lent, forditott_levezetes, hossziranyu_levezetes, nyomas_tipus, utannyomas_valtoztatassal, utasitas_ctp_nek, utasitas_gepmesternek, kiszallitasi_informaciok, gep_id, munkatipus_id, max_fordulat, kifutos, fekete_flekkben_szin_javitando, magas_szinterheles_nagy_feluleten, magas_szinterheles_szovegben, ofszet_festek, nyomas_minta_szerint, nyomas_vagojel_szerint, nyomas_specialis, gepindulasra_jon_ugyfel, ctp_nek_atadas_datum, file_beerkezett, ctp_kezdes_datum, ctp_belenyulasok, ctp_hibalista, jovahagyas, ctp_kesz_datum, nyomas_kezdes_datum, raktarbol_kiadva_datum, sztornozva, munkanev_search, megrendelonev_search, boritek_tipus_search, darabszam_tol_search, darabszam_ig_search, szinszam1_tol_search, szinszam1_ig_search, szinszam2_tol_search, szinszam2_ig_search, taskat_rogzito_user_id, torolt', 'safe', 'on'=>'search'),
		);
	}

	
	// LI : A színek számát összevetni a megadott színek számával, ha nem egyezik, jelezni. Max. 8 db panton szín adható meg. A színek számának ellenőrzésekor a panton színek is számítanak.
	public function check_szinek_szama ($attribute)
	{
		// read-only mezőbe található össz színek száma
		$megadott_szinek_szama = 0;
		
		// a nyomdakönyvön a user által megadott össz színek száma
		$szinek_szama = 0;
		
		$megrendeles_tetel =  MegrendelesTetelek::model()->findByPk($this->megrendeles_tetel_id);
		if ($megrendeles_tetel != null) {
			try {
				$panton_szinek = explode(',', $this->szin_pantone);
				if (is_array($panton_szinek)) {
					// összesen max. 8 panton színt lehet felvenni, ezt is itt ellenőrzöm
					foreach ($panton_szinek as $szin) {
						if (trim($szin) != '') {
							$szinek_szama += 1;
						}
					}
					
					if ($szinek_szama > 8) {
						$this->addError($attribute, 'Max. 8 db panton szín adható meg!');
					}
				}

				$megadott_szinek_szama = $megrendeles_tetel->szinek_szama1 + $megrendeles_tetel->szinek_szama2;
				
				if ($this->szin_c_elo == 1) $szinek_szama += 1;
				if ($this->szin_m_elo == 1) $szinek_szama += 1;
				if ($this->szin_y_elo == 1) $szinek_szama += 1;
				if ($this->szin_k_elo == 1) $szinek_szama += 1;
				if ($this->szin_c_hat == 1) $szinek_szama += 1;
				if ($this->szin_m_hat == 1) $szinek_szama += 1;
				if ($this->szin_y_hat == 1) $szinek_szama += 1;
				if ($this->szin_k_hat == 1) $szinek_szama += 1;
				
				if ($megadott_szinek_szama != $szinek_szama) {
					$this->addError($attribute, 'A színek száma nem egyezik a megadott színek számával!');
				}
				
			} catch (Exception $e) {}
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
			'megrendeles_tetel' => array(self::BELONGS_TO, 'MegrendelesTetelek', 'megrendeles_tetel_id'),
			'gep' => array(self::BELONGS_TO, 'Nyomdagepek', 'gep_id'),
			'munkatipus' => array(self::BELONGS_TO, 'NyomdaMunkatipusok', 'munkatipus_id'),
			'lejelentes_sorok' => array(self::HAS_MANY, 'NyomdakonyvLejelentes', 'nyomdakonyv_id'),
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
			'pantone' => 'Színek megnevezése (Pantone), vesszőkkel elválasztva',
			'szin_pantone' => 'Pantone',
			'munka_beerkezes_datum' => 'Munka beerkezés dátum',
			'taska_kiadasi_datum' => 'Táska kiadási dátum',
			'elkeszulesi_datum' => 'Elkészülési dátum',
			'ertesitesi_datum' => 'Értesítési dátum',
			'szallitolevel_sorszam' => 'Szállitólevél sorszám',
			'szallitolevel_datum' => 'Szállitólevél dátum',
			'szamla_sorszam' => 'Számla sorszám',
			'szamla_datum' => 'Számla dátum',
/*			'proforma_szama' => 'Proforma száma',
			'proforma_datuma' => 'Proforma dátuma',*/
			'ctp' => 'CTP',
			'sos' => 'SOS',
			'film' => 'Film',
			'szin_c_elo' => '(C)yan',
			'szin_m_elo' => '(M)agenta',
			'szin_y_elo' => '(Y)ellow',
			'szin_k_elo' => 'Blac(K)',
			'szin_c_hat' => '(C)yan',
			'szin_m_hat' => '(M)agenta',
			'szin_y_hat' => '(Y)ellow',
			'szin_k_hat' => 'Blac(K)',
			'szin_mutaciok' => 'Mutáció',
			'szin_mutaciok_szam' => 'Színszám',
			'kifuto_bal'  => '',
			'kifuto_fent' => '',
			'kifuto_jobb' => '',
			'kifuto_lent' => '',
			'forditott_levezetes' => 'Fordított levezetés',
			'hossziranyu_levezetes' => 'Hosszirányú levezetés',
			'nyomas_tipus' => 'Nyomás típusa',
			'utannyomas_valtoztatassal' => 'Utánnyomás változtatással',
			'utasitas_ctp_nek' => 'Utasítás CTP-nek',
			'utasitas_gepmesternek' => 'Utasítás gépmesternek',
			'kiszallitasi_informaciok' => 'Kiszállítasi információk',
			'gep_id' => 'Gép',
			'munkatipus_id' => 'Munkatípus',
			'max_fordulat' => 'Maximális fordulatszám',
			'erkezett' => 'Érkezett',
			'file_beerkezett' => 'File beérkezett',
			'kifutos' => 'Kifutós',
			'fekete_flekkben_szin_javitando' => 'Fekete flekkben szín javítandó',
			'magas_szinterheles_nagy_feluleten' => 'Magas színterhelés nagy felületen',
			'magas_szinterheles_szovegben' => 'Magas színterhelés szövegben',
			'ofszet_festek' => 'Ofszet festék',
			'nyomas_minta_szerint' => 'Nyomás minta szerint',
			'nyomas_vagojel_szerint' => 'Nyomás vágójel szerint',
			'nyomas_domy_szerint' => 'Nyomás Domy szerint',
			'nyomas_specialis' => 'Nyomás speciális',
			'gepindulasra_jon_ugyfel' => 'Gépindulásra jön az ügyfél',
			'ctp_nek_atadas_datum' => 'CTP-nek átadva',
			'ctp_kezdes_datum' => 'CTP-kezdés',
			'ctp_belenyulasok' => 'CTP-belenyúlások',
			'ctp_hibalista' => 'CTP-hibalista',
			'jovahagyas' => 'Jováhagyás jött',
			'nyomhato' => 'Nyomható',
			'ctp_kesz_datum' => 'CTP-kész',
			'nyomas_kezdes_datum' => 'Nyomás elkezdve',
			'raktarbol_kiadva_datum' => 'Raktárból kiadva',
			'kep_file_nev' => 'Kép csatolása',
			'sztornozas_oka' => 'Sztornózás oka',
			'sztornozva' => 'Sztornózva',
			'torolt' => 'Törölt',
			
			'display_normaido' => 'Normaidő',
			'display_normaar' => 'Normaár',
			'darabszam_tol_search' =>'Darabszám -tól',
			'darabszam_search' =>'Darabszám tól-ig',
			'szinszam1_search' => 'Előoldal színszám tól-ig',
			'szinszam2_search' => 'Hátoldal színszám tól-ig',
			'folyamatban_levo_muvelet' => 'Folyamatban lévő művelet',
			'varhato_befejezes' => 'Várható befejezés',
			'kesz_jo' => 'Jó termék',
			'kesz_selejt' => 'Selejt',
			'kesz_visszazu' => 'VisszaZu',

			'DisplayKifutok' =>	'Kifutó',
			'HataridoFormazott' => 'Határidő',
			'GyartasiIdo' => 'Gyártási idő',
			'UtemezesBejegyzesPrint' => 'Munka részletek',
			'SzinErtekek' => 'Színek',
			
			'dsp_szallitolevel_datum' => 'Szállítólevél dátuma',
			'dsp_szallitolevel_sorszam' => 'Szállítólevél sorszáma',
			'dsp_szamla_datum' => 'Számla dátuma',
			'dsp_szamla_sorszam' => 'Számla sorszáma',
			'dsp_proforma_datum' => 'Proforma számla dátuma',
			'dsp_proforma_sorszam' => 'Profoma számla sorszáma',
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

		$criteria->together = true;
		$criteria->with = array('megrendeles_tetel', 'megrendeles_tetel.termek.zaras', 'megrendeles_tetel.megrendeles', 'megrendeles_tetel.megrendeles.ugyfel');

		$criteria->compare('taskaszam',$this->taskaszam,true);
		$criteria->compare('megrendeles_tetel.munka_neve', $this->munkanev_search, true );
		$criteria->compare('cegnev', $this->megrendelonev_search, true );
		$criteria->compare('zaras.nev', $this->boritek_tipus_search, true );
		
		$darabszam_tol = ($this->darabszam_tol_search != '') ? $this->darabszam_tol_search : 0;
		$darabszam_ig = ($this->darabszam_ig_search != '') ? $this->darabszam_ig_search : 99999999;
		$criteria->addCondition('megrendeles_tetel.darabszam >= ' . $darabszam_tol . ' AND megrendeles_tetel.darabszam <= ' . $darabszam_ig);
		
		$szinszam1_tol = ($this->szinszam1_tol_search != '') ? $this->szinszam1_tol_search : 0;
		$szinszam1_ig = ($this->szinszam1_ig_search != '') ? $this->szinszam1_ig_search : 9;
		$criteria->addCondition('megrendeles_tetel.szinek_szama1 >= ' . $szinszam1_tol . ' AND megrendeles_tetel.szinek_szama1 <= ' . $szinszam1_ig);
		
		$szinszam2_tol = ($this->szinszam2_tol_search != '') ? $this->szinszam2_tol_search : 0;
		$szinszam2_ig = ($this->szinszam2_ig_search != '') ? $this->szinszam2_ig_search : 9;
		$criteria->addCondition('megrendeles_tetel.szinek_szama2 >= ' . $szinszam2_tol . ' AND megrendeles_tetel.szinek_szama2 <= ' . $szinszam2_ig);
		
		/*
		$criteria->compare('id',$this->id,true);
		$criteria->compare('megrendeles_tetel_id',$this->megrendeles_tetel_id,true);
		$criteria->compare('hatarido',$this->hatarido,true);
		$criteria->compare('pantone',$this->pantone,true);
		$criteria->compare('szin_pantone',$this->szin_pantone,true);
		$criteria->compare('munka_beerkezes_datum',$this->munka_beerkezes_datum,true);
		$criteria->compare('taska_kiadasi_datum',$this->taska_kiadasi_datum,true);
		$criteria->compare('elkeszulesi_datum',$this->elkeszulesi_datum,true);
		$criteria->compare('ertesitesi_datum',$this->ertesitesi_datum,true);
		$criteria->compare('szallitolevel_sorszam',$this->szallitolevel_sorszam,true);
		$criteria->compare('szallitolevel_datum',$this->szallitolevel_datum,true);
		$criteria->compare('szamla_sorszam',$this->szamla_sorszam,true);
		$criteria->compare('szamla_datum',$this->szamla_datum,true);
		$criteria->compare('ctp',$this->ctp);
		$criteria->compare('sos',$this->sos);
		$criteria->compare('szin_c_elo',$this->szin_c_elo);
		$criteria->compare('szin_m_elo',$this->szin_m_elo);
		$criteria->compare('szin_y_elo',$this->szin_y_elo);
		$criteria->compare('szin_k_elo',$this->szin_k_elo);
		$criteria->compare('szin_c_hat',$this->szin_c_hat);
		$criteria->compare('szin_m_hat',$this->szin_m_hat);
		$criteria->compare('szin_y_hat',$this->szin_y_hat);
		$criteria->compare('szin_k_hat',$this->szin_k_hat);
		$criteria->compare('szin_mutaciok',$this->szin_mutaciok);
		$criteria->compare('szin_mutaciok_szam',$this->szin_mutaciok_szam);
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
		$criteria->compare('munkatipus_id',$this->munkatipus_id);
		$criteria->compare('max_fordulat',$this->max_fordulat);
		$criteria->compare('erkezett',$this->erkezett);
		$criteria->compare('file_beerkezett',$this->file_beerkezett);
		$criteria->compare('kifutos',$this->kifutos);
		$criteria->compare('fekete_flekkben_szin_javitando',$this->fekete_flekkben_szin_javitando);
		$criteria->compare('magas_szinterheles_nagy_feluleten',$this->magas_szinterheles_nagy_feluleten);
		$criteria->compare('magas_szinterheles_szovegben',$this->magas_szinterheles_szovegben);
		$criteria->compare('ofszet_festek',$this->ofszet_festek);
		$criteria->compare('nyomas_minta_szerint',$this->nyomas_minta_szerint);
		$criteria->compare('nyomas_vagojel_szerint',$this->nyomas_vagojel_szerint);
		$criteria->compare('nyomas_domy_szerint',$this->nyomas_domy_szerint);
		$criteria->compare('nyomas_specialis',$this->nyomas_specialis,true);
		$criteria->compare('gepindulasra_jon_ugyfel',$this->gepindulasra_jon_ugyfel);
		$criteria->compare('ctp_nek_atadas_datum',$this->ctp_nek_atadas_datum,true);
		$criteria->compare('ctp_kezdes_datum',$this->ctp_kezdes_datum,true);
		$criteria->compare('ctp_belenyulasok',$this->ctp_belenyulasok,true);
		$criteria->compare('ctp_hibalista',$this->ctp_hibalista,true);
		$criteria->compare('jovahagyas',$this->jovahagyas,true);
		$criteria->compare('ctp_kesz_datum',$this->ctp_kesz_datum,true);
		$criteria->compare('nyomhato',$this->nyomhato,true);
		$criteria->compare('nyomas_kezdes_datum',$this->nyomas_kezdes_datum,true);
		$criteria->compare('raktarbol_kiadva_datum',$this->raktarbol_kiadva_datum,true);
		$criteria->compare('sztornozas_oka',$this->sztornozas_oka,true);
		$criteria->compare('sztornozva',$this->sztornozva);
		*/
		
		// LI: logikailag törölt sorok ne jelenjenek meg, ha a belépett user nem az 'Admin'
		if (!Yii::app()->user->checkAccess('Admin'))
			$criteria->compare('t.torolt', 0, false);
	
		// id szerint csökkenő sorrendben kérdezzük le az adatokat, így biztos, hogy a legújabb lesz legfelül
		$criteria->order = 't.id DESC';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>Utils::getIndexPaginationNumber(),)
		));
	}

	// LI: miután betöltöttük a model-t az adatbázisból megnézzük, hogy van-e hozzá
	// szálítólevél, számla ill proforma és ha igen, kiírjük a dátum és sorszám mezőket
	protected function afterFind() {
		parent::afterFind();
		
		$megrendeles_tetel = MegrendelesTetelek::model()->findByPk($this->megrendeles_tetel_id);
		$megrendeles = null;
		
		if ($megrendeles_tetel != null) {
			$megrendeles = Megrendelesek::model()->findByPk($megrendeles_tetel->megrendeles_id);
		}
		
		if ($megrendeles != null && $megrendeles_tetel != null) {
			// szállítólevelek keresése
			$szallitolevelek = Szallitolevelek::model()->findAllByAttributes(array('megrendeles_id' => $megrendeles->id));
			if ($szallitolevelek != null) {
				foreach($szallitolevelek as $szallito) {
					$szallitolevel_tetelek = $szallito -> tetelek;
					
					if (is_array($szallitolevel_tetelek)) {
						foreach($szallitolevel_tetelek as $tetel) {
							if ($tetel->megrendeles_tetel_id == $this->megrendeles_tetel_id) {
								$this->dsp_szallitolevel_datum .= (strlen($this->dsp_szallitolevel_datum) > 0 ? ', ' : '') . $szallito->datum ;
								$this->dsp_szallitolevel_sorszam .= (strlen($this->dsp_szallitolevel_sorszam) > 0 ? ', ' : '') . $szallito->sorszam ;
							}
						}
					}
				}
			}

			// számla keresése
			$this -> dsp_szamla_datum = $megrendeles -> rendeles_idopont;
			$this -> dsp_szamla_sorszam = $megrendeles -> szamla_sorszam;

			// proforma számla keresése
			$this -> dsp_proforma_datum = $megrendeles ->proforma_kiallitas_datum;
			$this -> dsp_proforma_sorszam = $megrendeles -> proforma_szamla_sorszam;
		}
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
	
	//Kifutós információkat egy stringben visszaadjuk
	public function getDisplayKifutok() {
		$return = "" ;
		if ($this->kifuto_fent != "" && $this->kifuto_fent != 0)
			$return .= "F " ;			
		if ($this->kifuto_bal != "" && $this->kifuto_bal != 0)
			$return .= "B " ;			
		if ($this->kifuto_jobb != "" && $this->kifuto_jobb != 0)
			$return .= "J " ;			
		if ($this->kifuto_lent != "" && $this->kifuto_lent != 0)
			$return .= "A " ;
		return trim($return) ;
	}
	
	//Határidő visszaadása formázott módon
	public function getHataridoFormazott() {
		return Yii::app()->dateFormatter->format("yyyy.MM.dd EEEE",$this->hatarido);
	}
	
	//Várható gyártási idő visszaadása formázott módon. A normaszámításból jön az idő
	public function getGyartasiIdo() {
		$norma = Utils::getNormaadat($this->megrendeles_tetel_id, $this->gep_id, $this->munkatipus_id, $this->max_fordulat);
		return $norma ;
	}
	
	//A nyomdai munkánál megadott színkódokat, színeket adja vissza listában, nyomtatásban megjelenítéshez
	public function getSzinErtekek() {
		$return = "" ;
		$cmyk = "CMYK" ;
		$szin_elooldali = $this->szin_c_elo . $this->szin_m_elo . $this->szin_y_elo . $this->szin_k_elo ;
		$szin_hatoldali = $this->szin_c_hat . $this->szin_m_hat . $this->szin_y_hat . $this->szin_k_hat ;
		for ($i = 0; $i < 4; $i++) {
			if ($szin_elooldali[$i] == 1)
				$szin_elooldali[$i] = $cmyk[$i] ;
			if ($szin_hatoldali[$i] == 1)
				$szin_hatoldali[$i] = $cmyk[$i] ;
		}
		$szin_elooldali = str_replace("0", "", $szin_elooldali) ;
		$szin_hatoldali = str_replace("0", "", $szin_hatoldali) ;
		$szin_pantone = $this->szin_pantone ;
		if ($szin_elooldali != "") {
			$return .= $szin_elooldali . ", " ;
		}
		if ($szin_hatoldali != "") {
			$return .= $szin_hatoldali . ", " ;
		}
		if ($szin_pantone != "") {
			$return .= $szin_pantone ;
		}
		return rtrim($return, ", ") ;
	}
	
	//Az ütemezés nyomtatáshoz az egyes rekordokból csinál egy kompakt html blokkot olyan elrendezéssel, ahogy meg kell jelennie a nyomtatási képen
	public function getUtemezesBejegyzesPrint() {
		$ctp_vagy_film = "CTP" ;
		if ($this->film == "1") {
			$ctp_vagy_film = "FILM" ;	
		}
		$html = '<table style="width:800px;" class="blokk_table">' ;
		$html .= '<tr><td class="utemezes_elso_oszlop">&nbsp;</td><td class="utemezes_cegnev"><strong>' . $this->megrendeles_tetel->megrendeles->ugyfel->cegnev . '</strong></td><td class="utemezes_ctp_film">' . $ctp_vagy_film . '</td><td class="utemezes_ctp_input_td" style="width:180px;border: 1px solid #000000;">&nbsp;</td></tr>' ;
		$html .= '<tr><td class="utemezes_elso_oszlop utemezes_taskaszam">' . $this->taskaszam . '</td><td colspan="2" class="utemezes_munka_neve">' . $this->megrendeles_tetel->munka_neve . '</td><td class="utemezes_ctpnek_atadva">CTP-nek átadva: &nbsp;&nbsp;&nbsp;. &nbsp;&nbsp;&nbsp;. &nbsp;&nbsp;&nbsp; 0,00</td></tr>' ;
		$html .= '<tr><td class="utemezes_elso_oszlop kisbetu utemezes_kifutok">' . $this->getDisplayKifutok() . '</td><td colspan="3" class="utemezes_termeknev kisbetu">' . $this->megrendeles_tetel->megrendelt_termek_nev . '</td></tr>' ;
//		$html .= '<tr><td class="utemezes_elso_oszlop utemezes_taska">Táska OK</td><td class="utemezes_szinek_szama kisbetu" colspan="3">' . $this->megrendeles_tetel->displayTermekSzinekSzama . ' &nbsp;&nbsp;&nbsp;&nbsp; ' . $this->megrendeles_tetel->DarabszamFormazott . ' db&nbsp;&nbsp;&nbsp;&nbsp; ' . $this->getGyartasiIdo() . '</td></tr>' ;
		$html .= '<tr><td class="utemezes_elso_oszlop utemezes_taska">Táska OK</td><td class="utemezes_szinek_szama kisbetu" colspan="3">' . $this->megrendeles_tetel->displayTermekSzinekSzama . ' &nbsp;&nbsp;&nbsp;&nbsp; ' . $this->getSzinErtekek() . ' &nbsp;&nbsp;&nbsp;&nbsp; ' . $this->megrendeles_tetel->DarabszamFormazott . ' db&nbsp;&nbsp;&nbsp;&nbsp; ' . $this->getGyartasiIdo() . '</td></tr>' ;
		$html .= '</table>' ;
		return $html;
	}
	
	// LI: visszaadja, hogy a nyomdakönyvi munka szerepel-e a negatív raktárkészletben
	public function isInNegativRkatarTermekek () {
		$negativRaktarTermek = RaktarTermekekNegativ::model() -> findByAttributes(array('nyomdakonyv_id' => $this ->id));
		
		return $negativRaktarTermek != null;
	}
	
}


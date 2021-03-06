<?php

	// LI: általános(abb)an használt metódusok gyűjteménye
	class Utils
	{
	
		// LI: Paraméterben kapott integer-t alakít át szöveggé (ár szöveggel történő kiírásához kell)
		function num2text($nsz) {
		   
		$hatv=array('','ezer','millió','milliárd','billió','billiárd','trillió','trilliárd','kvadrillió','kvadrilliárd','kvintillió','kvintilliárd','szextillió', 'szextilliárd','szeptillió','szeptilliárd','oktillió','oktilliárd',			'nonillió','nonilliárd','decillió','decilliárd','centillió');
		   
		$tizesek=array('','','harminc','negyven','ötven','hatvan','hetven','nyolcvan','kilencven');
		   
		$szamok=array('egy','kettő','három','négy','öt','hat','hét','nyolc','kilenc');
			$tsz='';
			$ej=($nsz<0?'- ':'');
			$sz=trim(''.floor($nsz));
			$hj=0;
			if ($sz=='0') {
			$tsz='nulla';
			} else {
			while ($sz>'') {
				$hj++;
				$t='';
				$wsz=substr('00'.substr($sz,-3),-3);
				$tizesek[0]=($wsz[2]=='0'?'tíz':'tizen');
				$tizesek[1]=($wsz[2]=='0'?'húsz':'huszon');
				if ($c=$wsz[0]) {
				$t=$szamok[$c-1].'száz';
				}
				if ($c=$wsz[1]) {
				$t.=$tizesek[$c-1];
				}
				if ($c=$wsz[2]) {
				$t.=$szamok[$c-1];
				}
		//        $tsz=($t?$t.$hatv[$hj-1]:'').($tsz==''?'':'-').$tsz;
		$tsz=($t?$t.$hatv[$hj-1]:'').($tsz==''?'':($nsz>2000?'-':'')).$tsz;
				$sz=substr($sz,0,-3);
			}
			}
			return $ej.$tsz;
		}
		
		// LI: Paraméterben kap egy anyagrendelést és egy anyagbeszállítást. Végigmegy a rajtuk található
		//	   tételeken (rendelt tétel + darabszám) és ellenőrzi, hogy megegyeznek-e. Ha valami eltérés van
		//	   a tételek között, akkor hibaüzenetet ad vissza, egyébként egy üres string-et.
		//	   Az anyagrendelés vizsgálatakor az IRODA által átvett és a RAKTÁR által átvett táblákat is ellenőrzi.
		// TÁ: Módosítás: a sikerességet jelző mező TRUE visszatéréshez tehát az kell, hogy az anyagbeszállításon (iroda és raktár is) egyezzenek a tételek és darabszámok, az anyagrendeléshez képesti eltérést egy tömbben visszaadjuk
		// TÁ: Bővül a funkcionalitás annyival, hogy ha van anyagrendelés, akkor visszaadja az anyagrendeléshez képesti eltérést egy tömbben
		//	   Így ha kell, létrehozható egy új megrendelés automatikusan a hiányzó tételekkel
		function checkAnyagrendelesBeszallitas ($anyagrendeles_id, $anyagbeszallitas_id) {
			$anyagrendeles = Anyagrendelesek::model()->findByPk($anyagrendeles_id);
			$anyagbeszallitas = Anyagbeszallitasok::model()->findByPk($anyagbeszallitas_id);	
			$anyagrendeles_beszallitas_tetel_elteresek = array() ;			
			$return["uzenet"] = "" ;
			$return["tetel_elteresek"] = array() ;
			$return["ok"] = true ;
			$return['hozott_boritek'] = 0;
			
			// ha az anyagrendelés ID hibás volt, akkor hibaüzenettel kilépek
			// LI: új igény: ha nincs anyagrendelés megadva akkor csak az iroda és raktár által átvetteket hasonlítjuk egymáshoz
			//if ($anyagrendeles == null) return "Hibás anyagrendelés azonosító!";

			if ($anyagbeszallitas != null) {
				// anyagbeszállítás tételeinek lekérdezése
				// iroda
				$anyagbeszallitas_iroda_termekek = AnyagbeszallitasTermekekIroda::model()->findAllByAttributes(array('anyagbeszallitas_id' => $anyagbeszallitas->id));
				// raktár
				$anyagbeszallitas_raktar_termekek = AnyagbeszallitasTermekek::model()->findAllByAttributes(array('anyagbeszallitas_id' => $anyagbeszallitas->id));

				// először ellenőrzöm, hogy a tételek száma egyáltalán egyezik-e az irodai és raktáros listán, ha nem, akkor hibaüzenettel kilépek
				if ( count($anyagbeszallitas_iroda_termekek) == count($anyagbeszallitas_raktar_termekek) ) {
					// végigmegyek az anyagbeszállítás irodás listáján és ha bármi eltérést találok a raktáros listában, hibaüzenettel kilépek
					foreach ($anyagbeszallitas_iroda_termekek as $anyagbeszallitas_iroda_termek) {
						$foundMatch = false;
						foreach ($anyagbeszallitas_raktar_termekek as $anyagbeszallitas_raktar_termek) {
							if ($anyagbeszallitas_iroda_termek->termek_id == $anyagbeszallitas_raktar_termek->termek_id && $anyagbeszallitas_iroda_termek->darabszam == $anyagbeszallitas_raktar_termek -> darabszam &&
								$anyagbeszallitas_iroda_termek->nyomdakonyv_id == $anyagbeszallitas_raktar_termek -> nyomdakonyv_id) {

								// ha bármelyik tétel hozott borítékosan van jelölve, akkor elmentjük egy flag-ban
								if ($anyagbeszallitas_iroda_termek->hozott_boritek == 1) {
									$return['hozott_boritek'] = 1;
								}
								
								$foundMatch = true;
								break;
							}
						}
						if (!$foundMatch) {
							$return["uzenet"] = "Eltérés található az iroda és a raktár által felvett anyaglistán. További információhoz használja a <strong><a href='" . Yii::app()->createUrl("raktareltereslista/index") . "' target='_blank'>Raktár eltéréslista</a></strong> nézetet.";
							$return["ok"] = false ;
							return $return ;								
						}
					}
				} else {
					$return["uzenet"] = "Eltérés található az iroda vagy a raktár által átvett rendelési tételek között. További információhoz használja a <strong><a href='" . Yii::app()->createUrl("raktareltereslista/index") . "' target='_blank'>Raktár eltéréslista</a></strong> nézetet.";
					$return["ok"] = false ;
					return $return ;						
				}		

				if ($anyagrendeles != null) {
					// ha az anyagbeszállítás ID üres, akkor megnézem, hogy tartozik-e a megrendeléshez beszállítás,
					// ha igen, akkor dolgozom tovább azzal, ha nem, akkor hibaüzenettel kilépek
					if ($anyagbeszallitas == null) {
						$anyagbeszallitas = Anyagbeszallitasok::model() -> findByAttributes(array('anyagrendeles_id' => $anyagrendeles->id));
						
						if ($anyagbeszallitas == null) {
							$return["uzenet"] = "Hibás anyagbeszállítás azonosító!";
							$return["ok"] = false ;
							return $return ;
						}
					}
				
					// anyagrendelés tételeinek lekérdezése
					$anyagrendeles_termekek = AnyagrendelesTermekek::model()->findAllByAttributes(array('anyagrendeles_id' => $anyagrendeles->id));
					
					// először ellenőrzöm, hogy a tételek száma egyáltalán egyezik-e az irodai és a raktáros beszállítás listáján, ha nem, akkor hibaüzenettel kilépek
					if (count($anyagbeszallitas_iroda_termekek) == count($anyagbeszallitas_raktar_termekek)) {
						// végigmegyek az anyagrendelés tételein és ha bármi eltérést találok, hibaüzenettel kilépek
						foreach ($anyagrendeles_termekek as $anyagrendeles_termek) {
							$res = Utils::searchAnyagbeszallitasIrodaRaktarTetel ($anyagrendeles_termek, $anyagbeszallitas_iroda_termekek, $anyagbeszallitas_raktar_termekek);
							if (is_numeric($res)) {
								$anyagrendeles_beszallitas_tetel_elteresek_sor = array() ;
								$anyagrendeles_beszallitas_tetel_elteresek_sor["termek"] = $anyagrendeles_termek ;
								$anyagrendeles_beszallitas_tetel_elteresek_sor["db"] = $res ;
								$anyagrendeles_beszallitas_tetel_elteresek[] = $anyagrendeles_beszallitas_tetel_elteresek_sor ;
							}
							elseif ($res != "") {
								$return["uzenet"] = $res ;
								$return["ok"] = false ;
								return $return;
							}
							
						}
						if (count($anyagrendeles_beszallitas_tetel_elteresek) > 0) {
							$return["uzenet"] = "Eltérés volt az anyagrendeléshez képest a beszállított tételekben." ;
							$return["tetel_elteresek"] = $anyagrendeles_beszallitas_tetel_elteresek ;
							$return["ok"] = true ;
							return $return ;
						}
					} else {
						$return["uzenet"] = "Eltérés található az iroda és a raktár által átvett tételek között. További információhoz használja a <strong><a href='" . Yii::app()->createUrl("raktareltereslista/index") . "' target='_blank'>Raktár eltéréslista</a></strong> nézetet.";
						$return["ok"] = false ;
						return $return ;						
					}
				}

			} else {
				$return["uzenet"] = "Anyagrendelés.";
				$return["ok"] = false;
				return $return ;
			}
		
			return $return ;
		}
		
		// LI: paraméterben kap egy anyagrendelés tételt és két anyagbeszállítás listát (iroda, raktár).
		//	   A kapott anyagbeszállítás listákon végigmegy és ha nem találja bennük az anyagrendelés tételt hibával tér vissza.
		// TÁ: Módosítás: az eltérés darabszámát adja vissza, ha nincs benne egyáltalán, akkor a teljes megrendelt darabszámot
		function searchAnyagbeszallitasIrodaRaktarTetel ($anyagrendeles_termek, $anyagbeszallitas_iroda_termekek, $anyagbeszallitas_raktar_termekek) {
			$termek_id = $anyagrendeles_termek -> termek_id;
			$darabszam = $anyagrendeles_termek -> rendelt_darabszam;
			$iroda_elteres_darabszam = $raktar_elteres_darabszam = 0 ;

			// először az iroda által felvett listán megyünk végig
			$foundInIroda = false;

			foreach ($anyagbeszallitas_iroda_termekek as $anyagbeszallitas_iroda_termek) {
				if ($anyagbeszallitas_iroda_termek->termek_id == $termek_id) {
					$foundInIroda = true;
					break;
				}
			}
			if ($foundInIroda) {
				$iroda_elteres_darabszam = $darabszam - $anyagbeszallitas_iroda_termek->darabszam ;
			}
			else
			{
				$iroda_elteres_darabszam = $darabszam ;
			}
			

//			if (!$foundInIroda) return "Eltérés található az iroda által felvett anyaglistán. További információhoz használja a <strong><a href='" . Yii::app()->createUrl("raktareltereslista/index") . "' target='_blank'>Raktár eltéréslista</a></strong> nézetet.";
			
			// ezután a raktár által felvett listát vizsgáljuk
			$foundInRaktar = false;
			foreach ($anyagbeszallitas_raktar_termekek as $anyagbeszallitas_raktar_termek) {
				if ($anyagbeszallitas_raktar_termek->termek_id == $termek_id) {
					$foundInRaktar = true;
					break;
				}
			}
			if ($foundInRaktar) {
				$raktar_elteres_darabszam = $darabszam - $anyagbeszallitas_raktar_termek->darabszam ;
			}
			else
			{
				$raktar_elteres_darabszam = $darabszam ;
			}
			
			if ($iroda_elteres_darabszam != $raktar_elteres_darabszam) return "Eltérés található az iroda és raktár által felvett anyaglistán. További információhoz használja a <strong><a href='" . Yii::app()->createUrl("raktareltereslista/index") . "' target='_blank'>Raktár eltéréslista</a></strong> nézetet.";
			
			if ($iroda_elteres_darabszam < 0) {
				$iroda_elteres_darabszam = 0 ;	
			}
			
			if ($iroda_elteres_darabszam == 0) {
				$iroda_elteres_darabszam = "" ;	
			}
			
			return $iroda_elteres_darabszam;
		}
	
		// LI: archív termékár lekérdezése egy raktárban lévő termékhez az anyagbeszállítás tételéből
		function getArchiveTermekar ($anyagbeszallitas_id, $termek_id) {
			if ($anyagbeszallitas_id != null && $anyagbeszallitas_id != 0 && $termek_id != null && $termek_id != 0) {
				$anyagbeszallitasTermek = AnyagbeszallitasTermekek::model()->findByAttributes(array('anyagbeszallitas_id' => $anyagbeszallitas_id, 'termek_id' => $termek_id));
				
				return ($anyagbeszallitasTermek != null) ? $anyagbeszallitasTermek->netto_darabar : 0;
			}
			
			return 0;
		}
	
		// LI: egy paraméterben kapott termék aktuálisan aktív termékárát adja vissza
		// TÁ: Bővítettem a $darabszam, $szinszam1, $szinszam2 opcionális paraméterekkel, amelyek segítségével a felülnyomási árat adhatjuk vissza a natúr darabár helyett, amennyiben kérnek felülnyomást
		function getActiveTermekar ($termek_id, $darabszam = 1, $szinszam1 = 0, $szinszam2 = 0) {
			if ($termek_id != null && $termek_id != 0) {
				$termekAr = Yii::app() -> db -> createCommand  ("SELECT * FROM dom_termek_arak WHERE
												('" . date("Y-m-d") . "' BETWEEN datum_mettol AND datum_meddig) AND (termek_id = $termek_id AND torolt = 0)
												") -> queryRow();

				if ($termekAr != false && $darabszam > 0 && ($szinszam1 > 0 || $szinszam2 > 0)) {
					//Ha van a terméknek érvényes ára és kértek előoldali, vagy hátoldali felülnyomást, akkor a $termekAr módosul a nyomás árával
							$termek_reszletek = Termekek::model()->findByPk($termek_id) ;				
							$termek_meret_adatok = TermekMeretek::model()->findByPk($termek_reszletek->meret_id);	
					
							return $termek_meret_adatok->nev ;
							
							$termekAr = Yii::app() -> db -> createCommand  ("SELECT * FROM dom_nyomasi_arak WHERE
															('" . date("Y-m-d") . "' BETWEEN datum_mettol AND datum_meddig) AND (termek_id = $termek_id AND torolt = 0)
															") -> queryRow();
					
				}
				
				if ($termekAr != false) 
					return $termekAr;			

			}
			
			return 0;
		}
	
		// LI: egy paraméterben kapott termék aktuálisan aktív termékárát adja vissza JSON-ben
		// TÁ: Bővítettem a $darabszam, $szinszam1, $szinszam2 opcionális paraméterekkel, amelyek segítségével a felülnyomási árat adhatjuk vissza a natúr darabár helyett, amennyiben kérnek felülnyomást
		// TÁ: Bővítettem az ugyfel_id paraméterrel is, mert a szorzót is itt kell alkalmazni, már kész árat adunk vissza, nem számolgatunk javascriptben
		// TÁ: Bővítettem a hozott boríték paraméterrel, ha annak értéke 1, akkor nem számoljuk a boríték árát, csak a nyomási munkadíjat
		function getActiveTermekarJSON ($ugyfel_id, $termek_id, $darabszam = 1, $szinszam1 = 0, $szinszam2 = 0, $hozott_boritek = 0, $afakulcs_id = 0) {
			$result = 0;

			$ugyfel_reszletek = Ugyfelek::model()->findByPk($ugyfel_id) ;
			$arkategoria_reszletek = Arkategoriak::model()->findByPk($ugyfel_reszletek["arkategoria"]);
			$szorzo = $arkategoria_reszletek["szorzo"];
			$termekAr["db_ar_nyomashoz"] = 0;
			$netto_osszeg = 0;
			$ar = 0;
			$db_ar = 0;
			$darabszam_szamolashoz = $darabszam ;
/*			if ($darabszam < 1000) {
				$darabszam_szamolashoz = 1000 ;	
			}*/
			
			$afakulcsSzazalek = 0;
			if ($afakulcs_id != null && $afakulcs_id != 0) {
				$afaKulcs = AfaKulcsok::model()->findByPk($afakulcs_id);
				
				if ($afaKulcs != null){
					$afakulcsSzazalek = $afaKulcs->afa_szazalek;
				}
			}
			
			if ($termek_id != null && $termek_id != 0) {
						$termek_reszletek = Termekek::model()->findByPk($termek_id) ;
						$query = "SELECT * FROM dom_termek_arak WHERE
														('" . date("Y-m-d") . "' BETWEEN datum_mettol AND datum_meddig) AND (termek_id = $termek_id AND torolt = 0)
														" ;
						$termekAr = Yii::app() -> db -> createCommand  ($query) -> queryRow();
						$termek_teljes_csomagszam = floor($darabszam_szamolashoz / $termek_reszletek->csom_egys) ;
						$termekSavosCsomagAr = Yii::app() -> db -> createCommand ("SELECT * FROM dom_termek_ar_savos_csomagarak WHERE 
														termek_ar_id = '" . $termekAr["id"] . "' and torolt = 0 and (" . $termek_teljes_csomagszam . " BETWEEN csomagszam_tol AND csomagszam_ig)
														") -> queryRow();
/*						print_r($termekSavosCsomagAr) ;
						die("SELECT * FROM dom_termek_ar_savos_csomagarak WHERE 
														termek_ar_id = '" . $termekAr->id . "' and torolt = 0 and (" . $termek_teljes_csomagszam . " BETWEEN csomagszam_tol AND csomagszam_ig)
														") ;*/
						if ($termek_reszletek->csom_egys <= $darabszam_szamolashoz) {
							if ($termekSavosCsomagAr != null) {
								$db_ar = $termekSavosCsomagAr["csomag_eladasi_ar"] / $termek_reszletek->csom_egys ;
							}
							else
							{
								$db_ar = $termekAr["csomag_eladasi_ar"] / $termek_reszletek->csom_egys ;
							}
						}
						else
						{
							$db_ar = $termekAr["db_eladasi_ar"] ;
						}
			}
			$selejt = $selejt1 = $selejt2 = 0 ;
			$szinszam = max($szinszam1,$szinszam2) ;
			if ($hozott_boritek == 1) {
				$termekAr["db_ar_nyomashoz"] = 0;
			}
			
			if ($termekAr != false && $darabszam_szamolashoz > 0 && ($szinszam > 0)) {
				//Ha van a terméknek érvényes ára és kértek előoldali, vagy hátoldali felülnyomást, akkor a $termekAr módosul a nyomás árával								
				$termek_reszletek = Termekek::model()->findByPk($termek_id) ;
				if ($termek_reszletek->csom_egys <= $darabszam_szamolashoz) {
					if ($termekSavosCsomagAr != null) {
						$db_ar = $termekSavosCsomagAr["csomag_ar_nyomashoz"] / $termek_reszletek->csom_egys ;						
					}
					else
					{
						$db_ar = $termekAr["csomag_ar_nyomashoz"] / $termek_reszletek->csom_egys ;
					}
				}
				else
				{
					$db_ar = $termekAr["db_ar_nyomashoz"] ;	
				}

				$termek_kategoria_tipus = $termek_reszletek["kategoria_tipus"] ;
				$nyomasi_ar_kategoria_tipus = "" ;
				$termek_reszletek = Termekek::model()->findByPk($termek_id) ;
				$termek_kategoria_tipus = $termek_reszletek["kategoria_tipus"] ;
				if ($termek_kategoria_tipus == "") {
					$kifuto = 0 ;	//Ajánlatnál lehet ezt megadni, vagy csak a nyomdakönyvben?					
					$nyomasi_ar_kategoria_tipus = Utils::NyomasiKategoriaSzamol($szinszam1 . "+" . $szinszam2, $darabszam_szamolashoz, $termek_reszletek->tipus, $kifuto);
				}
				$nyomasi_ar_kategoria_tipus = str_replace("/","",$nyomasi_ar_kategoria_tipus) ;
//				echo "tipus: " . $nyomasi_ar_kategoria_tipus ;
				//Itt kérdés, hogy a $szinszam1 + $szinszam2 összege adja ki a színek számát, vagy a nagyobbik érték a kettő közül
				//Alapból most a nagyobbik értéket veszem, aztán meglátjuk
/*				if ($termek_kategoria_tipus == "A") {
					if ($szinszam > 2) {
						$nyomasi_ar_kategoria_tipus = "C" ;
					}
					else {
						$nyomasi_ar_kategoria_tipus = "A" . $szinszam ;	
					}
				}
				else if ($termek_kategoria_tipus == "B") {
					//Itt kérdés, hogy a $szinszam1 + $szinszam2 összege adja ki a színek számát, vagy a nagyobbik érték a kettő közül
					//Alapból most az összegüket veszem, aztán meglátjuk
					if ($szinszam > 2) {
						$nyomasi_ar_kategoria_tipus = "D" ;
					}
					else {
						$nyomasi_ar_kategoria_tipus = "B" . $szinszam ;	
					}							
				}*/
				
				$sql = "SELECT * FROM dom_nyomasi_arak WHERE ('" . $darabszam_szamolashoz . "' BETWEEN peldanyszam_tol AND peldanyszam_ig) AND (kategoria_tipus = '$nyomasi_ar_kategoria_tipus' AND torolt = 0) order by ervenyesseg_tol desc limit 1" ;
//				echo $sql ;
				$nyomasiAr = Yii::app() -> db -> createCommand  ($sql) -> queryRow();
				$nyomasi_ar = 0 ;
//				print_r($nyomasiAr) ;
				if ($nyomasiAr != false) {					
					switch ($szinszam1) {
						case 1: $elooldali_nyomasi_ar = $nyomasiAr["szin_egy"] ;
							break ;
						case 2: $elooldali_nyomasi_ar = $nyomasiAr["szin_ketto"] * $szinszam1 ;
							break ;
						case 3: $elooldali_nyomasi_ar = $nyomasiAr["szin_harom"] * $szinszam1 ;
							break ;
						case 0: $elooldali_nyomasi_ar = 0 ;
							break ;
						default: $elooldali_nyomasi_ar = $nyomasiAr["szin_tobb"] * $szinszam1 ;
					}
					
					switch ($szinszam2) {
						case 1: $hatoldali_nyomasi_ar = $nyomasiAr["szin_egy"] ;
							break ;
						case 2: $hatoldali_nyomasi_ar = $nyomasiAr["szin_ketto"] * $szinszam2 ;
							break ;
						case 3: $hatoldali_nyomasi_ar = $nyomasiAr["szin_harom"] * $szinszam2 ;
							break ;
						case 0: $hatoldali_nyomasi_ar = 0 ;
							break ;
						default: $hatoldali_nyomasi_ar = $nyomasiAr["szin_tobb"] * $szinszam2 ;
					}
					$nyomasi_ar = $elooldali_nyomasi_ar + $hatoldali_nyomasi_ar ;
//					echo $nyomasi_ar ;
				}
				if ($darabszam < 1000) {
					$db_ar = ((($db_ar * $darabszam_szamolashoz) + ($nyomasi_ar * 1000)) / $darabszam) * $szorzo ; 
				}
				else
				{
					$db_ar = ($db_ar + $nyomasi_ar) * $szorzo ;
				}
//				echo $db_ar ;

				//Selejtszámítás a nyomáshoz
				$sql = "SELECT * FROM dom_zuh WHERE ('" . $darabszam_szamolashoz . "' BETWEEN db_tol AND db_ig) AND (nyomasi_kategoria = '$nyomasi_ar_kategoria_tipus' AND torolt = 0 and aktiv = 1)" ;
				$ervenyes_zuh_rekord = Yii::app() -> db -> createCommand  ($sql) -> queryRow();
				if ($ervenyes_zuh_rekord != false) {					
					if ($szinszam1 > 0) {
						if ($szinszam1 > 3) {
							$selejt1 = ($ervenyes_zuh_rekord["szin_" . $szinszam1 . "_db"] > 0 ? $ervenyes_zuh_rekord["szin_" . $szinszam1 . "_db"] * $szinszam1 : $darabszam * ($ervenyes_zuh_rekord["szin_" . $szinszam1 . "_szazalek"] / 100));							
						}
						else
						{
							$selejt1 = ($ervenyes_zuh_rekord["tobb_szin_db"] > 0 ? $ervenyes_zuh_rekord["tobb_szin_db"] : $darabszam * ($ervenyes_zuh_rekord["tobb_szin_szazalek"] / 100));
						}						
					}
					
					if ($szinszam2 > 0) {
						if ($szinszam1 > 3) {
							$selejt2 = ($ervenyes_zuh_rekord["szin_" . $szinszam2 . "_db"] > 0 ? $ervenyes_zuh_rekord["szin_" . $szinszam2 . "_db"] * $szinszam2 : $darabszam * ($ervenyes_zuh_rekord["szin_" . $szinszam2 . "_szazalek"] / 100));							
						}
						else
						{
							$selejt2 = ($ervenyes_zuh_rekord["tobb_szin_db"] > 0 ? $ervenyes_zuh_rekord["tobb_szin_db"] : $darabszam * ($ervenyes_zuh_rekord["tobb_szin_szazalek"] / 100));
						}						
					}
					$selejt = $selejt1 + $selejt2 ;
//					echo "selejt: " . $selejt ;
				}			
				
				//Selejtszámítás eddig 		
				$darabszam_osszesen = $darabszam + $selejt ;
				$darabszam_szamolashoz_osszesen = $darabszam_szamolashoz + $selejt ;

//				echo $darabszam_osszesen ;

				if ($darabszam >= 2000) {
//					$netto_osszeg = ($darabszam_osszesen * $db_ar) + ($nyomasi_ar * $darabszam_osszesen) ;
					$netto_osszeg = ($darabszam_szamolashoz_osszesen * $db_ar) ;
				}
				else
				{					
					$netto_osszeg = $nyomasi_ar + $darabszam_szamolashoz_osszesen * $db_ar ;									
				}				
			}

//			echo $netto_osszeg ;
			$ar = ($db_ar == 0) ? 0 : $db_ar;
			if ($szinszam == 0)
				$netto_osszeg = round($darabszam_szamolashoz * $ar) ;			
			else if ($darabszam > 0)
				$ar = round($netto_osszeg / $darabszam_osszesen, 2);

			$netto_osszeg = round($netto_osszeg * $szorzo) ;
			$ar = round($ar * $szorzo, 2) ;

			// bruttó ár
			$brutto_osszeg = round($netto_osszeg * ((100 + $afakulcsSzazalek) / 100));
			$arr[] = array(
				'status'=>'success',
				'ar'=>$ar,
				'netto_osszeg'=>$netto_osszeg,
				'brutto_osszeg'=>$brutto_osszeg,
			);						

			echo CJSON::encode($arr);
		}
	
		// LI: 	egy paraméterben kapott árajánlathoz tartozó ügyfélnek ellenőrzi le a rendelési limitösszegét.
		//     	Ha a beállított tartozási limitet meghaladja a kiegyenlítetlen megrendelés állománya az árajánlat értékével együtt,
		//		akkor nem lehet megrendelést csinálni az árajánlatból, tehát FALSE értékkel tér vissza a függvény. Minden más esetben TRUE-val.
		function reachedUgyfelLimit ($arajanlat_id) {
		
		// LI: ha a felhasználó rendelkezik a Megrendelesek.LimitMegkerulese jogosultsággal, akkor nem ellenőrizzük, hogy az ügyfél elérte-e a limitet.
		if (Yii::app()->user->checkAccess("Megrendelesek.LimitMegkerulese")) 
			return false;
		
			if ($arajanlat_id != null) {
				// megkeressük a paraméterben kapott árajánlatot
				$arajanlat = Arajanlatok::model() -> with('tetelek') -> findByAttributes(array('id' => $arajanlat_id));
				
				// ha létezik továbbmegyünk
				if ($arajanlat != null) {
					
					// megkeressük az árajánlathoz tartozó ügyfelet
					$ugyfel = Ugyfelek::model() -> findByAttributes(array('id' => $arajanlat->ugyfel_id));
					
					// ha megtaláltuk továbbmegyünk
					if ($ugyfel != null) {
						
						// megkeresük az ügyfélhez tartozó összes kiegyenlítetlen megrendelést (ID-kat kapunk első körben)
						$kiegyenlitetlenMegrendelesek = Yii::app() -> db -> createCommand  ("SELECT id FROM dom_megrendelesek WHERE sztornozva = 0 AND torolt = 0 AND szamla_fizetve = 0 AND rendelest_lezaro_user_id = 0 AND ugyfel_id = " . $ugyfel->id) -> queryAll();

						// végigmegyünk a kapott ID-kon, megkeressük a hozzájuk tartozó tételeket és összeadjuk a tételekt értékét
						$sumMegrendelesek = 0;
						$sumArajanlat = 0;
						
						foreach ($kiegyenlitetlenMegrendelesek as $megrendelesId )
						{
							$megrendeles = Megrendelesek::model() -> with('tetelek') -> findByPk ($megrendelesId['id']);
							
							if ($megrendeles != null) {
								foreach ($megrendeles->tetelek as $tetel) {
									$sumMegrendelesek += $tetel->netto_darabar * $tetel->darabszam;
								}
							}
						}
						
						// végigmegyünk az árajánlat tételein és összeadjuk őket
						foreach ($arajanlat->tetelek as $tetel) {
							$sumArajanlat += $tetel->netto_darabar * $tetel->darabszam;
						}
						// a $sumMegrendelesek változóban van az összeszámolt KIEGYENLÍTETLEN megrendelések összege
						// a $sumArajanlat változóban pedig az ÁRAJÁNLAT tételeinek összege
						//
						// Ha a beállított tartozási limitet meghaladja a kiegyenlítetlen megrendelés állománya az árajánlat értékével együtt,
						// akkor nem lehet megrendelést csinálni az árajánlatból, tehát FALSE értékkel tér vissza a függvény. Minden más esetben TRUE-val.
						return $sumMegrendelesek + $sumArajanlat >= $ugyfel->rendelesi_tartozasi_limit;
					}
				}
				
				return false;
			}
			
		}
		
		// LI: 	egy paraméterben kapott megrendelés/árajánlat tételein megy végig. Azt vizsgálja, hogy át lett-e írva az ár kézzel valamelyik tételnél.
		//		Ha igen, akkor TRUE értékkel, egyébként FALSE-szal tér vissza.
		function isEgyediArMegrendelesArajanlat ($id, $isMegrendeles) {
			$egyedi = false;
			
			if ($id != null) {
				// megkeressük a paraméterben kapott megrendelést / árajánlatot
				$model = $isMegrendeles ? (Megrendelesek::model() -> with('tetelek') -> findByAttributes(array('id' => $id))) : (Arajanlatok::model() -> with('tetelek') -> findByAttributes(array('id' => $id)));

				// ha megtaláltuk a megrendelést/árajánlatot továbbmegyünk
				if ($model != null) {
					foreach ($model->tetelek as $tetel) {
						if ( $tetel->egyedi_ar == 1) {
							$egyedi = true;
							break;
						}
					}
				}
			}
			
			$model->egyedi_ar = ($egyedi ? 1 : 0);
			$model->save();

			return $egyedi;
			
		}
		
		// LI: 	egy paraméterben kapott megrendelés/árajánlat tételét vizsgálja, hogy át lett-e írva az ár kézzel rajta vagy sem.
		//		Ha igen, akkor TRUE értékkel, egyébként FALSE-szal tér vissza.
		function isEgyediAr ($id, $isMegrendeles, $szorzo_tetel_arhoz) {
			$egyedi = false;
			
			if ($id != null) {
				// megkeressük a paraméterben kapott megrendelést / árajánlatot
				$tetel = $isMegrendeles ? (MegrendelesTetelek::model() -> findByAttributes(array('id' => $id))) : (ArajanlatTetelek::model() -> findByAttributes(array('id' => $id)));
				
				// ha megtaláltuk a tételt továbbmegyünk
				if ($tetel != null) {
					$termekAr = Utils::getActiveTermekar ($tetel->termek_id);

					if ( ( (($termekAr == 0) ? 0 : $termekAr["db_eladasi_ar"]) * (int)$szorzo_tetel_arhoz ) != $tetel->netto_darabar) {
						$egyedi = true;
					}
					
					$tetel->egyedi_ar = ($egyedi ? 1 : 0);
					$tetel->save();
				}
			}

			return $egyedi;
			
		}

		// LI: 		egy paraméterben kapott megrendelés azon tételeit adja vissza, amik még nem szerepelnek egy szállítólevélen sem
		// TODO:	ezeket a kevert nyelvű függvényneveket majd egyszer lehet átírnám, nem szokásom ilyen elnevezéseket csinálni, de mivel
		//			az adatbázisban is így tároljuk őket, valahogy így álltam neki
		// $skipId: ha ez TRUE, akkor a lekérdezésben az adott ID-hoz tartozó szállítólevél tételeket is visszaadjuk (pl. szerkesztésnél kell)
		//			annyival bővült a szűrés, hogy a negatív raktárban lévő elemeket kihagyjuk az eredményhalmazból
		function getSzallitolevelTetelToMegrendeles ($id, $skipId = null) {
			$result = array();

			if ($id != null) {
				$megrendeles = Megrendelesek::model() -> with('tetelek') -> findByAttributes(array('id' => $id));

				if ($megrendeles != null) {
					$skipIDCondition = ($skipId != null) ? " AND dom_szallitolevelek.id <> $skipId" : "";
					$marSzallitonLevoTetelekSql =
						"
							SELECT megrendeles_tetel_id, SUM(darabszam) AS darabszam FROM dom_szallitolevelek
							JOIN dom_szallitolevel_tetelek
							ON dom_szallitolevelek.id = dom_szallitolevel_tetelek.szallitolevel_id 
							WHERE sztornozva = 0 AND dom_szallitolevelek.torolt = 0 AND megrendeles_id = :id " . $skipIDCondition . " 
							GROUP BY megrendeles_tetel_id
						";

						$command = Yii::app()->db->createCommand($marSzallitonLevoTetelekSql);
						$command->bindParam(':id', $id);
						$megrendelesTetelek = $command->queryAll();

						// végigmegyünk a megrendelés tételein és külön gyűjtjük azokat, amiket nem találunk a szállítóleveleken még
						foreach ($megrendeles->tetelek as $tetel )
						{
							$nyomdakonyv = Nyomdakonyv::model()->findByAttributes(array("megrendeles_tetel_id" => $tetel -> id, "sztornozva" => "0"));

							if ($tetel -> negativ_raktar_termek == 0 && (($nyomdakonyv != null && $nyomdakonyv -> sztornozva == 0) || ($nyomdakonyv == null && $tetel->szinek_szama1 + $tetel->szinek_szama2 == 0)) ) {
								$darabszamKulonbozet = Utils::isTetelOnDeliveryNote ($tetel, $megrendelesTetelek);

								if ($darabszamKulonbozet == -1) {
									if ( ($nyomdakonyv != null && Utils::getTermekRaktarkeszlet($tetel->termek_id, "foglalt_db", $tetel -> hozott_boritek != 1) >= $tetel -> darabszam) || ($nyomdakonyv == null && $tetel->szinek_szama1 + $tetel->szinek_szama2 == 0 && Utils::getTermekRaktarkeszlet($tetel->termek_id, "elerheto_db", $tetel -> hozott_boritek != 1) >= $tetel -> darabszam) || $skipId != null) {

										array_push ($result, $tetel);
									}
								}
								else if ($darabszamKulonbozet > 0) {
									$tetel->darabszam = $darabszamKulonbozet;
									array_push ($result, $tetel);
								}
							}
						}

				}
			}

			return $result;
		}
		
		// LI: 	megnézei, hogy az adott megrendelés tétel rajta van-e a szállítókon.
		//	   	Ha rajta van, akkor megnézi, hogy a darabszámuk egyezik-e (minden darab szállítón van-e már).
		//		Visszatérési értékek: 		-1 - nincs rajta
		//									 0 - minden megrendelt termék szállítón van már
		//									 ezektől eltérő - nincs minden megrendelt termék szállítón, a különbözetet adjuk vissza (ennyi választható még)
		function isTetelOnDeliveryNote ($megrendelesTetel, $szallitonLevoTetelek) {
			foreach ($szallitonLevoTetelek as $tetel) {
				if ($megrendelesTetel->id == $tetel['megrendeles_tetel_id']) {
					if ($megrendelesTetel->darabszam == $tetel['darabszam']) return 0;
						else return $megrendelesTetel->darabszam - $tetel['darabszam'];
				}
			}

			return -1;
		}
		
		function array_to_xml( $data, &$xml_data ) {
			foreach( $data as $key => $value ) {
				if( is_array($value) ) {
					if( is_numeric($key) ){
//						$key = 'item'.$key; //dealing with <0/>..<n/> issues
						$key = 'BSor'; //dealing with <0/>..<n/> issues
					}
					if ($key == 'Szallitasicim') {
						$key = 'Partnercim' ;	
					}
					if ($key != 'bsorok') {
						$subnode = $xml_data->addChild($key);
					}
					Utils::array_to_xml($value, $subnode);
				} else {
//					$xml_data->addChild("$key",htmlspecialchars("$value"));
//					$xml_data->addChild("$key","$value");
					$xml_data->addChild("$key") ;
					$xml_data->$key = "$value" ;
				}
			 }
		}		
		
		// Létrehozza az ACTUAL rendszerben a megrendeléshez a számlát
		function szamla_letrehozasa($megrendeles_id) {
			$megrendeles_tetelek = MegrendelesTetelek::model() -> findAllByAttributes(array('megrendeles_id' => $megrendeles_id)) ;
			$megrendeles_adatok = Megrendelesek::model() -> findByAttributes(array('id' => $megrendeles_id)) ;
/*			switch ($megrendeles_adatok->proforma_fizetesi_mod) {
					case '1': $fizmod_domy_kod = "készpénz" ;
						break ;
					case '2': $fizmod_domy_kod = "átutalás" ;
						break ;
					case '3': $fizmod_domy_kod = "utánvét" ;
						break ;
					case '4': $fizmod_domy_kod = "bankkártya" ;
						break ;
					default: "átutalás" ;
			}
			$megrendeles_fizmod = FizetesiModok::model() -> findByAttributes(array('nev' => $fizmod_domy_kod)) ;*/
			$megrendeles_fizmod = FizetesiModok::model() -> findByPk($megrendeles_adatok->proforma_fizetesi_mod) ;
			if (count($megrendeles_tetelek) > 0) {
				$partner_orszag = Orszagok::model() -> findByAttributes(array('id' => $megrendeles_adatok->ugyfel->szekhely_orszag)) ;
				$partner_kozterulet_nev = $megrendeles_adatok->ugyfel->szekhely_cim	;
				$partner_kozterulet_jellege = " " ;
				$partner_kozterulet_hsz = " " ;
				if (preg_match("/(.*?) (utca|u\.|u|tér|tere|út|körút|krt\.|sétány|köz|park)\s?(.*?)$/i", $megrendeles_adatok->ugyfel->szekhely_cim, $matches)) {
					$partner_kozterulet_nev = trim($matches[1]) ;
					$partner_kozterulet_jellege = trim($matches[2]) ;
					$partner_kozterulet_hsz = trim($matches[3]) ;
				}
				$megrendeles = array() ;				
				$megrendeles["TranzakcioID"] = $megrendeles_id ; 
				$megrendeles["TranzakcioTipus"] = 0 ;
				$megrendeles["PartnerModositas"] = 0 ;
				$megrendeles["Ideiglenes"] = 1 ;
				$megrendeles["BFejlec"]["MozgasAlapID"] = 600 ;
				$megrendeles["BFejlec"]["Kiallitas"] = date("Y.m.d") ;
				$megrendeles["BFejlec"]["Teljesites"] = date("Y.m.d") ;
				$megrendeles["BFejlec"]["Esedekes"] = date("Y.m.d", mktime(0, 0, 0, date("m")  , date("d")+$megrendeles_fizmod->fizetesi_hatarido, date("Y"))) ;
				$megrendeles["BFejlec"]["Lejarat"] = date("Y.m.d", mktime(0, 0, 0, date("m")  , date("d")+$megrendeles_fizmod->fizetesi_hatarido, date("Y"))) ;
//				$megrendeles["BFejlec"]["FizModID"] = 1 ;		//Alapértelmezetten az átutalásos fizetési mód él
				$megrendeles["BFejlec"]["FizModID"] = $megrendeles_fizmod->szamlazo_azonosito ;		
//				if ($megrendeles_adatok->megrendeles_forras_megrendeles_id != "") {
//					$megrendeles["BFejlec"]["BSorszam2"] = "WEB-" . $megrendeles_adatok->megrendeles_forras_megrendeles_id ;
					$megrendeles["BFejlec"]["BSorszam2"] = "WEB-" . $megrendeles_id ;
/*				}
				else
				{
					$megrendeles["BFejlec"]["BSorszam2"] = "" ;					
				}*/
				$megrendeles["BFejlec"]["Devizanem"] = "HUF" ;
				$megrendeles["BFejlec"]["BArfolyam"] = 1 ;
				$megrendeles["BFejlec"]["Partner"]["PNev"] = $megrendeles_adatok->ugyfel->cegnev ;
				$megrendeles["BFejlec"]["Partner"]["PIrszam"] = $megrendeles_adatok->ugyfel->szekhely_irsz ;
				$megrendeles["BFejlec"]["Partner"]["PHelyseg"] = $megrendeles_adatok->ugyfel->szekhely_varos ;
				$megrendeles["BFejlec"]["Partner"]["POrszag"] = $partner_orszag->nev ;
//				$megrendeles["BFejlec"]["Partner"]["PUtca"] = $megrendeles_adatok->ugyfel->szekhely_cim ;
				$megrendeles["BFejlec"]["Partner"]["KozteruletNev"] = $partner_kozterulet_nev ;
				$megrendeles["BFejlec"]["Partner"]["KozteruletJelleg"] = $partner_kozterulet_jellege ;
				$megrendeles["BFejlec"]["Partner"]["Hazszam"] = $partner_kozterulet_hsz ;
				$megrendeles["BFejlec"]["Partner"]["Adoszam"] = $megrendeles_adatok->ugyfel->adoszam ;
				$megrendeles["BFejlec"]["Partner"]["Partnercim"]["CimTipus"] = 1 ;
				$megrendeles["BFejlec"]["Partner"]["Partnercim"]["CimNev"] = $megrendeles_adatok->ugyfel->cegnev ;
				$megrendeles["BFejlec"]["Partner"]["Partnercim"]["IrSzam"] = $megrendeles_adatok->ugyfel->szekhely_irsz ;
				$megrendeles["BFejlec"]["Partner"]["Partnercim"]["Helyseg"] = $megrendeles_adatok->ugyfel->szekhely_varos ;
				$megrendeles["BFejlec"]["Partner"]["Partnercim"]["Orszag"] = $partner_orszag->nev ;
//				$megrendeles["BFejlec"]["Partner"]["Partnercim"]["Utca"] = $megrendeles_adatok->ugyfel->szekhely_cim ;
				$megrendeles["BFejlec"]["Partner"]["Partnercim"]["KozteruletNev"] = $partner_kozterulet_nev ;
				$megrendeles["BFejlec"]["Partner"]["Partnercim"]["KozteruletJelleg"] = $partner_kozterulet_jellege ;
				$megrendeles["BFejlec"]["Partner"]["Partnercim"]["Hazszam"] = $partner_kozterulet_hsz ;
				if ($megrendeles_adatok->ugyfel->szallitasi_cim != "" && $megrendeles_adatok->ugyfel->szallitasi_cim != $megrendeles_adatok->ugyfel->szekhely_cim) {
					$szallitasi_orszag = Orszagok::model() -> findByAttributes(array('id' => $megrendeles_adatok->ugyfel->szallitasi_orszag)) ;
					$szallitasi_kozterulet_nev = $megrendeles_adatok->ugyfel->szallitasi_cim	;
					$szallitasi_kozterulet_jellege = " " ;
					$szallitasi_kozterulet_hsz = " " ;
					if (preg_match("/(.*?) (utca|u\.|u|tér|tere|út|körút|krt\.|sétány|köz|park|Park)\s?(.*?)$/i", $megrendeles_adatok->ugyfel->szallitasi_cim, $matches)) {
						$szallitasi_kozterulet_nev = trim($matches[1]) ;
						$szallitasi_kozterulet_jellege = trim($matches[2]) ;
						$szallitasi_kozterulet_hsz = trim($matches[3]) ;
					}					
					$megrendeles["BFejlec"]["Partner"]["Szallitasicim"]["CimTipus"] = 2 ;
					$megrendeles["BFejlec"]["Partner"]["Szallitasicim"]["CimNev"] = $megrendeles_adatok->ugyfel->cegnev ;
					$megrendeles["BFejlec"]["Partner"]["Szallitasicim"]["IrSzam"] = $megrendeles_adatok->ugyfel->szallitasi_irsz ;
					$megrendeles["BFejlec"]["Partner"]["Szallitasicim"]["Helyseg"] = $megrendeles_adatok->ugyfel->szallitasi_varos ;
					$megrendeles["BFejlec"]["Partner"]["Szallitasicim"]["Orszag"] = $szallitasi_orszag->nev ;
	//				$megrendeles["BFejlec"]["Partner"]["Szallitasicim"]["Utca"] = $megrendeles_adatok->ugyfel->szallitasi_cim ;
					$megrendeles["BFejlec"]["Partner"]["Szallitasicim"]["KozteruletNev"] = $szallitasi_kozterulet_nev ;
					$megrendeles["BFejlec"]["Partner"]["Szallitasicim"]["KozteruletJelleg"] = $szallitasi_kozterulet_jellege ;
					$megrendeles["BFejlec"]["Partner"]["Szallitasicim"]["Hazszam"] = $szallitasi_kozterulet_hsz ;					
				}
				
				$megrendeles["bsorok"] = array() ;				
				foreach ($megrendeles_tetelek as $tetel) {
					if ($tetel->termek->cikkszam == "") {
						$cikkszam = "nincs" ;	
					}
					else
					{
						$cikkszam = $tetel->termek->cikkszam ;						
					}
					$afakulcs = AfaKulcsok::model() -> findByAttributes(array('id'=>$tetel->termek->afakulcs_id)) ;
					$sor = array() ;
					$sor["Cikkszam"] = $cikkszam;
					if ($tetel->szinek_szama1 + $tetel->szinek_szama2 > 0) {
						$cikknev = "Nyomás " . $tetel->termek->getDisplayTermekTeljesNev() . " " . $tetel->szinek_szama1 . "+" . $tetel->szinek_szama2 ;
					}
					else
					{
						$cikknev = $tetel->termek->getDisplayTermekTeljesNev() ;
					}
					$sor["CikkNev"] = substr($cikknev,0,100) ;
					$sor["MEgyseg"] = "db" ;
					$sor["AfaKulcs"] = $afakulcs->afa_szazalek ;
					if ($tetel->termek->tipus == "Szolgáltatás") {
						$sor["CikkTipus"] = 6 ;	
					}
					if ($tetel->munka_neve != "") {
						$sor["SorMegjegyzes"] = $tetel->szinek_szama1 . "+" . $tetel->szinek_szama2 . " " . $tetel->munka_neve;	
					}
					$sor["Jegyzekszam"] = $tetel->termek->ksh_kod ;
					$sor["Mennyiseg"] = $tetel->darabszam ;
					$sor["EgysegAr"] = $tetel->netto_darabar ;	
					$megrendeles["bsorok"][] = $sor ;
				}
				$megrendeles_kesz["Tranzakcio"] = $megrendeles ; 
				$xml_megrendeles = new SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-2"?><root/>');
				Utils::array_to_xml($megrendeles_kesz, $xml_megrendeles) ;
				$SzamlaImportPath = Yii::app()->config->get('SzamlaImportPath');
 				$xml_megrendeles->asXML($SzamlaImportPath . "/domy_" . $megrendeles_id . ".xml");			
			}
		}
		
		/* Az ACTUAL adatbázisából beolvassa a $megrendeles_id azonosítójú megrendeléshez tartozó számla sorszámot és visszaadja */
		function szamla_sorszam_beolvas($megrendeles_id) {
			$return = 0;
			$sql = "select BSorszam, Esedekes, Kiallitas from kerBFejlec where BSorszam2 = 'WEB-" . $megrendeles_id . "'" ;
/*			$fp = fopen('szamla_sorszamok_queryk.txt', 'a');
			fwrite($fp, $sql . "\n");
			fclose($fp);*/
			$szamla_fej = Yii::app()->db_actual->createCommand($sql)->queryRow();
			if (is_array($szamla_fej)) {
				$return = $szamla_fej ;	
			}
			return $return;
		}

		/* Az ACTUAL adatbázisából beolvassa azon megrendelésekhez az átutalási adatokat, amelyeknél még nincs jelölve, hogy fizetve van, de van számla sorszám hozzá. Ahol megtalálja az átutalást, ott automatikusan beállítja, hogy fizetve, és a fizetés dátumát */
		function szamla_kiegyenlitettseg_szinkron() {
			$nyitott_szamlak = Yii::app()->db->createCommand()
													->select('id, szamla_sorszam')
													->from('dom_megrendelesek')
													->where("szamla_sorszam != '' and szamla_fizetve = 0") 
													->queryAll();
/*			$fp = fopen('data.txt', 'a');
			fwrite($fp, date("Y-m-d H:i:s") . " - Nyitott szamlak: " . count($nyitott_szamlak) . "\n");
			fclose($fp);*/
			if (count($nyitott_szamlak) > 0) {
				foreach ($nyitott_szamlak as $szamla) {
					$sql = "select penBFejlec.Sorszam, penBFejlec.OsszegBevHUF, penBFejlec.BizonylatDatum, penBSor.Bizonylatszam from penBSor join penBFejlec on penBSor.BFejlecID = penBFejlec.BFejlecID where penBSor.BSorszam = '" . $szamla["szamla_sorszam"] . "'" ;
/*					$fp = fopen('data.txt', 'a');
					fwrite($fp, date("Y-m-d H:i:s") . " - " . $sql . "\n");
					fclose($fp);*/
//					echo $sql . "<br />" ;
					$kiegyenlites_adatok = Yii::app()->db_actual->createCommand($sql)->queryRow();
					if (is_array($kiegyenlites_adatok)) {						
//						echo "Találat: " .	$kiegyenlites_adatok["OsszegBevHUF"] . " Ft, " . substr($kiegyenlites_adatok["BizonylatDatum"], 0, 10) . "<br />" ; 	
						$megrendeles = Megrendelesek::model() -> findByPk ($szamla["id"]);

						$tranzakciok = PenzugyiTranzakciok::model() -> findAllByAttributes(array('megrendeles_id' => $megrendeles->id));
						$tranzakciok_osszeg = 0 ;
						$mar_rogzitett = false ;
						$kiegyenlitve = 0 ;
/*						$fp = fopen('data.txt', 'a');
						fwrite($fp, date("Y-m-d H:i:s") . " - Van kiegyenlítési adat ehhez:" . $megrendeles->id . " -> Bizonylatszam:" . $kiegyenlites_adatok["Bizonylatszam"] . "\n");
						fwrite($fp, date("Y-m-d H:i:s") . " - Tranzakciok:" . count($tranzakciok) . "\n");
						fclose($fp);*/
						if (count($tranzakciok) > 0) {
							foreach ($tranzakciok as $tranzakcio) {
								$tranzakciok_osszeg += $tranzakcio->osszeg ;
								if ($tranzakcio->bizonylatszam == $kiegyenlites_adatok["Bizonylatszam"]) {
									$mar_rogzitett = true ;	
								}
							}
/*							$fp = fopen('data.txt', 'a');
							fwrite($fp, date("Y-m-d H:i:s") . " Tranzakcio osszeg -> " . $tranzakciok_osszeg . "\n");
							fclose($fp);*/
							if (!$mar_rogzitett) {
								$tranzakcio_mod = "Bank" ;
								if (strpos($kiegyenlites_adatok["Bizonylatszam"], "PENZT") !== false) {
									$tranzakcio_mod = "Pénztár" ;	
								}
								$uj_tranzakcio = new PenzugyiTranzakciok() ;
								$uj_tranzakcio->setAttribute("megrendeles_id", $megrendeles->id) ;
								$uj_tranzakcio->setAttribute("bizonylatszam", $kiegyenlites_adatok["Bizonylatszam"]) ;
								$uj_tranzakcio->setAttribute("mode", $tranzakcio_mod) ;
								$uj_tranzakcio->setAttribute("osszeg", $kiegyenlites_adatok["OsszegBevHUF"]) ;
								$uj_tranzakcio->setAttribute("datum", $kiegyenlites_adatok["BizonylatDatum"]) ;
								$uj_tranzakcio->save() ;
								$tranzakciok_osszeg += $uj_tranzakcio->osszeg ;								
							}
						}
						else
						{
							$tranzakcio_mod = "Bank" ;
							if (strpos($kiegyenlites_adatok["Sorszam"], "PENZT") !== false) {
								$tranzakcio_mod = "Pénztár" ;	
							}
							$uj_tranzakcio = new PenzugyiTranzakciok() ;
							$uj_tranzakcio->setAttribute("megrendeles_id", $megrendeles->id) ;
							$uj_tranzakcio->setAttribute("bizonylatszam", $kiegyenlites_adatok["Bizonylatszam"]) ;
							$uj_tranzakcio->setAttribute("mode", $tranzakcio_mod) ;
							$uj_tranzakcio->setAttribute("osszeg", $kiegyenlites_adatok["OsszegBevHUF"]) ;
							$uj_tranzakcio->setAttribute("datum", $kiegyenlites_adatok["BizonylatDatum"]) ;
							$uj_tranzakcio->save() ;
							$tranzakciok_osszeg += $uj_tranzakcio->osszeg ;							
						}
						$megrendeles_ertek = $megrendeles->getMegrendelesOsszeg() ;
						$megrendeles_ertek_kerekitett = round($megrendeles_ertek["brutto_osszeg"]) ;
						$megrendeles_ertek["brutto_osszeg_kerekitett"] = $megrendeles_ertek_kerekitett ;
/*						$megrendeles_ertek_utolso_szamjegy = substr($megrendeles_ertek_kerekitett, count($megrendeles_ertek_kerekitett) - 2) ;
						if ($tranzakciok_osszeg - $megrendeles_ertek_kerekitett <= 2) {
							if ($megrendeles_ertek_utolso_szamjegy == 1 || $megrendeles_ertek_utolso_szamjegy == 2) {
								$megrendeles_ertek["brutto_osszeg_kerekitett"]	= substr($megrendeles_ertek_kerekitett, 0, count($megrendeles_ertek_kerekitett) - 2) . "0" ;
							}
							else if ($megrendeles_ertek_utolso_szamjegy == 6 || $megrendeles_ertek_utolso_szamjegy == 7) {
								$megrendeles_ertek["brutto_osszeg_kerekitett"]	= substr($megrendeles_ertek_kerekitett, 0, count($megrendeles_ertek_kerekitett) - 2) . "5" ;
							}
						}*/
/*						$fp = fopen('data.txt', 'a');
						fwrite($fp, date("Y-m-d H:i:s") . " Kiegyenlites -> " . $megrendeles_ertek["brutto_osszeg_kerekitett"] . " <= " . $tranzakciok_osszeg . "\n");
						fclose($fp);*/
//						if ($megrendeles_ertek["brutto_osszeg_kerekitett"] <= $tranzakciok_osszeg + 5) {
						if (abs($megrendeles_ertek["brutto_osszeg_kerekitett"] - $tranzakciok_osszeg) < 10) {
							$kiegyenlitve = 1 ;
							$megrendeles->setAttribute("szamla_fizetve", $kiegyenlitve);
							$megrendeles->setAttribute("szamla_kiegyenlites_datum", substr($kiegyenlites_adatok["BizonylatDatum"], 0, 10)) ;
							$megrendeles->save();
							$fp = fopen('data.txt', 'a');
							fwrite($fp, date("Y-m-d H:i:s") . " Megrendeles kiegyenlitve -> " . $megrendeles->id . "\n");
							fclose($fp);
							Utils::SetUgyfelFizetesiMoralMegrendelesAlapjan($megrendeles) ;
						}
					}
				}
			}
		}
		
		/* Egy megrendelés ügyfelének frissíti a fizetési morálját és késés adatait */
		function SetUgyfelFizetesiMoralMegrendelesAlapjan($megrendeles) {
			$ugyfel = Ugyfelek::model()->findByPk($megrendeles->ugyfel_id) ;
			if ($ugyfel != null) {
				if ($megrendeles->szamla_fizetesi_hatarido != "0000-00-00" && $megrendeles->szamla_kiegyenlites_datum != "0000-00-00") {
					$ugyfel->updateAtlagosFizetesiKeses() ;
				}					
			}
		}
		
		/** Egy selectből a munka típusát is ki kell választania az adminnak egy nyomdakönyvhöz.
		 *  A selectbe a munkához már meglévő termék_id, darabszám és színszám paraméterekkel megszűrt típusokat ajánljuk fel.
		 *  Az alapértelmezett munkatípus az, amelyikhez a legkevesebb művelet tartozik, ezek közül pedig az, amely a legkevesebb normaórát adja (a műveletek összideje a legkisebb).
		 *
		 *  Ez a függvény az alapértelmezett munkatípust adja vissza egy nyomdakönyvhöz.
		 */
		function getDefaultMunkatipusToNyomdakonyv ($darabszam, $szinszam_elo, $szinszam_hat, $termek_id ) {
			$sql = "
				SELECT munkatipusok.id, munkatipus_nev, COUNT(muveletek.id) AS muveletek_szama, SUM(muveletek.elokeszites_ido)+SUM(muveletek.muvelet_ido) AS muveleti_idok

				FROM dom_nyomda_munkatipusok AS munkatipusok

				INNER JOIN dom_nyomda_munkatipus_termekek AS munkatipus_termekek
				ON munkatipusok.id = munkatipus_termekek.munkatipus_id
				
				INNER JOIN dom_nyomda_munkatipus_muveletek AS munkatipus_muveletek
				ON munkatipusok.id = munkatipus_muveletek.munkatipus_id

				INNER JOIN dom_nyomda_muveletek AS muveletek
				ON munkatipus_muveletek.muvelet_id = muveletek.id
				
				WHERE
				
				(:darabszam >= darabszam_tol AND :darabszam <= darabszam_ig) AND
				(:szinszam_elo >= szinszam_tol_elo AND :szinszam_elo <= szinszam_ig_elo) AND
				(:szinszam_hat >= szinszam_tol_hat AND :szinszam_hat <= szinszam_ig_hat) AND
				munkatipus_termekek.termek_id = :termek_id
				
				GROUP BY munkatipusok.munkatipus_nev
				ORDER BY muveletek_szama, muveleti_idok
			";

			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(':darabszam', $darabszam);
			$command->bindParam(':szinszam_elo', $szinszam_elo);
			$command->bindParam(':szinszam_hat', $szinszam_hat);
			$command->bindParam(':termek_id', $termek_id);
			
			$defaultMunkatipus = $command->queryRow();
			
			if (is_array ($defaultMunkatipus) ) {
					return $defaultMunkatipus['id'];
			} else {
				return null;
			}				
		}
		
		/**
		 *  Ez a függvény visszaadja az összes munkatípust, ami egy adott nyomdcakönyvhöz elérhető.
		 */
		function getAllMunkatipusToNyomdakonyv ($darabszam, $szinszam_elo, $szinszam_hat, $termek_id ) {
			$sql = "
				SELECT munkatipusok.id, munkatipus_nev

				FROM dom_nyomda_munkatipusok AS munkatipusok

				INNER JOIN dom_nyomda_munkatipus_termekek AS munkatipus_termekek
				ON munkatipusok.id = munkatipus_termekek.munkatipus_id
				
				INNER JOIN dom_nyomda_munkatipus_muveletek AS munkatipus_muveletek
				ON munkatipusok.id = munkatipus_muveletek.munkatipus_id

				INNER JOIN dom_nyomda_muveletek AS muveletek
				ON munkatipus_muveletek.muvelet_id = muveletek.id
				
				WHERE
				
				(:darabszam >= darabszam_tol AND :darabszam <= darabszam_ig) AND
				(:szinszam_elo >= szinszam_tol_elo AND :szinszam_elo <= szinszam_ig_elo) AND
				(:szinszam_hat >= szinszam_tol_hat AND :szinszam_hat <= szinszam_ig_hat) AND
				munkatipus_termekek.termek_id = :termek_id
				
				GROUP BY munkatipusok.munkatipus_nev
				ORDER BY munkatipusok.munkatipus_nev
			";

			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(':darabszam', $darabszam);
			$command->bindParam(':szinszam_elo', $szinszam_elo);
			$command->bindParam(':szinszam_hat', $szinszam_hat);
			$command->bindParam(':termek_id', $termek_id);
			
			$munkatipusok = $command->queryAll();
			
			if (is_array ($munkatipusok) ) {
				return $munkatipusok;
			} else {
				return null;
			}				
		}
		
		/**
		 *  Ez a függvény visszaadja egy megrendelt termékhez és géphez kalkulált normaidőt és normaárat.
		 */
		function getNormaadat($megrendeltTermekId, $gepId, $munkatipusId, $maxFordulatszam) {
			$megrendelesTetel = MegrendelesTetelek::model()->findByPk($megrendeltTermekId);
			$gep = Nyomdagepek::model()->findByPk($gepId);
			$munkatipus = NyomdaMunkatipusok::model()->findByPk($munkatipusId);
			
			if ($megrendelesTetel != null && $gep != null && $munkatipus != null) {
				$termek = Termekek::model()->findByPk($megrendelesTetel->termek_id);
				
				if ($termek != null) {
					$sql = "
						SELECT gepek.max_fordulat, gep_tipusok.fordulat_kis_boritek, gep_tipusok.fordulat_nagy_boritek, gep_tipusok.fordulat_egyeb FROM dom_nyomdagepek AS gepek
						INNER JOIN dom_nyomdagep_tipusok AS gep_tipusok ON
						gepek.id = gep_tipusok.gep_id

						WHERE (:szinszam >= szinszam_tol AND :szinszam <= szinszam_ig) AND (gep_tipusok.gep_id = :gep_id)
					";

					$osszSzin = $megrendelesTetel->szinek_szama1 + $megrendelesTetel->szinek_szama2;
					$command = Yii::app()->db->createCommand($sql);
					$command->bindParam(':szinszam', $osszSzin);
					$command->bindParam(':gep_id', $gepId);
					
					$result = $command->queryRow();
					
					if ($result) {
						// érvényes maximális fordulat kiszámítása
						$tipus = $termek->tipus;
						$geptipusFordulatszam = 0;
						if ($tipus == 'Kis boríték') {
							$geptipusFordulatszam = $result['fordulat_kis_boritek'];
						} else if ($tipus == 'Nagy boríték') {
							$geptipusFordulatszam = $result['fordulat_nagy_boritek'];
						} else if ($tipus == 'Egyéb') {
							$geptipusFordulatszam = $result['fordulat_egyeb'];
						}
						$ervenyesMaxFordulatszam = (!empty($maxFordulatszam) && ($maxFordulatszam > 0)) ? $maxFordulatszam : ($geptipusFordulatszam > $result['max_fordulat'] ? $result['max_fordulat'] : $geptipusFordulatszam);
						
						// műveleti idők összege
						$muveletiIdokOsszege = 0;
						$muveletiArakOsszege = 0;
						
						foreach ($munkatipus->muveletek as $munkatipus_muvelet) {
							$muvelet = NyomdaMuveletek::model()->findByPk($munkatipus_muvelet->muvelet_id);
							
							if ($muvelet != null) {
								// műveleti idő
								$muveletiIdo = $muvelet->elokeszites_ido + ($muvelet->muvelet_ido * $osszSzin);
								
								// műveleti idők összege
								$muveletiIdokOsszege += $muveletiIdo;
								
								// műveleti ár
								$muveletiAr = 0;
								
								$muveletiNormaAr = NyomdaMuveletNormaarak::model()->findByAttributes(array('muvelet_id' => $muvelet->id, 'gep_id' => $gep->id));
								if ($muveletiNormaAr != null) {
									$muveletiAr = $muvelet->muvelet_ido * $muveletiNormaAr->oradij / 60;
								}
								
								// műveleti árak összege
								$muveletiArakOsszege += $muveletiAr;
							}
						}
						
						$result['normaido'] = round ($muveletiIdokOsszege + ($megrendelesTetel->darabszam / $ervenyesMaxFordulatszam));
						
						//  : ide valami óradíj kellene jöjjön, de az csak műveletenként van. Mi kéne akkor ide jöjjön ?
						$result['normaar']  = round ($muveletiArakOsszege + ($megrendelesTetel->darabszam / $ervenyesMaxFordulatszam));
						
						return $result;
					} else return null;
				} else return null;
			} else return null;
		}
		
		/**
		 *  Ez a függvény visszaadja egy megadott ügyfél összes árajánlatának értékét és rajtuk lévő tételek darabszámát.
		 */
		function getUgyfelOsszesArajanlatErteke ($ugyfel_id ) {
			$sql = "
				SELECT ROUND(SUM(tetelek.netto_darabar * tetelek.darabszam)) AS arajanlat_netto_osszeg, COUNT(tetelek.id) AS tetel_darabszam FROM dom_arajanlatok AS arajanlatok
				INNER JOIN dom_arajanlat_tetelek AS tetelek ON
				tetelek.arajanlat_id = arajanlatok.id

				WHERE arajanlatok.torolt = 0 AND
						tetelek.torolt = 0 AND
						ugyfel_id = :ugyfel_id
			";

			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(':ugyfel_id', $ugyfel_id);
			
			$arajanlatokErteke = $command->queryRow();
			
			if (is_array ($arajanlatokErteke) ) {
				if ($arajanlatokErteke['arajanlat_netto_osszeg'] == '') {
					$arajanlatokErteke['arajanlat_netto_osszeg'] = 0;
				}
				
				return $arajanlatokErteke;
			} else {
				return null;
			}				
		}
		
		/**
		 *  Ez a függvény visszaadja egy megadott ügyfél összes megrendelésének értékét és rajtuk lévő tételek darabszámát.
		 */
		function getUgyfelOsszesMegrendelesErteke ($ugyfel_id ) {
			$sql = "
				SELECT ROUND(SUM(tetelek.netto_darabar * tetelek.darabszam)) AS megrendeles_netto_osszeg, COUNT(tetelek.id) AS tetel_darabszam FROM dom_megrendelesek AS megrendelesek
				INNER JOIN dom_megrendeles_tetelek AS tetelek ON
				tetelek.megrendeles_id = megrendelesek.id

				WHERE megrendelesek.torolt = 0 AND
						megrendelesek.sztornozva = 0 AND
						tetelek.torolt = 0 AND
						ugyfel_id = :ugyfel_id
			";

			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(':ugyfel_id', $ugyfel_id);
			
			$megrendelesekErteke = $command->queryRow();
			
			if (is_array ($megrendelesekErteke) ) {
				if ($megrendelesekErteke['megrendeles_netto_osszeg'] == '') {
					$megrendelesekErteke['megrendeles_netto_osszeg'] = 0;
				}

				return $megrendelesekErteke;
			} else {
				return null;
			}				
		}
		
		/**
		 *  Ez a függvény visszaadja egy megadott ügyfél összes árajánlatának számát.
		 */
		function getUgyfelOsszesArajanlatDarab ($ugyfel_id ) {
			$sql = "
				SELECT COUNT(*) AS darab FROM dom_arajanlatok AS arajanlatok
				WHERE arajanlatok.torolt = 0 AND ugyfel_id = :ugyfel_id
			";

			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(':ugyfel_id', $ugyfel_id);
			
			$arajanlatokSzam = $command->queryRow();
			
			if (is_array ($arajanlatokSzam) ) {
				return $arajanlatokSzam['darab'];
			} else {
				return 0;
			}				
		}
		
		/**
		 *  Ez a függvény visszaadja egy megadott ügyfél összes megrendelésének számát.
		 */
		function getUgyfelOsszesMegrendelesDarab ($ugyfel_id ) {
			$sql = "
				SELECT COUNT(*) AS darab FROM dom_megrendelesek AS megrendeles
				WHERE megrendeles.torolt = 0 AND ugyfel_id = :ugyfel_id
			";

			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(':ugyfel_id', $ugyfel_id);
			
			$megrendelesekSzam = $command->queryRow();
			
			if (is_array ($megrendelesekSzam) ) {
				return $megrendelesekSzam['darab'];
			} else {
				return 0;
			}				
		}
		
		/**
		 *  Egy táskaszám alatti munkához kiszámítja, hogy milyen nyomási kategóriába esik, és azt adja vissza
		 */
		 function NyomasiKategoriaSzamol($szinek_szama, $darabszam, $termektipus, $kifuto) {
		 	$return = "" ;
		 	$szinszam_elo = substr($szinek_szama, 0, 1) ;
		 	$szinszam_hat = substr($szinek_szama, 2, 1) ;
		 	
		 	if ($szinszam_elo <= 1 && $szinszam_hat <= 1 && $termektipus == "Kis boríték" && $kifuto == 0) {
		 		$return = "A/1" ;
		 	}
		 	else if ($szinszam_elo <= 1 && $szinszam_hat <= 1 && ($termektipus == "Nagy boríték" || $termektipus == "Egyéb") && $kifuto == 0) {
		 		$return = "B/1" ;
		 	}
		 	else if ($szinszam_elo <= 2 && $szinszam_hat <= 2 && $termektipus == "Kis boríték" && $kifuto == 0) {
		 		$return = "A/2" ;
		 	}
		 	else if ($szinszam_elo <= 2 && $szinszam_hat <= 2 && ($termektipus == "Nagy boríték" || $termektipus == "Egyéb") && $kifuto == 0) {
		 		$return = "B/2" ;
		 	}
		 	else if ($szinszam_elo <= 4 && $szinszam_hat <= 4 && $termektipus == "Kis boríték" && $kifuto == 0) {
		 		$return = "C" ;
		 	}
		 	else if ($szinszam_elo <= 4 && $szinszam_hat <= 4 && ($termektipus == "Nagy boríték" || $termektipus == "Egyéb") && $kifuto == 0) {
		 		$return = "D" ;
		 	}
		 	else if (($szinszam_elo > 4 || $szinszam_hat > 4 || $kifuto == 1) && $termektipus == "Kis boríték") {
		 		$return = "E" ;
		 	}
		 	else if (($szinszam_elo > 4 || $szinszam_hat > 4 || $kifuto == 1) && ($termektipus == "Nagy boríték" || $termektipus == "Egyéb")) {
		 		$return = "F" ;
		 	}		 	
		 	return $return ;
		 }
		
		/**
		 *  HTTP url hívás CURL-lal, a visszakapott adatokat adja vissza
		 */
		 function httpGet($url)
		{
			$ch = curl_init();  
		
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		//	curl_setopt($ch,CURLOPT_HEADER, false); 
		
			$output=curl_exec($ch);
		
			curl_close($ch);
			return $output;
		}
		
		/**
		 *  Windows-1250-es kódolású szöveget UTF-8-asra alakít
		 */
		function w1250_to_utf8($text) {
			$map = array(
				chr(0x8A) => chr(0xA9),
				chr(0x8C) => chr(0xA6),
				chr(0x8D) => chr(0xAB),
				chr(0x8E) => chr(0xAE),
				chr(0x8F) => chr(0xAC),
				chr(0x9C) => chr(0xB6),
				chr(0x9D) => chr(0xBB),
				chr(0xA1) => chr(0xB7),
				chr(0xA5) => chr(0xA1),
				chr(0xBC) => chr(0xA5),
				chr(0x9F) => chr(0xBC),
				chr(0xB9) => chr(0xB1),
				chr(0x9A) => chr(0xB9),
				chr(0xBE) => chr(0xB5),
				chr(0x9E) => chr(0xBE),
				chr(0x80) => '&euro;',
				chr(0x82) => '&sbquo;',
				chr(0x84) => '&bdquo;',
				chr(0x85) => '&hellip;',
				chr(0x86) => '&dagger;',
				chr(0x87) => '&Dagger;',
				chr(0x89) => '&permil;',
				chr(0x8B) => '&lsaquo;',
				chr(0x91) => '&lsquo;',
				chr(0x92) => '&rsquo;',
				chr(0x93) => '&ldquo;',
				chr(0x94) => '&rdquo;',
				chr(0x95) => '&bull;',
				chr(0x96) => '&ndash;',
				chr(0x97) => '&mdash;',
				chr(0x99) => '&trade;',
				chr(0x9B) => '&rsquo;',
				chr(0xA6) => '&brvbar;',
				chr(0xA9) => '&copy;',
				chr(0xAB) => '&laquo;',
				chr(0xAE) => '&reg;',
				chr(0xB1) => '&plusmn;',
				chr(0xB5) => '&micro;',
				chr(0xB6) => '&para;',
				chr(0xB7) => '&middot;',
				chr(0xBB) => '&raquo;',
			);
			return html_entity_decode(mb_convert_encoding(strtr($text, $map), 'UTF-8', 'ISO-8859-2'), ENT_QUOTES, 'UTF-8');
		}		 

		function DarabszamFormazas($darabszam) {
			return number_format($darabszam, 0, '.', ' ') ;	
		}
		
		function OsszegFormazas($osszeg, $tizedes = 2) {
			return number_format($osszeg, $tizedes, '.', ' ');		
		}
		
		function SulyFormazas($suly) {
			// LI: kilogrammban írja ne grammban
			return (number_format($suly / 1000, 0, '.', ' '));
		}

		// LI: egy session változóban tárolt url-re irányít át (az oldal nevét paraméterben várja)
		function gotoPrevPage ($pageName, $args = array()) {
			$link = Yii::app()->session[$pageName . Yii::app()->user->id . 'returnURL'] ;
			
			$args_string = "";
			if (count($args) > 0) {
				$args_string = "?" ;
				$link_args_string = substr($link, strpos($link, "?") + 1) ;
				$link_args = array() ;
				if ($link_args_string != "") {
					$link_args = explode("&", $link_args_string) ;	
				}
				$link = substr($link, 0, strpos($link, "?")) ;
				if (count($link_args) > 0) {
					foreach($link_args as $arg) {
						$arg_array = explode("=", $arg) ;
						if (isset($args[$arg_array[0]])) {
							$arg_array[1] = $args[$arg_array[0]] ;
							$args[$arg_array[0]] = "" ;
						}
						$args_string .= $arg_array[0] . "=" . $arg_array[1] . "&" ;
					}
					foreach ($args as $arg_name => $arg_value) {
						if ($arg_value != "") {
							$args_string .= $arg_name . "=" . $arg_value . "&" ;
						}
					}
					$args_string = rtrim($args_string, "&") ;
				}				
			}
			$this->redirect($link . $args_string);
		}
		
		// LI: egy sessionváltozóba menti a jelenlegi url-t (paraméterben várja, hogy milyen kulccsal mentse)
		function saveCurrentPage ($pageName) {
			Yii::app()->session[$pageName . Yii::app()->user->id . 'returnURL'] = Yii::app()->request->Url;
		}

		// LI: a sessionváltozóba mentett URL-t adja vissza (paraméterben várja, hogy milyen kulccsal mentse)
		function getPrevPageUrl ($pageName) {
			return Yii::app()->session[$pageName . Yii::app()->user->id . 'returnURL'];
		}
		
		// LI: az ékezeteket kicseréli a string-ben, az egyéb speciális karaktereket meg kiszűri
		function atalakit_ekezet_nelkulire ($string) {
			/*
			$mit =  array("ö","ü","ó","ú","ű","á","í","é","ő","Ö","Ü","Ó","Ő","Ú","Ű","Á","Í","É");
			$mire = array("o","u","o","u","u","a","i","e","o","o","u","o","o","u","u","a","i","e");

			$isUTF8 = preg_match('%^(?:
				 [\x09\x0A\x0D\x20-\x7E]           # ASCII
			   | [\xC2-\xDF][\x80-\xBF]            # non-overlong 2-byte
			   | \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
			   | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
			   | \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
			   | \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
			   | [\xF1-\xF3][\x80-\xBF]{3}         # planes 4-15
			   | \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
		   )*$%xs', $string);
			if(!$isUTF8){
				$string  = utf8_encode($string);
			}
			
			$string = str_replace($mit,$mire,strtolower($string));
			$string = preg_replace('/[^a-z0-9_\-\.]/i','',$string);
			*/
			
			$CHARMAP = array(  
			  'ö' => 'o',  
			  'Ö' => 'O',  
			  'ó' => 'o',  
			  'Ó' => 'O',  
			  'ő' => 'o',  
			  'Ő' => 'O',  
			  'ú' => 'u',  
			  'Ú' => 'U',  
			  'ű' => 'u',  
			  'Ű' => 'U',  
			  'ü' => 'u',  
			  'Ü' => 'U',  
			  'á' => 'a',  
			  'Á' => 'A',  
			  'é' => 'e',  
			  'É' => 'E',  
			  'í' => 'i',  
			  'Í' => 'I',  
			);  
			  
			$string = strtr($string, $CHARMAP);  
			  
			// minden más karakter  
			$string = preg_replace('/[^a-zA-Z0-9.*]/','_',$string); 
			
			return strtolower($string);
		}
	
		// LI: 'általános' e-mailküldő metódus, első körben a raktárkészlettel kapcsolatos figyelmeztető üzenetek kiküldéséhez használom
		function sendEmail ($recipients, $subject, $body_text, $attach_filename = null) {
			$mailer = Yii::app()->mailer;
			
			// debug-hoz
			// $mailer->SMTPDebug = 2;
			
			$validator = new CEmailValidator;

			// A $recipients lehet sima string, vagy akár tömb is, ha több címzettnek akarjuk küldeni az e-mailt.
			// Ha több, mint 1 címzett van, akkor az első címzett után CC-ben címződnek a többiek.
			
			if (is_array($recipients)) {
				$len = count($recipients);
				
				$isFirst = true;
				foreach ($recipients as $recipient) {
					if ($validator->validateValue($recipient)) {
						if ($isFirst) {
							$mailer->AddAddress($recipient, '');
							$isFirst = false;
						} else {
							$mailer->AddCC($recipient, '');
						}
					}
				}
			} else {
				if ($validator->validateValue($recipients)) {
					$mailer->AddAddress($recipients, '');
				} else
					return false;
			}

			$ArajanlatKuldoEmail = Yii::app()->config->get('ArajanlatKuldoEmail');
			$ArajanlatKuldoHost = Yii::app()->config->get('ArajanlatKuldoHost');
			$ArajanlatKuldoPort = Yii::app()->config->get('ArajanlatKuldoPort');
			$ArajanlatKuldoTitkositas = Yii::app()->config->get('ArajanlatKuldoTitkositas');
			$ArajanlatKuldoSMTP = Yii::app()->config->get('ArajanlatKuldoSMTP');
			
			if ($ArajanlatKuldoSMTP == 1)
				$ArajanlatKuldoSMTP = true;
			else
				$ArajanlatKuldoSMTP = false;
			
			$ArajanlatKuldoSMTPUser = Yii::app()->config->get('ArajanlatKuldoSMTPUser');
			$ArajanlatKuldoSMTPPassword = Yii::app()->config->get('ArajanlatKuldoSMTPPassword');
			$ArajanlatKuldoFromName = Yii::app()->config->get('ArajanlatKuldoFromName');

			$mailer ->Host = $ArajanlatKuldoHost;			// Az smtp szerver címe	-> admin beállításokból
			$mailer ->From = $ArajanlatKuldoEmail;			// A küldő e-mail címe	-> admin beállításokból
			$mailer ->Port = $ArajanlatKuldoPort;			// Az smtp szerver portja -> admin beállításokból
			$mailer ->FromName = $ArajanlatKuldoFromName;	// A küldő neve -> admin beállításokból
			$mailer ->AddReplyTo($ArajanlatKuldoEmail);		// A válasz e-mail cím, alapból a feladó e-mail címe lesz, ami az admin beállításokból jön
			$mailer ->isHTML(true);
			
			if ($ArajanlatKuldoSMTP) {
				$mailer ->IsSMTP();
				$mailer ->SMTPAuth=$ArajanlatKuldoSMTP;
				$mailer ->SMTPSecure = $ArajanlatKuldoTitkositas;	// Enable TLS encryption, `ssl` also accepted			
				$mailer ->Username = $ArajanlatKuldoSMTPUser;		// Az smtp bejelentkezéshez a usernév (e-mail cím) -> admin beállításokból
				$mailer ->Password = $ArajanlatKuldoSMTPPassword;	// Az smtp bejelentkezéshez a jelszó -> admin beállításokból				
			}
			
			if ($attach_filename != null) {
				$mailer -> AddEmbeddedImage($attach_filename, "image", $attach_filename);
			}
			
			$mailer ->CharSet = "utf-8";
			$mailer ->Encoding = "base64";		
			$mailer ->Subject = $subject;
			$mailer ->Body = $body_text;
			
			return $mailer ->Send();
		}
		
		// LI: visszaad egy string listát, ami a nagyfőnök jogosultsággal rendelkező felhasználók e-mail címei találhatók
		function getNagyfonokFelhasznaloEmailek () {
			$emailek = array();
			
			$sql = "
				SELECT tbl_users.email from authassignment
				INNER JOIN tbl_users ON authassignment.userid=tbl_users.id
				WHERE itemname = 'fonok'
			";

			$command = Yii::app()->db->createCommand($sql);
			$nagyfonokEmailek = $command->queryAll();
			
			if (is_array ($nagyfonokEmailek) ) {
				foreach ($nagyfonokEmailek as $email) {
					array_push($emailek, $email['email']);
				}
			}
			
			return $emailek;
		}
	
		// LI: visszaadja az aktuálisan bejelentkezett / paraméterben kapott felhasználó e-mail címét
		function getFelhasznaloEmail ($userId = null) {
			$resultEmail = '';

			$user = User::model()->findByPk($userId == null ? Yii::app()->user->id : $userId);
			if ($user != null) {
				$resultEmail = $user->email;
			}

			return $resultEmail;
		}
		
		// LI: visszaadja egy termék min. vagy max. raktárkészlete alá esése esetén értesítendő felhasználók e-mail címét listába szervezve
		function getRaktarkeszletLimitAtlepesEsetenErtesitendokEmail ($userId = null) {
			$emailek = array();
			
			$sql = "
				SELECT tbl_users.email from authassignment
				INNER JOIN tbl_users ON authassignment.userid = tbl_users.id
				INNER JOIN authitemchild ON authassignment.itemname = authitemchild.parent
				WHERE authitemchild.child = 'termekek.raktarkeszlethataratlepesertesites'
			";

			$command = Yii::app()->db->createCommand($sql);
			$nagyfonokEmailek = $command->queryAll();
			
			if (is_array ($nagyfonokEmailek) ) {
				foreach ($nagyfonokEmailek as $email) {
					array_push($emailek, $email['email']);
				}
			}
			
			return $emailek;
		}

		// LI: bejegyzést készít egy raktármozgásról (ezek lehetnek: lásd a lenti függvényt)
		function createRaktarMozgasTranzakció ($termekId, $anyagbeszallitas_id, $raktarhely_id, $foglal_darabszam, $betesz_kivesz_darabszam, $szallitolevel_nyomdakonyv_id, $tranzakcioDatum=null) {
			$raktarTermekekTranzakciok = new RaktarTermekekTranzakciok;
			
			$raktarTermekekTranzakciok->termek_id = $termekId;
			$raktarTermekekTranzakciok->anyagbeszallitas_id = $anyagbeszallitas_id;
			$raktarTermekekTranzakciok->raktarhely_id = $raktarhely_id;
			$raktarTermekekTranzakciok->tranzakcio_datum = $tranzakcioDatum == null ? date("Y-m-d H:i:s") : $tranzakcioDatum;
			$raktarTermekekTranzakciok->foglal_darabszam = $foglal_darabszam;
			$raktarTermekekTranzakciok->betesz_kivesz_darabszam = $betesz_kivesz_darabszam;
			$raktarTermekekTranzakciok->szallitolevel_nyomdakonyv_id = $szallitolevel_nyomdakonyv_id;
			
			$raktarTermekekTranzakciok->save(false);
		}
		
		// LI: 	egy belső függvény, ami a tételek raktárban történő helyváltoztatásait kezeli le 
		// 		tetelId 	- a szóban forgó megrendelésen lévő termék id-ja,
		// 		darabszam 	- az adott tételből hány darabra vonatkozik az elvégzendő művelet
		//		muvelet		- BERAK, FOGLAL, SZTORNOZ, KIVESZ, KIVESZ_SZTORNOZ értékek lehetnek itt
		//
		// LI: ha hozott borítékos, akkor nem foglalkozunk a raktárműveletekkel, mert nem saját borítékot használunk
		// LI: ha a termék szolgáltatás típusú, akkor nem foglalkozunk a raktárműveletekkel
		private function raktarMozgas ($tetelId, $darabszam, $muvelet, $szallitolevel_nyomdakonyv_id, $tranzakcioMentese=true, $checkNegativRaktarTermekek, $skipEmailSend, $tranzakcioDatum, $skipStornoPart, $megrendeles_tetel_id) {
			$result = true;
			
			$megrendeles_tetel = null;
			if ($megrendeles_tetel_id != null) {
				$megrendeles_tetel = MegrendelesTetelek::model() -> findByPk($megrendeles_tetel_id);
			}
			
			$hozottBoritekRaktarHely = Utils::getHozottBoritekRaktarHely ();
			
			if ($tetelId != null && $darabszam != null && $muvelet != null && $muvelet != "") {
				$termek = Termekek::model()->findByPk($tetelId);
				
				if ($termek != null && $termek->tipus != 'Szolgáltatás') {
					if ($muvelet != null && $muvelet != "") {
						if ($muvelet == 'BERAK') {
							// TODO: egyelőre ez az AnyagrendelesekController és AnyagbeszallitasokController osztályokban van kezelve
						} else if ($muvelet == 'FOGLAL' || $muvelet == 'SZTORNOZ') {
							if (!$skipStornoPart) {
								// 'sztorno' művelet kell a nyomdakönyv létrehozásakor/módosításakor is, mert az előző értékeket ki kell törölnünk, hogy újat vehessünk fel
								// végigmegyünk az elmentett FOGLAL típusú raktátranzakciókon és visszaírjuk őket a raktárba, majd töröljük a tételeket
								$raktarTermekekTranzakciok = RaktarTermekekTranzakciok::model()->findAllByAttributes(
										array(),
										$condition  = 'szallitolevel_nyomdakonyv_id = :szallitolevel_nyomdakonyv_id AND foglal_darabszam <> 0 AND termek_id = :termek_id',
										$params     = array(
												':szallitolevel_nyomdakonyv_id' => $szallitolevel_nyomdakonyv_id,
												':termek_id' => $termek ->id,
										)
								);

								if ($raktarTermekekTranzakciok != null && count($raktarTermekekTranzakciok > 0) && $termek != null) {
									foreach ($raktarTermekekTranzakciok as $raktarTermekekTranzakcio) {
										$raktarTermek = RaktarTermekek::model() -> findByAttributes(array('termek_id' => $termek->id, 'anyagbeszallitas_id' => $raktarTermekekTranzakcio->anyagbeszallitas_id));
										
										if ($raktarTermek != null) {
											$raktarTermek -> foglalt_db -= $raktarTermekekTranzakcio->foglal_darabszam * -1;
											$raktarTermek -> elerheto_db += $raktarTermekekTranzakcio->foglal_darabszam * -1;

											$raktarTermek ->save(false);

											if ($raktarTermekekTranzakcio != null) {
												$raktarTermekekTranzakcio->delete();
											}
										}

									}
								}
							}
							if ($muvelet == 'FOGLAL') {
								// leellenőrizzük még minden előtt, hogy tudunk-e megfelelő mennyiséget foglalni, ha nem, neki se állunk
								// nem engedünk mínuszba menni, mert az eléggé megbonyolítaná a raktárkezelés további részeit
								$elerheto_db = 0;
								if (!$skipEmailSend) {
									$elerheto_db = Utils::getTermekRaktarkeszlet($termek -> id, "elerheto_db", ($megrendeles_tetel == null || ($megrendeles_tetel != null && $megrendeles_tetel -> hozott_boritek != 1)));
								}
								if ($elerheto_db < $darabszam && !$skipEmailSend) {
									$recipients = Utils::getRaktarkeszletLimitAtlepesEsetenErtesitendokEmail();
									$termek_info = $termek->nev . ', jelenleg foglalható raktármennyiség:  <strong>' . $elerheto_db . ' db</strong>, foglalni kívánt darabszám: <strong>' . $darabszam . '</strong>';
									$email_body = Yii::app()->controller->renderPartial('application.views.szallitolevelek.ertesites_nincs_eleg_raktarkeszlet', array('termek_info'=>$termek_info), true);
									
									if (!$skipEmailSend) {
										Utils::sendEmail ($recipients, 'Figyelmeztetés! Termék elérhető mennyisége túl alacsony!', $email_body);
									}
									
									$result = false;
								} else {
									$raktarTermekek = RaktarTermekek::model() -> findAllByAttributes(array('termek_id' => $tetelId), array('order'=> ($megrendeles_tetel == null || ($megrendeles_tetel != null && $megrendeles_tetel -> hozott_boritek != 1)) ? 'id ASC' : 'raktarhely_id DESC'));
									$termek = Termekek::model() -> findByPk($tetelId);

									if ($raktarTermekek != null && count($raktarTermekek) > 0 && $termek != null) {
										// elindulunk a raktárkészlet megfelelő elemein és elkezdjük levonogatni a kért darabszámot
										$mentendoDarabszam = 0;
										
										foreach ($raktarTermekek as $raktarTermek) {
											// ha nem hozott borítékhoz foglalunk, akkor a hozott borítékos raktárhelyet ki kell hagyni, onnan nem szabad anyagot foglalni 'normál' munkákhoz,
											// hozott esetén először a hozott raktárból kell kivenni, amit lehet, aztán mehet a 'normál' raktárból
											if ($megrendeles_tetel == null || $megrendeles_tetel -> hozott_boritek == 1 || ($megrendeles_tetel -> hozott_boritek == 0 && $hozottBoritekRaktarHely -> id != $raktarTermek -> raktarhely_id)) {

												if ($raktarTermek -> elerheto_db < $darabszam) {
													$mentendoDarabszam = $raktarTermek -> elerheto_db;
													$darabszam -= $raktarTermek -> elerheto_db;
													
													$raktarTermek -> foglalt_db += $raktarTermek -> elerheto_db;
													$raktarTermek -> elerheto_db -= $raktarTermek -> elerheto_db;
												} else {
													$raktarTermek -> foglalt_db += $darabszam;
													$raktarTermek -> elerheto_db -= $darabszam;
													
													$mentendoDarabszam = $darabszam;
													$darabszam = 0;
												}

												$raktarTermek->save(false);
												
												// elmentjük a tranzakciót a statisztika készítéséhez
												if ($tranzakcioMentese && $mentendoDarabszam != 0) {
													Utils::createRaktarMozgasTranzakció ($termek->id, $raktarTermek->anyagbeszallitas_id, $raktarTermek->raktarhely_id, $mentendoDarabszam * -1, 0, $szallitolevel_nyomdakonyv_id, $tranzakcioDatum);
												}
												
												// ha sikeresen le tudtuk vonni a kívánt darabszámot a készletből, akkor megállhatunk, nem kell további anyagbeszállításokból levonni
												if ($darabszam == 0) {
													break;
												}
											}
										}
 
										// ez azért kell, hogy a hívó oldalon ki tudjuk jelezni, hogy mínuszos lett az összes mennyiség
										if ($darabszam > 0)
											$result = false;
									}
								}
							}
						} else if ( $muvelet == 'KIVESZ_SZTORNOZ') {
							if (!$skipStornoPart) {
								// 'sztorno' művelet kell szállítólevél létrehozásakor/módosításakor is, mert az előző értékeket ki kell törölnünk, hogy újat vehessünk fel
								// végigmegyünk az elmentett KIVESZ típusú tranzakciókon és visszaírjuk őket a raktárba, majd töröljük a tételeket
								$raktarTermekekTranzakciok = RaktarTermekekTranzakciok::model()->findAllByAttributes(
										array(),
										$condition  = 'szallitolevel_nyomdakonyv_id = :szallitolevel_nyomdakonyv_id AND betesz_kivesz_darabszam < 0 AND termek_id = :termek_id',
										$params     = array(
												':szallitolevel_nyomdakonyv_id' => $szallitolevel_nyomdakonyv_id,
												':termek_id' => $termek ->id,
										)
								);
								$termek = Termekek::model() -> findByPk($tetelId);

								if ($raktarTermekekTranzakciok != null && count($raktarTermekekTranzakciok > 0) && $termek != null) {
									foreach ($raktarTermekekTranzakciok as $raktarTermekekTranzakcio) {
										$raktarTermek = RaktarTermekek::model() -> findByAttributes(array('termek_id' => $termek->id, 'anyagbeszallitas_id' => $raktarTermekekTranzakcio->anyagbeszallitas_id, 'raktarhely_id'=>$raktarTermekekTranzakcio->raktarhely_id));
										
										if ($raktarTermek != null) {
											$raktarTermek -> foglalt_db += $raktarTermekekTranzakcio->betesz_kivesz_darabszam * -1;
											$raktarTermek -> osszes_db += $raktarTermekekTranzakcio->betesz_kivesz_darabszam * -1;

											$raktarTermek -> save(false);
										} else {
											// ha nem találunk ilyen raktártermék sort, akkor létrehozzuk azt
											$raktarTermekRestore = new RaktarTermekek();
											
											$raktarTermekRestore -> termek_id = $raktarTermekekTranzakcio -> termek_id;
											$raktarTermekRestore -> anyagbeszallitas_id = $raktarTermekekTranzakcio -> anyagbeszallitas_id;
											$raktarTermekRestore -> raktarhely_id = $raktarTermekekTranzakcio -> raktarhely_id;
											$raktarTermekRestore -> foglalt_db = $raktarTermekekTranzakcio->betesz_kivesz_darabszam * -1;
											$raktarTermekRestore -> osszes_db = $raktarTermekekTranzakcio->betesz_kivesz_darabszam * -1;
											$raktarTermekRestore -> elerheto_db = 0;
											
											$raktarTermekRestore -> save(false);
										}
										
										if ($tranzakcioMentese) {
											$raktarTermekekTranzakcio->delete();							
										}
									}
								}
							}							
						} else if ($muvelet == 'KIVESZ') {
							// csak azokat a tranzakciórekordokat használhatjuk fel a kivétre, amikre korábban történt a foglalás
							
							// NYOMÁSOS munka esetén itt NEM ÜRES eredményhalmazt kapunk vissza
							$sql = "
								SELECT * FROM dom_raktar_termekek_tranzakciok
								WHERE foglal_darabszam < 0 AND termek_id = " . mysql_escape_string($tetelId) . " AND szallitolevel_nyomdakonyv_id IN

								(SELECT id FROM dom_nyomdakonyv WHERE megrendeles_tetel_id = " . $megrendeles_tetel_id . ")
							";
								
							$command = Yii::app()->db->createCommand($sql);
							$raktarTermekTranzakciok = $command->queryAll();
							
							if (!is_array ($raktarTermekTranzakciok) || count($raktarTermekTranzakciok) == 0) {
								// NEM NYOMÁSOS munkát találtunk, így más lekérdezés kell, ugyanis a dom_nyomdakonyv táblában ilyenkor nincs rekord
								$sql = "
									SELECT * FROM dom_raktar_termekek_tranzakciok
										INNER JOIN dom_szallitolevelek ON dom_raktar_termekek_tranzakciok.szallitolevel_nyomdakonyv_id = dom_szallitolevelek.id
									WHERE foglal_darabszam < 0 AND dom_szallitolevelek.id=" . $szallitolevel_nyomdakonyv_id . " AND dom_raktar_termekek_tranzakciok.termek_id= " . mysql_escape_string($tetelId) . "
								";

								$command = Yii::app()->db->createCommand($sql);
								$raktarTermekTranzakciok = $command->queryAll();
							}
							
							$termek = Termekek::model() -> findByPk($tetelId);
							if (is_array ($raktarTermekTranzakciok) && count($raktarTermekTranzakciok) > 0 && $termek != null) {
								// elindulunk az egyes tranzakciókhoz tartozó raktárkészletek megfelelő elemein és elkezdjük levonogatni a kért darabszámot
								foreach ($raktarTermekTranzakciok as $tranzakcio) {
									$raktarTermek = RaktarTermekek::model()->findByAttributes(array('termek_id'=>$tetelId, 'anyagbeszallitas_id'=>$tranzakcio['anyagbeszallitas_id'], 'raktarhely_id'=>$tranzakcio['raktarhely_id']), array('order'=>'elerheto_db ASC'));
									
									if ($raktarTermek != null) {
									
									/*					
									echo 'MegrendelésTétel ID : ' . $megrendeles_tetel_id . '<br />';
									echo 'Anyagbeszállítás ID : ' . $raktarTermek->anyagbeszallitas_id . '<br />';
									echo 'Darabszám : ' . $darabszam . '<br />';
									echo 'Összes db: ' . $raktarTermek -> osszes_db . '<br />';
									echo 'Foglalt db: ' . $raktarTermek -> foglalt_db . '<br />';
									*/
									
										$maxLevonhato = $darabszam;
										if ($tranzakcio['foglal_darabszam'] * -1 < $darabszam) {
											$maxLevonhato = $tranzakcio['foglal_darabszam'] * -1;
										}

										if ($raktarTermek -> foglalt_db < $maxLevonhato) {
											$maxLevonhato = $raktarTermek -> foglalt_db;
										} 
										
										$raktarTermek -> foglalt_db -= $maxLevonhato;
										$raktarTermek -> osszes_db -= $maxLevonhato;
										
										$darabszam -= $maxLevonhato;
										$raktarTermek->save(false);

									/*	
									echo 'Összes db: ' . $raktarTermek -> osszes_db . '<br />';
									echo 'Foglalt db: ' . $raktarTermek -> foglalt_db . '<br />';
									echo 'Levont  db: ' . $maxLevonhato * -1 . '<br /><br />';
									*/
									
										// elmentjük a tranzakciót a statisztika készítéséhez
										if ($tranzakcioMentese && $maxLevonhato != 0) {
											Utils::createRaktarMozgasTranzakció ($termek->id, $raktarTermek->anyagbeszallitas_id, $raktarTermek->raktarhely_id, 0, $maxLevonhato * -1, $szallitolevel_nyomdakonyv_id, $tranzakcioDatum);
										}

										// itt vizsgáljuk, hogy a termék minimum raktárkészlete alá mentünk-e,
										// ha igen e-mailt küldünk azoknak felhasználóknak, akik jogosultat megkapni ezt az infót
										if (Utils::getTermekRaktarkeszlet($raktarTermek -> termek_id, "osszes_db", ($megrendeles_tetel == null || ($megrendeles_tetel != null && $megrendeles_tetel -> hozott_boritek != 1))) < $termek -> minimum_raktarkeszlet && !$skipEmailSend) {
											$recipients = Utils::getRaktarkeszletLimitAtlepesEsetenErtesitendokEmail();
											$termek_info = $termek->nev . ', jelenlegi raktármennyiség:  <strong>' . $raktarTermek -> osszes_db . ' db</strong>, minimum raktármennyiség: <strong>' . $termek -> minimum_raktarkeszlet . '</strong>';
											$email_body = Yii::app()->controller->renderPartial('application.views.szallitolevelek.ertesites_minimum_raktarkeszlet', array('termek_info'=>$termek_info), true);
											
											Utils::sendEmail ($recipients, 'Figyelmeztetés! Minimum raktárkészlet túllépve', $email_body);
										}
										
										if ($darabszam == 0) {
											break;
										}
									}
								}

								// ez azért kell, hogy a hívó oldalon ki tudjuk jelezni, hogy mínuszos lett az összes mennyiség
								$result = $darabszam == 0;
							}

						}
						
					}
				}

				if ($checkNegativRaktarTermekek) {
					// megnézzük van-e termék a negatív raktártermék táblában és ha igen, akkor kielégíthető-e valamely igény
					Utils::checkNegativRaktarTermekek();
				}
				
				// töröljük az olyan raktártermék sorokat, ahol az összes, elérhető és foglalt darabszámok is 0-ák
				Utils::removeEmptyRaktarTermekek();
			}
			
			return $result;
		}
		
		// LI: tétel raktárba történő bevétele
		function raktarbaBerak ($tetelId, $darabszam, $szallitolevel_nyomdakonyv_id=null, $tranzakcioMentese=true, $checkNegativRaktarTermekek=true, $skipEmailSend=false, $tranzakcioDatum=null, $skipStornoPart=false, $megrendeles_tetel_id=null) {
			return Utils::raktarMozgas ($tetelId, $darabszam, 'BERAK', $szallitolevel_nyomdakonyv_id, $tranzakcioMentese, $checkNegativRaktarTermekek, $skipEmailSend, $tranzakcioDatum, $skipStornoPart, $megrendeles_tetel_id);
		}
		
		// LI: tétel raktárban történő lefoglalása
		function raktarbanFoglal ($tetelId, $darabszam, $szallitolevel_nyomdakonyv_id, $tranzakcioMentese=true, $checkNegativRaktarTermekek=true, $skipEmailSend=false, $tranzakcioDatum=null, $skipStornoPart=false, $megrendeles_tetel_id=null) {
			return Utils::raktarMozgas ($tetelId, $darabszam, 'FOGLAL', $szallitolevel_nyomdakonyv_id, $tranzakcioMentese, $checkNegativRaktarTermekek, $skipEmailSend, $tranzakcioDatum, $skipStornoPart, $megrendeles_tetel_id);
		}

		// LI: tétel raktárban történő sztornózás
		function raktarbanSztornoz ($tetelId, $darabszam, $szallitolevel_nyomdakonyv_id, $tranzakcioMentese=true, $checkNegativRaktarTermekek=true, $skipEmailSend=false, $tranzakcioDatum=null, $skipStornoPart=false, $megrendeles_tetel_id=null) {
			return Utils::raktarMozgas ($tetelId, $darabszam, 'SZTORNOZ', $szallitolevel_nyomdakonyv_id, $tranzakcioMentese, $checkNegativRaktarTermekek, $skipEmailSend, $tranzakcioDatum, $skipStornoPart, $megrendeles_tetel_id);
		}
		
		// LI: tétel raktárból történő kivétele
		function raktarbolKivesz ($tetelId, $darabszam, $szallitolevel_nyomdakonyv_id, $tranzakcioMentese=true, $checkNegativRaktarTermekek=true, $skipEmailSend=false, $tranzakcioDatum=null, $skipStornoPart=false, $megrendeles_tetel_id=null) {
			return Utils::raktarMozgas ($tetelId, $darabszam, 'KIVESZ', $szallitolevel_nyomdakonyv_id, $tranzakcioMentese, $checkNegativRaktarTermekek, $skipEmailSend, $tranzakcioDatum, $skipStornoPart, $megrendeles_tetel_id);
		}
		
		// LI: tétel raktárból történő kivétel sztornózása
		function raktarbolKiveszSztornoz ($tetelId, $darabszam, $szallitolevel_nyomdakonyv_id, $tranzakcioMentese=true, $checkNegativRaktarTermekek=true, $skipEmailSend=false, $tranzakcioDatum=null, $skipStornoPart=false, $megrendeles_tetel_id=null) {
			return Utils::raktarMozgas ($tetelId, $darabszam, 'KIVESZ_SZTORNOZ', $szallitolevel_nyomdakonyv_id, $tranzakcioMentese, $checkNegativRaktarTermekek, $skipEmailSend, $tranzakcioDatum, $skipStornoPart, $megrendeles_tetel_id);
		}
		
		// LI: küldünk az árajnálat lérehozójának egy e-mailt, ami tartalmazza az e-mailből létrehozott megrendelés linkjét
		function sendEmailToArajanlatCreator ($megrendeles, $arajanlat) {
			if ($megrendeles != null && $arajanlat != null) {
				$user = User::model()->findByPk($arajanlat->admin_id);
				if ($user != null) {
					$arajanlat_letrehozo = $user->fullname;
				}
				
				$megrendeles_url = Yii::app()->controller->createAbsoluteUrl('megrendelesek/update', array('id'=>$megrendeles->id));
				$email_body = Yii::app()->controller->renderPartial('application.views.megrendelesek.megrendeles_ertesites_email_body', array('arajanlat_letrehozo'=>$arajanlat_letrehozo, 'megrendeles_url'=>$megrendeles_url), true);

				$recipient = Utils::getFelhasznaloEmail($arajanlat->admin_id);
				Utils::sendEmail ($recipient, 'Megrendelés érkezett', $email_body);
			}
		}
		
		// LI: lekérdezi egy megadott termék raktárban jelenleg tárolt valamely adatát: összes/foglalt/elérhető db
		//	   $skipHozottRaktarHely - default-ban TRUE, ilyenkor nem számoljuk bele a hozott borítékokat a lekérdezésbe, ha FALSE, akkor pedig igen
		function getTermekRaktarkeszlet ($termek_id, $mezo_neve, $skipHozottRaktarHely = true) {
			$hozottBoritekRaktarHely = Utils::getHozottBoritekRaktarHely();
			$skipHozottRaktarHelyWhere = $skipHozottRaktarHely ? " AND dom_raktar_termekek.raktarhely_id <> " . $hozottBoritekRaktarHely -> id : "";
			$sql = "SELECT SUM(" . $mezo_neve . ") as " . $mezo_neve . " from dom_raktar_termekek WHERE termek_id = :termek_id" . $skipHozottRaktarHelyWhere;
		
			$command = Yii::app() -> db -> createCommand($sql);
			$command->bindParam(':termek_id', $termek_id);
			
			$result = $command -> queryRow();
			
			return $result ? $result[$mezo_neve] : 0;			
		}
		
		// LI: lekérdezi a beállításokban beállított, nézetekben megjelenítendő sorok számát
		//     (ha nincs beállítva az alapértelmezett a 10 db)
		function getIndexPaginationNumber () {
			$pagination = Yii::app()->config->get('IndexViewPagination');

			if ($pagination == null || !is_numeric($pagination)) {
				$pagination = 10;
			}
			
			return $pagination;
		}
		
		//Visszaadja az alapértelemeztt ÁFA kulcs százalékos értékét
		function getAlapertelmezettAFASzazalek() {
			$afakulcsSzazalek = 0 ;
			$afaKulcs = AfaKulcsok::model()->findByAttributes(array("alapertelmezett"=>"1"));
			
			if ($afaKulcs != null){
				$afakulcsSzazalek = $afaKulcs->afa_szazalek;
			}			
			return $afakulcsSzazalek ;
		}
		
		// TÁ: Legenerál egy XML filet egy konkrét nyomdakönyvbe kerülő munka részleteiről
		function munkaTaskaXMLGeneralas($nyomdakonyv) {
			$megrendeles_tetel = MegrendelesTetelek::model()->findbyPk($nyomdakonyv->megrendeles_tetel_id) ;
			$gepTipusNev = "" ;
			$sql = "
						SELECT gep_tipusok.tipusnev FROM dom_nyomdagepek AS gepek
						INNER JOIN dom_nyomdagep_tipusok AS gep_tipusok ON
						gepek.id = gep_tipusok.gep_id
		
						WHERE (:szinszam >= szinszam_tol AND :szinszam <= szinszam_ig) AND (gep_tipusok.gep_id = :gep_id)
					";
		
			$osszSzin = $megrendeles_tetel->szinek_szama1 + $megrendeles_tetel->szinek_szama2;
			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(':szinszam', $osszSzin);
			$command->bindParam(':gep_id', $nyomdakonyv->gep_id);
			
			$result = $command->queryRow();
			
			if ($result) {
				$gepTipusNev = $result['tipusnev'];
			}
			
			$termek = Termekek::model()->findbyPk($megrendeles_tetel->termek_id);
			$termek_meret = TermekMeretek::model()->findByPk($termek -> meret_id);
			
			if ($termek_meret == null)
				$termek_meret = new TermekMeretek();
				
			$zarasmod = TermekZarasiModok::model()->findByPk($termek -> zaras_id);
			if ($zarasmod == null)
				$zarasmod = new TermekZarasiModok();
						
			$ablakmeret = TermekAblakMeretek::model()->findByPk($termek -> ablakmeret_id);
			if ($ablakmeret == null)
				$ablakmeret = new TermekAblakMeretek();
						
			$ablakhely = TermekAblakhelyek::model()->findByPk($termek -> ablakhely_id);
			if ($ablakhely == null)
				$ablakhely = new TermekAblakhelyek();
						
			$papirtipus = PapirTipusok::model()->findByPk($termek -> papir_id);
			if ($papirtipus == null)
				$papirtipus = new PapirTipusok();
						
			// ez csak egy évszám, ami nem tudom pontosan honnan jön, de kb. ez jó lehet ide, még pontosítani kell
			$fejlecDatum = "" ;
			if ($nyomdakonyv->hatarido != "0000-00-00 00:00:00") {
				$fejlecDatum = date('Y', strtotime(str_replace("-", "", $nyomdakonyv->hatarido)));
			}	
			
			$actualUserName = '';
			$actualUser = User::model()->findByPk(Yii::app()->user->getId());
			if ($actualUser != null) {
				$actualUserName	= $actualUser->fullname;
			}
			
			$gyartasIdeje = '';
			$normaAdat = Utils::getNormaadat($megrendeles_tetel->id, $nyomdakonyv->gep_id, $nyomdakonyv->munkatipus_id, $nyomdakonyv->max_fordulat);
			if ($normaAdat != null) {
				$gyartasIdeje = $normaAdat['normaido'];
			}
			
			$elooldal_szinek = array() ;
			$i = 1 ;
			if ($nyomdakonyv->szin_c_elo == 1) {
				$elooldal_szinek["szin$i"] = "C" ;	
				$i++ ;
			}
			if ($nyomdakonyv->szin_m_elo == 1) {
				$elooldal_szinek["szin$i"] = "M" ;	
				$i++ ;
			}
			if ($nyomdakonyv->szin_y_elo == 1) {
				$elooldal_szinek["szin$i"] = "Y" ;	
				$i++ ;
			}
			if ($nyomdakonyv->szin_k_elo == 1) {
				$elooldal_szinek["szin$i"] = "K" ;	
				$i++ ;
			}
		
			$hatoldal_szinek = array() ;
			$i = 1 ;
			if ($nyomdakonyv->szin_c_hat == 1) {
				$hatoldal_szinek["szin$i"] = "C" ;	
				$i++ ;
			}
			if ($nyomdakonyv->szin_m_hat == 1) {
				$hatoldal_szinek["szin$i"] = "M" ;	
				$i++ ;
			}
			if ($nyomdakonyv->szin_y_hat == 1) {
				$hatoldal_szinek["szin$i"] = "Y" ;	
				$i++ ;
			}
			if ($nyomdakonyv->szin_k_hat == 1) {
				$hatoldal_szinek["szin$i"] = "K" ;	
				$i++ ;
			}
			$pantone_elooldal_szinek = array() ;
			$pantone_hatoldal_szinek = array() ;
			if ($nyomdakonyv->szin_pantone != "") {
				$pantone_elol_hatul = explode("+", $nyomdakonyv->szin_pantone) ;
				if($pantone_elol_hatul[0] != "") {
					$pantone_elol = explode(",", $pantone_elol_hatul[0]) ;
					if (count($pantone_elol) > 0) {
						$i = 0 ;
						foreach ($pantone_elol as $szin) {
							$i++ ;
							if (trim($szin) != "") {
								$pantone_elooldal_szinek["szin$i"] = trim($szin) ;
							}
						}
					}
				}
				if($pantone_elol_hatul[1] != "") {
					$pantone_hatul = explode(",", $pantone_elol_hatul[1]) ;
					if (count($pantone_hatul) > 0) {
						$i = 0 ;
						foreach ($pantone_hatul as $szin) {
							$i++ ;
							if (trim($szin) != "") {
								$pantone_hatoldal_szinek["szin$i"] = trim($szin) ;
							}
						}
					}
				}
			}
			
			$munkataska = array() ;
			$munkataska["Taskaszam"] = $nyomdakonyv->taskaszam ;
			$munkataska["Hatarido"] = $nyomdakonyv->hatarido ;
			$munkataska["GepTipusNev"] = $gepTipusNev;
			$munkataska["SOS"] = $nyomdakonyv->sos ;
			$munkataska["Munkanev"] = $megrendeles_tetel->munka_neve ;
			$munkataska["GyartasIdeje"] = $gyartasIdeje ;
			$munkataska["LemezSzam"] = $osszSzin ;
			$munkataska["TermekNev"] = $megrendeles_tetel->getTetelnevHozottNemHozott() . $termek->getDisplayTermekTeljesNev() ;
			$munkataska["Darabszam"] = $megrendeles_tetel->darabszam ;
			$munkataska["PantoneElooldal"] = $pantone_elooldal_szinek ;
			$munkataska["PantoneHatoldal"] = $pantone_hatoldal_szinek ;
			$munkataska["ElooldalSzinek"] = $elooldal_szinek ;
			$munkataska["HatoldalSzinek"] = $hatoldal_szinek ;
			$munkataska["UtasitasGepmesternek"] = $nyomdakonyv->utasitas_gepmesternek ;
			$munkataska["UtasitasCTPnek"] = $nyomdakonyv->utasitas_ctp_nek ;
			$munkataska["MagasSzinterhelesNagyFeluleten"] = $nyomdakonyv->magas_szinterheles_nagy_feluleten ;
			$munkataska["MagasSzinterhelesSzovegben"] = $nyomdakonyv->magas_szinterheles_szovegben ;
			$munkataska["NyomasTipus"] = $nyomdakonyv->nyomas_tipus ;
			$munkataska["NyomasMintaSzerint"] = $nyomdakonyv->nyomas_minta_szerint ;
			$munkataska["NyomasVagojelSzerint"] = $nyomdakonyv->nyomas_vagojel_szerint ;
			$munkataska["NyomasDomySzerint"] = $nyomdakonyv->nyomas_domy_szerint ;
			$munkataska["NyomasSpecialis"] = $nyomdakonyv->nyomas_specialis ;
			$munkataska["MegrendelesKelte"] = $megrendeles_tetel->megrendeles->rendeles_idopont ;
			$munkataska["MunkaBeerkezett"] = $nyomdakonyv->munka_beerkezes_datum ;
			$munkataska["TaskaKiadasDatum"] = $nyomdakonyv->taska_kiadasi_datum ;
			$munkataska["UgyfelKapcsolattartoNev"] = $megrendeles_tetel->megrendeles->ugyfel->kapcsolattarto_nev;
			$munkataska["UgyfelKapcsolattartoTelefon"] = $megrendeles_tetel->megrendeles->ugyfel->kapcsolattarto_telefon;						
			
			$munkataska_kesz["Munkataska"] = $munkataska ; 
			$xml_munkataska = new SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-2"?><Munkataska/>');
			Utils::array_to_xml($munkataska, $xml_munkataska) ;
			$MunkataskaXmlExportPath = Yii::app()->config->get('MunkataskaXmlExportPath');		//Ennek a beállítási lehetőségét betenni a nyomdakönyvi beállítások oldalra
			$xml_munkataska->asXML($MunkataskaXmlExportPath . "/" . $nyomdakonyv->taskaszam . ".xml");			
			
		}

		// LI : az adott munka foglalása a negatív raktárban van-e (true, false)
		function isMunkaInNegativRaktar ($nyomdakonyv_id) {
			$nyomdakonyv = Nyomdakonyv::model()->findByPk ($nyomdakonyv_id);
			
			if ($nyomdakonyv != null) {
				$negativRaktarTermek = RaktarTermekekNegativ::model() -> findByAttributes(array('nyomdakonyv_id' => $nyomdakonyv->id));
				
				return $negativRaktarTermek != null;
			}
			
			return false;
		}
		
		// LI : nyomdakönyv sztornózásakor törlésekor, sztornózásakor a negatív táblában lévő, megrendeléshez kapcsolódó termékeket kitöröljük
		function negativRaktarbanSztornoz ($nyomdakonyv_id) {
			$negativRaktarTermek = RaktarTermekekNegativ::model() -> findByAttributes(array('nyomdakonyv_id' => $nyomdakonyv_id));
			
			if ($negativRaktarTermek != null) {
				$negativRaktarTermek -> delete ();
			}
		}
		
		// LI : végigmegy a negatív raktárban lévő termékeken és kielégít minden foglalási igényt, amit a jelenlegi raktárkészlet alapján tud
		function checkNegativRaktarTermekek () {
			$sql = 
			"
				SELECT
					dom_raktar_termekek_negativ.id AS negativ_raktar_termek_id,
					dom_raktar_termekek_negativ.termek_id AS termek_id,
					dom_raktar_termekek_negativ.darabszam AS darabszam,
					dom_raktar_termekek_negativ.nyomdakonyv_id AS nyomdakonyv_id,
					dom_megrendeles_tetelek.id AS megrendeles_tetel_id,
					dom_megrendeles_tetelek.hozott_boritek AS hozott_boritek
					
				FROM dom_raktar_termekek_negativ

				INNER JOIN dom_nyomdakonyv ON
				dom_raktar_termekek_negativ.nyomdakonyv_id = dom_nyomdakonyv.id

				INNER JOIN dom_megrendeles_tetelek ON
				dom_nyomdakonyv.megrendeles_tetel_id = dom_megrendeles_tetelek.id
			";
			
			$negativRaktarTermekek = Yii::app() -> db -> createCommand  ($sql) -> queryAll();
			
			if ($negativRaktarTermekek != null) {

				foreach ($negativRaktarTermekek as $negativRaktarTermek) {
					if (Utils::getTermekRaktarkeszlet($negativRaktarTermek['termek_id'], 'elerheto_db', $negativRaktarTermek['hozott_boritek'] != 1) >= $negativRaktarTermek['darabszam']) {
						// találtunk a soron következő foglalási igényhez elegendő terméket a raktárban, így elindítjuk a foglalást, majd töröljük a negatív raktártermék táblából az igényt
						Utils::raktarbanFoglal($negativRaktarTermek['termek_id'], $negativRaktarTermek['darabszam'], $negativRaktarTermek['nyomdakonyv_id'], true, false, false, null, false, $negativRaktarTermek['megrendeles_tetel_id']);

						// megkeressük a megrendelés tételt és levesszük róla a flag-et, ami jelzi, hogy negatív raktárban van a foglalási igény
						$nyomdakonyv = Nyomdakonyv::model() -> findByPk ($negativRaktarTermek['nyomdakonyv_id']);
						if ($nyomdakonyv != null) {
							$nyomdakonyv -> megrendeles_tetel -> negativ_raktar_termek = 0;
							$nyomdakonyv -> megrendeles_tetel -> save (false);
						}
						
						// töröljük a negatív raktárban lévő tételt
						RaktarTermekekNegativ::model() -> findByPk ($negativRaktarTermek['negativ_raktar_termek_id']) -> delete();
					}
				}
				
			}
		}

		// LI : törli az olyan raktártermék sorokat, ahol az összes, elérhető és foglalt darabszámok is 0-ák
		function removeEmptyRaktarTermekek () {
			RaktarTermekek::model() ->deleteAllByAttributes (array ('osszes_db' => 0, 'foglalt_db' => 0, 'elerheto_db' => 0));
		}

		
		/**
		 *  LI: raktárban történő átmozgatásnál a foglalt db mennyiségeket itt kezeljük le
		 *		$raktarTermek - a raktár termék DB rekord, ahonnan az áhelyezés indul
		 *		$model		  - az áthelyezős formon kitöltött adatokat tartalmazó objektum
		 */
		function foglaltDbAtmozgatas ($raktarTermek, $model) {
			$tranzakciok = RaktarTermekekTranzakciok::model()->findAll(array(
				'condition'=>'termek_id=:termek_id AND anyagbeszallitas_id=:anyagbeszallitas_id AND raktarhely_id = :raktarhely_id AND (foglal_darabszam < 0 OR betesz_kivesz_darabszam < 0)',
				'params'=>array(':termek_id' => $raktarTermek->termek_id, ':anyagbeszallitas_id'=>$raktarTermek->anyagbeszallitas_id, ':raktarhely_id'=>$model->forrasRaktarHelyId),
				'order'=>'foglal_darabszam ASC',
			));
			
			if ($tranzakciok != null && is_array($tranzakciok)) {
				// 1. lépés összeadjuk azon elemeket, amik már kivételre kerültek
				$osszesKivet = 0;
				foreach ($tranzakciok as $tranzakcio) {
					$osszesKivet += abs($tranzakcio->betesz_kivesz_darabszam);
				}

				// 2. lépés elkezdjük a legnagyobb foglalástól levonogatni az áthelyezendő mennyiséget (figyelembe véve azt a darabszámot, amit közben esetleg már kivettek a raktárból)
				$celDb = $model -> celFoglaltDb;
				
				if ($celDb > 0) {
					foreach ($tranzakciok as $tranzakcio) {
						// elértünk a levoonogatás végére
						if ($celDb == 0) {
							break;
						}
						
						$foglalt = abs($tranzakcio->foglal_darabszam);
						
						// nem elégíthető ki egy az egyben a soron következő tranzakcióval a kívánt darabszám
						if ($foglalt < ($celDb + $osszesKivet)) {
							if ($osszesKivet >= $foglalt) {
								$osszesKivet -= $foglalt;
							} else {
								$foglalt -= $osszesKivet;
								$osszesKivet = 0;

								// a célhelyre írjuk a maradékot
								Utils::createRaktarMozgasTranzakció ($raktarTermek->termek_id, $raktarTermek->anyagbeszallitas_id, $model->celRaktarHelyId, $foglalt * -1, 0, $tranzakcio->szallitolevel_nyomdakonyv_id);
								$tranzakcio->delete();
								$celDb -= $foglalt;
							}
						} else if ($foglalt == ($celDb + $osszesKivet)) {
								Utils::createRaktarMozgasTranzakció ($raktarTermek->termek_id, $raktarTermek->anyagbeszallitas_id, $model->celRaktarHelyId, $celDb * -1, 0, $tranzakcio->szallitolevel_nyomdakonyv_id);
								$tranzakcio->delete();
								$celDb = 0;
						} else if ($foglalt > ($celDb + $osszesKivet)) {
								Utils::createRaktarMozgasTranzakció ($raktarTermek->termek_id, $raktarTermek->anyagbeszallitas_id, $model->celRaktarHelyId, $celDb * -1, 0, $tranzakcio->szallitolevel_nyomdakonyv_id);
								$tranzakcio->foglal_darabszam = $celDb - $foglalt;
								$tranzakcio->save(false);
								$celDb = 0;
						}
					}
				}
			}
		}
		
		/**
		 *  LI: raktárban történő átmozgatásnál az elérhető db mennyiségeket itt kezeljük le
		 *		$raktarTermek - a raktár termék DB rekord, ahonnan az áhelyezés indul
		 *		$model		  - az áthelyezős formon kitöltött adatokat tartalmazó objektum
		 */
		function elerhetoDbAtmozgatas ($raktarTermek, $model) {
			$tranzakciok = RaktarTermekekTranzakciok::model()->findAll(array(
				'condition'=>'termek_id=:termek_id AND anyagbeszallitas_id=:anyagbeszallitas_id AND raktarhely_id = :raktarhely_id AND (foglal_darabszam < 0 OR betesz_kivesz_darabszam < 0)',
				'params'=>array(':termek_id' => $raktarTermek->termek_id, ':anyagbeszallitas_id'=>$raktarTermek->anyagbeszallitas_id, ':raktarhely_id'=>$model->forrasRaktarHelyId),
				'order'=>'betesz_kivesz_darabszam DESC',
			));
			
			if ($tranzakciok != null && is_array($tranzakciok)) {
				// 1. lépés összeadjuk azon elemeket, amik már kivételre kerültek
				$osszesBetet = 0;
				foreach ($tranzakciok as $tranzakcio) {
					$osszesBetet += abs($tranzakcio->betesz_kivesz_darabszam);
				}

				// 2. lépés elkezdjük a legnagyobb foglalástól levonogatni az áthelyezendő mennyiséget (figyelembe véve azt a darabszmot, amit közben esetleg már kivettek a raktárból)
				$celDb = $model -> celFoglaltDb;
				
				if ($celDb > 0) {
					foreach ($tranzakciok as $tranzakcio) {
						// elértünk a levoonogatás végére
						if ($celDb == 0) {
							break;
						}
						
						$foglalt = abs($tranzakcio->foglal_darabszam);
						
						// nem elégíthető ki egy az egyben a soron következő tranzakcióval a kívánt darabszám
						if ($foglalt < ($celDb + $osszesBetet)) {
							if ($osszesBetet >= $foglalt) {
								$osszesBetet -= $foglalt;
							} else {
								$foglalt -= $osszesBetet;
								$osszesBetet = 0;

								// a célhelyre írjuk a maradékot
								Utils::createRaktarMozgasTranzakció ($raktarTermek->termek_id, $raktarTermek->anyagbeszallitas_id, $model->celRaktarHelyId, $foglalt * -1, 0, $tranzakcio->szallitolevel_nyomdakonyv_id);
								$tranzakcio->delete();
								$celDb -= $foglalt;
							}
						} else if ($foglalt == ($celDb + $osszesBetet)) {
								Utils::createRaktarMozgasTranzakció ($raktarTermek->termek_id, $raktarTermek->anyagbeszallitas_id, $model->celRaktarHelyId, $celDb * -1, 0, $tranzakcio->szallitolevel_nyomdakonyv_id);
								$tranzakcio->delete();
								$celDb = 0;
						} else if ($foglalt > ($celDb + $osszesBetet)) {
								Utils::createRaktarMozgasTranzakció ($raktarTermek->termek_id, $raktarTermek->anyagbeszallitas_id, $model->celRaktarHelyId, $celDb * -1, 0, $tranzakcio->szallitolevel_nyomdakonyv_id);
								$tranzakcio->foglal_darabszam = $celDb - $foglalt;
								$tranzakcio->save(false);
								$celDb = 0;
						}
					}
				}
			}
		}

		function adatszinkronizacio() {
			$fp = fopen('szinkron_log.txt', 'a');
			fwrite($fp, date("Y-m-d H:i:s") . ": indult\n");
			fclose($fp);
			// Nyomdakönyvi munkák szinkronizációja
			$nyc = Yii::app()->createController('Nyomdakonyv');
			$nyomdakonyv_controller = $nyc[0] ;

			$nyomdakonyv_controller->NyitottNyomdakonyvAdatszinkron() ;
			$fp = fopen('szinkron_log.txt', 'a');
			fwrite($fp, date("Y-m-d H:i:s") . ": Nyomdakönyv adatszinkron kész\n");
			fclose($fp);
			// Nyomdakönyvi munkák szinkronizációja eddig
			// Megrendelések begyűjtése és számlák szinkronizációja
			$fp = fopen('szinkron_log.txt', 'a');
			fwrite($fp, date("Y-m-d H:i:s") . ": Számlakiegyenlítettség adatszinkron indult\n");
			fclose($fp);
			Utils::szamla_kiegyenlitettseg_szinkron() ;
			$fp = fopen('szinkron_log.txt', 'a');
			fwrite($fp, date("Y-m-d H:i:s") . ": Számlakiegyenlítettség adatszinkron kész\n");
			fclose($fp);
			$mc = Yii::app()->createController('Megrendelesek');
			$megrendelesek_controller = $mc[0] ;
			$megrendelesek_controller->webaruhazMegrendelesekBegyujt() ;
//			Yii::app()->runController('Megrendelesek/MegrendelesekBegyujt') ;
			$megrendeles_model=new Megrendelesek('search');
			$megrendeles_model->unsetAttributes();
			$c = new CDbCriteria;
			$c->order = "rendeles_idopont DESC" ;
			$c->select = "t.id" ;
			$c->join = "left join dom_ugyfelek on t.ugyfel_id = dom_ugyfelek.id" ;
			if (Yii::app()->user->checkAccess('Admin') == false) {
				$c->addCondition('t.torolt = 0') ;
			}
			if(isset($_GET['Megrendelesek']) && count($_GET['Megrendelesek'])) {
				$megrendeles_model->attributes=$_GET['Megrendelesek'];
				foreach ($_GET["Megrendelesek"] as $kulcs => $ertek) {
					if ($ertek != "") {
						$mezonev = "" ;
						switch ($kulcs) {
							case 'sorszam': $mezonev = 'sorszam' ;
								break ;
							case 'cegnev_search': $mezonev = 'dom_ugyfelek.cegnev' ;
								break ;
						}
						$c->addCondition($mezonev . " = '" . $ertek . "'") ;
					}
				}
			}
//Normál esetben nem ellenőrizzük végig mindet, mert csak viszi az erőforrást, ha szinkronizálni kell, akkor viszont jól jön ez
//		$dataProvider=new CActiveDataProvider('Megrendelesek', array('criteria'=>$c,'pagination'=>false)) ;
//Ha csak annyit néznénk végig, amennyi egy oldalra normál esetben kifér
//			$dataProvider=new CActiveDataProvider('Megrendelesek', array('criteria'=>$c)) ;
//
			$dataProvider=new CActiveDataProvider('Megrendelesek', array('criteria'=>$c, 'pagination'=>array('pageSize'=>1000,),)) ;

			//Normál esetben nem ellenőrizzük végig mindet, mert csak viszi az erőforrást, ha szinkronizálni kell, akkor viszont jól jön ez
			foreach ($dataProvider->getData() as $sor) {
				$megrendelesek_controller->checkSzamlaSorszam($sor->id) ;
			}

			// Megrendelések begyűjtése és számlák szinkronizációja eddig

			$fp = fopen('szinkron_log.txt', 'a');
			fwrite($fp, date("Y-m-d H:i:s") . ": lefutott\n");
			fclose($fp);
		}

		/**
		 * Időzített munkánál kerül meghívásra, a tipikusan használt statisztikákat legenerálja és a statisztika cache táblába belerakatja az eredményt
		 * Így később, normál hívásnál, ha van cachelve az adott statisztika adott paraméterekkel, betölti onnan az eredményt
		 */
		public function statisztika_generalas_cachebe()
		{
			$statisztikak_controller = Yii::app()->createController('Statisztikak');
			$statisztika_controller = $statisztikak_controller[0];
			//Napi statisztika generálás
			$statisztika_controller->actionNapiKombinaltStatisztikaPrintPDF("", "", true);
			//Havi "napi" és beszállítói statisztika generálás
			$mettol_date = new DateTime("first day of this month");
			$meddig_date = new DateTime("last day of this month");
			$mettol_datum = $mettol_date->format('Y-m-d');
			$meddig_datum = $meddig_date->format('Y-m-d');
			$statisztika_controller->actionNapiKombinaltStatisztikaPrintPDF($mettol_datum, $meddig_datum, true);
			$beszallito_stat_model = new StatisztikakBeszallitoiStatisztika;
			$beszallito_stat_model->statisztika_mettol = $mettol_datum;
			$beszallito_stat_model->statisztika_meddig = $meddig_datum;
			//Euro
			$beszallito_stat_model->gyarto_id = 1 ;
			$statisztika_controller->beszallitoiStatisztikaPrintPDF($beszallito_stat_model, true);
			//Harmanec
			$beszallito_stat_model->gyarto_id = 11 ;
			$statisztika_controller->beszallitoiStatisztikaPrintPDF($beszallito_stat_model, true);
			//GPV
			$beszallito_stat_model->gyarto_id = 6 ;
			$statisztika_controller->beszallitoiStatisztikaPrintPDF($beszallito_stat_model, true);
			//Global pack
			$beszallito_stat_model->gyarto_id = 9 ;
			$statisztika_controller->beszallitoiStatisztikaPrintPDF($beszallito_stat_model, true);
			//Előző havi "napi" és beszállítói statisztika generálás
			$mettol_date = new DateTime("first day of last month");
			$meddig_date = new DateTime("last day of last month");
			$mettol_datum = $mettol_date->format('Y-m-d');
			$meddig_datum = $meddig_date->format('Y-m-d');
			$statisztika_controller->actionNapiKombinaltStatisztikaPrintPDF($mettol_datum, $meddig_datum, true);
			$beszallito_stat_model->statisztika_mettol = $mettol_datum;
			$beszallito_stat_model->statisztika_meddig = $meddig_datum;
			//Euro
			$beszallito_stat_model->gyarto_id = 1 ;
			$statisztika_controller->beszallitoiStatisztikaPrintPDF($beszallito_stat_model, true);
			//Harmanec
			$beszallito_stat_model->gyarto_id = 11 ;
			$statisztika_controller->beszallitoiStatisztikaPrintPDF($beszallito_stat_model, true);
			//GPV
			$beszallito_stat_model->gyarto_id = 6 ;
			$statisztika_controller->beszallitoiStatisztikaPrintPDF($beszallito_stat_model, true);
			//Global pack
			$beszallito_stat_model->gyarto_id = 9 ;
			$statisztika_controller->beszallitoiStatisztikaPrintPDF($beszallito_stat_model, true);
			//Aktuális éves beszállítói statisztika generálás
			$mettol_datum = date('Y-01-01');
			$meddig_datum = date('Y-12-31');
			$beszallito_stat_model->statisztika_mettol = $mettol_datum;
			$beszallito_stat_model->statisztika_meddig = $meddig_datum;
			//Euro
			$beszallito_stat_model->gyarto_id = 1 ;
			$statisztika_controller->beszallitoiStatisztikaPrintPDF($beszallito_stat_model, true);
			//Harmanec
			$beszallito_stat_model->gyarto_id = 11 ;
			$statisztika_controller->beszallitoiStatisztikaPrintPDF($beszallito_stat_model, true);
			//GPV
			$beszallito_stat_model->gyarto_id = 6 ;
			$statisztika_controller->beszallitoiStatisztikaPrintPDF($beszallito_stat_model, true);
			//Global pack
			$beszallito_stat_model->gyarto_id = 9 ;
			$statisztika_controller->beszallitoiStatisztikaPrintPDF($beszallito_stat_model, true);
		}

		/**
		* Újragenerálja a dom_raktar_termekek és a dom_raktar_termekek_tranzakciok táblák tartalmát.
		**/
		public function raktarTermekekUjrageneralas () {
			$time_start = microtime(true);
			
			set_time_limit(0);
			ini_set('memory_limit', '2048M');
			
			$connection = Yii::app() -> db;

			/**
			 * 0. lépés
			 * Kiválogatjuk a dom_raktar_termekek_tranzakciok táblából a 'betét' jellegű sorokat.
			 **/
			$raktarTermekekBevetel = RaktarTermekekTranzakciok::model()->findAllByAttributes(
					array(),
					$condition  = 'betesz_kivesz_darabszam > 0 AND foglal_darabszam = 0 AND szallitolevel_nyomdakonyv_id = 0'
			);

			/**
			 * 1. lépés
			 * Töröljük a dom_raktar_termekek és dom_raktar_termekek_tranzakciok táblák tartalmát, valamint a negativ_raktar_termek flag-et a megrendelés tételekről
			 **/

			$sql = "TRUNCATE dom_raktar_termekek";
			$command = $connection -> createCommand($sql);
			$command -> execute();
			
			$sql = "TRUNCATE dom_raktar_termekek_tranzakciok";
			$command = $connection -> createCommand($sql);
			$command -> execute();
			
			$sql = "TRUNCATE dom_raktar_termekek_negativ";
			$command = $connection -> createCommand($sql);
			$command -> execute();
			
			$sql = "UPDATE dom_megrendeles_tetelek SET dom_megrendeles_tetelek.negativ_raktar_termek = 0";
			$command = $connection -> createCommand($sql);
			$command -> execute();
			
			/**
			 * 2. lépés
			 * Bevételezzük a raktár(ak)ba az összes terméket, amit találtunk a 0. lépésben.
			 **/

			if ($raktarTermekekBevetel != null) {
				while( $bevetel = array_pop($raktarTermekekBevetel)) {
					$raktarTermek = RaktarTermekek::model()->findByAttributes( array('termek_id' => $bevetel -> termek_id, 'anyagbeszallitas_id' => $bevetel -> anyagbeszallitas_id, 'raktarhely_id' => $bevetel -> raktarhely_id) );
					
					$rendelt_darabszam = $bevetel -> betesz_kivesz_darabszam;
					
					// ha van már a raktárban ilyen termék, akkor frissítjük a darabszámát
					if ($raktarTermek != null) {
						$raktarTermek -> elerheto_db += $rendelt_darabszam;
						$raktarTermek -> osszes_db += $rendelt_darabszam;
					} else {
						// ha nincs, akkor létrehozunk egy új bejegyzést
						$raktarTermek = new RaktarTermekek;
						$raktarTermek -> termek_id = $bevetel -> termek_id;
						$raktarTermek -> raktarhely_id = $bevetel -> raktarhely_id;
						$raktarTermek -> anyagbeszallitas_id = $bevetel -> anyagbeszallitas_id;
						
						$raktarTermek -> elerheto_db = $rendelt_darabszam;
						$raktarTermek -> osszes_db = $rendelt_darabszam;
					}
					
					$raktarTermek -> save (false);
					
					// a tranzakció adatait külön menjtük (jelenleg csak a statisztikákhoz szükséges)
					$raktarTermekekTranzakciok = new RaktarTermekekTranzakciok;
					$raktarTermekekTranzakciok->termek_id = $raktarTermek->termek_id;
					$raktarTermekekTranzakciok->anyagbeszallitas_id = $raktarTermek->anyagbeszallitas_id;
					$raktarTermekekTranzakciok->raktarhely_id = $bevetel -> raktarhely_id;
					$raktarTermekekTranzakciok->tranzakcio_datum = $bevetel->tranzakcio_datum;
					$raktarTermekekTranzakciok->betesz_kivesz_darabszam = $rendelt_darabszam;
					$raktarTermekekTranzakciok->save(false);
					
					unset($bevetel);
					unset($raktarTermek);
					unset($raktarTermekekTranzakciok);
				}
				
				unset($raktarTermekekBevetel);
			}

			/**
			 * 3. lépés
			 * Lefoglaljuk a nyomdakönyvben található termékeket a raktárban.
			 **/
			$nyomdakonyvek = Nyomdakonyv::model()->findAll(array(
				'condition'=>'torolt = 0 AND sztornozva = 0',
				'order'=>'megrendeles_tetel_id ASC',
			));			
			
			if ($nyomdakonyvek != null) {
				// találtam néhány megrendeles_tetel_id-ból többet, elvileg ugye nem lehet ilyen, ha csak nem storno vagy törlés történt, de mégis van
				// a változó segítségével vizsgálom, hogy volt-e már egy megadott megrendelés tétel, ha igen, akkor skip
				$elozoMegrendelesTetelId = 0;
				$kulonbozet = 0;
				
				$tempanyagBeszallitasId = Utils::getOrCreateTempAnyagbeszallitas();
				
				while($nyomdakonyv = array_pop($nyomdakonyvek)) {
					$tetel = $nyomdakonyv -> megrendeles_tetel;
					
					if ($tetel != null && $elozoMegrendelesTetelId != $tetel->id) {
						$elozoMegrendelesTetelId = $tetel->id;
						$elerheto_db = Utils::getTermekRaktarkeszlet($tetel -> termek_id, "elerheto_db");

						// ha van elérhető mennyiség az adott termékből raktáron, akkor szimplán foglalásba tesszük
						if ( $elerheto_db >= $tetel -> darabszam) {
							// a raktárban foglaljuk a megfelelő mennyiséget
							Utils::raktarbanFoglal($tetel -> termek_id, $tetel -> darabszam, $nyomdakonyv->id, true, true, true, $nyomdakonyv->munka_beerkezes_datum, true);
						} else {
							// megnézzük, hogy annak ellenére, hogy nincs a raktárban elérhető mennyiség történt-e az adott foglalás mennyiségét teljesen
							// kielégítő szállítólevél létrehozás
							$szallitonVan = Utils::isNyomdakonyvSzalliton($nyomdakonyv);
							
							// ha igen, akkor úgy vesszük, hogy adathiba van, és létrehozunk a darabszám különbségével egy beszállítást, hogy legyen elég darab a foglaláshoz,
							// majd foglalunk
							if ($szallitonVan) {
								Utils::createBeszallitas ($tetel->termek_id, $tetel -> darabszam - $elerheto_db, $tempanyagBeszallitasId);
								
								// a raktárban foglaljuk a megfelelő mennyiséget
								Utils::raktarbanFoglal($tetel -> termek_id, $tetel -> darabszam, $nyomdakonyv->id, true, true, true, $nyomdakonyv->munka_beerkezes_datum, true);
							} else {
								// ha nincs szállítólevélre rakva még a foglalni kívánt termékből az adott mennyiség, akkor megy a negatív raktárba
								$raktarTermekNegativ = new RaktarTermekekNegativ;
								$raktarTermekNegativ -> termek_id = $tetel -> termek_id;
								$raktarTermekNegativ -> darabszam = $tetel -> darabszam;
								$raktarTermekNegativ -> megrendeles_id = $tetel -> megrendeles_id;
								$raktarTermekNegativ -> nyomdakonyv_id = $nyomdakonyv -> id;
								$raktarTermekNegativ -> hatarido = $nyomdakonyv -> hatarido;
								$raktarTermekNegativ -> save (false);
								unset($raktarTermekNegativ);
								
								// rámentjük a megrendelés tételre is, hogy ő egy negatív raktártermék tétel lett, így könnyebb később kezelnünk a lekérdezésekben
								$tetel -> negativ_raktar_termek = 1;
								$tetel -> save (false);
							}
						}
					}
					
					unset($tetel);
				}
			}
			
			/**
			 * 3.5 lépés
			 * Végigmegyünk a szállítóleveleken és megnézzük, hogy mind kielégíthető-e a nyomdakönyvi munkákkal (csak a nyomásos munkákat nézzük itt).
			 * Ha nem, akkor létrehozzuk a megfelelő beszállítást és foglalást hozzájuk.
			 **/
			 $sql = "
				SELECT dom_nyomdakonyv.id AS nyomdakonyv_id, dom_szallitolevel_tetelek.megrendeles_tetel_id,
						 SUM(dom_szallitolevel_tetelek.darabszam) AS tetelek_darabszam, dom_megrendeles_tetelek.darabszam AS foglalt_darabszam,
						 dom_szallitolevelek.datum AS datum,
				 		 dom_megrendeles_tetelek.termek_id AS termek_id,
						 szinek_szama1,
						 szinek_szama2
						 
				FROM dom_szallitolevel_tetelek

				INNER JOIN dom_megrendeles_tetelek
				ON dom_szallitolevel_tetelek.megrendeles_tetel_id = dom_megrendeles_tetelek.id

				INNER JOIN dom_szallitolevelek
				ON dom_szallitolevel_tetelek.szallitolevel_id = dom_szallitolevelek.id

				LEFT OUTER JOIN dom_nyomdakonyv
				ON dom_szallitolevel_tetelek.megrendeles_tetel_id=dom_nyomdakonyv.megrendeles_tetel_id

				WHERE dom_szallitolevel_tetelek.darabszam > 0 AND (szinek_szama1 > 0 OR szinek_szama2 > 0)

				group by dom_szallitolevel_tetelek.megrendeles_tetel_id
				order by dom_szallitolevel_tetelek.megrendeles_tetel_id
			";
			
			$command = Yii::app()->db->createCommand($sql);
			$szallitolevelekOsszesitve = $command->queryAll();
			
			if ($szallitolevelekOsszesitve != null) {
				$tempanyagBeszallitasId = Utils::getOrCreateTempAnyagbeszallitas();
				while($szallitolevelTetel = array_pop($szallitolevelekOsszesitve)) {
					if ($szallitolevelTetel['nyomdakonyv_id'] == null || !$szallitolevelTetel['nyomdakonyv_id'] > 0) {
						// nincs nyomdakönyv, tehát foglalás az adott megrendelés tételhez, csinálunk így egyet
						$nyomdakonyv = new Nyomdakonyv;
						$nyomdakonyv->taskaszam = Utils::ujTaskaszamGeneralas ();
						$nyomdakonyv->megrendeles_tetel_id = $szallitolevelTetel['megrendeles_tetel_id'];
						
						// default értékek beállítása
						$nyomdakonyv->ctp = 1;
						$nyomdakonyv->ofszet_festek = 1;
						$nyomdakonyv->nyomas_vagojel_szerint = 1;
						
						// beállítjuk az alapértelmezett gépet a munkához, ha van
						$gep = Nyomdagepek::model()->findByAttributes(array('alapertelmezett'=> 1));
						if ($gep != null) {
							$nyomdakonyv -> gep_id = $gep -> id;
						}

						// beállítjuk az alapértelmezett munkatípust a munkához, ha van
						$defaultMunkatipus = Utils::getDefaultMunkatipusToNyomdakonyv ($szallitolevelTetel['foglalt_darabszam'], $szallitolevelTetel['szinek_szama1'], $szallitolevelTetel['szinek_szama2'], $szallitolevelTetel['termek_id'] );
		
						if ($defaultMunkatipus != null) {
							$nyomdakonyv -> munkatipus_id = $defaultMunkatipus;
						}

						$nyomdakonyv -> taskat_rogzito_user_id = Yii::app()->user->getId();
						$nyomdakonyv -> save(false);

						Utils::createBeszallitas ($szallitolevelTetel['termek_id'], $szallitolevelTetel['foglalt_darabszam'], $tempanyagBeszallitasId);
						Utils::raktarbanFoglal ($szallitolevelTetel['termek_id'], $szallitolevelTetel['foglalt_darabszam'], $nyomdakonyv -> id, true, true, true, $szallitolevelTetel['datum'], true);
					}
				}
			}

			/**
			 * 4. lépés
			 * A 3. pontban lefoglalt termékek közül kivételezzük, amik már szállítólevélre kerültek.
			 **/
			$sql = "
				SELECT
					dom_megrendeles_tetelek.id AS megrendeles_tetel_id,
					dom_megrendeles_tetelek.hozott_boritek,
					dom_megrendeles_tetelek.szinek_szama1,
					dom_megrendeles_tetelek.szinek_szama2,
					dom_megrendeles_tetelek.negativ_raktar_termek,
					dom_megrendeles_tetelek.termek_id,
					dom_szallitolevel_tetelek.darabszam,
					dom_szallitolevelek.id AS szallitolevel_id,
					dom_szallitolevelek.datum
							
				FROM dom_szallitolevel_tetelek

				INNER JOIN dom_szallitolevelek
				ON dom_szallitolevel_tetelek.szallitolevel_id = dom_szallitolevelek.id

				INNER JOIN dom_megrendeles_tetelek
				ON dom_szallitolevel_tetelek.megrendeles_tetel_id = dom_megrendeles_tetelek.id

				WHERE dom_szallitolevel_tetelek.darabszam > 0 AND dom_szallitolevelek.sztornozva != 1 AND dom_szallitolevelek.torolt != 1 AND dom_szallitolevel_tetelek.torolt != 1
				
				ORDER BY megrendeles_tetel_id, hozott_boritek, szinek_szama1, szinek_szama2, negativ_raktar_termek, termek_id, darabszam, datum
			";
		
			$command = Yii::app()->db->createCommand($sql);
			$szallitolevelek = $command->queryAll();
		
			// találtam néhány esetben olyat (fogalmam sincs hogy sikerült), hogy egy megrendeléshez duplán szerepelt ugyanaz a szállítólevél (és nem volt egyik sem törölve, sem sztornózva)
			// ezeket itt megpróbálom kiszűrni
			$elozoSzallitolevel = null;
			
			// itt tároljuk a már feldolgozott szállítólevél sorokat és figyeljük majd azesetleges duplikálódásokat
			// $feldolgozottSzallitolevelek = array();
			
			if ($szallitolevelek != null) {
				$tempanyagBeszallitasId = Utils::getOrCreateTempAnyagbeszallitas();
				while($szallitolevel = array_pop($szallitolevelek)) {
				
						if ($elozoSzallitolevel == null || !(
							$elozoSzallitolevel['megrendeles_tetel_id'] == $szallitolevel['megrendeles_tetel_id'] &&
							$elozoSzallitolevel['hozott_boritek'] == $szallitolevel['hozott_boritek'] &&
							$elozoSzallitolevel['szinek_szama1'] == $szallitolevel['szinek_szama1'] &&
							$elozoSzallitolevel['szinek_szama2'] == $szallitolevel['szinek_szama2'] &&
							$elozoSzallitolevel['negativ_raktar_termek'] == $szallitolevel['negativ_raktar_termek'] &&
							$elozoSzallitolevel['termek_id'] == $szallitolevel['termek_id'] &&
							$elozoSzallitolevel['darabszam'] == $szallitolevel['darabszam'] &&
							$elozoSzallitolevel['datum'] == $szallitolevel['datum'])
						) {
							
						// a raktárban csökkentjük a foglalt és az elérhető mennyiségeket
						// nyomdakönyves munkáról van szó
						if (($szallitolevel['szinek_szama1'] + $szallitolevel['szinek_szama2']) > 0) {
							Utils::raktarbolKivesz($szallitolevel['termek_id'], $szallitolevel['darabszam'], $szallitolevel['szallitolevel_id'], true, true, true, $szallitolevel['datum'], true, $szallitolevel['megrendeles_tetel_id']);
							//echo 'NYOMAS: ' . $szallitolevel['szallitolevel_id'] . ' - ' . $szallitolevel['darabszam'] . '<br />';
						} else if ($szallitolevel['szinek_szama1'] + $szallitolevel['szinek_szama2'] == 0 && $szallitolevel['negativ_raktar_termek'] == 0) {
							// ha sima boríték eladásról van szó, akkor nincs foglalás, csak levonjuk a raktárkészletből a megfelelő mennyiséget, ha van elég,
							// ha nincs, akkor létrehozzuk kézzel a szükséges mennyiséget, mert elvileg ezt már egyszer kiadták, tehát valami adathiba lehet
							$elerheto_db = Utils::getTermekRaktarkeszlet($szallitolevel['termek_id'], "elerheto_db");
							if ($elerheto_db < $szallitolevel['darabszam']) {
								Utils::createBeszallitas ($szallitolevel['termek_id'], $szallitolevel['darabszam'] - $elerheto_db, $tempanyagBeszallitasId);
							}
							
							Utils::raktarbanFoglal ($szallitolevel['termek_id'], $szallitolevel['darabszam'], $szallitolevel['szallitolevel_id'], true, true, true, $szallitolevel['datum'], true);
							Utils::raktarbolKivesz ($szallitolevel['termek_id'], $szallitolevel['darabszam'], $szallitolevel['szallitolevel_id'], true, true, true, $szallitolevel['datum'], true, $szallitolevel['megrendeles_tetel_id']);
							
							//echo 'ELADAS: ' . $szallitolevel['szallitolevel_id'] . ' - ' . $szallitolevel['darabszam'] . '<br />';
						}
					}	

					$elozoSzallitolevel = $szallitolevel;
				}
			}
			
			/**
			 * 5. lépés
			 * A kézzel kivételezett darabszámok levonása a raktárkészletből.
			 **/
			 /*
			 $raktarKiadasok = RaktarKiadasok::model() -> findAllByAttributes( array('sztornozva' => 0) );
			 
 			 if ($raktarKiadasok != null) {
				foreach ($raktarKiadasok as $raktarKiadas) {
					$nyomdakonyv = Nyomdakonyv::model()->findByPk($raktarKiadas->nyomdakonyv_id);
					
					if ($nyomdakonyv != null) {
						// kivesszük a raktárból a kért darabszámot
						Utils::raktarbanFoglal ($raktarKiadas->termek_id, $raktarKiadas->darabszam, $raktarKiadas->nyomdakonyv_id, true, true, true, date("Y-m-d H:i:s"), true);
						Utils::raktarbolKivesz ($raktarKiadas->termek_id, $raktarKiadas->darabszam, $raktarKiadas->nyomdakonyv_id, true, true, true, date("Y-m-d H:i:s"), true, $nyomdakonyv -> megrendeles_tetel_id);
					}
				}
			 }
			*/
			
			$time_end = microtime(true);
			
			echo 'Az újragenerálás sikeresen lefutott. Futási idő: <strong>' . ($time_end - $time_start)/60 . '</strong> perc';
		}

		 /**
		 * Új táskaszám generálása nyomdakönyvbe kerülő megrendelési tételhez
		 */
		 private function ujTaskaszamGeneralas() {
			$criteria = new CDbCriteria;
			$criteria->select = 'max(id) AS id';
			$row = Nyomdakonyv::model() -> find ($criteria);
			$utolsoMunka = $row['id'];
			$sorszam = "MT" . date("Y") . str_pad( ($utolsoMunka != null) ? ($utolsoMunka + 1) : "000001", 6, '0', STR_PAD_LEFT );
			
			return $sorszam ;
		 }
		
		// a raktárkészlet helyreállításához használjuk egyelőre csak
		// azt vizsgálja, hogy egy adott nyomdakönyvi munka szállítóra lett-e már téve (teljesen, összeadogatva az esetleges tételeket)
		function isNyomdakonyvSzalliton ($nyomdakonyv) {
			$szallitonLevoOsszDarabszamSql = 
				"
					select sum(dom_szallitolevel_tetelek.darabszam) as darabszam from dom_szallitolevel_tetelek

					inner join dom_megrendeles_tetelek on
					dom_szallitolevel_tetelek.megrendeles_tetel_id=dom_megrendeles_tetelek.id

					where dom_szallitolevel_tetelek.torolt=0 AND dom_szallitolevel_tetelek.megrendeles_tetel_id = 
				" . $nyomdakonyv -> megrendeles_tetel_id;

				$osszDarabszam = Yii::app() -> db -> createCommand  ($szallitonLevoOsszDarabszamSql) -> queryRow();
				
				return $osszDarabszam == null ? false : $osszDarabszam['darabszam'] == $nyomdakonyv -> megrendeles_tetel -> darabszam;
		}

		// szintén a raktárkészlet helyreállításához használjuk egyelőre csak
		// létrehoz a 'Segédanyagok' raktárban egy bizony termékből egy megadott mennyiséget egy 'gyűjtő' beszállításhoz rendelve
		function createBeszallitas ($termekId, $darabszam, $anyagbeszallitasId) {
			$raktarTermek = RaktarTermekek::model()->findByAttributes( array('termek_id' => $termekId, 'anyagbeszallitas_id' => $anyagbeszallitasId, 'raktarhely_id' => 8) );
			
			// ha van már a raktárban ilyen termék, akkor frissítjük a darabszámát
			if ($raktarTermek != null) {
				$raktarTermek -> elerheto_db += $darabszam;
				$raktarTermek -> osszes_db += $darabszam;
			} else {
				// ha nincs, akkor létrehozunk egy új bejegyzést
				$raktarTermek = new RaktarTermekek;
				$raktarTermek -> termek_id = $termekId;
				$raktarTermek -> raktarhely_id = 8;
				$raktarTermek -> anyagbeszallitas_id = $anyagbeszallitasId;
				
				$raktarTermek -> elerheto_db = $darabszam;
				$raktarTermek -> osszes_db = $darabszam;
			}
			
			$raktarTermek -> save (false);
			
			$termekAr = Utils::getActiveTermekar ($termekId);
			$aktivAr = $termekAr == 0 ? 0 : $termekAr["db_eladasi_ar"];

			// ugyan most nem használjuk, de később ki tudja: létrehozzuk a termekek és termekek_iroda rekordokat is
			$anyagbeszallitasTermekek = new AnyagbeszallitasTermekek;
			$anyagbeszallitasTermekek -> anyagbeszallitas_id = $anyagbeszallitasId;
			$anyagbeszallitasTermekek -> termek_id = $termekId;
			$anyagbeszallitasTermekek -> darabszam = $darabszam;
			$anyagbeszallitasTermekek -> netto_darabar = $aktivAr;
			$anyagbeszallitasTermekek -> save(false);

			$anyagbeszallitasTermekekIroda = new AnyagbeszallitasTermekekIroda;
			$anyagbeszallitasTermekekIroda -> anyagbeszallitas_id = $anyagbeszallitasId;
			$anyagbeszallitasTermekekIroda -> termek_id = $termekId;
			$anyagbeszallitasTermekekIroda -> darabszam = $darabszam;
			$anyagbeszallitasTermekekIroda -> netto_darabar = $aktivAr;
			$anyagbeszallitasTermekekIroda -> save(false);
			
			// a tranzakció adatait külön menjtük (jelenleg csak a statisztikákhoz szükséges)
			$raktarTermekekTranzakciok = new RaktarTermekekTranzakciok;
			$raktarTermekekTranzakciok->termek_id = $termekId;
			$raktarTermekekTranzakciok->anyagbeszallitas_id = $anyagbeszallitasId;
			$raktarTermekekTranzakciok->raktarhely_id = 8;
			$raktarTermekekTranzakciok->tranzakcio_datum = date("Y-m-d H:i:s");
			$raktarTermekekTranzakciok->betesz_kivesz_darabszam = $darabszam;
			$raktarTermekekTranzakciok->save(false);
		}
		
		// szintén a raktárkészlet helyreállításához használjuk egyelőre csak
		// létrehoz egy 'pótlás' bizonylatszámú anyagbeszállítást, ha még nincs
		function getOrCreateTempAnyagbeszallitas () {
			$tempAnyagbeszallitas = Anyagbeszallitasok::model()->findByAttributes( array('bizonylatszam' => 'pótlás') );
			
			if ($tempAnyagbeszallitas == null) {
				$tempAnyagbeszallitas = new Anyagbeszallitasok;
				
				$tempAnyagbeszallitas -> bizonylatszam = 'pótlás';
				$tempAnyagbeszallitas -> beszallitas_datum = '0000-00-00 00:00:00';
				$tempAnyagbeszallitas -> kifizetes_datum = '0000-00-00 00:00:00';
				$tempAnyagbeszallitas -> megjegyzes = '';
				$tempAnyagbeszallitas -> user_id = 1;
				$tempAnyagbeszallitas -> anyagrendeles_id = '';
				$tempAnyagbeszallitas -> gyarto_id = 0;
				$tempAnyagbeszallitas -> lezarva = 0;
				
				$tempAnyagbeszallitas -> save(false);
			}
			
			return $tempAnyagbeszallitas -> id;
		}
	
		/*
		* Visszaadja a 'hozott boríték raktár' raktárhely rekordot. Ha nincs ilyen raktárhely, akkor létrehoz egyet, valamint hozzá egy raktárat is, ha az sincs (és legközelebb már ezeket fogja használni).
		*/
		public function getHozottBoritekRaktarHely () {
			$match = 'hozott boríték';
			$query = new CDbCriteria( array(
				'condition' => "nev LIKE :match",
				'params'    => array(':match' => "%$match%")
			) );
			 
			$hozottBoritekRaktar = Raktarak::model()->find( $query );
			
			if ($hozottBoritekRaktar == null) {
				$hozottBoritekRaktar = new Raktarak();
				$hozottBoritekRaktar -> nev = 'Hozott boríték raktár';
				$hozottBoritekRaktar -> tipus = 'alap';
				$hozottBoritekRaktar -> leiras = 'Hozott borítékok tárolására szolgáló raktár';
				$hozottBoritekRaktar -> save(false);
			}
			
			// itt már mindenképpen kell legyen egy Raktar típusú objektum a kezünkben
			// ellenőrizzük, hogy van-e hozzá raktárhely, ha nincs, felveszünk egyet
			$raktarHely = null;
			if ($hozottBoritekRaktar -> raktarHelyek == null || count($hozottBoritekRaktar -> raktarHelyek) == 0) {
				$raktarHely = new RaktarHelyek;
				$raktarHely -> raktar_id = $hozottBoritekRaktar -> id;
				$raktarHely -> nev = 'Hozott boríték raktár 1';
				$raktarHely ->save(false);
			}
			
			return $raktarHely != null ? $raktarHely : $hozottBoritekRaktar->raktarHelyek[0];
		}
	
	}

?>
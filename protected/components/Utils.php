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
		//	   TRUE visszatéréshez tehát az kell, hogy az anyagrendelésen és az anyagbeszállításon (iroda és raktár is) egyezzenek a tételek és darabszámok.
		function checkAnyagrendelesBeszallitas ($anyagrendeles_id, $anyagbeszallitas_id) {
			$anyagrendeles = Anyagrendelesek::model()->findByPk($anyagrendeles_id);
			$anyagbeszallitas = Anyagbeszallitasok::model()->findByPk($anyagbeszallitas_id);

			// ha az anyagrendelés ID hibás volt, akkor hibaüzenettel kilépek
			if ($anyagrendeles == null) return "Hibás anyagrendelés azonosító!";
			
			// ha az anyagbeszállítás ID üres, akkor megnézem, hogy tartozik-e a megrendeléshez beszállítás,
			// ha igen, akkor dolgozom tovább azzal, ha nem, akkor hibaüzenettel kilépek
			if ($anyagbeszallitas == null) {
				$anyagbeszallitas = Anyagbeszallitasok::model() -> findByAttributes(array('anyagrendeles_id' => $anyagrendeles->id));
				
				if ($anyagbeszallitas == null) {
					return "Hibás anyagbeszállítás azonosító!";
				}
			}
			
			// anyagrendelés tételeinek lekérdezése
			$anyagrendeles_termekek = AnyagrendelesTermekek::model()->findAllByAttributes(array('anyagrendeles_id' => $anyagrendeles->id));
			
			// anyagbeszállítás tételeinek lekérdezése
			// iroda
			$anyagbeszallitas_iroda_termekek = AnyagbeszallitasTermekekIroda::model()->findAllByAttributes(array('anyagbeszallitas_id' => $anyagbeszallitas->id));
			// raktár
			$anyagbeszallitas_raktar_termekek = AnyagbeszallitasTermekek::model()->findAllByAttributes(array('anyagbeszallitas_id' => $anyagbeszallitas->id));

			// először ellenőrzöm, hogy a tételek száma egyáltalán egyezik-e a rendelésen és beérkezett termékek listáján, ha nem, akkor hibaüzenettel kilépek
			if ( (count($anyagrendeles_termekek) == count($anyagbeszallitas_iroda_termekek)) && (count($anyagbeszallitas_iroda_termekek) == count($anyagbeszallitas_raktar_termekek)) ) {
				// végigmegyek az anyagrendelés tételein és ha bármi eltérést találok, hibaüzenettel kilépek
				foreach ($anyagrendeles_termekek as $anyagrendeles_termek) {
					$res = Utils::searchAnyagbeszallitasIrodaRaktarTetel ($anyagrendeles_termek, $anyagbeszallitas_iroda_termekek, $anyagbeszallitas_raktar_termekek);
					if ($res != "") return $res;
					
				}
			} else return "Eltérés található a megrendelt és az iroda vagy a raktár által átvett rendelési tételek között. További információhoz használja a <strong><a href='" . Yii::app()->createUrl("raktareltereslista/index") . "' target='_blank'>Raktár eltéréslista</a></strong> nézetet.";
			
			return "";
		}
		
		// LI: paraméterben kap egy anyagrendelés tételt és két anyagbeszállítás listát (iroda, raktár).
		//	   A kapott anyagbeszállítás listákon végigmegy és ha nem találja bennük az anyagrendelés tételt hibával tér vissza.
		function searchAnyagbeszallitasIrodaRaktarTetel ($anyagrendeles_termek, $anyagbeszallitas_iroda_termekek, $anyagbeszallitas_raktar_termekek) {
			$termek_id = $anyagrendeles_termek -> termek_id;
			$darabszam = $anyagrendeles_termek -> rendelt_darabszam;

			// először az iroda által felvett listán megyünk végig
			$foundInIroda = false;
			foreach ($anyagbeszallitas_iroda_termekek as $anyagbeszallitas_iroda_termek) {
				if ($anyagbeszallitas_iroda_termek->termek_id == $termek_id && $anyagbeszallitas_iroda_termek->darabszam == $darabszam) {
					$foundInIroda = true;
					break;
				}
			}
			if (!$foundInIroda) return "Eltérés található az iroda által felvett anyaglistán. További információhoz használja a <strong><a href='" . Yii::app()->createUrl("raktareltereslista/index") . "' target='_blank'>Raktár eltéréslista</a></strong> nézetet.";
			
			// ezután a raktár által felvett listát vizsgáljuk
			$foundInRaktar = false;
			foreach ($anyagbeszallitas_raktar_termekek as $anyagbeszallitas_raktar_termek) {
				if ($anyagbeszallitas_raktar_termek->termek_id == $termek_id && $anyagbeszallitas_raktar_termek->darabszam == $darabszam) {
					$foundInRaktar = true;
					break;
				}
			}
			if (!$foundInRaktar) return "Eltérés található a raktár által felvett anyaglistán. További információhoz használja a <strong><a href='" . Yii::app()->createUrl("raktareltereslista/index") . "' target='_blank'>Raktár eltéréslista</a></strong> nézetet.";
			
			return "";
		}
	
		// LI: egy paraméterben kapott termék aktuálisan aktív termékárát adja vissza
		// TÁ: Bővítettem a $darabszam, $szinszam1, $szinszam2 opcionális paraméterekkel, amelyek segítségével a felülnyomási árat adhatjuk vissza a natúr darabár helyett, amennyiben kérnek felülnyomást
		function getActiveTermekar ($termek_id, $darabszam = 1, $szinszam1 = 0, $szinszam2 = 0) {
			if ($termek_id != null && $termek_id != 0) {
						$termekAr = Yii::app() -> db -> createCommand  ("SELECT * FROM dom_termek_arak WHERE
														('" . date("Y-m-d") . "' BETWEEN datum_mettol AND datum_meddig) AND (termek_id = $termek_id AND torolt = 0)
														") -> queryRow();
			}
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
			
			return 0;
		}
	
		// LI: egy paraméterben kapott termék aktuálisan aktív termékárát adja vissza JSON-ben
		// TÁ: Bővítettem a $darabszam, $szinszam1, $szinszam2 opcionális paraméterekkel, amelyek segítségével a felülnyomási árat adhatjuk vissza a natúr darabár helyett, amennyiben kérnek felülnyomást
		function getActiveTermekarJSON ($termek_id, $darabszam = 1, $szinszam1 = 0, $szinszam2 = 0) {
			$result = 0;

			if ($termek_id != null && $termek_id != 0) {
						$termekAr = Yii::app() -> db -> createCommand  ("SELECT * FROM dom_termek_arak WHERE
														('" . date("Y-m-d") . "' BETWEEN datum_mettol AND datum_meddig) AND (termek_id = $termek_id AND torolt = 0)
														") -> queryRow();
						$db_ar = $termekAr["db_eladasi_ar"] ;
			}

			if ($termekAr != false && $darabszam > 0 && ($szinszam1 > 0 || $szinszam2 > 0)) {
				//Ha van a terméknek érvényes ára és kértek előoldali, vagy hátoldali felülnyomást, akkor a $termekAr módosul a nyomás árával
						$db_ar = $termekAr["db_ar_nyomashoz"] ;
						$termek_reszletek = Termekek::model()->findByPk($termek_id) ;
						$termek_kategoria_tipus = $termek_reszletek["kategoria_tipus"] ;
						$nyomasi_ar_kategoria_tipus = "" ;
						//Itt kérdés, hogy a $szinszam1 + $szinszam2 összege adja ki a színek számát, vagy a nagyobbik érték a kettő közül
						//Alapból most a nagyobbik értéket veszem, aztán meglátjuk
						$szinszam = max($szinszam1,$szinszam2) ;
						if ($termek_kategoria_tipus == "A") {
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
						}
						
						$sql = "SELECT * FROM dom_nyomasi_arak WHERE ('" . $darabszam . "' BETWEEN peldanyszam_tol AND peldanyszam_ig) AND (kategoria_tipus = '$nyomasi_ar_kategoria_tipus' AND torolt = 0)" ;
						$nyomasiAr = Yii::app() -> db -> createCommand  ($sql) -> queryRow();
						$nyomasi_ar = 0 ;
						if ($nyomasiAr != false) {
							switch ($szinszam1) {
								case 1: $elooldali_nyomasi_ar = $nyomasiAr["szin_egy"] ;
									break ;
								case 2: $elooldali_nyomasi_ar = $nyomasiAr["szin_ketto"] ;
									break ;
								case 3: $elooldali_nyomasi_ar = $nyomasiAr["szin_harom"] ;
									break ;
								case 0: $elooldali_nyomasi_ar = 0 ;
									break ;
								default: $elooldali_nyomasi_ar = $nyomasiAr["szin_tobb"] ;
							}
							
							switch ($szinszam2) {
								case 1: $hatoldali_nyomasi_ar = $nyomasiAr["szin_egy"] ;
									break ;
								case 2: $hatoldali_nyomasi_ar = $nyomasiAr["szin_ketto"] ;
									break ;
								case 3: $hatoldali_nyomasi_ar = $nyomasiAr["szin_harom"] ;
									break ;
								case 0: $hatoldali_nyomasi_ar = 0 ;
									break ;
								default: $hatoldali_nyomasi_ar = $nyomasiAr["szin_tobb"] ;
							}
							$nyomasi_ar = $elooldali_nyomasi_ar + $hatoldali_nyomasi_ar ;
						}
						$db_ar = $db_ar + $nyomasi_ar ;
 				
			}
			
			if ($termekAr != false) 
				$result = $db_ar;
			
			$fix_ar = false ;
			if ($szinszam > 0 && $darabszam < 2000)
				$fix_ar = true ;				
			
			$ar = ($db_ar == 0) ? 0 : $db_ar;
				
			$arr[] = array(
				'status'=>'success',
				'ar'=>$ar,
				'fix_ar'=>$fix_ar,
			);      

			echo CJSON::encode($arr);
		}
	
		// LI: 	egy paraméterben kapott árajánlathoz tartozó ügyfélnek ellenőrzi le a rendelési limitösszegét.
		//     	Ha a beállított tartozási limitet meghaladja a kiegyenlítetlen megrendelés állománya az árajánlat értékével együtt,
		//		akkor nem lehet megrendelést csinálni az árajánlatból, tehát FALSE értékkel tér vissza a függvény. Minden más esetben TRUE-val.
		function reachedUgyfelLimit ($arajanlat_id) {
		
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
						$kiegyenlitetlenMegrendelesek = Yii::app() -> db -> createCommand  ("SELECT id FROM dom_megrendelesek WHERE sztornozva = 0 AND torolt = 0 AND rendelest_lezaro_user_id = 0 AND ugyfel_id = " . $ugyfel->id) -> queryAll();

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

	}

?>
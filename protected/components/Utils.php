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
			
			$afakulcsSzazalek = 0;
			if ($afakulcs_id != null && $afakulcs_id != 0) {
				$afaKulcs = AfaKulcsok::model()->findByPk($afakulcs_id);
				
				if ($afaKulcs != null){
					$afakulcsSzazalek = $afaKulcs->afa_szazalek;
				}
			}
			
			if ($termek_id != null && $termek_id != 0) {
						$termek_reszletek = Termekek::model()->findByPk($termek_id) ;
						$termekAr = Yii::app() -> db -> createCommand  ("SELECT * FROM dom_termek_arak WHERE
														('" . date("Y-m-d") . "' BETWEEN datum_mettol AND datum_meddig) AND (termek_id = $termek_id AND torolt = 0)
														") -> queryRow();
						if ($termek_reszletek->csom_egys <= $darabszam) {
							$db_ar = $termekAr["csomag_eladasi_ar"] / $termek_reszletek->csom_egys ;	
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
			
			if ($termekAr != false && $darabszam > 0 && ($szinszam > 0)) {
				//Ha van a terméknek érvényes ára és kértek előoldali, vagy hátoldali felülnyomást, akkor a $termekAr módosul a nyomás árával								
				$termek_reszletek = Termekek::model()->findByPk($termek_id) ;
				if ($termek_reszletek->csom_egys <= $darabszam) {
					$db_ar = $termekAr["csomag_ar_nyomashoz"] / $termek_reszletek->csom_egys ;	
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
					$nyomasi_ar_kategoria_tipus = Utils::NyomasiKategoriaSzamol($szinszam1 . "+" . $szinszam2, $darabszam, $termek_reszletek->tipus, $kifuto);
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
				
				$sql = "SELECT * FROM dom_nyomasi_arak WHERE ('" . $darabszam . "' BETWEEN peldanyszam_tol AND peldanyszam_ig) AND (kategoria_tipus = '$nyomasi_ar_kategoria_tipus' AND torolt = 0)" ;
				$nyomasiAr = Yii::app() -> db -> createCommand  ($sql) -> queryRow();
				$nyomasi_ar = 0 ;
//				print_r($nyomasiAr) ;
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
//				$db_ar = ($db_ar + $nyomasi_ar) * $szorzo ;

				//Selejtszámítás a nyomáshoz						
				if ($szinszam1 > 0) {
					if ($szinszam1 > 2) {
						$selejt1=($szinszam1)*(($darabszam<10000) ? 200 : $darabszam*.02);
					}
					else
					{
						if ($darabszam < 10000) {
							$selejt1 = $szinszam1 * 300 ;
						}			
						else if ($darabszam >= 10000 && $darabszam < 20000) {
							$selejt1 = $szinszam1 * ($darabszam * .03) ;
						}
						else {
							$selejt1 = $szinszam1 * ($darabszam * .02) ;
						}
					}
				}
				
				if ($szinszam2 > 0) {
					if ($szinszam2 > 2) {
						$selejt2=($szinszam2)*(($darabszam<10000) ? 200 : $darabszam*.02);
					}
					else
					{
						if ($darabszam < 10000) {
							$selejt2 = $szinszam2 * 300 ;
						}			
						else if ($darabszam >= 10000 && $darabszam < 20000) {
							$selejt2 = $szinszam2 * ($darabszam * .03) ;
						}
						else {
							$selejt2 = $szinszam2 * ($darabszam * .02) ;
						}
					}
				}
				$selejt = $selejt1 + $selejt2 ;	
				//Selejtszámítás eddig 		
				$darabszam_osszesen = $darabszam + $selejt ;
								
				if ($darabszam >= 2000) {
					$netto_osszeg = ($darabszam * $db_ar) + ($nyomasi_ar * $darabszam) ;
				}
				else
				{					
					$netto_osszeg = $nyomasi_ar + $darabszam_osszesen * $db_ar ;									
				}				
			}

			$ar = ($db_ar == 0) ? 0 : $db_ar;
			if ($szinszam == 0)
				$netto_osszeg = round($darabszam * $ar) ;			
			else if ($darabszam > 0)
				$ar = round($netto_osszeg / $darabszam, 2);

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

		// LI: 		egy paraméterben kapott megrendelés azon tételeit adja vissza, amik még nem szerepelnek egy szállítólevélen sem
		// TODO:	ezeket a kevert nyelvű függvényneveket majd egyszer lehet átírnám, nem szokásom ilyen elnevezéseket csinálni, de mivel
		//			az adatbázisban is így tároljuk őket, valahogy így álltam neki
		// $skipId: ha ez TRUE, akkor a lekérdezésben az adott ID-hoz tartozó szállítólevél tételeket is visszaadjuk (pl. szerkesztésnél kell)
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
							WHERE sztornozva = 0 AND dom_szallitolevelek.torolt = 0 AND megrendeles_id = :id" . $skipIDCondition . " 
							GROUP BY megrendeles_tetel_id
						";

						$command = Yii::app()->db->createCommand($marSzallitonLevoTetelekSql);
						$command->bindParam(':id', $id);
						$megrendelesTetelek = $command->queryAll();

						// végigmegyünk a megrendelés tételein és külön gyűjtjük azokat, amiket nem találunk a szállítóleveleken még
						foreach ($megrendeles->tetelek as $tetel )
						{
							$darabszamKulonbozet = Utils::isTetelOnDeliveryNote ($tetel, $megrendelesTetelek);
							if ($darabszamKulonbozet == -1)
								array_push ($result, $tetel);
							else if ($darabszamKulonbozet > 0) {
								$tetel->darabszam = $darabszamKulonbozet;
								array_push ($result, $tetel);
							}
						}
				}
			}

			return $result;
		}
		
		// LI: 	megnézei, hogy az adott megnredelés tétel rajta van-e a szállítókon.
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
			switch ($megrendeles_adatok->proforma_fizetesi_mod) {
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
			$megrendeles_fizmod = FizetesiModok::model() -> findByAttributes(array('nev' => $fizmod_domy_kod)) ;
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
					$sor["CikkNev"] = substr($tetel->termek->getDisplayTermekTeljesNev(),0,100) ;
					$sor["MEgyseg"] = "db" ;
					$sor["AfaKulcs"] = $afakulcs->afa_szazalek ;
					if ($tetel->termek->tipus == "Szolgáltatás") {
						$sor["CikkTipus"] = 6 ;	
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
			$return = 0 ;
			$sql = "select BSorszam from kerBFejlec where BSorszam2 = 'WEB-" . $megrendeles_id . "'" ;
			$szamla_fej = null; //Yii::app()->db_actual->createCommand($sql)->queryRow();
			if (is_array($szamla_fej)) {
				$return = $szamla_fej["BSorszam"] ;	
			}
			return $return ;
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
						
						// TODO: ide valami óradíj kellene jöjjön, de az csak műveletenként van. Mi kéne akkor ide jöjjön ?
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
				INNER JOIN dom_arajanlat_tetelek AS tetelek ON
				tetelek.arajanlat_id = arajanlatok.id

				WHERE arajanlatok.torolt = 0 AND
						tetelek.torolt = 0 AND
						ugyfel_id = :ugyfel_id
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
				INNER JOIN dom_megrendeles_tetelek AS tetelek ON
				tetelek.megrendeles_id = megrendeles.id

				WHERE megrendeles.torolt = 0 AND
						tetelek.torolt = 0 AND
						ugyfel_id = :ugyfel_id
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

		function OsszegFormazas($osszeg) {
			return number_format($osszeg, 2, '.', ' ');		
		}
		
		function SulyFormazas($suly) {
			// LI: kilogrammban írja ne grammban
			return (number_format($suly / 1000, 0, '.', ' '));
		}

		// LI: egy sessionváltozóban tárolt url-re irányít át (az oldal nevét paraméterben várja)
		function gotoPrevPage ($pageName) {
			$this->redirect(Yii::app()->session[$pageName . Yii::app()->user->id . 'returnURL']);
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
	
	}

?>
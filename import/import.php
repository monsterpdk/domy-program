<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
	include "include/config.php" ;
	include "include/functions.php" ;

	  define("UGYFELEK", "C:\inetpub\wwwroot\domyweb/import/UGYFEL.dbf") ;
	  define("TERMEKEK", "C:\inetpub\wwwroot\domyweb/import/TERMEK.DBF") ;
	  define("NYOMASI_ARAK", "C:\inetpub\wwwroot\domyweb/import/NYOMASAR.DBF") ;


//Nyomási árak importja  
	function nyomasi_arak_import() {
		echo "nyomasi arak import inditas<br />" ;		
		$parameters = array() ;
		$parameters[] = array("field"=>"EKEZD", "value"=>date("Y.m.d"), "op"=>"<=") ;
		$parameters[] = array("field"=>"EVEGE", "value"=>date("Y.m.d"), "op"=>">=") ;
		$query_url = "http://" . $_SERVER["HTTP_HOST"] . "/import/dbfcomm.php?mode=select&dbf=" . NYOMASI_ARAK . "&filter=" . json_encode($parameters) ;
		echo $query_url ;
		$dbf_result = unserialize(httpGet($query_url)) ;
		foreach ($dbf_result as $sor) {
			foreach ($sor as $mezo => $ertek) {
				$sor[$mezo] = w1250_to_utf8($ertek) ;	
			}
			$ertekek = array() ;
			$ertekek["kategoria_tipus"] = str_replace("/", "", $sor["TIPUS"]) ;
			$ertekek["boritek_fajtak"] = $sor["NEVEK"] ;
			$ertekek["lehetseges_szinek"] = $sor["SZINEK"] ;
			$ertekek["peldanyszam_tol"] = $sor["ARHATAR1"] ;
			$ertekek["peldanyszam_ig"] = $sor["ARHATAR2"] ;
			$ertekek["szin_egy"] = $sor["AR1SZIN"] ;
			$ertekek["szin_ketto"] = $sor["AR2SZIN"] ;
			$ertekek["szin_harom"] = $sor["AR3SZIN"] ;
			$ertekek["szin_tobb"] = $sor["AR4SZIN"] ;
			$ertekek["grafika"] = $sor["GRAFIKA"] ;
			$ertekek["grafika_roviden"] = $sor["GRAFROV"] ;
			$ertekek["megjegyzes"] = $sor["MEGJEGYZ"] ;
			$ertekek["ervenyesseg_tol"] = str_replace(".", "-", $sor["EKEZD"]) ;
			$mezok_query = $ertekek_query = "" ;
			foreach ($ertekek as $kulcs => $ertek) {
				$mezok_query .= $kulcs . "," ;
				$ertekek_query .= "'" . addslashes($ertek) . "'," ;
			}
			$mezok_query = "(" . rtrim($mezok_query,",") . ")" ;
			$ertekek_query = "(" . rtrim($ertekek_query, ",") . ")" ;
			$query = "insert into dom_nyomasi_arak $mezok_query values $ertekek_query" ;
//				echo $query . "<br />" ;
			lekerdez($query) ;
		}
	}
	  
	  
//Ügyfelek importja  
	function ugyfel_import($mettol, $hanyat) {
		echo "ugyfel import inditas<br />" ;		
		$parameters = array() ;
		$parameters[] = array("field"=>"UGYKOD", "value"=>$mettol, "op"=>">") ;
		$parameters[] = array("field"=>"UGYKOD", "value"=>$mettol + $hanyat, "op"=>"<=") ;
		$query_url = "http://" . $_SERVER["HTTP_HOST"] . "/import/dbfcomm.php?mode=select&dbf=" . UGYFELEK . "&filter=" . json_encode($parameters) ;
		echo $query_url ;
		$dbf_result = unserialize(httpGet($query_url)) ;
		//Országok kigyűjtése
		$query = "select id, iso2 from dom_orszagok" ;
		$result = lekerdez($query) ;
		$orszagok = array() ;
		if (mysql_num_rows($result) > 0) {
			while ($sor = mysql_fetch_assoc($result)) {
				$orszagok[$sor["iso2"]] = $sor["id"] ; 	
			}
			mysql_free_result($result) ;
		}
		//Városok kigyűjtése
		$query = "select * from dom_varosok" ;
		$result = lekerdez($query) ;
		$varosok_irsz_alapjan = array() ;
		$varosok_nev_alapjan = array() ;
		if (mysql_num_rows($result) > 0) {
			while ($sor = mysql_fetch_assoc($result)) {
				$varosok_irsz_alapjan[$sor["iranyitoszam"]] = $sor["id"] ;
				$varosok_nev_alapjan[$sor["varosnev"]] = $sor["id"] ;
			}
			mysql_free_result($result) ;
		}
		//Cégformák kigyűjtése
		$query = "select * from dom_cegformak" ;
		$result = lekerdez($query) ;
		$cegformak = array() ;
		if (mysql_num_rows($result) > 0) {
			while ($sor = mysql_fetch_assoc($result)) {
				$cegformak[$sor["cegforma"]] = $sor["id"] ; 	
			}
			mysql_free_result($result) ;
		}
	  
		foreach ($dbf_result as $sor) {
			foreach ($sor as $mezo => $ertek) {
				$sor[$mezo] = w1250_to_utf8($ertek) ;	
			}
			$ertekek = array() ;			
			$ugyfel_tipus = "vasarlo" ;
			if ($sor["UGYTIP"] == "FALSE") {
				$ugyfel_tipus = "erdeklodo" ;
			}
			$ugyfel_orszag = "135" ;
			if ($sor["EUADOSZ"] != "") {
				$ugyfel_orszag = $orszagok[substr($sor["euadosz"],0,2)] ;	
			}
			if ($ugyfel_orszag == "") {
				$ugyfel_orszag = 135 ;	
			}
			$ugyfel_varos = $varosok_irsz_alapjan[$sor["IRSZAM"]] ;
			if ($ugyfel_varos == "") {
				$ugyfel_varos = $varosok_nev_alapjan[$sor["CIM1"]] ;	
			}
			$ugyfel_ugyintezok = array () ;
			for ($i = 1; $i < 6; $i++) {
				$ugyintezo_sor = array() ;
				if ($sor["UGYINT" . $i] != "") {
					 $ugyintezo_sor["nev"] = $sor["UGYINT" . $i] ;
					 $ugyintezo_sor["telefon"] = $sor["UTEL" . $i] ;
					 $ugyintezo_sor["email"] = $sor["UEMAIL" . $i] ;
					 $ugyfel_ugyintezok[] = $ugyintezo_sor ;
				}
			}
			$ugyfel_cegforma_nev = "" ;
			if (preg_match("/.*( \w*?\.)$/", $sor["CEGNEV"], $matches)) {
				$ugyfel_cegforma_nev = trim($matches[1]) ;
			}
			$ugyfel_cegforma = $cegformak[$ugyfel_cegforma_nev] ;
			if ($ugyfel_cegforma == "") {
				switch ($sor["CEGFORMA"]) {
					case "Korlátolt Felelőségű Társaság": $ugyfel_cegforma = 4 ;
						break ;
					case "Zártkörű Részvény Társaság": $ugyfel_cegforma = 1 ;
						break ;
					case "Betéti Társaság": $ugyfel_cegforma = 2 ;
						break ;
					case "Egyéni cég": $ugyfel_cegforma = 7 ;
						break ;
					case "Egyéb": $ugyfel_cegforma = 8 ;
						break ;
					case "Részvény Társaság": $ugyfel_cegforma = 5 ;
						break ;
					default: $ugyfel_cegforma = "3" ;	//Nincs megadva	
				}				
			}
			$fizetesi_felszolitas_volt = "0" ;
			if ($sor["FIZFNO"] == "TRUE") {
				$fizetesi_felszolitas_volt = "1" ;
			}
			$ugyvedi_felszolitas_volt = "0" ;
			if ($sor["VUGYV"] == "TRUE") {
				$ugyvedi_felszolitas_volt = "1" ;
			}
			$levelezes_engedelyezett = "0" ;
			if ($sor["LEVNO"] == "TRUE") {
				$levelezes_engedelyezett = "1" ;
			}
			$email_engedelyezett = "0" ;
			if ($sor["EMAILOK"] == "TRUE") {
				$email_engedelyezett = "1" ;
			}
			$kupon_engedelyezett = "0" ;
			if ($sor["KUPON"] == "TRUE") {
				$kupon_engedelyezett = "1" ;
			}
			$egyedi_kupon_engedelyezett = "0" ;
			if ($sor["EKUPON"] == "TRUE") {
				$egyedi_kupon_engedelyezett = "1" ;
			}
			$archiv = "0" ;
			if ($sor["ARHIV"] == "TRUE") {
				$archiv = "1" ;
			}
			
			$ertekek["ugyfel_tipus"] = $ugyfel_tipus ;
			$ertekek["cegnev"] = $sor["CEGNEV"] ;
			$ertekek["cegnev_teljes"] = $sor["CEGNEVT"] ;
			$ertekek["szekhely_irsz"] = $sor["IRSZAM"] ;
			$ertekek["szekhely_orszag"] = $ugyfel_orszag ;
			$ertekek["szekhely_varos"] = $ugyfel_varos ;
			$ertekek["szekhely_cim"] = $sor["CIM2"] ;
			$ertekek["posta_cim"] = $sor["POSTA"] ;
			$ertekek["ugyvezeto_nev"] = $sor["UGYVEZ"] ;
			$ertekek["ugyvezeto_telefon"] = $sor["UTEL"] ;
			$ertekek["ugyvezeto_email"] = $sor["UEMAIL"] ;
			$ertekek["kapcsolattarto_nev"] = $sor["KAPCSOLAT"] ;
			$ertekek["kapcsolattarto_telefon"] = $sor["KTEL"] ;
			$ertekek["kapcsolattarto_email"] = $sor["KEMAIL"] ;
			$ertekek["ceg_telefon"] = $sor["TEL1"] . ", " . $sor["TEL2"] . ", " . $sor["RADIOTEL"] ;
			$ertekek["ceg_fax"] = $sor["FAX"] ;
			$ertekek["ceg_email"] = $sor["EMAIL"] ;
			$ertekek["ceg_honlap"] = $sor["WEB"] ;
			$ertekek["cegforma"] = $ugyfel_cegforma ;
			$ertekek["szamlaszam1"] = $sor["SZLASZAM"] ;
			$ertekek["szamlaszam2"] = $sor["SZLASZAM1"] ;
			$ertekek["adoszam"] = $sor["ADOSZAM"] ;
			$ertekek["eu_adoszam"] = $sor["EUADOSZ"] ;
			$ertekek["teaor"] = $sor["TEVSZAM"] ;
			$ertekek["tevekenysegi_kor"] = $sor["TEVKOR"] ;
			$ertekek["arbevetel"] = $sor["ARBEV"] ;
			$ertekek["foglalkoztatottak_szama"] = $sor["FOGLSZ"] ;
			$ertekek["adatforras"] = $sor["ADATFOR"] ;
			$ertekek["arkategoria"] = $sor["ARKAT"] ;
			$ertekek["besorolas"] = $sor["BESOROL"] ;
			$ertekek["megjegyzes"] = $sor["MEGJEGYS"] ;
			$ertekek["fontos_megjegyzes"] = $sor["MEGJEGYZ"] ;
			$ertekek["fizetesi_felszolitas_volt"] = $fizetesi_felszolitas_volt ;
			$ertekek["ugyvedi_felszolitas_volt"] = $ugyvedi_felszolitas_volt ;
			$ertekek["levelezes_engedelyezett"] = $levelezes_engedelyezett ;
			$ertekek["email_engedelyezett"] = $email_engedelyezett ;
			$ertekek["kupon_engedelyezett"] = $kupon_engedelyezett ;
			$ertekek["egyedi_kuponkedvezmeny"] = $egyedi_kupon_engedelyezett ;
			$ertekek["elso_vasarlas_datum"] = str_replace(".","-",$sor["ELSOVASAR"]) ;
			$ertekek["utolso_vasarlas_datum"] = str_replace(".","-",$sor["UTSOVASAR"]) ;
			$ertekek["fizetesi_hatarido"] = $sor["FIZHAT"] ;
			$ertekek["max_fizetesi_keses"] = $sor["MAXK"] ;
			$ertekek["atlagos_fizetesi_keses"] = $sor["ATLK"] ;
			$ertekek["rendelesi_tartozasi_limit"] = $sor["RLIMIT"] ;
			$ertekek["fizetesi_moral"] = $sor["FIZMOR"] ;
			$ertekek["adatok_egyeztetve_datum"] = str_replace(".","-",$sor["FRISSIT"]) ;
			$ertekek["archiv"] = $archiv ;
			$ertekek["archivbol_vissza_datum"] = str_replace(".","-",$sor["ARHIVV"]) ;
//			$ertekek["felvetel_idopont"] = $sor["CEGNEV"] ;	//Nem tudom, melyik mező tartalmazza a dbf-ben ezt az infót
			$ertekek["felvetel_idopont"] = date("Y-m-d") ;	//Nem tudom, melyik mező tartalmazza a dbf-ben ezt az infót

			$szam = 0;
			$query = "" ;
			if ($ertekek["adoszam"] != "") {
				$query = "select count(*) as szam from dom_ugyfelek where adoszam = '" . $ertekek["adoszam"] . "'" ;
			}
			else if ($ertekek["eu_adoszam"] != "") 
			{
				$query = "select count(*) as szam from dom_ugyfelek where eu_adoszam = '" . $ertekek["eu_adoszam"] . "'" ;
			}
			if ($query != "") {
				$result = lekerdez($query) ;
				$szam = mysql_result($result, 0, "szam") ;
				mysql_free_result($result) ;
			}
			if ($szam == 0) {
				$mezok_query = $ertekek_query = "" ;
				foreach ($ertekek as $kulcs => $ertek) {
					$mezok_query .= $kulcs . "," ;
					$ertekek_query .= "'" . addslashes($ertek) . "'," ;
				}
				$mezok_query = "(" . rtrim($mezok_query,",") . ")" ;
				$ertekek_query = "(" . rtrim($ertekek_query, ",") . ")" ;
				$query = "insert into dom_ugyfelek $mezok_query values $ertekek_query" ;
//				echo $query . "<br />" ;
				lekerdez($query) ;
				if (count($ugyfel_ugyintezok) > 0) {
					$query = "select id from dom_ugyfelek where adoszam = '" . $ertekek["adoszam"] . "'" ;
					$result = lekerdez($query) ;
					$ugyfel_id = mysql_result($result, 0, "id") ;
					mysql_free_result($result) ;
					foreach ($ugyfel_ugyintezok as $ugyintezo) {
						$query = "insert into dom_ugyfel_ugyintezok (ugyfel_id, nev, telefon, email) values ('" . $ugyfel_id . "', '" . $ugyintezo["nev"] . "', '" . $ugyintezo["telefon"] . "', '" . $ugyintezo["email"] . "')" ;
						lekerdez($query) ;
					}
				}
			}
		}
		echo "ugyfel import kesz!<br />" ;
	}
	
	function meret_felvesz(&$meretek, $meret_nev) {
		$szelesseg = 0 ;
		$magassag = 0 ;
		if (preg_match("/(\d*?)x(\d*)/", $meret_nev, $matches)) {
			$szelesseg = $matches[1] ;
			$magassag = $matches[2] ;
		}
		$query = "insert into dom_termek_meretek (nev, magassag, szelesseg, vastagsag, suly, aktiv) values ('" . $meret_nev . "', '" . $magassag . "', '" . $szelesseg . "', '0', '0', '1')" ;
		lekerdez($query) ;
		$query = "select id from dom_termek_meretek order by id desc limit 1" ;
		$result = lekerdez($query) ;
		$meret_id = mysql_result($result, 0, "id") ;
		mysql_free_result($result) ;
		$meretek[mb_strtolower($meret_nev)] = $meret_id ;
	}

	function zaras_felvesz(&$zarasok, $zaras_nev) {
		$query = "insert into dom_termek_zarasi_modok (nev, aktiv) values ('" . $zaras_nev . "', '1')" ;
		lekerdez($query) ;
		$query = "select id from dom_termek_zarasi_modok order by id desc limit 1" ;
		$result = lekerdez($query) ;
		$zaras_id = mysql_result($result, 0, "id") ;
		mysql_free_result($result) ;
		$zarasok[mb_strtolower($zaras_nev)] = $zaras_id ;
	}

	function ablak_meret_felvesz(&$ablak_meretek, $meret_nev) {
		$szelesseg = 0 ;
		$magassag = 0 ;
		if (preg_match("/(\d*?)x(\d*)/", $meret_nev, $matches)) {
			$magassag = $matches[1] ;
			$szelesseg = $matches[2] ;
		}
		$query = "insert into dom_termek_ablak_meretek (nev, magassag, szelesseg, aktiv) values ('" . $meret_nev . "', '" . $magassag . "', '" . $szelesseg . "', '1')" ;
		lekerdez($query) ;
		$query = "select id from dom_termek_ablak_meretek order by id desc limit 1" ;
		$result = lekerdez($query) ;
		$meret_id = mysql_result($result, 0, "id") ;
		mysql_free_result($result) ;
		$ablak_meretek[mb_strtolower($meret_nev)] = $meret_id ;
	}

	function ablak_hely_felvesz(&$ablak_helyek, $hely_nev) {
		$szelesseg = 0 ;
		$magassag = 0 ;
		if (preg_match("/(jobb|bal) (a|f)(\d*)(j|b)(\d*)/", $hely_nev, $matches)) {
			$hely = $matches[1] ;
			$x_poz_honnan = $matches[2] ;
			$x_poz_mm = $matches[3] ;
			$y_poz_honnan = $matches[4] ;
			$y_poz_mm = $matches[5] ;
		}
		else if ($hely_nev == "") {
			$hely_nev = "Nincs ablak" ;	
		}
		$query = "insert into dom_termek_ablak_helyek (nev, hely, x_pozicio_honnan, x_pozicio_mm, y_pozicio_honnan, y_pozicio_mm, aktiv) values ('" . $hely_nev . "', '" . $hely . "', '" . $x_poz_honnan . "', '" . $x_poz_mm . "', '" . $y_poz_honnan . "', '" . $y_poz_mm . "', '1')" ;
		lekerdez($query) ;
		$query = "select id from dom_termek_ablak_helyek order by id desc limit 1" ;
		$result = lekerdez($query) ;
		$hely_id = mysql_result($result, 0, "id") ;
		mysql_free_result($result) ;
		$ablak_helyek[mb_strtolower($hely_nev)] = $hely_id ;
	}
	
	function papir_tipus_felvesz(&$papir_tipusok, $papir_nev) {
		$query = "insert into dom_papir_tipusok (nev, aktiv) values ('" . $papir_nev . "', '1')" ;
		lekerdez($query) ;
		$query = "select id from dom_papir_tipusok order by id desc limit 1" ;
		$result = lekerdez($query) ;
		$papir_id = mysql_result($result, 0, "id") ;
		mysql_free_result($result) ;
		$papir_tipusok[mb_strtolower($papir_nev)] = $papir_id ;
	}
	
	function gyarto_felvesz(&$gyartok, $gyarto_nev) {
		$query = "insert into dom_gyartok (cegnev) values ('" . $gyarto_nev . "')" ;
		lekerdez($query) ;
		$query = "select id from dom_gyartok order by id desc limit 1" ;
		$result = lekerdez($query) ;
		$gyarto_id = mysql_result($result, 0, "id") ;
		mysql_free_result($result) ;
		$gyartok[mb_strtolower($gyarto_nev)] = $gyarto_id ;
	}
	
	
	function termek_import($mettol, $hanyat) {
		echo "termek import inditas<br />" ;		
		$parameters = array() ;
		$parameters[] = array("field"=>"KOD", "value"=>$mettol, "op"=>">") ;
		$parameters[] = array("field"=>"KOD", "value"=>$mettol + $hanyat, "op"=>"<=") ;
		$query_url = "http://" . $_SERVER["HTTP_HOST"] . "/import/dbfcomm.php?mode=select&dbf=" . TERMEKEK . "&filter=" . json_encode($parameters) ;
		echo $query_url ;
		$dbf_result = unserialize(httpGet($query_url)) ;
		
		//Termék méretek kigyűjtése
		$query = "select * from dom_termek_meretek" ;
		$result = lekerdez($query) ;
		$meretek = array() ;
		if (mysql_num_rows($result) > 0) {
			while ($sor = mysql_fetch_assoc($result)) {				
				$meretek[mb_strtolower($sor["nev"], 'UTF-8')] = $sor ; 	
			}
			mysql_free_result($result) ;
		}
		//Zárási módok kigyűjtése
		$query = "select * from dom_termek_zarasi_modok" ;
		$result = lekerdez($query) ;
		$zarasok = array() ;
		if (mysql_num_rows($result) > 0) {
			while ($sor = mysql_fetch_assoc($result)) {				
				$zarasok[mb_strtolower($sor["nev"], 'UTF-8')] = $sor ; 	
			}
			mysql_free_result($result) ;
		}
		//Ablak helyek kigyűjtése
		$query = "select * from dom_termek_ablak_helyek" ;
		$result = lekerdez($query) ;
		$ablak_helyek = array() ;
		if (mysql_num_rows($result) > 0) {
			while ($sor = mysql_fetch_assoc($result)) {				
				$ablak_helyek[mb_strtolower($sor["nev"], 'UTF-8')] = $sor ; 	
			}
			mysql_free_result($result) ;
		}
		//Ablak méretek kigyűjtése
		$query = "select * from dom_termek_ablak_meretek" ;
		$result = lekerdez($query) ;
		$ablak_meretek = array() ;
		if (mysql_num_rows($result) > 0) {
			while ($sor = mysql_fetch_assoc($result)) {				
				$ablak_meretek[mb_strtolower($sor["nev"], 'UTF-8')] = $sor ; 	
			}
			mysql_free_result($result) ;
		}
		//Papír típusok kigyűjtése
		$query = "select * from dom_papir_tipusok" ;
		$result = lekerdez($query) ;
		$papir_tipusok = array() ;
		if (mysql_num_rows($result) > 0) {
			while ($sor = mysql_fetch_assoc($result)) {				
				$papir_tipusok[mb_strtolower($sor["nev"], 'UTF-8')] = $sor ; 	
			}
			mysql_free_result($result) ;
		}
		//Gyártók kigyűjtése
		$query = "select * from dom_gyartok" ;
		$result = lekerdez($query) ;
		$gyartok = array() ;
		if (mysql_num_rows($result) > 0) {
			while ($sor = mysql_fetch_assoc($result)) {				
				$gyartok[mb_strtolower($sor["cegnev"], 'UTF-8')] = $sor ; 	
			}
			mysql_free_result($result) ;
		}
		
		foreach ($dbf_result as $sor) {
			foreach ($sor as $mezo => $ertek) {
				$sor[$mezo] = w1250_to_utf8($ertek) ;									
			}
			$ertekek = array() ;
			$termek_tipus = "Egyéb" ;			
			if (strpos($sor["NEV"], "LC/6") !== false || strpos($sor["NEV"], "LA/4") !== false || strpos($sor["NEV"], "C6/C5") !== false || strpos($sor["NEV"], "LC/5") !== false || strpos($sor["NEV"], "TC/5") !== false) {
				$termek_tipus = "Kis boríték" ;
			}
			else if (strpos($sor["NEV"], "LC/4") !== false || strpos($sor["NEV"], "TC/4") !== false || strpos($sor["NEV"], "TB/4") !== false) {
				$termek_tipus = "Nagy boríték" ;	
			}
			$meret_id = $meretek[mb_strtolower($sor["MERET"], 'UTF-8')]["id"] ;
			if ($meret_id == "") {
				meret_felvesz($meretek, $sor["MERET"]) ;
				$meret_id = $meretek[mb_strtolower($sor["MERET"], 'UTF-8')]["id"] ;
			}
			$zaras_id = $zarasok[mb_strtolower($sor["ZARAS"], 'UTF-8')]["id"] ;
			if ($zaras_id == "") {
				zaras_felvesz($zarasok, $sor["ZARAS"]) ;
				$zaras_id = $zarasok[mb_strtolower($sor["ZARAS"], 'UTF-8')]["id"] ;
			}
			$ablakmeret_id = $ablak_meretek[mb_strtolower($sor["ABLAKMERET"], 'UTF-8')]["id"] ;
			if ($ablakmeret_id == "") {
				ablak_meret_felvesz($ablak_meretek, $sor["ABLAKMERET"]) ;
				$ablakmeret_id = $ablak_meretek[mb_strtolower($sor["ABLAKMERET"], 'UTF-8')]["id"] ;
			}
			$ablakhely_id = $ablak_helyek[mb_strtolower($sor["ABLAKHELY"], 'UTF-8')]["id"] ;
			if ($ablakhely_id == "") {
				ablak_hely_felvesz($ablak_helyek, $sor["ABLAKHELY"]) ;
				$ablakhely_id = $ablak_helyek[mb_strtolower($sor["ABLAKHELY"], 'UTF-8')]["id"] ;
			}
			$papir_id = $papir_tipusok[mb_strtolower($sor["PAPIR"], 'UTF-8')]["id"] ;
			if ($papir_id == "") {
				papir_tipus_felvesz($papir_tipusok, $sor["PAPIR"]) ;
				$papir_id = $papir_tipusok[mb_strtolower($sor["PAPIR"], 'UTF-8')]["id"] ;
			}
			$gyarto_id = $gyartok[mb_strtolower($sor["GYARTO"], 'UTF-8')]["id"] ;
			if ($gyarto_id == "") {
				gyarto_felvesz($gyartok, $sor["GYARTO"]) ;
				$gyarto_id = $gyartok[mb_strtolower($sor["GYARTO"], 'UTF-8')]["id"] ;
			}
			
			
			$ertekek["nev"] = $sor["NEV"] ;
			$ertekek["tipus"] = $termek_tipus ;
			$ertekek["kodszam"] = $sor["KODSZAM"] ;
			$ertekek["cikkszam"] = $sor["KOD"] ;
			$ertekek["meret_id"] = $meret_id ;
			$ertekek["zaras_id"] = $zaras_id ;
			$ertekek["ablakmeret_id"] = $ablakmeret_id ;
			$ertekek["ablakhely_id"] = $ablakhely_id ;
			$ertekek["papir_id"] = $papir_id ;
			$ertekek["redotalp"] = $sor["REDOTALP"] ;
//			$ertekek["belesnyomott"] = $sor["NEV"] ;	//Ehhez nem találtam a dbf-ben mezőt
//			$ertekek["kategoria_tipus"] = $sor["NEV"] ;	//Ehhez nem találtam a dbf-ben mezőt
			$ertekek["gyarto_id"] = $gyarto_id ;
			$ertekek["afakulcs_id"] = "1" ;
			$ertekek["ksh_kod"] = $sor["KSH"] ;
			$ertekek["csom_egys"] = $sor["CSOMEGYS"] ;
			$ertekek["minimum_raktarkeszlet"] = $sor["MIN"] ;
			$ertekek["maximum_raktarkeszlet"] = $sor["MAX"] ;
			$ertekek["doboz_suly"] = $sor["DOBSULY"] ;
			$ertekek["raklap_db"] = $sor["RAKLAP"] ;
			$ertekek["doboz_hossz"] = $sor["DOBH"] ;
			$ertekek["doboz_szelesseg"] = $sor["DOBSZ"] ;
			$ertekek["doboz_magassag"] = $sor["DOBM"] ;
			$ertekek["megjegyzes"] = $sor["MEGJEGYZ"] ;
			$ertekek["megjelenes_mettol"] = "1970-01-01" ;
			$ertekek["megjelenes_meddig"] = "2050-12-31" ;
			$ertekek["datum"] = str_replace(".","-",$sor["DATUM"]) ;
			
			$ar_ertekek["csomag_beszerzesi_ar"] = $sor["ARBESZ"] ;
			$ar_ertekek["db_beszerzesi_ar"] = $sor["ARBESZ"] / $sor["CSOMEGYS"] ;
			$ar_ertekek["csomag_ar_szamolashoz"] = $sor["ELADAR"] ;
			$ar_ertekek["csomag_ar_nyomashoz"] = $sor["ELADAR2"] ;
			$ar_ertekek["db_ar_nyomashoz"] = $sor["ELADAR2"] / $sor["CSOMEGYS"] ;
			$ar_ertekek["csomag_eladasi_ar"] = $sor["ARCSOME"] ;
			$ar_ertekek["db_eladasi_ar"] = $sor["ARCSOME"] / $sor["CSOMEGYS"] ;
			$ar_ertekek["csomag_ar2"] = $sor["ELADAR3"] ;
			$ar_ertekek["db_ar2"] = $sor["ELADAR3"] / $sor["CSOMEGYS"] ;
			$ar_ertekek["csomag_ar3"] = $sor["ELADAR4"] ;
			$ar_ertekek["db_ar3"] = $sor["ELADAR4"] / $sor["CSOMEGYS"] ;
			$ar_ertekek["datum_mettol"] = "2015-12-01" ;
			$ar_ertekek["datum_meddig"] = "2025-12-31" ;
			
			$szam = 0;
			$query = "" ;
			if ($ertekek["cikkszam"] != "") {
				$query = "select count(*) as szam from dom_termekek where cikkszam = '" . $ertekek["cikkszam"] . "'" ;
			}
			else
			{
				$ertekek["cikkszam"] = code(10) ;	
			}
			if ($query != "") {
				$result = lekerdez($query) ;
				$szam = mysql_result($result, 0, "szam") ;
				mysql_free_result($result) ;
			}
			if ($szam == 0) {
				$mezok_query = $ertekek_query = "" ;
				foreach ($ertekek as $kulcs => $ertek) {
					$mezok_query .= $kulcs . "," ;
					$ertekek_query .= "'" . addslashes($ertek) . "'," ;
				}
				$mezok_query = "(" . rtrim($mezok_query,",") . ")" ;
				$ertekek_query = "(" . rtrim($ertekek_query, ",") . ")" ;
				$query = "insert into dom_termekek $mezok_query values $ertekek_query" ;
//				echo $query . "<br />" ;
				lekerdez($query) ;
				$query = "select id from dom_termekek where cikkszam = '" . $ertekek["cikkszam"] . "'" ;
				$result = lekerdez($query) ;
				$termek_id = mysql_result($result, 0, "id") ;
				mysql_free_result($result) ;
				$mezok_query = $ertekek_query = "" ;
				foreach ($ar_ertekek as $kulcs => $ertek) {
					$mezok_query .= $kulcs . "," ;
					$ertekek_query .= "'" . addslashes($ertek) . "'," ;
				}
				$mezok_query = "(termek_id, " . rtrim($mezok_query,",") . ")" ;
				$ertekek_query = "('$termek_id', " . rtrim($ertekek_query, ",") . ")" ;
				$query = "insert into dom_termek_arak $mezok_query values $ertekek_query" ;
//				echo $query . "<br />" ;
				lekerdez($query) ;
			}
		}		
		echo "termek import kesz!<br />" ;
	}
	
	$mode = $_GET["mode"] ;
	$mettol = $_GET["mettol"] ;
	$hanyat = $_GET["hanyat"] ;
	
	if (!is_numeric($mettol)) {
		$mettol = 0 ;
	}
	if (!is_numeric($hanyat)) {
		$hanyat = 50 ;		
	}
	switch ($mode) {
		case "ugyfel": ugyfel_import($mettol, $hanyat) ;
					   $max_sorszam = 17000 ;
			break ;
		case "termek": termek_import($mettol, $hanyat) ;
					   $max_sorszam = 900 ;
			break ;				
		case "nyomasi_arak": nyomasi_arak_import() ;
					   $mettol = $max_sorszam = 200 ;
			break ;				
	}
	
	if ($mettol < $max_sorszam) {
		$kov_mettol = $mettol + $hanyat ;

?>
<meta http-equiv="refresh" content="2;URL=<?php echo HOST . substr($_SERVER["REQUEST_URI"],0,strrpos($_SERVER["REQUEST_URI"],"/"))."/import.php?mode=$mode&mettol=$kov_mettol&hanyat=$hanyat" ;?>">
<title>Importálás folyamatban...</title>
</head>

<body>
	Importálás folyamatban...<br>
<?php	
    echo "Következő $hanyat rekord importálása kész, összesen importálva eddig $kov_mettol sorszámig." ;
?>
<?php
	}
	else
	{
?>
<title>Importálás kész...</title>
</head>

<body>
Teljes import kész!
<?php
	}
?>
</body>
</html>


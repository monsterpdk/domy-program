<?php
	include ('functions.php') ;

	$raktarkeszletek = array() ;

	$query = "select dom_anyagbeszallitas_termekek.anyagbeszallitas_id, dom_anyagbeszallitas_termekek.termek_id, dom_anyagbeszallitas_termekek.darabszam from dom_anyagbeszallitas_termekek inner join dom_anyagbeszallitasok on (dom_anyagbeszallitas_termekek.anyagbeszallitas_id = dom_anyagbeszallitasok.id) where dom_anyagbeszallitasok.lezarva = 1 order by termek_id, anyagbeszallitas_id" ;
	$result = lekerdez($query) ;
	
	while ($sor = mysql_fetch_assoc($result)) {
		$raktarkeszletek[$sor["termek_id"]]["darabszam"] += $sor["darabszam"] ;
		$raktarkeszletek[$sor["termek_id"]]["anyagbeszallitas_id"] = $sor["anyagbeszallitas_id"] ;	
	}
	mysql_free_result($result) ;
	
	$query = "select dom_megrendeles_tetelek.termek_id, dom_szallitolevel_tetelek.darabszam from dom_szallitolevelek inner join dom_szallitolevel_tetelek on (dom_szallitolevelek.id = dom_szallitolevel_tetelek.szallitolevel_id) inner join dom_megrendeles_tetelek on (dom_megrendeles_tetelek.id = dom_szallitolevel_tetelek.megrendeles_tetel_id) where dom_szallitolevelek.datum >= '2016-15-11 00:00:00' and dom_megrendeles_tetelek.hozott_boritek = 0 and dom_szallitolevel_tetelek.torolt = 0 order by dom_megrendeles_tetelek.termek_id" ;
	$result = lekerdez($query) ;
	
	while ($sor = mysql_fetch_assoc($result)) {
		$raktarkeszletek[$sor["termek_id"]]["darabszam"] -= $sor["darabszam"] ;	
	}
	mysql_free_result($result) ;

	foreach ($raktarkeszletek as $termek_id => $termek_adatok) {
		$query = "select sum(foglalt_db) as ossz_foglalas from dom_raktar_termekek where termek_id = '$termek_id'" ;
		$result = lekerdez($query) ;
		$raktarkeszletek[$termek_id]["foglalt_db"] = mysql_result($result, 0, "ossz_foglalas") ;
	}

	$query = "truncate table dom_raktar_termekek" ;
	lekerdez($query) ;
	
	foreach ($raktarkeszletek as $termek_id => $termek_adatok) {
		$query = "insert into dom_raktar_termekek (termek_id, anyagbeszallitas_id, raktarhely_id, osszes_db, foglalt_db, elerheto_db) values ('$termek_id', '" . $termek_adatok["anyagbeszallitas_id"] . "', '1', '" . $termek_adatok["darabszam"] . "', '" . $termek_adatok["foglalt_db"] . "', '" . ($termek_adatok["darabszam"] - $termek_adatok["foglalt_db"]) . "')" ;
		lekerdez($query) ;
		echo $query . "<br />" ;	
	}

	
?>

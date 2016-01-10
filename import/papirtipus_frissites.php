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
	
	function papir_tipus_felvesz(&$papir_tipusok, $papir_nev_suly) {
		$papir_tomb = explode("::", $papir_nev_suly) ;
		$query = "insert into dom_papir_tipusok (nev, suly, aktiv) values ('" . $papir_tomb[0] . "', '" . intval($papir_tomb[1]) . "', '1')" ;
		lekerdez($query) ;
		$query = "select id from dom_papir_tipusok order by id desc limit 1" ;
		$result = lekerdez($query) ;
		$papir_id = mysql_result($result, 0, "id") ;
		mysql_free_result($result) ;
		$papir_tipusok[mb_strtolower($papir_nev_suly, 'UTF-8')] = $papir_id ;
	}
	  
	  
	$parameters = array() ;
	$parameters[] = array("field"=>"KOD", "value"=>694, "op"=>">") ;
	$query_url = "http://" . $_SERVER["HTTP_HOST"] . "/import/dbfcomm.php?mode=select&dbf=" . TERMEKEK . "&filter=" . json_encode($parameters) ;
	echo $query_url ;
	$dbf_result = unserialize(httpGet($query_url)) ;
	
	//Papír típusok kigyűjtése
	$query = "select * from dom_papir_tipusok" ;
	$result = lekerdez($query) ;
	$papir_tipusok = array() ;
	if (mysql_num_rows($result) > 0) {
		while ($sor = mysql_fetch_assoc($result)) {				
			$papir_tipusok[mb_strtolower($sor["nev"], 'UTF-8')."::".$sor["suly"]] = $sor ; 	
		}
		mysql_free_result($result) ;
	}
	foreach ($dbf_result as $sor) {
		foreach ($sor as $mezo => $ertek) {
			$sor[$mezo] = w1250_to_utf8($ertek) ;									
		}
		$ertekek = array() ;
		if ($sor["PAPIR"] != "" || $sor["SULY"] != "") {
			if ($sor["SULY"] == "") {
				$sor["SULY"] = "0" ;	
			}
			$termek_papir_nev_suly = $sor["PAPIR"]."::".$sor["SULY"] ;
		}
		else
		{
			$termek_papir_nev_suly = "Nincs::0" ;
		}		
		$papir_id = $papir_tipusok[mb_strtolower($termek_papir_nev_suly, 'UTF-8')]["id"] ;
		if ($papir_id == "") {
			echo mb_strtolower($termek_papir_nev_suly, 'UTF-8') . "!==" ;
			print_r($papir_tipusok) ;
			echo "<br /><br /><br />\n\n\n" ;
//			die() ;
			papir_tipus_felvesz($papir_tipusok, $termek_papir_nev_suly) ;
			$papir_id = $papir_tipusok[mb_strtolower($termek_papir_nev_suly, 'UTF-8')]["id"] ;
		}
		
		$query = "update dom_termekek set papir_id = '" . $papir_id . "' where cikkszam = '" . $sor["KOD"] . "'" ;
		echo $query . "<br />" ;
		lekerdez($query) ;			
	}
	  
	  
?>

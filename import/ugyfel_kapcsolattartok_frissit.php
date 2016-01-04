<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
	include "include/config.php" ;
	include "include/functions.php" ;
	
	$query = "SELECT dom_ugyfelek.* FROM dom_ugyfelek left join dom_ugyfel_ugyintezok on (dom_ugyfelek.id = dom_ugyfel_ugyintezok.ugyfel_id) WHERE length(`kapcsolattarto_nev`) > 5 and dom_ugyfel_ugyintezok.ugyfel_id IS NULL ORDER BY `kapcsolattarto_nev` ASC" ;
	$result = lekerdez($query) ;
	while ($sor = mysql_fetch_assoc($result)) {
		$ugyfel_id = $sor["id"] ;
		$kapcs_nev = $sor["kapcsolattarto_nev"] ;
		$kapcs_telefon = $sor["kapcsolattarto_telefon"] ;
		$kapcs_email = $sor["kapcsolattarto_email"] ;
		if (!email_check($kapcs_email)) {
			$kapcs_email = "" ;	
		}
		$query = "insert into dom_ugyfel_ugyintezok (ugyfel_id, nev, telefon, email, alapertelmezett_kapcsolattarto) values ('" . $ugyfel_id . "', '" . addslashes($kapcs_nev) . "', '" . $kapcs_telefon . "', '" . $kapcs_email . "', 1)" ;
		lekerdez($query) ;
	}
	mysql_free_result($result) ;
	echo "kész!" ;
?>

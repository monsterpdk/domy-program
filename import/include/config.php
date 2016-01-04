<?php

	$DBConn["host"]="localhost";
	$DBConn["login"]="root";
	$DBConn["password"]="doMYP4ss";
	$DBConn["DB"]="domy";

	define("HOST", "http://domyweb.dyndns.org:81") ; 
	
	setlocale(LC_ALL, 'hu_HU');
	
	ini_set('error_reporting', E_ALL ^ E_NOTICE);
	error_reporting(E_ALL ^ E_NOTICE);	
	
	$kapcsolat = mysql_connect($DBConn["host"],$DBConn["login"],$DBConn["password"]);

	if (!$kapcsolat) {
	  	echo "Nem tudok csatlakozni: " . mysql_error();
	   exit;
	}
	
?>
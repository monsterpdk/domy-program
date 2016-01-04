<?php

	//html-es <br> és <br />-rel tört szöveget átalakít \\n-nel törtre
	function br2nl($str) {
	   $str = preg_replace("/(\r\n|\n|\r)/", "", $str);
	   return preg_replace("=<br */?>=i", "\n", $str);
	}


	//Ezzel a függvénnyel szedegetjük ki az esetleges kódokat, html-tageket a szövegből, a szerver védelmére
	function szovegfeldolgoz($szoveg) {
		$uj_szoveg = strip_tags($szoveg) ;
		return $uj_szoveg ;
	}

 //Ezzel a függvénnyel szedegetjük ki az esetleges kódokat, html-tageket a szövegből, ami lekérdezésbe megy, a szerver védelmére
 function szovegfeldolgoz_array_walk(&$szoveg) {
  $uj_szoveg = strip_tags($szoveg) ;
  $uj_szoveg = str_replace('%', '', $uj_szoveg) ;
  $uj_szoveg = str_replace('&#37', '', $uj_szoveg) ;
  $uj_szoveg = str_replace("'", "", $uj_szoveg) ;
  $uj_szoveg = str_replace('&#39', '', $uj_szoveg) ;
  $uj_szoveg = str_replace("=", "", $uj_szoveg) ;
  $uj_szoveg = str_replace('&#61', '', $uj_szoveg) ;
  $uj_szoveg = str_replace('&#59', '', $uj_szoveg) ;
  $uj_szoveg = str_replace(";", "", $uj_szoveg) ;
  $szoveg = $uj_szoveg ;
 }

	//Ezzel kérdezünk le mindent
	function lekerdez($query) {
//		if (strpos($query, 'napitalalat') > 0) {
//			$query_temp = "insert into lt_talalatok (datum, query) values (now(), '$query')" ;
//			mysql_query($query_temp) or die(mysql_error());
//		}
		global $DBConn ;

		$kapcsolat = mysql_connect($DBConn["host"],$DBConn["login"],$DBConn["password"]);


		if (!$kapcsolat) {
		  	echo "Nem tudok csatlakozni: " . mysql_error();
		   exit;
		}

		$DBSelect = mysql_select_db($DBConn["DB"]);

		if (!$DBSelect) {
		   echo "Nem tudok belépni az adatbázisba: " . mysql_error();
		   exit;
		}

		mysql_query("SET NAMES 'utf8'"); 


		$result = mysql_query($query) or die(mysql_error()) ;
		mysql_close($kapcsolat) ;
		return $result ;
	}
	
	//Mentesítünk egy stringet az ékezetektől, illetve egyéb nem kívánt karakterektől
	function ekezetlenites($szoveg) {
		$miket=array('á','é','í','ó','ö','ő','ú','ü','ű','Á','É','Í','Ó','Ö','Ő','Ú','Ü','Ű',':','  ',',','.',' ','/') ;
		$mire=array('a','e','i','o','o','o','u','u','u','A','E','I','O','O','O','U','U','U','-','-','-','-','-','-') ;
		
		$uj_szoveg = $szoveg ;
		for ($i=0;$i < count($miket);$i++) {
			$uj_szoveg = str_replace($miket[$i], $mire[$i], $uj_szoveg) ;
		}
		$uj_szoveg = rawurlencode($uj_szoveg) ;
		return $uj_szoveg ;
	} 	
	
	function code($nc, $a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
	   $l=strlen($a)-1; $r='';
	   while($nc-->0) $r.=$a{mt_rand(0,$l)};
	   return $r;
	}
	
		function current_page_url(){
	    $page_url   = 'http';
	    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
	        $page_url .= 's';
	    }
	    return $page_url.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
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
	
	function email_check($email) {
		return preg_match('/^[0-9a-z_-]+(?:\.[0-9a-z_-]+)*?@[0-9a-z_-]+(?:\.[0-9a-z_-]+)*\.[0-9a-z_-]{2,}$/is',$email) ;		
	}

?>
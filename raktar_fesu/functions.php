<?php

function szovegfeldolgoz($szoveg) {
	$uj_szoveg = strip_tags($szoveg) ;
	return $uj_szoveg ;
}

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

function lekerdez($query) {

	$Host     = "localhost";
//	$Database = "domy_teszt";
	$Database = "domy";
	$User     = "root";
	$Password = "doMYP4ss";

	$kapcsolat = mysql_connect($Host, $User, $Password);
	if (!$kapcsolat) {
	   die('Nem lehet csatlakozni ' . mysql_error());
	}
	else
		mysql_select_db($Database, $kapcsolat);
	
/*	$fp = fopen('mysql_log.txt', 'a');
	fwrite($fp, date("Y-m-d H:i") . "  " . $query . "\n") ;
	fclose($fp);*/

	$result = mysql_query("set names 'utf8'"); 	
	$result = mysql_query($query,$kapcsolat) or die(mysql_error()) ;
	return $result ;
}

//Kigyoml·lja a szˆvegbıl a kÌv·nt karaktereket
	function strip_spec_chars($szoveg) {
		$mit = array('/', ' ') ;
		$mire = array('', '_') ;
		$szoveg = str_replace($mit, $mire, $szoveg) ;
		return $szoveg ;
	}

	//MentesÌt¸nk egy stringet az Èkezetektıl, illetve egyÈb nem kÌv·nt karakterektıl
	function ekezetlenites($cegnev) {

//$miket=array("á","é","í","ó","ö","ü","ű","ú","Á","É","Í","Ó","Ö","Ü","Ű","Ú","ä","Ä","ß","§" );
//$mire=array("&#225;","&#233;","&#237;","&#243;","&#246;","&#252;","ű","&#250;","&#193;","&#201;","&#205;","&#211;","&#214;","&#220;","Ű","&#218;","&#228;","&#196;","&#223;","&#167;");
//		print($cegnev);
		$miket=array('á','é','í','ó','ö','ő','&#337;','ú','ü','ű','Á','É','Í','Ó','Ö','Ő','Ú','Ü','Ű','&#201;','c3,a9','c3, a9','%C3%A9','&#233;','%E9','&eacute;','c3a9') ;
		$mire=array('a','e','i','o','o','o','o','u','u','u','A','E','I','O','O','O','U','U','U','e','e','e','e','e','e','e','e') ;

		$uj_cegnev = $cegnev ;
		for ($i=0;$i < count($miket);$i++) {
			$uj_cegnev = str_replace($miket[$i], $mire[$i], $uj_cegnev) ;
		}
		return $uj_cegnev ;
	}

//Kigyoml·lja a szˆvegbıl a kÌv·nt karaktereket a kisokos rÈszben
	function strip_spec_chars_kisokos($szoveg) {
		$mit = array('/', ' ') ;
		$mire = array('|', '_') ;
		$szoveg = str_replace($mit, $mire, $szoveg) ;
		return $szoveg ;
	}

//visszateszi a szˆvegbe a kÌv·nt karaktereket a kisokos rÈszben
	function add_spec_chars_kisokos($szoveg) {
		$mit = array('|', '_') ;
		$mire = array('/', ' ') ;
		$szoveg = str_replace($mit, $mire, $szoveg) ;
		return $szoveg ;
	}
	function oldalnev(){
		$cimtomb = array(
		'/index.php' => 'NyitÛlap', 
		'/arszamolo_nagy.php' => 'Non-Stop ·rsz·molÛ', 
		'/arlista.php' => 'BorÌtÈk ·rlista', 
		'/arlista_teljes.php' => '÷sszesÌtett borÌtÈk ·rlista',
		'/uzleti_boritek.php' => '‹zleti borÌtÈkok', 
		'/cygnus.php' => 'Cygnus Excellence', 
		'/kapcsolat.php' => 'Kapcsolat', 
		'/kisokos.php' => 'Kisokos', 
		'/rendel_segit.php' => 'MegrendelÈsi segÌtsÈg',
		'/termekminta.php' => 'TermÈkminta kÈrÈse', 
		'/filmkeszites.php' => 'FilmkÈszÌtÈs', 
		'/sitemap.php' => 'OldaltÈrkÈp', 
		'/referenciak.php' => 'Referenci·k', 
		'/felulnyomas_arlista.php' => 'Fel¸lnyom·s ·rlista',
		'/instant.php' => 'Ez az');
		$site = $_SERVER["SCRIPT_URL"];
		$title = $cimtomb[$site];
		echo $title;
	
	
	}
	
	//Rendszeremailek küldéséhez a felhasználóknak
	function emailkuldes($cimzett, $felado_email, $felado_nev, $targy, $email_body_html, $email_body_text) {
		global $root_path ;
		require_once($root_path."include.ac/class.phpmailer.php");
	
		$mail = new PHPMailer();
		// $mail->IsSMTP();
		$mail->IsHTML(true);
		$mail->CharSet = "ISO-8859-1";
		$mail->Host="www.domypress.hu";
		$mail->Mailer="mail";
		
		$mail->From     = $felado_email;
		
	 	$mail->FromName = $felado_nev;
		$mail->Subject=$targy; //your mailsubject incl. current date
		
		
		$mail->Body = $email_body_html;
    $mail->AltBody=$email_body_text ;
		$mail->AddAddress($cimzett);
//		$mail->AddCC($user_email2);
		if($mail->Send()) {
			//
		}		
	}
	
	function code($nc, $a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
	   $l=strlen($a)-1; $r='';
	   while($nc-->0) $r.=$a{mt_rand(0,$l)};
	   return $r;
	}
	
	//Szállítási költség számoló függvény, súlyfüggő
	function szallitasi_koltseg_szamolas($suly) {
		//Díjtábla tömb felépítése: $dijtabla[sulyhatár] = ár ;
		$dij_kilonkent_tabla_felett = 100 ;		//Ha valaki a díjtábla feletti súlyban rendel, akkor ezzel számolunk
		$dijtabla = array() ;
		$dijtabla[10000] = 1230 ;
		$dijtabla[20000] = 1350 ;
		$dijtabla[30000] = 1530 ;
		$dijtabla[40000] = 1775 ;
		$dijtabla[50000] = 2260 ;
		$dijtabla[60000] = 2510 ;
		$dijtabla[70000] = 2635 ;
		$dijtabla[80000] = 2988 ;
		$dijtabla[90000] = 3475 ;
		$dijtabla[100000] = 3730 ;
		$dijtabla[150000] = 3960 ;
		$dijtabla[999999] = 5700 ;
		
		$ar = 0 ;
		foreach ($dijtabla as $sulyhatar => $ertek) {
			if ($suly > $sulyhatar) {
				continue ;
			}
			else
			{
				$ar = $ertek ;
				break ;
			}
		}
		if ($ar == 0) {
			$ar = $dij_kilonkent_tabla_felett * ceil($suly) ;
		}
		return $ar ;
	}	
	
	function tumblr_tags_lekeres() {
		$cimkek = array() ;
		$tumblr_postok = tumblr_posts_lekeres(1000) ;
		for ($i=0;$i < count($tumblr_postok["tumblr"]["posts"]["post"]); $i++) {
			for ($j=0;$j<count($tumblr_postok["tumblr"]["posts"]["post"][$i]["tag"]); $j++) {
				$cimke = mb_convert_encoding($tumblr_postok["tumblr"]["posts"]["post"][$i]["tag"][$j], "ISO-8859-2","UTF-8") ;
				if (is_numeric($cimkek[$cimke])) {
					$cimkek[$cimke]++ ;	
				}
				else
				{
					$cimkek[$cimke] = 1 ;	
				}
			}
		}
		return $cimkek ;
	}
	
	function tumblr_posts_lekeres($post_num, $tag="") {
		global $root_path ;
		require_once($root_path."include.ac/Xml2array.class.php");

		$curl = curl_init();

		$feedURL = "http://blog.domypress.hu/api/read/?";
		$params = array() ;
		if ($tag != "") {
			$tag = mb_convert_encoding($tag, "UTF-8", "ISO-8859-2") ;
//			$tag = urlencode($tag) ;
			$params['tagged'] = $tag ; 
//			$feedURL .= "&tagged=".$tag."&" ;	
		}
//		$params['num'] = $post_num."#_=_" ;
		$feedURL .= "num=".$post_num ;
		
//		echo $feedURL ;

		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curl, CURLOPT_POST, false);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params); 	   
		curl_setopt($curl, CURLOPT_URL, $feedURL);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
	
		// execute and return string (this should be an empty string '')
		$str = curl_exec($curl);
					
		curl_close($curl);
	
		// the value of $str is actually bool(true), not empty string ''
//		echo $str ;
//		$xml = str_replace(array("NULL","\r\n","\n"), array("","",""), $str) ;
		$xml = str_replace(array("NULL","\r\n"), array("",""), $str) ;
		$xml = trim(preg_replace('/\s+/', ' ', $xml));
		$array = XML2Array::createArray($xml);
//		print_r($array) ;
		return $array ;   		
	}
?>
<?php
	require_once "phpxbase/Column.class.php";
	require_once "phpxbase/Record.class.php";
	require_once "phpxbase/Table.class.php";
	require_once "phpxbase/api_conversion.php";
	require_once "class.compare.php" ;
	

  define("ROOT_PATH", "C:\\inetpub\\wwwroot\\domywebdev\\gepterem_komm/") ;
//  define("ROOT_PATH", "C:\\inetpub\\wwwroot\\domyweb\\gepterem_komm\\gepterem/") ;
//  define("ROOT_PATH", "C:\\wamp\\www\\domypress\\gepterem_komm/") ;
  define("NYOMDAKONYV", "NYOM.dbf") ;
  define("WORKFLOW", "workflow.dbf") ;
  define("WORKFLOW_gepterem", "gepterem/workflow.dbf") ;

/**
 * A php meghívásánál paraméterben megkapott json típusú keresőparancs, ezt szűrjük / alakítjuk általunk használható (dbf_query függvénynek átadható) szűrő tömbre.
 * A json-ban elméletileg ugyanúgy a mező, érték, operator hármasok sorakoznak, de ha esetleg csúnyaságokat, vagy elírásokat tettek volna bele, itt kiszűrjük.
 * Ha nincs megadva operator, akkor az = jel lesz használva alapértelmezetten.
 **/
  function dbf_filter_create($json_filter) {
  	  $return = array() ;
  	  $tomb = json_decode($json_filter) ;
  	  foreach ($tomb as $kulcs => $ertek) {  	  	  
  	  	  $mezo["field"] = strip_tags($ertek->field) ;
  	  	  $mezo["value"] = strip_tags(rawurldecode($ertek->value)) ;
  	  	  $mezo["operator"] = $ertek->op ;
  	  	  if (!in_array($mezo["operator"], array(">","<","=","<=",">=","!="))) {
  	  	  	  $mezo["operator"] = "=" ;
  	  	  }
  	  	  $return[] = $mezo ;
  	  }
  	  return $return ;
  }
  
/** 
 * A $dbf_file nevű fileban a keres a $filters-ben megadott szűrőknek megfelelő rekordokat. Az eredmény egy tömb lesz, amelynek sorai az megtalált rekordok
 * A $filters mező egy tömb, amelyben a rekord mezői: field=>"szűrendő mező"; value=>"szűréshez megadott érték"; operator=>"a szűrésnél használt operátor"
 * Operátorok lehetnek: > , < , = , <= , >= , !=
 **/
  function dbf_lekerdez($dbf_file, $filters) {
  	  	$return = array() ;
		/* create a table object and open it */
//		$table = new XBaseTable(ROOT_PATH . $dbf_file);
		$table = new XBaseTable($dbf_file);
		$table->open();
		/* print some header info */
/*		echo "version: ".$table->version."<br />";
		echo "foxpro: ".($table->foxpro?"yes":"no")."<br />";
		echo "modifyDate: ".date("r",$table->modifyDate)."<br />";
		echo "recordCount: ".$table->recordCount."<br />";
		echo "headerLength: ".$table->headerLength."<br />";
		echo "recordByteLength: ".$table->recordByteLength."<br />";
		echo "inTransaction: ".($table->inTransaction?"yes":"no")."<br />";
		echo "encrypted: ".($table->encrypted?"yes":"no")."<br />";
		echo "mdxFlag: ".ord($table->mdxFlag)."<br />";
		echo "languageCode: ".ord($table->languageCode)."<br />";*/

		$columns = array() ;
		$columns_indexes = array() ;
		foreach ($table->getColumns() as $i=>$c) {
			$columns[$c->getName()] = $c ;
			$columns_indexes[$c->getName()] = $i ;
		}
		
		
		$cmp = new compare ;
		while ($record=$table->nextRecord()) {
			$match = true ;
			$i = 0 ;
			while ($i < count($filters) && $match) {
				$filter = $filters[$i] ;
//				echo $columns[$filter["field"]]->getType() . " - " . $record->getString($columns[$filter["field"]]) . "<br />" ;
				if ($columns[$filter["field"]]->getType() == "D") {
					$ertek = date("Y-m-d", $record->getDate($columns[$filter["field"]])) ;
				}
				else
				{
					$ertek = $record->getString($columns[$filter["field"]]) ;
				}
				if (!$cmp->is($ertek, $filter["value"], $filter["operator"])) {
					$match = false ;
				}
				$i++ ;
			}
			if ($match) {
				$row = array() ;
				foreach ($columns as $key => $column) {
					$row[$key] = trim($record->choppedData[$columns_indexes[$key]]) ;
				}
				$return[] = $row ;	
			}			
		}		
		$table->close();
		return $return ;  	    	  
  }
  
/**
 * A php meghívásánál paraméterben megkapott json szerkezetű változóban átadjuk mező -> érték párokat.
 * A json-ban elméletileg ugyanúgy a mező, érték párosok sorakoznak, de ha esetleg csúnyaságokat, vagy elírásokat tettek volna bele, itt kiszűrjük.
 **/
  function dbf_fields_create($json_fields) {
  	  $return = array() ;
  	  $tomb = json_decode($json_fields) ;
  	  foreach ($tomb[0] as $kulcs => $ertek) {
//  	  	  $return[strip_tags($kulcs)] = iconv("UTF-8", "ASCII//TRANSLIT", strip_tags($ertek)) ;
  	  	  $return[strip_tags($kulcs)] = strip_tags(rawurldecode($ertek)) ;
  	  }
  	  return $return ;  	  
  }
  
/** 
 * A $dbf_file nevű filehoz egy rekordot hozzáad a file végére. Az eredmény egy szám lesz, amelyben a beszúrt sor sorszáma lesz, sikertelenség esetén pedig 0
 * A $filters mező egy tömb, amelyben a rekord mezői: field=>"szűrendő mező"; value=>"szűréshez megadott érték";
 **/  
  function dbf_add_record($dbf_file, $fields) {
	$table = new XBaseTable($dbf_file);
	$table->open();
	$record = array() ;
	foreach ($table->getColumns() as $i=>$c) {
		$record[$c->getName()] = iconv("utf-8", "windows-1250", $fields[$c->getName()]) ;
	}	
	$XBaseId = xbase_open($dbf_file,$flags=1) ;
	xbase_add_record($XBaseId, $record) ;

	return xbase_numrecords($XBaseId) ;  	  
  }
  
/** 
 * A $dbf_file nevű fileban a keres a $filters-ben megadott szűrőnek megfelelő rekordot. Az eredmény egy szám lesz, amely a módosított rekordok számát tartalmazza
 * A $filters mező egy tömb, amelyben a rekord mezői: field=>"szűrendő mező"; value=>"szűréshez megadott érték"; operator=> mindegy, mi van megadva, mindig = jel lesz az érvényes
 **/
  function dbf_update_record($dbf_file, $fields, $filters) {
  	  	$return = array() ;
		$table = new XBaseTable($dbf_file);
		$table->open();
		$columns = array() ;
		$columns_indexes = array() ;
		foreach ($table->getColumns() as $i=>$c) {
			$columns[$c->getName()] = $c ;
			$columns_indexes[$c->getName()] = $i ;
		}		
		
		$rows = array() ;
		$cmp = new compare ;
		while ($record=$table->nextRecord()) {
			$match = true ;
			$i = 0 ;
			while ($i < count($filters) && $match) {
				$filter = $filters[$i] ;
				if (!$cmp->is($record->getString($columns[$filter["field"]]), $filter["value"], $filter["operator"])) {
					$match = false ;
				}
				$i++ ;
			}
			if ($match) {
				$rows[] = $record ;
			}			
		}
		$table->close();
		$return = count($rows) ;
		$XBaseId = xbase_open($dbf_file,$flags=1) ;
		if (count($rows) > 0) {
			foreach ($rows as $record) {
				$new_record = array() ;
				foreach ($table->getColumns() as $i=>$c) {
					if (isset($fields[$c->getName()])) {
						$record->setObjectByName($c->getName(), iconv("utf-8", "windows-1250", $fields[$c->getName()])) ;
					}
					$new_record[$c->getName()] = $record->choppedData[$columns_indexes[$c->getName()]] ;
				}
				xbase_replace_record($XBaseId, $new_record, $record->getRecordIndex()+1) ;
			}
		}
  	  
	return $return ;  	  
  }  
  
  
  $mode = $_GET["mode"] ;
  if ($mode != "select" && $mode != "insert" && $mode != "update") {
  	 die("Please set the query mode!") ;  
  }
  $dbf_file = rawurldecode($_GET["dbf"]) ;
//  $dbf_file = NYOMDAKONYV ;
  if (!file_exists($dbf_file)) {
  	die("The dbf file is unreachable!") ;  
  }
  
  
  switch ($mode) {
  	case "select": 
  				//Teszteléshez: dbfcomm.php?mode=select&dbf=NYOM.DBF&filter=[{"field":"TSZAM","value":"KC0003","op":"="},{"field":"RENDSZAM","value":"RC0004","op":"="}]
  				   $filter_array = dbf_filter_create($_GET["filter"]) ;
  				   $result = dbf_lekerdez($dbf_file, $filter_array) ;
  				   break ;
  	case "insert": 
  				//Teszteléshez: dbfcomm.php?mode=insert&dbf=NYOM.DBF&fields=[{"TSZAM":"TE0001","CEGNEV":"Teszt Kft.","MUNEV":"Bor%C3%ADt%C3%A9k%20elad%C3%A1s","NEV":"Bor%C3%ADt%C3%A9kn%C3%A9v","DARAB":"1234","SZIN":"2%2B1","PANTON":"piros%2C%20k%C3%A9k%20%2B%20fekete","TASKKI":"2015.11.24","TASKKISE":"14%2C54","GEP":"2","LEMEZ":"3","DOMYFILM":"HAMIS","NYOMKATU":"A1","C":"FALSE","M":"FALSE","Y":"FALSE","K":"FALSE","MUTACIO":"FALSE","MUTSZIN":"0","FORDLEV":"0","CTP":"TRUE","KIFUT":"FALSE"}]
  				   $fields_array = dbf_fields_create($_GET["fields"]) ;  				   
  				   $result = dbf_add_record($dbf_file, $fields_array) ;
  				   break ;
    case "update": 
  				//Teszteléshez: dbfcomm.php?mode=update&dbf=NYOM.DBF&filter=[{"field":"TSZAM","value":"KC0003","op":"="},{"field":"RENDSZAM","value":"RC0004","op":"="}]&fields=[{"CEGNEV":"Teszt%20Kft.","MUNEV":"Bor%C3%ADt%C3%A9k%20elad%C3%A1s","NEV":"Bor%C3%ADt%C3%A9kn%C3%A9v","DARAB":"5555","SZIN":"2%2B1","PANTON":"piros%2C%20k%C3%A9k%20%2B%20fekete","TASKKI":"2015.11.24","TASKKISE":"14%2C54","GEP":"2","LEMEZ":"3","DOMYFILM":"FALSE","NYOMKATU":"A1","C":"FALSE","M":"FALSE","Y":"FALSE","K":"FALSE","MUTACIO":"FALSE","MUTSZIN":"0","FORDLEV":"0","CTP":"TRUE","KIFUT":"FALSE"}]
    			   $fields_array = dbf_fields_create($_GET["fields"]) ;
    			   $filter_array = dbf_filter_create($_GET["filter"]) ;
  				   $result = dbf_update_record($dbf_file, $fields_array, $filter_array) ;
  				   break ;
  }
  $result_serialized = serialize($result) ;
  echo $result_serialized ;
    

?>

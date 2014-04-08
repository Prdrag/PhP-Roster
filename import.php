<?php
      ini_set('display_errors', 1);
      error_reporting(E_ALL);

	// MYSQL Konfig
	  $tabelle = ""; 	// Name der Tabelle  
	  $dbname  = ""; 	// name der Datenbank
	  $dbuname = ""; 	// Datenbank Username
	  $dbpass  = ""; 	// Datenbank User Passwort
	  $dbhost  = ""; 	// Adresse der Datenbank
	  
      $guildname        = ''; //Gildenname
      $realmname        = ''; //Servername
      $guildfields      = 'members';      // Möglich sind: achievements, members
      $requestURL = 'http://eu.battle.net/api/wow/guild/'.rawurlencode($realmname).'/'.rawurlencode($guildname).'?fields='.$guildfields;
      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $requestURL);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $response = curl_exec($ch);
      curl_close($ch);
      $inhalt = json_decode($response, true);

	  // Verbindung zum MySQL Host aufbauen
	  $verbindung = mysql_connect($dbhost,$dbuname,$dbpass);
	  if (!$verbindung) {
			die('Verbindung zur Datenbank auf '.$dbhost.' schlug fehl: ' . mysql_error());
		}
	  //MySQL Datenbank öffnen
	  $opendb = mysql_select_db($dbname); 
	  if (!$opendb) {
			die('Die Datenbank '.$dbname.' konnte nicht geöffnet werden!');
		}	 	  
	  
	  
	  // Tabelle vor dem Import leeren - kann man auch auskommentieren, dann wird die Tabelle allerdings immer voller...
	  mysql_query("DROP TABLE ".$tabelle);	  
	  
	  // Tabelle anlegen, falls noch nicht vorhanden
	  mysql_query("
	  CREATE TABLE IF NOT EXISTS ".$tabelle." (
		  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  `name` varchar(255) NOT NULL,
		  `rank` int(2) NOT NULL,
		  `points` int NOT NULL,
		  `level` int(2) NOT NULL,
		  `race` int(2) NOT NULL,
		  `spec` varchar(255) NOT NULL,
		  `specimg` varchar(255) NOT NULL,
		  `tbnail` varchar(255) NOT NULL,
		  `klasse` int(1) NOT NULL,
		  `zeitstempel` datetime NOT NULL
		) COMMENT='' ENGINE='MyISAM'
	  ");
	  
	  // Hilfsfunktion um Sonderzeichen korrekt zu Interpretieren
	  function convutf8($var){
		return mb_convert_encoding($var, "ISO-8859-1" , "UTF-8");
	  }


	  // Alles einlesen und in DB Schreiben
      $i=0;
      foreach($inhalt['members'] as $member){

	  
            $name 		= $member['character']['name']; //Charaktername
			$rank 		= $member['rank']; //Rang des Charakters
            $points 	= $member['character']['achievementPoints']; // erklärt sich von selbst
            $tbnail		= $member['character']['thumbnail']; //Charakterbild
            @$spec 		= $member['character']['spec']['name'];  // Name der Spezializierung
            @$specimg 	= $member['character']['spec']['icon'];  // Icon der Spezializierung
            $race		= $member['character']['race']; // Rasse des Charakters
            $level		= $member['character']['level']; // Level
            $klasse 	= $member['character']['class'];   // class ist in einigen PHO Versionen reserviert, deshalb "klasse"


            $i++;

			// Felder der Tabelle			
			$fields = "`name`, `rank`, `points`, `tbnail`, `race`, `level`, `spec`, `specimg`, `klasse`, `zeitstempel`";
			$values = " '".mysql_escape_string(convutf8($name))."',
			'".mysql_escape_string($rank)."',
			'".mysql_escape_string($points)."',
			'".mysql_escape_string($tbnail)."',
			'".mysql_escape_string($race)."',
			'".mysql_escape_string($level)."',
			'".mysql_escape_string($spec)."',
			'".mysql_escape_string($specimg)."',
			'".mysql_escape_string($klasse)."', now()";
			// Der Befehl > mysql_escape_string() < filtert Böhses und escaped ', \ sowie " Zeichen selbstständig
			
			// Und jetzt alles Speichern ...
			mysql_query("INSERT INTO ".$tabelle." (".$fields.") VALUES (".$values.") ") or die("<h3>Oooops, Fehler:</h3>".mysql_error());

      }

echo "Es wurden ".$i." Datens&auml;tze importiert...";
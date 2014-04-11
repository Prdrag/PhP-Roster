<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

    // MYSQL Konfig
    $tabelle = "";        // Name der Tabelle  
    $dbname  = "";  // name der Datenbank
    $dbuname = "";   // Datenbank Username
    $dbpass  = "";          // Datenbank User Passwort
    $dbhost  = "";    // Adresse der Datenbank

	$guildname        = '';
	$realmname        = '';
	$guildfields      = '';      // Möglich sind: achievements, members
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
	  `prof1` varchar(255) NOT NULL,
	  `prof2` varchar(255) NOT NULL,
	  `rank` int(2) NOT NULL,
	  `points` int NOT NULL,
	  `level` int(2) NOT NULL,
	  `race` int(2) NOT NULL,
	  `spec` varchar(255) NOT NULL,
	  `specimg` varchar(255) NOT NULL,
	  `tbnail` varchar(255) NOT NULL,
	  `ailvl` int NOT NULL,
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
		
	    $name 		= $member['character']['name'];
	    $level		= $member['character']['level'];
	    $rank 		= $member['rank'];

	    if ($level == 90) {
	    	if ($rank == 0 or $rank == 1  or $rank == 3 or $rank == 4){
			    $charurl = 'http://eu.battle.net/api/wow/character/'.rawurlencode($realmname).'/'.rawurlencode($name).'?fields=items';
			    $profurl = 'http://eu.battle.net/api/wow/character/'.rawurlencode($realmname).'/'.rawurlencode($name).'?fields=professions';

				// build the individual requests as above, but do not execute them
				$ch_1 = curl_init($charurl);
				$ch_2 = curl_init($profurl);
				curl_setopt($ch_1, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch_2, CURLOPT_RETURNTRANSFER, true);

				// build the multi-curl handle, adding both $ch
				$mh = curl_multi_init();
				curl_multi_add_handle($mh, $ch_1);
				curl_multi_add_handle($mh, $ch_2);

				// execute all queries simultaneously, and continue when all are complete
				$running = null;
				do {
				curl_multi_exec($mh, $running);
				} while ($running);

				// all of our requests are done, we can now access the results
				$response_1 = curl_multi_getcontent($ch_1);
				$response_2 = curl_multi_getcontent($ch_2);
				$char = json_decode($response_1, true);
				$prof = json_decode($response_2, true);
	
			    @$ailvl 	= $char['items']['averageItemLevel'];
				@$prof1		= $prof['professions']['primary']['0']['name'];
				@$prof2		= $prof['professions']['primary']['1']['name'];
			    $points 	= $member['character']['achievementPoints'];
			    $tbnail		= $member['character']['thumbnail'];
			    @$spec 		= $member['character']['spec']['name']; 
			    @$specimg 	= $member['character']['spec']['icon'];  
			    $race		= $member['character']['race'];
			    $klasse 	= $member['character']['class'];   // class ist in einigen PHO Versionen reserviert, deshalb "klasse"

			    echo ("<pre>");
				print_r($name);
				echo ("</br><ul><li>klasse:");
				print_r($klasse);
				echo ("</li></br><li>ilvl:");
				print_r($ailvl);
				echo ("</li></br><li>Beruf1:");
				print_r($prof1);
				echo ("</li></br><li>Beruf2:");
				print_r($prof2);
				echo ("</li><ul></pre>");

			    $i++;

				// Felder der Tabelle			
				$fields = "`name`, `rank`, `points`, `tbnail`, `race`, `ailvl`, `level`, `prof1`,  `prof2`, `spec`, `specimg`, `klasse`, `zeitstempel`";
				$values = " '".mysql_escape_string(convutf8($name))."',
				'".mysql_escape_string($rank)."',
				'".mysql_escape_string($points)."',
				'".mysql_escape_string($tbnail)."',
				'".mysql_escape_string($race)."',
				'".mysql_escape_string($ailvl)."',
				'".mysql_escape_string($level)."',
				'".mysql_escape_string($prof1)."',
				'".mysql_escape_string($prof2)."',
				'".mysql_escape_string($spec)."',
				'".mysql_escape_string($specimg)."',
				'".mysql_escape_string($klasse)."', now()";
				// Der Befehl > mysql_escape_string() < filtert Böhses und escaped ', \ sowie " Zeichen selbstständig
				
				// Und jetzt alles Speichern ...
				mysql_query("INSERT INTO ".$tabelle." (".$fields.") VALUES (".$values.") ") or die("<h3>Oooops, Fehler:</h3>".mysql_error());
			}
		}
	}

	echo "Es wurden ".$i." Datens&auml;tze importiert...";
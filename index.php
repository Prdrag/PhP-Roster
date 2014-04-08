<?php 

	// MYSQL Konfig
	  $tabelle = ""; 	// Name der Tabelle  
	  $dbname  = ""; 	// name der Datenbank
	  $dbuname = ""; 	// Datenbank Username
	  $dbpass  = ""; 	// Datenbank User Passwort
	  $dbhost  = ""; 	// Adresse der Datenbank
	  
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
	  
		// Hier werden die Klassennummern der Api durch Namen ersetzt
		function id2class($id){ 
			if($id == 1)$val = "Krieger";
			if($id == 2)$val = "Paladin";
			if($id == 3)$val = "Jäger";
			if($id == 4)$val = "Schurke";
			if($id == 5)$val = "Priester";
			if($id == 6)$val = "Todesritter";
			if($id == 7)$val = "Schamane";
			if($id == 8)$val = "Magier";
			if($id == 9)$val = "Hexenmeister";
			if($id == 10)$val = "Mönch";
			if($id == 11)$val = "Druide";
			return $val;
		}
		//Hier werden die Ränge durch Namen ersetzt
		function id2rank($id){
			if($id == 0)$val = "Gildenmeister";
			if($id == 1)$val = "Offizier";
			if($id == 2)$val = "Offizier";
			if($id == 3)$val = "Member";
			if($id == 4)$val = "Trial";
			return $val;
		}
			
		// Hilfsfunktion um Sonderzeichen korrekt zu Interpretieren
		function convutf8($var){
		return mb_convert_encoding($var, "UTF-8", "ISO-8859-1");
		}

		function ausgabe($where)
		{
			GLOBAL $tabelle;
			// Ausgabe Konfig für die SQL Abfrage
			$max = 300;  					// Max Anzahl anzeigen
			$order = "order by klasse, rank "; 	// Nach Rang sortieren
			$groupby = "  ";  				// Optional z.B. "group by rank", dann wird jeder Rank nur mit einem Namen belegt
			$sql = "SELECT * FROM ".$tabelle." ".$where." ".$groupby." ".$order." LIMIT ".$max; 
				#echo $sql;		
				$val = '';
				$resultX = mysql_query($sql);
					  while ($row = mysql_fetch_object($resultX))
						{
						
						if($row->klasse != $oldklasse)
							$val .= '<tr><th colspan=2>'.id2class($row->klasse).'</th></tr>';
						
						$val .= '
								<tr>								
									<td valign=top>
										<div class="char">
										<div class="level">'.$row->level.'</div><div class="name"><b><a href ="http://eu.battle.net/wow/de/character/blackmoore/'.convutf8($row->name).'/advanced">'.convutf8($row->name).'</a>&nbsp;&nbsp;&nbsp;&nbsp;</b></div><div class="points"><img src="http://eu.battle.net/wow/static/images/icons/achievements.gif" alt=""> </img>'.$row->points.'</div>					
										<div class="specimg"><img src="http://media.blizzard.com/wow/icons/36/'.$row->specimg.'.jpg"><img></div><div class="spec">'.$row->spec.'</div><div class="rank">'.id2rank($row->rank).'</div>
										</div>
										<div class="img-polaroid"><img src="http://eu.battle.net/static-render/eu/'.$row->tbnail.'"></img></div>
									</td>
								</tr>
						';
						
						$oldklasse = $row->klasse;
						
						}
			return $val;
		} // Ende Ausgabefunktion
// Ausgabe
echo '
<!DOCTYPE html>
<html lang="de">
  <head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/style.css" type="text/css"/>	
</head>
';

echo '<div class="container">';
echo '<div class="row-fluid">';

echo '<div class="span3 krieger"><table class="table table-striped">';
echo ausgabe(" WHERE klasse = 1 AND (rank = 0 or rank = 1  or rank = 3 or rank = 4) ");
echo '</table></div>';

echo '<div class="span3 Paladin"><table class="table table-striped">';
echo ausgabe(" WHERE klasse = 2 AND (rank = 0 or rank = 1  or rank = 3 or rank = 4) ");
echo '</table></div>';

echo '<div class="span3 Priester"><table class="table table-striped">';
echo ausgabe(" WHERE klasse = 5 AND (rank = 0 or rank = 1  or rank = 3 or rank = 4) ");
echo '</table></div>';
						
echo '<div class="span3 Jaeger"><table class="table table-striped">';
echo ausgabe(" WHERE klasse = 3 AND (rank = 0 or rank = 1  or rank = 3 or rank = 4) ");
echo '</table></div>';

echo '<div class="span3 Schurke"><table class="table table-striped ">';
echo ausgabe(" WHERE klasse = 4 AND (rank = 0 or rank = 1  or rank = 3 or rank = 4) ");
echo '</table></div>';

echo '<div class="span3 Todesritter"><table class="table table-striped">';
echo ausgabe(" WHERE klasse = 6 AND (rank = 0 or rank = 1  or rank = 3 or rank = 4) ");
echo '</table></div>';

echo '<div class="span3 Schamane"><table class="table table-striped">';
echo ausgabe(" WHERE klasse = 7 AND (rank = 0 or rank = 1  or rank = 3 or rank = 4) ");
echo '</table></div>';

echo '<div class="span3 Druide"><table class="table table-striped">';
echo ausgabe(" WHERE klasse = 11 AND (rank = 0 or rank = 1  or rank = 3 or rank = 4) ");
echo '</table></div>';

echo '<div class="span3 Hexenmeister"><table class="table table-striped">';
echo ausgabe(" WHERE klasse = 9 AND (rank = 0 or rank = 1  or rank = 3 or rank = 4) ");
echo '</table></div>';

echo '<div class="span3 Moench"><table class="table table-striped">';
echo ausgabe(" WHERE klasse = 10 AND (rank = 0 or rank = 1  or rank = 3 or rank = 4) ");
echo '</table></div>';

echo '<div class="span3 Magier"><table class="table table-striped">';
echo ausgabe(" WHERE klasse = 8 AND (rank = 0 or rank = 1  or rank = 3 or rank = 4) ");
echo '</table></div>';

echo '</div>';		
echo '</div>';		
?>
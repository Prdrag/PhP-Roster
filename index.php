<?php 
    // MYSQL Konfig
    $tabelle = "";        // Name der Tabelle  
    $dbname  = "";  // name der Datenbank
    $dbuname = "";   // Datenbank Username
    $dbpass  = "";          // Datenbank User Passwort
    $dbhost  = "";    // Adresse der Datenbank
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
      
    function id2class($id){
        if($id == 1)$val = "<img class='topimg' src='img/krieger.jpg'>Krieger";
        if($id == 2)$val = "<img class='topimg' src='img/paladin.jpg'>Paladin";
        if($id == 3)$val = "<img class='topimg' src='img/jager.jpg'>Jäger";
        if($id == 4)$val = "<img class='topimg' src='img/schurke.jpg'>Schurke";
        if($id == 5)$val = "<img class='topimg' src='img/priester.jpg'>Priester";
        if($id == 6)$val = "<img class='topimg' src='img/todesritter.jpg'>Todesritter";
        if($id == 7)$val = "<img class='topimg' src='img/schamane.jpg'>Schamane";
        if($id == 8)$val = "<img class='topimg' src='img/magier.jpg'>Magier";
        if($id == 9)$val = "<img class='topimg' src='img/hexenmeister.jpg'>Hexenmeister";
        if($id == 10)$val = "<img class='topimg' src='img/monk.jpg'>Mönch";
        if($id == 11)$val = "<img class='topimg' src='img/druide.jpg'>Druide";
        return $val;
    }

    function id2rank($id){
        if($id == 0)$val = "<span style='color:#cf3a2a'>Gildenmeister</span>";
        if($id == 1)$val = "<span style='color:#cf3a2a'>Offizier</span>";
        if($id == 2)$val = "<span style='color:#cf3a2a'>Offizier</span>";
        if($id == 3)$val = "<span style='color:#4783ad'>Member</span>";
        if($id == 4)$val = "<span style='color:#dde191'>Trial</span>";
        return $val;
    }

    function id2race($id){
        if($id == 6)$val = "Taure"; //Taure
        if($id == 5)$val = "Untoter"; //Untoter
        if($id == 2)$val = "Orc"; //Orc
        if($id == 9)$val = "Goblin"; //Goblin
        if($id == 8)$val = "Troll"; //Troll
        if($id == 26)$val = "Pandaren"; //Pandaren
        if($id == 10)$val = "Blutelf"; //Blutelf
        return $val;
    }

    function id2iprof($id){
        if($id == 'Jewelcrafting')$val = "<img src='http://media.blizzard.com/wow/icons/18/inv_misc_gem_01.jpg'></img>"; 
        if($id == 'Blacksmithing')$val = "<img src='http://media.blizzard.com/wow/icons/18/trade_blacksmithing.jpg'></img>"; 
        if($id == 'Tailoring')$val = "<img src='http://media.blizzard.com/wow/icons/18/trade_tailoring.jpg'></img>"; 
        if($id == 'Enchanting')$val = "<img src='http://media.blizzard.com/wow/icons/18/trade_engraving.jpg'></img>"; 
        if($id == 'Alchemy')$val = "<img src='http://media.blizzard.com/wow/icons/18/trade_alchemy.jpg'></img>"; 
        if($id == 'Leatherworking')$val = "<img src='http://media.blizzard.com/wow/icons/18/trade_leatherworking.jpg'></img>"; 
        if($id == 'Inscription')$val = "<img src='http://media.blizzard.com/wow/icons/18/inv_inscription_tradeskill01.jpg'></img>"; 
        if($id == 'Engineering')$val = "<img src='http://media.blizzard.com/wow/icons/18/trade_engineering.jpg'></img>";
        if($id == 'Herbalism')$val = "<img src='http://media.blizzard.com/wow/icons/18/trade_herbalism.jpg'></img>"; 

        return $val;
    }

    function id2iprof2($id){
        if($id == 'Jewelcrafting')$val = "<img src='http://media.blizzard.com/wow/icons/18/inv_misc_gem_01.jpg'></img>"; 
        if($id == 'Blacksmithing')$val = "<img src='http://media.blizzard.com/wow/icons/18/trade_blacksmithing.jpg'></img>"; 
        if($id == 'Tailoring')$val = "<img src='http://media.blizzard.com/wow/icons/18/trade_tailoring.jpg'></img>"; 
        if($id == 'Enchanting')$val = "<img src='http://media.blizzard.com/wow/icons/18/trade_engraving.jpg'></img>"; 
        if($id == 'Alchemy')$val = "<img src='http://media.blizzard.com/wow/icons/18/trade_alchemy.jpg'></img>"; 
        if($id == 'Leatherworking')$val = "<img src='http://media.blizzard.com/wow/icons/18/trade_leatherworking.jpg'></img>"; 
        if($id == 'Inscription')$val = "<img src='http://media.blizzard.com/wow/icons/18/inv_inscription_tradeskill01.jpg'></img>"; 
        if($id == 'Engineering')$val = "<img src='http://media.blizzard.com/wow/icons/18/trade_engineering.jpg'></img>"; 
        if($id == 'Herbalism')$val = "<img src='http://media.blizzard.com/wow/icons/18/trade_herbalism.jpg'></img>"; 

        return $val;
    }

    function id2ilvl($id){
        if($id >= 577)$val = "<span style='color:#00A528'>".$id."</span>"; 
        if($id < 577 and $id > 570)$val = "<span style='color:#dde191'>".$id."</span>"; 
        if($id < 570)$val = "<span style='color:#cf3a2a'>".$id."</span>"; 
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
        $max = 300;                     // Max Anzahl anzeigen
        $order = "order by klasse, rank ";  // Nach Rang sortieren
        $groupby = "  ";                // Optional z.B. "group by rank", dann wird jeder Rank nur mit einem Namen belegt
        $sql = "SELECT * FROM ".$tabelle." ".$where." ".$groupby." ".$order." LIMIT ".$max; 
            #echo $sql;     
            $val = '';
            $resultX = mysql_query($sql);
                  while ($row = mysql_fetch_object($resultX))
                    {
                    
                    if($row->klasse != $oldklasse)
                        $val .= '<tr><th colspan=2>'.id2class($row->klasse).'</th></tr><th class ="td-header">
                                <div class="char">
                                    <div class="img-polaroid2"></div>
                                    <div class="specimg2"></div>
                                    <div class="level">Level</div>
                                    <div class="name2">Name</div>
                                    <div class="rank">Rank</div>
                                    <div class="prof2">Berufe</div>
                                    <div class="race">Rasse</div>
                                    <div class="race">iLvL</div>
                                    <div class="points">Points</div>
                                </div>
                                </th>';
                    
                    $val .= '
                            <tr>                                
                                <td valign=top>
                                    <div class="char">
                                    <div class="img-polaroid"><img src="http://eu.battle.net/static-render/eu/'.$row->tbnail.'"></img></div>
                                    <div class="specimg"><img src="http://media.blizzard.com/wow/icons/36/'.$row->specimg.'.jpg"><img></div>
                                    <div class="level">'.$row->level.'</div>
                                    <div class="name"><a href ="http://eu.battle.net/wow/de/character/blackmoore/'.convutf8($row->name).'/advanced">'.convutf8($row->name).'</a></div>
                                    <div class="rank">'.id2rank($row->rank).'</div>
                                    <div class="prof3">
                                    <div class="prof">'.id2iprof($row->prof1).'</div>
                                    <div class="prof">'.id2iprof2($row->prof2).'</div>
                                    </div>
                                    <div class="race">'.id2race($row->race).'</div><div class="race">'.id2ilvl($row->ailvl).'</div>
                                    <div class="points"><img src="http://eu.battle.net/wow/static/images/icons/achievements.gif" alt=""> </img>'.$row->points.'</div>
                                    </div>
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

    echo '<div class="span3 krieger"></img><table class="table table-striped">';

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

    // echo '<hr>';


    // echo '<div class=span3><table class="table table-striped">';
    // echo ausgabe(" WHERE klasse = 6 AND (rank = 0 or rank = 1 or rank = 3 or rank = 4) OR klasse = 5 AND (rank = 0 or rank = 1 or rank = 3 or rank = 4)  ");
    // echo '</table></div>';


    echo '</div>';      
    echo '</div>';      
?>
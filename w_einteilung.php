<?php

require_once 'HTMLB.php';
require_once 'Event.php';

session_start();
$pdo = new PDO('mysql:host=fbi-mysqllehre.th-brandenburg.de;dbname=kosts_db', 'kosts', '20192019');
$pdo->exec("set names utf8");


/*
if(!isset($_SESSION['userid'])) {
    exit('Bitte zuerst <a href="index.php">einloggen</a>');
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

echo "Hallo User: ".$userid;
echo '<br><a href="logout.php">Logout</a>';
*/

$statement = $pdo->prepare("SELECT nachname, vorname, id FROM mitarbeiter ORDER BY nachname");
$result = $statement->execute();
$mitarbeiter = $statement->fetchAll();

// print_r($mitarbeiter);

echo '<br><br>';


$showPage = true;

// EVENT hinzufügen Button Aktion definieren

if(isset($_GET['newEvent'])) {

    print_r($_POST);


    $error = false;
    $eventName = $_POST['eventName'];
    $mitarbeiterID = $_POST['mitarbeiterID'];
    $datum = $_POST['datum'];

    if (empty($eventName)){
        echo 'Bitte einen Eventnamen eingeben!<br>';
        $error = true;
    }

    if (empty($datum)){
        echo 'Bitte ein Datum eingeben!<br>';
        $error = true;
    }

    //Keine Fehler, das Event kann in die Datenbank aufgenommen werden

    if (!$error) {


        $statement = $pdo->prepare("INSERT INTO event (eventname, datum) VALUES (:eventname, :datum)");
        $result = $statement->execute(array('eventname' => $eventName, 'datum' => $datum));

        if ($result) {
            echo 'Event wurde erfolgreich registriert.';
           // $showPage = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }


        // Gerade angelegter Eventeintrag hat maximalen Schlüssel durch AutoIncrement
        $statement = $pdo->prepare("SELECT * FROM event WHERE eventid = ( SELECT MAX(eventid) FROM event )");
        $result = $statement->execute();
        $eventMax = $statement->fetch();
        echo '<br><br>' . $eventMax['eventid'];


        // Event Mitarbeiter zuordnen
        $statement = $pdo->prepare("INSERT INTO hasEvent (userid, eventid) VALUES (:userid, :eventid)");
        $result = $statement->execute(array('userid' => $mitarbeiterID, 'eventid' => $eventMax['eventid']));

        if ($result) {
            echo 'Event wurde erfolgreich dem Mitarbeiter zugeordnet (hasEvent).';
            // $showPage = false;
        } else {
            echo 'Zuordnung des Events zum Mitarbeiter fehlgeschlagen.' .'<br>';
        }

    }



// Abfrage alle Events und zugehörige Mitarbeiter:
// SELECT datum, nachname, vorname, eventname FROM mitarbeiter ma JOIN hasEvent hE ON hE.userid = ma.id JOIN event ev ON ev.eventid = hE.eventid

}


// Hauptprogramm


writeHeader();

if ($showPage) {
    HTMLB::writeHeadline("Wocheneinteilung");

    HTMLB::addLinkButton("Ausloggen", "logoutButton", "logout.php");

    HTMLB::startForm("post", "?newEvent=1");

    HTMLB::openselectElement("mitarbeiterID");

    for ($i=0; $i<count($mitarbeiter); $i++) {
        $selectText = $mitarbeiter[$i]['nachname'] . ", " . $mitarbeiter[$i]['vorname'];
        $selectID = $mitarbeiter[$i]['id'];
        HTMLB::fillselectElement("$selectID","$selectText");
    }

    HTMLB::closeselectElement();

    HTMLB::writeInputField("Event-Name", "eventName", "text");
    HTMLB::writeInputField("Datum", "datum", "date");
    HTMLB::closeForm("Event hinzufügen");

    HTMLB::responsiveTable($mitarbeiter, '2020-12-17', '2020-12-31');
}

HTMLB::writeFooter();










/*
 * spezieller HTML-Header für responsive Tabelle
 */

function writeHeader()
{
    echo "<!DOCTYPE html>
          <html lang=\"de\">
            <head><title>Wocheneinteilung</title>
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
                <style>
                    table {
                        border-collapse: collapse;
                        border-spacing: 0;
                        width: 100%;
                        border: 1px solid #ddd;
                    }
            
                    th, td {
                        text-align: left;
                        padding: 8px;
                    }
            
                    tr:nth-child(even){background-color: #f2f2f2}
                </style>
            </head>
            <body>";
}



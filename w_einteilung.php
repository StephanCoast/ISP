<?php

require_once 'HTMLB.php';
require_once 'Event.php';

session_start();
$pdo = new PDO('mysql:host=fbi-mysqllehre.th-brandenburg.de;dbname=kosts_db', 'kosts', '20192019');


/*
if(!isset($_SESSION['userid'])) {
    exit('Bitte zuerst <a href="index.php">einloggen</a>');
}



//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

echo "Hallo User: ".$userid;
echo '<br><a href="logout.php">Logout</a>';
*/

$showFormular = true;

if(isset($_GET['newEvent'])) {


}


// Hauptprogramm


HTMLB::writeHeader();

if ($showFormular) {
    HTMLB::writeHeadline("Wocheneinteilungen");
    HTMLB::startForm("post", "?newEvent=1");


    $statement = $pdo->prepare("SELECT vorname, nachname FROM mitarbeiter");
    $result = $statement->execute();
    $mitarbeiter = $statement->fetch();

    print_r($mitarbeiter);

    HTMLB::openselectElement("mitarbeiter");


    HTMLB::fillselectElement("peterkraus","Peter Kraus");


    HTMLB::closeselectElement();

    HTMLB::writeInputField("Event-Name", "eventName", "text");
    HTMLB::writeInputField("Datum", "datum", "date");
    HTMLB::closeForm("Event hinzufügen");
}

HTMLB::writeFooter();




/*
$aktDatum = date("d.m.Y");

$Event1 = new Event("Grillen", $aktDatum);

echo "Das Object " . $Event1->getEventName() . " mit dem Datum " . $Event1->getDatum() . " wurde erstellt!";

*/





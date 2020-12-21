<?php

require_once __DIR__.DIRECTORY_SEPARATOR.'HTMLB.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'DataRepository.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'DataModel.php';

/**
 * Login User
 * Dateiname: index.php
 * @author Stephan Kost
 * @date 29.11.2020
 */

//Beginn bei start, wenn index.php erstmalig aufgerufen wird.
if (!ISSET($_GET['page']))
$_GET['page'] = "start";

//Session starten
session_start();

//Datenbankverbindung aufbauen
try {
    $pdo = new PDO('mysql:host=fbi-mysqllehre.th-brandenburg.de; charset=utf8; dbname=kosts_db', 'kosts', '20192019');
    $pdo->exec("set names utf8");

} catch (Exception $e) {
    echo "Verbindung zur Datenbank funktioniert nicht";
    exit;
}
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


// Abgleich Zugangsdaten mit Datenbank
if($_GET['page'] == "login" && ISSET($_POST['email']) && ISSET($_POST['passwort'])) {
    $error = false;
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];


    $statement = $pdo->prepare("SELECT * FROM mitarbeiter WHERE email = :email");
    $result = $statement->execute(array('email' => $email));  // :email in prepare statement auflösen
    $user = $statement->fetch();

   // print_r($user);

    if ($user !== false && password_verify($passwort, $user['passwort'])) {

        $_SESSION['userid'] = $user['id'];
        $_SESSION['username'] = $user['vorname'];
        $_GET['page'] = "w_einteilung";
     //   header("Location: index.php");
     //   exit();

    } else {
        $fehlermeldung = "E-Mail oder Passwort ungültig!";
    }
}



// EVENT zur Datenbank hinzufügen - Prüfen ob Event schon vorhanden!

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






// Beginn des Hauptprogramms
$HTMLbuild = new HTMLB;

$HTMLbuild->writeHeader();
$HTMLbuild->writeHeadline("Wocheneinteilung");


// LOGIN-FORMULAR
if ($_GET['page'] == "start") {

    $HTMLbuild->startForm("post", "?page=login");
    $HTMLbuild->writeInputField("E-Mail", "email", "email");
    $HTMLbuild->writeInputField("Passwort", "passwort", "password");
    $HTMLbuild->closeForm("Einloggen");
}


// WOCHENEINTEILUNG NACH LOGIN
if ($_GET['page'] == "w_einteilung") {


    if(!isset($_SESSION['userid'])) {
        exit('Bitte zuerst <a href="index.php">einloggen</a>');
    }

    //Abfrage der Nutzername vom Login
    $username = $_SESSION['username'];
    echo "Hallo ".$username . "!";
    $HTMLbuild->addLinkButton("Ausloggen", "logoutButton", "logout.php");


    // HTML-Seitenaufbau

    $HTMLbuild->startForm("post", "?newEvent=1");

    // Mitarbeiter aus Datenbank abrufen für Select-Element
    $statement = $pdo->prepare("SELECT nachname, vorname, id FROM mitarbeiter ORDER BY nachname");
    $result = $statement->execute();
    $mitarbeiter = $statement->fetchAll();

    // print_r($mitarbeiter);

    $HTMLbuild->openselectElement("mitarbeiterID");
    for ($i=0; $i<count($mitarbeiter); $i++) {
        $selectText = $mitarbeiter[$i]['nachname'] . ", " . $mitarbeiter[$i]['vorname'];
        $selectID = $mitarbeiter[$i]['id'];
        $HTMLbuild->fillselectElement("$selectID","$selectText");
    }
    $HTMLbuild->closeselectElement();

    $HTMLbuild->writeInputField("Event-Name", "eventName", "text");
    $HTMLbuild->writeInputField("Datum", "datum", "date");
    $HTMLbuild->closeForm("Event hinzufügen");

    $HTMLbuild->responsiveTable($mitarbeiter, '2020-12-17', '2020-12-31');
}

if  (isset($fehlermeldung)) {
    echo $fehlermeldung;
}


$HTMLbuild->writeFooter();
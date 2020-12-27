<?php

require_once __DIR__.DIRECTORY_SEPARATOR.'HTMLB.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'DataRepository.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'EventModel.php';

/**
 * Login User
 * Dateiname: index.php
 * @author Stephan Kost
 * @date 29.11.2020
 */

//Beginn bei start, wenn index.php erstmalig aufgerufen wird.
if (!ISSET($_GET['page'])) {
    $_GET['page'] = "start";
}

//Session starten
session_start();


//if (!ISSET($pdo) && $_GET['page'] !== 'start') {

 //   echo '<script>console.log(\'Datenbankverbindung wird aufgebaut!\')</script>';
    //Datenbankverbindung aufbauen
    try {
        $pdo = new PDO('mysql:host=fbi-mysqllehre.th-brandenburg.de; charset=utf8; dbname=kosts_db', 'kosts', '20192019');
        $pdo->exec("set names utf8");

    } catch (Exception $e) {
        echo "Verbindung zur Datenbank funktioniert nicht";
        exit;
    }
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

// Objekt der Klasse DataRepository anlegen, PDO-Objekt übergeben
    $DataRepository = new DataRepository($pdo);

//}


if ($_GET['page'] === 'restart') {
    session_destroy();
    $_GET['page'] = 'start';
}


// Abgleich Zugangsdaten mit Datenbank
if($_GET['page'] == "login" && ISSET($_POST['email']) && ISSET($_POST['passwort'])) {

    $error = false;
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];

    $user = $DataRepository->fetchLoginData($email);

   // print_r($user);

    if ($user !== false && password_verify($passwort, $user['passwort'])) {

        $_SESSION['userid'] = $user['id'];
        $_SESSION['username'] = $user['vorname'];
        $_GET['page'] = "w_einteilung";
     //   header("Location: index.php");
     //   exit();

    } else {
        echo "E-Mail oder Passwort ungültig!";
        $_GET['page'] = "start";
    }
}



// EVENT zur Datenbank hinzufügen - Prüfen ob Event schon vorhanden!

if(isset($_GET['newEvent'])) {

  //  print_r($_POST);

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
      //  echo '<br><br>' . $eventMax['eventid'];


        // Event Mitarbeiter zuordnen
        $statement = $pdo->prepare("INSERT INTO hasEvent (userid, eventid) VALUES (:userid, :eventid)");
        $result = $statement->execute(array('userid' => $mitarbeiterID, 'eventid' => $eventMax['eventid']));

        if ($result) {
           // echo 'Event wurde erfolgreich dem Mitarbeiter zugeordnet (hasEvent).';
            $_GET['page'] = "w_einteilung";
        } else {
            echo 'Zuordnung des Events zum Mitarbeiter fehlgeschlagen.' .'<br>';
        }

    }




}



/*
// AJAX-GETREQUEST alle Events und zugehörige Mitarbeiter:
// SELECT datum, nachname, vorname, eventname FROM mitarbeiter ma JOIN hasEvent hE ON hE.userid = ma.id JOIN event ev ON ev.eventid = hE.eventid
if (ISSET($_GET['data'])) {
    $events = $DataRepository->fetchEventData();
    echo json_encode(array($events));

}
*/



// Beginn des Hauptprogramms

// Objekt von Klasse HTMLB erstellen
if (!ISSET($HTMLbuild)) {
    $HTMLbuild = new HTMLB;
}

$HTMLbuild->writeHeader();
$HTMLbuild->writeHeadline("Wocheneinteilung");

// LOGIN-FORMULAR
if ($_GET['page'] == "start") {

    $HTMLbuild->startForm("post", "?page=login");
    $HTMLbuild->writeInputField("E-Mail", "email", "email");
    $HTMLbuild->writeInputField("Passwort", "passwort", "password");
    $HTMLbuild->closeForm("Einloggen");
    echo "<br>";
    echo "<a href=\"register.php\">Registrieren</a>";

}

// WOCHENEINTEILUNG NACH LOGIN
if ($_GET['page'] === "w_einteilung") {

    if(!isset($_SESSION['userid'])) {
        exit('Bitte zuerst <a href="index.php">einloggen</a>');
    }

    //Abfrage der Nutzername vom Login
    $username = $_SESSION['username'];
    echo "Hallo ".$username . "!";
    $HTMLbuild->addLinkButton("Ausloggen", "logoutButton", "index.php?page=restart");

    $HTMLbuild->startForm("POST", "?page=w_einteilung");
    $HTMLbuild->writeInputField("Von", "von", "date");
    $HTMLbuild->writeInputField("Bis", "bis", "date");
    $HTMLbuild->closeForm("Zeitraum ändern");

    // HTML-Seitenaufbau

    // Tabelle Wocheneinteilungen

    // Mitarbeiterliste aus Datenbank abrufen für Select-Element
    $mitarbeiter = $DataRepository->getMitarbeiter();
    // print_r($mitarbeiter);


    if (!ISSET($_POST['von']) && !ISSET($_POST['bis'])) {
        $_POST['von'] = date('Y-m-d');
        $_POST['bis'] = date('Y-m-d', strtotime("+1 week"));
    }
    //JAHRESWECHSEL BEACHTEN!!

    $HTMLbuild->responsiveTable($mitarbeiter, $_POST['von'], $_POST['bis']);

    $HTMLbuild->startForm("post", "?newEvent=1");

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

    // Alle Events abrufen und in hidden HTML div schreiben
    $events = json_encode($DataRepository->fetchEventData(),JSON_UNESCAPED_UNICODE);
    $HTMLbuild->echoEventsJSON($events);
    // EVENTS mittels Javascript in vorgefertigte Tabelle einfügen
    $HTMLbuild->writeJavascript();
}

$HTMLbuild->writeFooter();
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
if (!ISSET($_GET['page'])) {
    $_GET['page'] = "start";
}

//Session starten
session_start();


//Datenbankverbindung mit PDO aufbauen
try {
    $pdo = new PDO('mysql:host=fbi-mysqllehre.th-brandenburg.de; charset=utf8; dbname=kosts_db', 'kosts', '20192019');
    $pdo->exec("set names utf8");
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (Exception $e) {
    echo "Verbindung zur Datenbank funktioniert nicht";
    exit;
}

// Objekt der Klasse DataRepository anlegen, PDO-Objekt übergeben
$DataRepository = new DataRepository($pdo);


// Objekt von Klasse HTMLB erstellen
if (!ISSET($HTMLbuild)) {
    $HTMLbuild = new HTMLB;
}


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


if(isset($_GET['replace'])) {

    $DataRepository->deleteEvent($_SESSION['overlapEventId']);
    $DataRepository->addEvent($_SESSION['eventname'], $_SESSION['datum'], $_SESSION['userid']);
    $_GET['page'] = "w_einteilung";

}


// EVENT zur Datenbank hinzufügen - Prüfen ob Event schon vorhanden!

if(isset($_GET['newEvent'])) {

  //  print_r($_POST);

    $error = false;

    if (empty($_POST['eventname'])){
        echo 'Bitte einen gültigen Eventnamen eingeben (max. 30 Zeichen)!<br>';
        $error = true;
    }

    if (empty($_POST['datum'])){
        echo 'Bitte ein Datum eingeben!<br>';
        $error = true;
    }

    if (!$error) {

        $_SESSION['eventname'] = $_POST['eventname'];
        $_SESSION['userid'] = $_POST['mitarbeiterID'];
        $_SESSION['datum'] = $_POST['datum'];

        $hasEvent = $DataRepository->gethasEvent();

        for ($i = 0; $i < count($hasEvent); $i++) {

            if ($hasEvent[$i]['datum'] == $_SESSION['datum'] && $hasEvent[$i]['userid'] == $_SESSION['userid']) {

                $_SESSION['overlapEventId'] = $hasEvent[$i]['eventid'];

                $HTMLbuild->startForm("POST", "?replace=1");
                echo 'Das Event überschneidet sich mit einem vorhandenen Event! Vorhandenes Event ersetzen?<br>';
                $HTMLbuild->closeForm("Ja");
                $HTMLbuild->addLinkButton("Nein", "nein", "?page=w_einteilung");

                $error = true;
            }
        }
    }

    //Keine Fehler, das Event kann in die Datenbank (event & hasEvent) eingetragen werden
    if (!$error) {
    $DataRepository->addEvent($_SESSION['eventname'], $_SESSION['datum'], $_SESSION['userid']);
    }

    //Stay with HTML w_einteilung
    $_GET['page'] = "w_einteilung";

}





// Beginn des HTML-Aufbau

$HTMLbuild->writeHeader();
$HTMLbuild->writeHeadline("Eventkalender");

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

    if (!isset($_SESSION['userid'])) {
        exit('Bitte zuerst <a href="index.php">einloggen</a>');
    }
    //Abfrage der Nutzername vom Login
    $username = $_SESSION['username'];
    echo "Hallo " . $username . "!";
    $HTMLbuild->addLinkButton("Ausloggen", "logoutButton", "index.php?page=restart");


    // Aktuelle Tabellenansicht aufrechterhalten & Von-Bis-Felder prüfen ob leer
    if (isset($_POST['von'])) {
        if ($_POST['von'] > 0)
            $_SESSION['von'] = $_POST['von'];
    }
    if (isset($_POST['bis'])) {
        if ($_POST['bis'] > 0)
            $_SESSION['bis'] = $_POST['bis'];
    }

    //Standardbereich heute +1 Woche zu Beginn festlegen
    if (!ISSET($_SESSION['von']) && !ISSET($_SESSION['bis'])) {
        $_SESSION['von'] = date('Y-m-d');
        $_SESSION['bis'] = date('Y-m-d', strtotime("+1 week"));
    }


    // Wenn Von > Bis, dann Tausch der Werte
    if (strtotime($_SESSION['von']) > strtotime($_SESSION['bis'])) {
        $temp = $_SESSION['von'];
        $_SESSION['von'] = $_SESSION['bis'];
        $_SESSION['bis'] = $temp;
    }


    $HTMLbuild->startForm("POST", "?page=w_einteilung");
    $HTMLbuild->writePredefinedInputField("Von", "von", "date", $_SESSION['von']);
    $HTMLbuild->writePredefinedInputField("Bis", "bis", "date", $_SESSION['bis']);
    $HTMLbuild->closeForm("Zeitraum ändern");

    // HTML-Seitenaufbau

    // Tabelle Wocheneinteilungen

    // Mitarbeiterliste aus Datenbank abrufen für Select-Element
    $mitarbeiter = $DataRepository->getMitarbeiter();
    // print_r($mitarbeiter);

    $HTMLbuild->responsiveTable($mitarbeiter, $_SESSION['von'], $_SESSION['bis']);

    $HTMLbuild->startForm("post", "?newEvent=1");

    $HTMLbuild->openselectElement("mitarbeiterID");
    for ($i=0; $i<count($mitarbeiter); $i++) {
        $selectText = $mitarbeiter[$i]['nachname'] . ", " . $mitarbeiter[$i]['vorname'];
        $selectID = $mitarbeiter[$i]['id'];
        $HTMLbuild->fillselectElement("$selectID","$selectText");
    }
    $HTMLbuild->closeselectElement();

    $HTMLbuild->writeInputField("Eventname", "eventname", "text");
    $HTMLbuild->writeInputField("Datum", "datum", "date");
    $HTMLbuild->closeForm("Event hinzufügen");

    // Alle Events abrufen und in hidden HTML div schreiben
    $events = json_encode($DataRepository->fetchEventData($_SESSION['von'], $_SESSION['bis']),JSON_UNESCAPED_UNICODE);
    $HTMLbuild->echoEventsJSON($events);
    // EVENTS mittels Javascript in vorgefertigte Tabelle einfügen
    $HTMLbuild->writeJavascript();
}

$HTMLbuild->writeFooter();
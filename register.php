<?php

require_once 'HTMLB.php';

session_start();
$pdo = new PDO('mysql:host=fbi-mysqllehre.th-brandenburg.de;dbname=kosts_db', 'kosts', '20192019');
$pdo->exec("set names utf8");
$showFormular = true;

/**
 * Registrierung neuer User
 * Dateiname: register.php
 * @author Stephan Kost
 * @date 29.11.2020
 */


if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];


    if (empty($vorname)) {
        echo 'Bitte einen Vornamen eingeben!<br>';
        $error = true;
    }

    if (empty($nachname)) {
        echo 'Bitte einen Nachnamen eingeben!<br>';
        $error = true;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }
    if (strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if ($passwort != $passwort2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }

    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if (!$error) {
        $statement = $pdo->prepare("SELECT * FROM mitarbeiter WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();

        if ($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }
    }

    //Keine Fehler, wir können den Nutzer registrieren
    if (!$error) {
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

        $statement = $pdo->prepare("INSERT INTO mitarbeiter (email, passwort, vorname, nachname) VALUES (:email, :passwort, :vorname, :nachname)");
        $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash, 'vorname' => $vorname, 'nachname' => $nachname));

        if ($result) {
            echo 'Du wurdest erfolgreich registriert. <a href="index.php">Zum Login</a>';
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
}

// Beginn des Hauptprogramms
$HMTLbuild = new HTMLB();

$HMTLbuild->writeHeader();

if ($showFormular) {
    $HMTLbuild->writeHeadline("Wocheneinteilung");
    $HMTLbuild->startForm("post", "?register=1");
    $HMTLbuild->writeInputField("Vorname", "vorname", "text");
    $HMTLbuild->writeInputField("Nachname", "nachname", "text");
    $HMTLbuild->writeInputField("E-Mail", "email", "email");
    $HMTLbuild->writeInputField("Passwort", "passwort", "password");
    $HMTLbuild->writeInputField("Passwort wiederholen", "passwort2", "password");
    $HMTLbuild->closeForm("Registrieren");
}

$HMTLbuild->writeFooter();
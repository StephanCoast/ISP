<?php

require_once 'HTMLB.php';

/**
 * Login User
 * Dateiname: index.php
 * @author Stephan Kost
 * @date 29.11.2020
 */


session_start();
$pdo = new PDO('mysql:host=fbi-mysqllehre.th-brandenburg.de;dbname=kosts_db', 'kosts', '20192019');
$pdo->exec("set names utf8");
$showFormular = true;


if(isset($_GET['login'])) {
    $error = false;
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];


    $statement = $pdo->prepare("SELECT * FROM mitarbeiter WHERE email = :email");
    $result = $statement->execute(array('email' => $email));  // :email in prepare statement auflösen
    $user = $statement->fetch();

   // print_r($user);

    if ($user !== false && password_verify($passwort, $user['passwort'])) {

        $_SESSION['userid'] = $user['id'];
        header("Location: w_einteilung.php");
        exit();

    } else {
        $fehlermeldung = "E-Mail oder Passwort ungültig!";


    }



}

// Beginn des Hauptprogramms

HTMLB::writeHeader();

if ($showFormular) {
    HTMLB::writeHeadline("Wocheneinteilungen");
    HTMLB::startForm("post", "?login=1");
    HTMLB::writeInputField("E-Mail", "email", "email");
    HTMLB::writeInputField("Passwort", "passwort", "password");
    HTMLB::closeForm("Einloggen");
}

if  (isset($fehlermeldung)) {
    echo $fehlermeldung;
}

HTMLB::writeFooter();
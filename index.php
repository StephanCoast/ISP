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

$showFormular = true;
session_start();

try {
    $pdo = new PDO('mysql:host=fbi-mysqllehre.th-brandenburg.de; charset=utf8; dbname=kosts_db', 'kosts', '20192019');
    $pdo->exec("set names utf8");

} catch (Exception $e) {
    echo "Verbindung zur Datenbank funktioniert nicht";
    exit;
}
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


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
$HTMLbuild = new HTMLB;

$HTMLbuild->writeHeader();

if ($showFormular) {
    $HTMLbuild->writeHeadline("Wocheneinteilung");
    $HTMLbuild->startForm("post", "?login=1");
    $HTMLbuild->writeInputField("E-Mail", "email", "email");
    $HTMLbuild->writeInputField("Passwort", "passwort", "password");
    $HTMLbuild->closeForm("Einloggen");
}

if  (isset($fehlermeldung)) {
    echo $fehlermeldung;
}

$HTMLbuild->writeFooter();
<?php

// Verbindung zum Datenbankserver
$pdo = new PDO('mysql:host=localhost:3306; dbname=kosts_db', 'root', '');

// Abfrage der Tabelle "php"  !!! AMATEURHAFT WEIL PARAMETER DIREKT ÜBERGEBEN !! BESSER PREPARED STATEMENTS WEITER UNTEN
$pdo->query("UPDATE `gaestebuch` SET `vorname` = 'Rita' WHERE `gaestebuch`.`email` = 'rrot@rot.de'");
$result = $pdo->query("SELECT vorname, nachname, email, eintrag FROM gaestebuch");

// Nachsehen, was in $result enthalten ist
print_r($result);
echo "<hr>";

// Ausgeben der Inhalte
foreach ($result as $row) {
    echo  " Name: "
        . $row['vorname'] . " " . $row['nachname']
        . "<br>"
        . " Mail: "
        . $row['email']
        . "<br>"
        . " Beitrag: "
        . $row['eintrag']
        . "<hr>";
}


//UPDATE

// Abfrage der Tabelle "php"
$pdo->query("UPDATE `gaestebuch` SET `vorname` = 'Margaritha' WHERE `gaestebuch`.`email` = 'rrot@rot.de'");
$result = $pdo->query("SELECT vorname, nachname, email, eintrag FROM gaestebuch");

// Nachsehen, was in $result enthalten ist
print_r($result);
echo "<hr>";

// Ausgeben der Inhalte
foreach ($result as $row) {
    echo  " Name: "
        . $row['vorname'] . " " . $row['nachname']
        . "<br>"
        . " Mail: "
        . $row['email']
        . "<br>"
        . " Beitrag: "
        . $row['eintrag']
        . "<hr>";
}



//PROFI Datenbankverbindung mit Prepared Statements & Charset=UTF8 & ATTR_EMULATE_PREPARES = false & Tabellenspezif. Nutzeraccount für PHP-Skript
//PROFIPROFI Auslagerung DB-Anfragen in Klasse MODEL und Repository

$start = 100;
$end = 500;

$pdo = new PDO('mysql:host=localhost:3306; charset=utf8; dbname=gibbon', 'root', '');
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$stmt = $pdo->prepare(
    "SELECT * FROM gibboncountry WHERE iddCountryCode BETWEEN :start AND :end"
);

$stmt->bindParam(":start", $start);
$stmt->bindParam(":end", $end);
$stmt->execute();

foreach ($stmt as $row) {
    echo $row['printable_name']
        . " hat die ID "
        . $row['iddCountryCode']
        . "<br>";
}
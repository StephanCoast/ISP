<?php

session_start();
$pdo = new PDO('mysql:host=fbi-mysqllehre.th-brandenburg.de;dbname=kosts_db', 'kosts', '20192019');
$showFormular = true;

/**
 * Registrierung neuer User
 * Dateiname: register.php
 * @author Stephan Kost
 * @date 29.11.2020
 */


function writeHeader()
{
    echo "<!DOCTYPE html>
          <html lang=\"de\">
          <head><title>Wocheneinteilung</title>
          </head>
          <body>";
}

function writeHeadline()
{
    echo "<h1>Log-IN</h1>";
}

function startForm($method, $url)
{
    echo "<form method=\"$method\" action=\"$url\">";
}

function writeInputField($text, $name, $typ)

{
    echo "<label for=\"$name\">$text: </label>
          <input type=\"$typ\" name=\"$name\" id=\"$name\">
          <br><br>";
}


function closeForm()
{
    echo "<input type=\"submit\" value=\"Einloggen\">
          </form>";
}

function writeFooter()
{
    echo "</body></html>";
}


if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];


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

writeHeader();

if ($showFormular) {
    writeHeadline();
    startForm("post", "?register=1");
    writeInputField("Vorname", "vorname", "text");
    writeInputField("Nachname", "nachname", "text");
    writeInputField("E-Mail", "email", "email");
    writeInputField("Passwort", "passwort", "password");
    writeInputField("Passwort wiederholen", "passwort2", "password");
    closeForm();
}

writeFooter();
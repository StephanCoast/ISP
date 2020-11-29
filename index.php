<?php

/**
 * Login User
 * Dateiname: index.php
 * @author Stephan Kost
 * @date 29.11.2020
 */


session_start();
$pdo = new PDO('mysql:host=fbi-mysqllehre.th-brandenburg.de;dbname=kosts_db', 'kosts', '20192019');
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

writeHeader();

if ($showFormular) {
    writeHeadline();
    startForm("post", "?login=1");
    writeInputField("E-Mail", "email", "email");
    writeInputField("Passwort", "passwort", "password");
    closeForm();
}

if  (isset($fehlermeldung)) {
    echo $fehlermeldung;
}

writeFooter();


//HTML-Bausteine

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
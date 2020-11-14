<?php

/**
 * Beispiel Formular - $_POST Daten mit foreach() prüfen und ausgeben
 * @author Lisa Meijer & Jörg Thomaschewski
 * basiert auf einer Version von Michael Gerbracht
 * @date 02.05.2019
 */

function writeHeaderAndHeadline()

{
    echo "<!DOCTYPE html>
          <html lang=\"de\">
          <head><title>Formular</title>
          </head>
          <body>
          <h1>Daten mit foreach() ausgeben</h1>";
}

function writeHtmlEnd()
{
    echo "</body></html>";
}

// Beginn des Hauptprogramms
writeHeaderAndHeadline();

$error = false;

// Alle POST-Daten mit foreach() auslesen und überprüfen

foreach ($_POST as $field => $content) {

    if (empty($content)) {
        echo "Das Feld $field enthält keinen Text!<br />";
        $error = true;
    }
}

if (!$error) {
    echo "Hallo " . $_POST["vorname"] . " " . $_POST["nachname"] . "!";
}

writeHtmlEnd();
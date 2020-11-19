<?php

/**
 * Beispiel Formular - Daten mit foreach() ausgeben
 * @author Lisa Meijer & Jörg Thomaschewski
 * @date 04.09.2019
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

// Alle POST-Daten auslesen und auf leere Felder überprüfen

echo "Es wurden Daten in dieser Reihenfolge eingetragen:<br>";

foreach ($_POST as $field => $content) {
    if (!empty($content)) {
        echo "$content <br>";
    }
}


// Alle POST-Daten sortiert auslesen und auf leere Felder überprüfen

echo "<hr>Ausgabe der sortierten Daten:<br>";

asort($_POST);

foreach ($_POST as $field => $content) {
    if (!empty($content)) {
        echo "$content <br>";
    }
}

writeHtmlEnd();
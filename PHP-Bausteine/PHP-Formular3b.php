<?php
/**
 * Beispiel Formular - Daten in Datei auf Server schreiben
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
          <h1>Daten auslesen</h1>";
}

function writeHtmlEnd()
{
    echo "</body></html>";
}

// Beginn des Hauptprogramms
writeHeaderAndHeadline();

// Dateiinhalt wird gelöscht
file_put_contents("formular3b.txt", "");

// Alle POST-Daten mit foreach() auslesen und speichern
foreach ($_POST as $field => $content) {

    if (!empty($content)) {

        /* NICHT GUT!!!, da Datei immer wieder geöffnet wird innerhalb der Schleife */
        file_put_contents("formular3b.txt", $content, FILE_APPEND);
    }
}

// Gespeicherte Datei auslesen
echo "Es wurden folgende Daten gespeichert:<br>";
$textOut = file_get_contents("formular3b.txt");
echo "$textOut";
writeHtmlEnd();
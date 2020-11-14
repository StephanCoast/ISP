<?php
/**
 * Beispiel Formular - Cookies
 * @author Michael Gerbracht, Mirko Groenewold
 * @date 14.05.2019
 */

function writeHeaderAndHeadline()
{
    echo "<!DOCTYPE html>
          <html lang=\"de\">
          <head><title>Cookies</title>
          </head>
          <body>
          <h1>Beispiel Cookies</h1>";
}

function makeOutput()
{
    echo "Ihr Browser lieferte folgende Daten <br />\r\n";
    echo "Vorname: " . $_COOKIE["vorname"] . "<br />\r\n";
    echo "Name: " . $_COOKIE["nachname"];
}

function closeFooter()
{
    echo "</body></html>";
}



// Beginn des Hauptprogramms
writeHeaderAndHeadline();
makeOutput("vorname", "nachname");
closeFooter();
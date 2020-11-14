<?php
/**
 * Beispiel Formular - Cookies
 * @author Michael Gerbracht, Mirko Groenewold
 * @date 14.05.2019
 */

setcookie("vorname",  $_POST["vorname"]);
setcookie("nachname", $_POST["nachname"]);

function writeHeaderAndHeadline()
{
    echo "<!DOCTYPE html>
          <html lang=\"de\">
          <head><title>Cookies</title>
          </head>
          <body>
          <h1>Beispiel Cookies</h1>";
}

function startForm($method, $url)
{
    echo "<form method=\"$method\" action=\"$url\">";
}

function closeFormAndFooter()
{
    echo "</form>
          </body></html>";
}

// Beginn des Hauptprogramms
writeHeaderAndHeadline();
startForm("post", "PHP-Cookie3.php");
print("Die Daten wurden nun als Cookie an Ihren Browser übermittelt.
       Klicken Sie <a href='PHP-Cookie3.php'>hier</a>,
       um die Daten anzuzeigen.\n");

closeFormAndFooter();
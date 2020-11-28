<?php
/**
 * Beispiel Formular - Daten einlesen
 * Dateiname: formular2.php
 * @author Lisa Meijer
 * @date 19.04.2019
 */


function writeHeaderAndHeadline()
{

    echo "<!DOCTYPE html>
          <html lang=\"de\">
          <head><title>Formular</title>
          </head>
          <body>
          <h1>Beispielformular</h1>";

}

function startForm($method, $url)
{
    echo "<form method=\"$method\" action=\"$url\">";
}


function writeInputField($text, $name)

{
    echo "<label for=\"$name\">$text: </label>
          <input type=\"text\" name=\"$name\" id=\"$name\">
          <br><br>";
}


function closeFormAndFooter()
{
    echo "<input type=\"submit\" value=\"Formular abschicken\">
          </form>
          </body></html>";
}

// Beginn des Hauptprogramms

writeHeaderAndHeadline();
startForm("post", "PHP-Formular3b.php");
writeInputField("Vorname", "vorname");
writeInputField("Name",    "nachname");
closeFormAndFooter();
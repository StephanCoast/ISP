<?php

/**
 * Beispiel Formular - Daten einlesen
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
$fieldCount = 3;

writeHeaderAndHeadline();
startForm("post", "PHP-Formular4a.php");
for ($count = 1; $count <= $fieldCount; $count++) {
    writeInputField("$count. Ort", "ort$count");
}

closeFormAndFooter();

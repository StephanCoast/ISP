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

function startForm($method, $url)
{
    echo "<form method=\"$method\" action=\"$url\">";
}

/**
 * Erstellt Textfelder für ein simples Formular, wobei Text = der
 * Text, der dem Benutzer angezeigt werden soll und Name = der Name
 * des Textfeldes
 */

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
startForm("post", "PHP-Cookie2.php");
writeInputField("Vorname", "vorname");
writeInputField("Name",    "nachname");
closeFormAndFooter();
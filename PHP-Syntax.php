<?php

// VARIAblen sind case-sensitive


// String mit und ohne Variablenauswertung in "" bzw. ''

$variable = "Test";
echo "<br>Gib die Variable $variable aus";  //Ausgabe: Gib die Variable Test aus

echo '<br>Gib das Wort $variable aus';      //Ausgabe: Gib das Wort $variable aus

echo "<br>Gib zweimal die Variable {$variable}{$variable} aus"; // Variablen ohne Leerzeichen hintereinander schreiben



$velocity = 3;

echo "<br><br>Mein Ergebnis lautet: ", $velocity, " km/h";

echo "<br>Mein Ergebnis lautet: " . $velocity . " km/h";

echo "<br>Mein Ergebnis lautet: $velocity km/h";

echo '<br>Mein Ergebnis lautet: ', $velocity, ' km/h';

echo '<br>Mein Ergebnis lautet: ' . $velocity . ' km/h';


//Verschachtelung für HTML
$name = "Peter";

echo '<br><br><input type="text" name="', $name, '">';

echo "<br><input type=\"text\" name=\"$name\">";

$path = "https://www.byte.fm/static/images/ByteFM_Logo.svg";
echo '<br><br><img alt="Picture" src="' . $path . '" title="Title">';

//Formartierung von Strings mit printf()
$hour = 6; $minute = 3; $second =9;
printf("<br><br>%02d:%02d:%02d", $hour, $minute, $second);


//CONST - Konstanten definieren abfragen ob definiert -> vorher in Konfigurationsdatei config.ini schreiben
const AUTOR = "Thomaschewski";
echo "<br><br>Ausgabe der Konstanten: ", AUTOR, "<br>";

if (defined('AUTOR')) {
    echo "Die Konstante AUTOR ist gesetzt.";
}


/* VORDEFINIERTE KONSTANTEN in PHP

__LINE__ 	Aktuelle Zeile
Beinhaltet die aktuelle Zeilennummer, in der __LINE__ verwendet wird.
__FILE__ 	Aktuelle Datei
Beinhaltet den Dateinamen, in dem __FILE__ verwendet wird.
__DIR__ 	Aktuelles Verzeichnis
Beinhaltet das aktuelle Verzeichnis, in dem die Datei liegt, in der __DIR__ verwendet wird.
__FUNCTION__ 	Aktuelle Funktion
Beinhaltet die aktuelle Funktion, in der __FUNCTION__ verwendet wird.
__METHOD__ 	Aktuelle Methode
Beinhaltet die aktuelle Methode, in der __METHOD__ verwendet wird.
__CLASS__ 	Aktuelle Klasse
Beinhaltet die aktuelle Klasse, in der __CLASS__ verwendet wird.
__TRAIT__ 	Aktuelles Trait
Beinhaltet das aktuelle Trait, in der __TRAIT__ verwendet wird.
__NAMESPACE__ 	Aktueller Namensraum
Beinhaltet den aktuellen Namensraum, in dem __NAMESPACE__ verwendet wird.
*/

//MAGISCHE KONSTANTEN
echo "<br><br>Aktuelles Verzeichnis: ", __DIR__;

$flower = ["Tulpe" => "Gelb", "Rose" => "Rot", "Kornblume" => "Blau"];
echo "<br>Die Farbe der Rose ist " . $flower["Rose"] . "<br>";
echo __DIR__ . "<br>";
echo __FILE__ . "<br>";
echo __LINE__ . "<br>";


//SUPERGLOBALS
echo "<pre>";
print_r($_SERVER);
echo "</pre>";

//Prüfen ob Formulardaten in POST-Array gesendet wurden
if (!empty($_POST)) {
    echo '<br>Es gibt POST-Daten';
} else {
    echo '<br>Erzeuge das leere Formular!';
}

//Schwach typisierte Sprache PHP -> Eingabe 0 wird als leer gedeutet
$name = "0";
if (empty($name)) {
    echo '$name ist leer';
} else {
    echo '$name ist nicht leer';
}

$var = "text";
if (0 == $var)   {
    /* Bedingung wird durchlaufen */
    echo '<br>$var ist leer';
}



//PROFITIPP Systemunabhängig Klassen und Module einbinden
$incPath   = __DIR__.DIRECTORY_SEPARATOR.'inc'.DIRECTORY_SEPARATOR;
$classPath = __DIR__.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR;
//require_once $incPath.'footer.inc.php';
//require_once $classPath.'HtmlInput.php';


//DEBUGGING - ganzes Array ausgeben mit print_r() und var_dump() - nicht im produktien System verwenden!
$cmyk = ["c" => "cyan", "m" => "magenta", "yk" => ["yellow", "key"]];

echo "<br><br>Ausgabe mit print_r() <br>";
print_r($cmyk);
echo "<hr>";

echo "Ausgabe mit var_dump() <br>";
var_dump($cmyk);
echo "<hr>";

echo "Ausgabe mit einem pre-Element";
echo "<pre>";
print_r($cmyk);
echo "</pre>";


//DEBUGGING II

// Unter den Includes
$debug="ja";
//session_start();

if ($debug==="ja") {
    error_reporting (-1);
    echo "POST/GET <br>";
    print_r($_REQUEST);
    echo "<hr>";
    echo "SESSION <br>";
  //  print_r($_SESSION);
} else {
    error_reporting (0);
}
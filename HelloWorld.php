<?php

/**

 * Datei zu Aufgabe 1

 *

 * @author       Stephan Kost <stephan.kost@th-brandenburg.de>

 * @since 0.1    Variablen in PHP

 */

// Boole'sche Variablen

$var = (bool) "false";

if (is_bool($var)) {
    echo "Ja, es ist ein Boolean-Typ.";
} else {
    echo "Nein, es ist kein Boolean-Typ.";
}
echo "var_dump: ";

var_dump($var);

// Strings
$var = (string) "lern";

$b = "Wir " . $var . "en PHP! <br>";
$c = "Wir {$var}en PHP! <br>";
echo $b, $c;


// Stringblöcke
$a = "PHP";
$b = <<<STRINGENDE
Wir lernen
$a! <br> <br>
STRINGENDE;
echo $b;


$var = "Wir lernen PHP!";
echo $var[0];
echo $var[5];
echo $var[7];
echo "<br>";

//Integer
$normal = (int) 42;
$hexa   = (int) 0x11;
$octal1 = (int) 042;

echo "<br>Normaler Integer: $normal <br>";
echo "Hex: $hexa <br>";
echo "Oktal#1: $octal1 <br>";

//FLoat (14 Stellen Genauigkeit, für mehr bc-Math aktivieren
var_dump(is_float(47));
var_dump(is_float(6.11));
var_dump(is_float(95.1));
var_dump(is_float(66e6));
var_dump(is_float('xyz'));
var_dump(is_float(false));


//INDIZIERTE ARRAYS - erstes Element Index 0
$name = ["Maria", "Ute", "Jürgen"];
// automatische Indexzuweisung – alternative Schreibweise
$name[] = "Maria";
$name[] = "Ute";
$name[] = "Jürgen";
// manuelle Indexzuweisung
$name[0] = "Maria";
$name[1] = "Ute";
$name[2] = "Jürgen";

// veraltete Schreibweise: array()-Funktion
$name = array("Maria", "Ute", "Jürgen");

$name[]= "Uta";

echo "2. Name im Array: $name[1] <br>"; //String mit Variablenauswertung eingeschlossen "" ohne ''
echo "1. Name im Array: $name[0] <br>";
echo "4. Name im Array: $name[3] <br>";


//ASSOZIATIVE ARRAYS - erstes Element Index 0
$flower = ["Tulpe" => "Gelb", "Rose" => "Rot", "Kornblume" => "Blau"];

// alternative Schreibweise
$flower["Tulpe"] = "Gelb";
$flower["Rose"] = "Rot";
$flower["Kornblume"] = "Blau";

echo "flower 3:" . $flower["Kornblume"] . "<br>";
echo "flower 1:" . $flower["Tulpe"] . "<br>";
echo "flower 2:" . $flower["Rose"] . "<br>";

//ARRAY in ARRAY
// Schreibweise für sehr einfache Arrays
$name = ["Maria", "Ute", "Jürgen"];

// Bessere Schreibweise, sobald die Arrays komplexer werden
$name = [
    "Maria",
    "Ute",
    "Jürgen"
];

$data = [
    "Maria"  => ["7201234", "Medientechnik", "6. Semester"],
    "Ute"    => ["7208888", "Informatik", "2. Semester"],
    "Jürgen" => ["7211111", "Medientechnik", "2. Semester"],
];

echo "Die Matr.-Nr. von Ute ist: " . $data["Ute"][0] . "<br>";

//Array-Keys auslesen (Maria, Ute, etc.)

$data = [
    "Maria"  => ["7201234", "Medientechnik", "6. Semester"],
    "Ute"    => ["7208888", "Informatik", "2. Semester"],
    "Jürgen" => ["7211111", "Medientechnik", "2. Semester"],
];


$name = array_keys($data);
echo "Die Matr.-Nr. von " . $name[1] . " ist: " . $data["Ute"][0] . "<br>";

// Auch die folgende "Kurzform" ist möglich
echo "Die Matr.-Nr. von ".array_keys($data)[1]." ist: ".$data["Ute"][0] . "<br>";


//Vergleich von ARRAYS
$one = [1, 2, 3, 4];
$two = [1, 2, 3];
$three = ["x" => 1, "y" => 2, "z" => 3];

if ($one == $two) { //nur Wert vergleichen
    echo '1: $one & $two haben den gleichen Inhalt!';
}
if ($one === $two) { //Typ und Wert vergleichen
    echo '2: $one & $two sind identisch!';
}
if ($one == $three) {
    echo '3: $one & $three haben den gleichen Inhalt!';
}

/* Ausgabe: 1: $one & $two haben den gleichen Inhalt!
Die zweite if-Bedingung (Zeile 9) wird nicht durchlaufen, da die Typen in den Elementen unterschiedlich sind.
Die dritte if-Bedingung (Zeile 13) wird nicht durchlaufen, da es sich um verschiedene Arraytypen handelt.
*/


// Schnitt- und Differenzmenge bestimmen

for ($i = 0 ; $i < sizeof(array_intersect($one,$two)); $i++) {
    echo array_intersect($one,$two)[$i];
}

//Hinterlässt differenz[3] = 4
$differenz = array_diff($one,$two);

//Komplettes ARRAY mittels var_dump() oder print_r() und <pre>-Element ausgeben
echo "Ausgabe mit var_dump() <br>";
var_dump($differenz);
echo "<hr>";

echo "Ausgabe mit einem pre-Element";
echo "<pre>";
print_r($differenz);
echo "</pre>";





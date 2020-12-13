<?php

/*

count() 	Bestimmt die Anzahl der Elemente in einem Array
next() 	Rückt den Zeiger des Arrays auf das folgende Element
prev() 	Rückt den Zeiger des Arrays auf das vorherige Element
end() 	Setzt den Zeiger des Arrays auf das letzte Element
current() 	Liefert das aktuelle Element eines Arrays
key() 	Liefert den Schlüssel eines assoziativen Arrays
list() 	Überträgt Elemente eines Arrays auf einzelne Variablen

/*
 *
array_keys() 	Auslesen der Keys eines assoziativen Arrays. Hier ein Beispiel
array_pop() 	Liefert und löscht das letzte Element einen indizierten oder assoziativen Arrays Hier ein Beispiel
array_shift() 	Liefert und löscht das erste Element einen indizierten oder assoziativen Arrays
array_unshift() 	Fügt ein oder mehr Elemente am Anfang eines Arrays ein.
array_slice() 	Extrahiert ein Teil-Array aus einem Array.

*/

$cmyk = ["Cyan", "Magenta", "Yellow", "Key"];

echo "Elementanzahl: ", count($cmyk);
echo "<br>aktuelles Element: ", current($cmyk);
echo "<br>nächstes Element: ", next($cmyk);
echo "<br>letztes Element: ", end($cmyk);



// Daten aus einer "Tabelle", nur die Ziffern in der
// Mitte sollen "herausgeholt" werden

$data = [
    ['x', 'x', 1, 2, 3, 'x', 'x'],
    ['x', 'x', 4, 5, 6, 'x', 'x'],
    ['x', 'x', 7, 8, 9, 'x', 'x']
];

// Extraktion der Nutzdaten

foreach ($data as $row) {
    echo implode(", ", array_slice($row, 2, 3)) . "<br>";
}


//SORTIEREN

/*

Aufsteigend 	Absteigend 	Benutzerdefiniert 	Funktion
sort() 	        rsort() 	usort() 	        Sortiert die Werte eines Arrays und weist numerische Indizes zu. Die Zuordnung von Schlüssel zu Wert bleibt dabei nicht erhalten. Ein vorher assoziatives Array wird in ein indiziertes Array umgewandelt.
asort() 	    arsort() 	uasort() 	        Die Funktion asort() sortiert ein assoziatives Array aufsteigend nach den Werten der Elemente. Die Zuordnung von Schlüssel zu Wert bleibt dabei erhalten.
ksort() 	    krsort() 	uksort() 	        Die Funktion ksort() sortiert ein assoziatives Array aufsteigend nach den Schlüsseln. Die Beziehung zwischen Schlüssel und Wert bleibt erhalten.

 */

$digits = [17, 19, 21, 15, 9, 13];

$size = sizeof($digits);


//unsortiert

echo "unsortiert: ";
for ($count = 0; $count < $size; $count++) {
    echo "$digits[$count] ";
}


//aufsteigend sortiert
sort($digits);
echo "<br>aufsteigend sortiert: ";
for ($count = 0; $count < $size; $count++) {
    echo "$digits[$count] ";
}


//absteigend sortiert
rsort($digits);
echo "<br>absteigend sortiert: ";
for ($count = 0; $count < $size; $count++) {
    echo "$digits[$count] ";
}

//benutzerdefinierte Sortierfunktion
function compare($one, $two)
{
    if ($two > $one)  return 1;
    if ($two < $one)  return -1;
    if ($two == $one) return 0;
}

//ASSOZIATIVES ARRAY
$digits = [4 => "vier", 3 => "drei", 20 => "zwanzig", 10 => "zehn"];
uksort($digits, "compare");

print_r($digits);
echo "<br><br>";

while (list($key, $value) = each($digits)) {
    echo "$key: $value<br />";
}
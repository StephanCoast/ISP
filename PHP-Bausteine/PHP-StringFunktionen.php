<?php

/*

strlen() 	Ermittelt die Länge eines Strings
trim() 	Entfernt Whitespaces am Anfang und Ende eines Strings
rtrim() 	Auch chop(). Entfernt Leerraum am Ende eines Strings
strtoupper() 	Wandelt alle Zeichen des Strings in Großbuchstaben um
strtolower() 	Wandelt alle Zeichen des Strings in Kleinbuchstaben um
ucfirst() 	Wandelt erstes Zeichen eines Strings in einen Großbuchstaben um
ucwords() 	Wandelt jedes erste Zeichen eines Wortes in einen Großbuchstaben um
strstr() 	Findet erstes Vorkommen eines Strings innerhalb eines anderen Strings und gibt diesen ab dem Suchergebnis zurück
strrev() 	Gibt String in umgekehrter Reihenfolge zurück
implode() 	Verbindet die Elemente eines Arrays zu einem String. Bei assoziativen Arrays werden nur die Werte (und nicht die Keys) verwendet.
explode() 	Gegenteil zu implode(). Macht also aus einem String ein indiziertes Array.

 */

$stringExample = "Wir lernen PHP! ";

echo ucwords($stringExample), "<br>";
echo strtoupper($stringExample), "<br>";
echo strstr($stringExample, "n"), "<br>";
echo strrev($stringExample);


//IMPLODE
$data = ["firstname", "lastname", "zip", "city"];

$stringData = implode(";", $data);
echo "<br><br> $stringData <br>";
$color = ["r" => 127, "g" => 127, "b" => 255];
$stringColor = implode(", ", $color);
echo "$stringColor <br>";

//EXPLODE
$stringData = "<br><br>firstname;lastname;zip;city";

$data = explode(";", $stringData);
print_r($data);


//DATUM

/* Formatierung

Y 	Vierstellige Jahresangabe 	1946 oder 2007
y 	Zweistellige Jahresangabe 	46 oder 07
m 	Monat mit führender Null 	01 bis 12
n 	Monat 	1 bis 12
M 	Monat, 3 Buchstaben 	Jan oder Dec
F 	Monat ausgeschrieben 	January oder December
d 	Tag des Monats mit führender Null 	01 bis 31
j 	Tag des Monats ohne Null 	1 bis 31
D 	Wochentag in 3 Buchstaben 	Sun oder Mon
l 	Wochentag ausgeschrieben 	"Sunday" oder "Monday"
h 	Stunde im 12er Format mit führender Null 	01 bis 12
H 	Stunde im 24er Format mit führender Null 	00 bis 24
g 	Stunde im 12er Format ohne Null 	1 bis 12
G 	Stunde im 24er Format ohne Null 	0 bis 24
i 	Minuten mit führender Null 	00 bis 59
s 	Sekunden mit führender Null 	00 bis 59
t 	Anzahl der Tage im Monat 	28 bis 31
z 	Tag eines Jahres 	0 bis 365

*/

echo date("d. F Y"),"<br>";

echo "Datum: ", date("l, d F Y "), "um ", date("H:i:s "), "Uhr";

//ZUFALLSZAHL

$numbers = mt_rand(1, 3);
echo "<img src=\"datei{$numbers}.png\">";
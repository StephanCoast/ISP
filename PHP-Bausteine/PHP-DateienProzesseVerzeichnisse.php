<?php

// Ordnerinhalt auslesen

$directory = opendir('.\.');

while ($file = readdir($directory)) {
    echo "$file <br>";
}

closedir($directory);


/*
 *
 *  '.' aktuelles Verzeichnis
 *  '..' eins höher
 *  '..\..' zwei höher
 */


// PROZESSE starten und schließen -> Sendmail funktioniert nur auf UNIX mit SMTP-Server

$fd = popen("..\..\sendmail\sendmail -t", "w");

fputs($fd, "To: stephan.kost@th-brandenburg.de\n");
fputs($fd, "Subject: Internetanfrage\n\n");
fputs($fd, "Sie haben folgende Anfrage erhalten:\n");
pclose($fd);


// DATEIEN einlesen und schreiben

/*
file_get_contents() 	Liest den Inhalt einer Datei in einen String.
file_put_contents() 	Schreibt den Inhalt einer String-, oder Array-Variable in eine Datei.
file() 	                Liest eine ganze Datei zeilenweise in ein Array.
file_exists() 	        Prüft, ob eine Datei existiert.
*/

// DATEIEN einlesen mit file_get_contents()

$textIn = "Dies ist ein Beispiel-Text.\nZweite Zeile";
// Text in Datei a.txt schreiben
file_put_contents("a.txt", $textIn);
// Text aus der Datei a.txt auslesen
$textOut = file_get_contents("a.txt");
echo "<br><br>";
print_r($textOut);


// DATEI als Array einlesen mit file()

$textIn = "Dies ist ein Beispiel-Text.\nZweite Zeile";
// Text in Datei a.txt schreiben
file_put_contents("a.txt", $textIn);
// Text aus der Datei a.txt auslesen
$textOut = file("a.txt");
echo "<br><br>";
print_r($textOut);

// DATEI direkt ausgeben readfile()

$textIn = "Dies ist ein Beispiel-Text.\nZweite Zeile";
// Text in Datei a.txt schreiben
file_put_contents("a.txt", $textIn);
// Text aus der Datei a.txt auslesen
echo "<br><br>";
readfile("a.txt");


/*  Dezidiertes Editieren
fopen() 	Öffnet eine Datei
feof() 	    Prüft, ob der Dateizeiger am Ende der Datei steht
fgets() 	Liest eine Zeile von Beginn des Dateizeigers
fread() 	Liest Binärdaten aus einer Datei
fwrite() 	Schreibt den Inhalt einer Zeichenkette in eine Datei. Die Zeichenkette kann auch binäre Daten enthalten (= Binär-sicheres Schreiben).
fclose() 	Schli
 */

/* Für fopen("Dateiname", "Aktion") sind folgende Aktionen zugelassen:
r 	Öffnet die Datei nur zum Lesen und positioniert den Dateizeiger auf den Anfang der Datei.
r+ 	Öffnet die Datei zum Lesen und Schreiben und setzt den Dateizeiger auf den Anfang der Datei.
w 	Öffnet die Datei nur zum Schreiben und setzt den Dateizeiger auf den Anfang der Datei, sowie die Länge der Datei auf 0 Byte. Wenn die Datei nicht existiert, wird versucht sie anzulegen.
w+ 	Öffnet die Datei zum Lesen und Schreiben und setzt den Dateizeiger auf den Anfang der Datei, sowie die Länge der Datei auf 0 Byte. Wenn die Datei nicht existiert, wird versucht sie anzulegen.
a 	Öffnet die Datei nur zum Schreiben. Positioniert den Dateizeiger auf das Ende der Datei. Wenn die Datei nicht existiert, wird versucht sie anzulegen.
a+ 	Öffnet die Datei zum Lesen und Schreiben. Positioniert den Dateizeiger auf das Ende der Datei. Wenn die Datei nicht existiert, wird versucht sie anzulegen. */


// Eine Datei zeilenweise auslesen und auf dem Browser ausgeben.

echo "<br><br>";
$testfile = fopen("a.txt", "r");

while (!feof($testfile)) {
    $line = fgets($testfile, 1000);
    echo "$line <br>";
}

fclose($testfile);




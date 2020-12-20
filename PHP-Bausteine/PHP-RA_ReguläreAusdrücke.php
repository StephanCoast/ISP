<?php

/*

Sonderzeichen 	Erklärung
( ) 	Gruppiert die Elemente zu einem einzigen Element. Es muss eine Übereinstimmung in der Reihenfolge mit allen Elementen vorliegen, z.B. (tee).
(...|...|...) 	tea|te).
[ ] 	Bezeichnet eine Klasse von Elementen, die erkannt werden sollen. Es muss eine Übereinstimmung mit nur einem der Elemente vorliegen, z.B. [0-9].

Sonderzeichen der Mengenklammer sind [^ - / \], alle anderen Zeichen haben keine Sonderfunktion.
[^ ] 	Bezeichnet eine negierte Klasse von Elementen. Das Zeichen ^ negiert die gesamte Klasse.

Anmerkung: Der Operator gilt für die Negation nur in der Mengenklammer [ ], z.B. [^0-9].
\d bzw. Negation \D 	Digit (entsprechend [0-9]) bzw. nicht Digit (entsprechend [^0-9]).
\w bzw. Negation \W 	Alphanumerische Zeichen (Wort) entsprechend [a-zA-Z0-9_] bzw. nicht alphanumerische Zeichen entsprechend [^a-zA-Z0-9_].
\s bzw. Negation \S 	Whitespace (Leerzeichen und Tabulator) bzw. nicht whitespace.
\b bzw. Negation \B 	Wortgrenze (b = boundary) bzw. nicht Wortgrenze.

Eine Wortgrenze ist definiert als \W Zeichen vor oder hinter einem \w-Zeichen.
. 	Der „Punkt“ steht für ein beliebiges Zeichen (Ausnahme: Zeilenumbruch Newline).
{n,m} 	Wiederholungsintervall (gierig).
{n} genau n-mal
{n,} mindestens n-mal
{,m} maximal m-mal
{n,m} mindestens n-mal und maximal m-mal
{n,m}? 	Wiederholungsintervall (nicht-gierig).
? 	Das vorstehende Zeichen 0 oder 1-mal (gierig).
+ 	Das vorstehende Zeichen 1-mal oder beliebig oft (gierig).
* 	Das vorstehende Zeichen 0-mal oder beliebig oft (gierig).
?? 	Das vorstehende Zeichen 0 oder 1-mal (nicht-gierig).
+? 	Das vorstehende Zeichen 1-mal oder beliebig oft (nicht-gierig).
*? 	Das vorstehende Zeichen 0-mal oder beliebig oft (nicht-gierig).
^ 	Markiert, dass der Suchausdruck am Anfang stehen muss. Im Mehrzeilenmodus wird auch jedes Newline-Zeichen erkannt.
$ 	Erkennt das Zeilenende bzw. das Zeichen unmittelbar vor dem letzten Newline-Zeichen.
/ /i 	Modifikator: Groß-/Kleinschreibung ignorieren.
/ /s 	Modifikator: Single-line-Mode: Zeichenketten als eine einzige Zeile betrachten. Der Punkt-Operator gilt auch für das Newline-Zeichen.
/ /x 	Modifikator: Ignoriert Whitespace und erlaubt Kommentare ( #). So kann bei längeren Suchmustern eine Formatierung zur besseren Lesbarkeit des Suchmusters vorgenommen werden, indem das Suchmuster über mehrere Zeilen geschrieben wird.

 */


/* PRAKTISCHE BEISPIELE

Praktische Bespiele für reguläre Ausdrücke 	Erklärung
preg_replace( ' /^\s*$/ ' , , $datei); 	Löscht alle Leerzeilen einer Datei

preg_replace( ' /^#.*$/ ' , , $datei); 	Löscht alle einzeiligen Kommentarzeilen einer Datei

preg_replace( ' /^.*\// ' , , $pfad); 	Entfernt in absoluten Pfaden die Verzeichnisse und lässt den Dateinamen übrig

preg_match( ' /^\d{5}$/ ' , $feld); 	Überprüft ein PLZ-Formularfeld auf 5 Digits

preg_match( ' /^\S+@\S+\.[A-Z]{2,6}$/i ' , $feld); 	Einfache Überprüfung eines E-Mail-Formularfeldes

preg_match('/^#[0-9A-F]{3}([0-9A-F]{3})?$/i', $farbe) 	Überprüft einen HTML-Hexcode für Farben (sowohl 3-stellig als auch 6-stellig)
*/


// Ist Suchmuster in String vorhanden?
$text = "PHP macht viel Spass";
$suchmuster = '/viel/';

if(preg_match ($suchmuster, $text, $treffer)) {
    print_r($treffer);
}else{

    print "Kein Treffer";
}
echo "<br><br>";


// Wie oft ist Suchmuster in String vorhanden?
$text = "PHP macht viel Spass";
$suchmuster = '/a/';

if (preg_match_all($suchmuster, $text, $treffer)) {
    print_r($treffer);
    //Rückgabewert Anzahl
    echo preg_match_all($suchmuster,$text);
} else {
    print "Kein Treffer";
}
echo "<br><br>";


// PREG_REPLACE() Ersetzen eines Ausdruckes durch einen anderen
$text = "PHP macht  viel  Spass";
$suchmuster = '/ viel /';
$ersetzen = 'mir';

$neuerText = preg_replace($suchmuster, $ersetzen, $text);
print $neuerText;
echo "<br><br>";

//KURZ
$neuerText=preg_replace("/H/","M","Haus<Auto");
print $neuerText;
echo "<br><br>";


//Beispiele
//Achtung: Deutsche Umlaute sind nicht in der Menge von \w enthalten und werden entsprechend als Wortgrenze angesehen. Umlaute sind „fies“ und darauf wird später noch eingegangen.

$text = "Hier teste ich 1000 Texte";
// $suchmuster = '/\w\w\w\s\d\d\d\d/';
$suchmuster = '/.+1000/';

if(preg_match ($suchmuster, $text, $treffer)) {
    print_r($treffer);
}else{

    print "Kein Treffer";
}
echo "<br><br>";


//KONVERTIEREN DATUMSFORMAT - Ergebnis jeder runden Klammer in $1, $2, ... $n gespeichert
$date = '2011-05-31';
$such = '/(\d{4})-(\d{2})-(\d{2})/';
$ersetz = '$3.$2.$1';

$datum = preg_replace($such, $ersetz, $date);
print $datum;
echo "<br><br>";

//Suchmuster über mehrere Zeilen - Preis aus String filtern
$text = "Ich habe 122,50 € und 80 € ausgegeben.";
$text2 = "Ich habe nix ausgegeben.";
$text3 = "Ich habe 12200000000,50 € ausgegeben.";

# RegExp. in einer Linie
# $such = '/^.*?(\d{1,6},?(\d{1,2})?\s?€).*$/';
# RegExp. mit Kommentaren und  / x
$such   =   '/
          ^[A-Z\s]*?          # Am Textanfang beginnen
          (             # Klammer für $1
          \d{1,6}       # 1-6 Zahlen für Eurobetrag
          ,?            # Komma für Cent-Beträge (optional)
          (\d{1,2})?    # Zwei Nachkommastellen (optional)
          \s?€          # Leerzeichen (optional) und €-Zeichen
          )             # Klammer für $1 schließen
         . *$           # bis zum Ende
           /x ';

$ersetz = '$1';

$b   =   preg_replace ($such,   $ersetz,   $text);
print $b . "<br>";
$b   =   preg_replace ($such,   $ersetz,   $text2);
print $b . "<br>";
$b   =   preg_replace ($such,   $ersetz,   $text3);
print $b . "<br>";
echo "<br><br>";


// PREG_REPLACE auch ARRAY-fähig
$text   =   array("Er hat 122,50 € auf dem Konto",
    "Er hat 122€ auf dem Konto",
    "Er hat 0,5 €",
    "Er hat 1220000000 € auf dem Konto",
    "Er hat nix",
    "Er hat ,5€");

$such = '/^([A-Z\s]*?)(\d{1,6},?(\d{1,2})?\s?€)(.*)$/i';
$ersetz = '($1)($2)($4)';

$b   =   preg_replace ($such,   $ersetz,   $text);

foreach   ($b as $value)   {
    echo "$value <br \> ";
}
echo "<br><br>";


//UMLAUTE erlauben, Sonderzeichen nicht
$text = "Jörg André Meier (+#,.-)";

# Alles finden – nur zur Kontrolle
$such1 = '/^.*$/';
preg_match_all($such1,   $text,   $treffer);
print_r($treffer);
echo "<hr \>";

# Mit \w arbeiten -> BEST PRACTICE /u
$such2 = '/[\w\s]+/u';
preg_match_all($such2,   $text,   $treffer);
print_r($treffer);
echo "<hr \>";

# Sonderzeichen einzeln angeben
$such3  = '/[a-zäöü\s]+/i';
preg_match_all($such3,   $text,   $treffer);
print_r($treffer);
echo "<hr \>";


//AUTO-Maskierungsfunktion

$meine_dateizeile = "Er hatte die $-Zeichen in \"den Augen\"";
$mein_string = preg_quote ($meine_dateizeile);
print($mein_string);
echo "<br><br>";


//SINGLELINE-MODE für HTML CODE

$text = "
 //Auszug aus einer Klasse in einen String geschrieben
 //String wird so bearbeitet, dass jeweils Kommentare geloescht werden.
 /**
  * displays test
  */
 public function test()
 {
    echo('test');
 }
 ";

print "Mit Kommentaren:<br />

    <pre>"   .   $text   .   "</pre>";

$suchmuster = '/\/\*.*?\*\//s';
$ersetzen = '';
$neuerText = preg_replace($suchmuster, $ersetzen, $text);

print "- - - <br />
    Ohne Kommentare:<br />
    <pre>"   .   $neuerText   .   "</pre>";
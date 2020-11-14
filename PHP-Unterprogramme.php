<?php

/**
 * Prozedur = ohne Rückgabe
 * @return void
 */

function add($x, $y)
{
    $z = $x+$y;
    echo "$z";
}

$a = 1;
$b = 2;
add($a, $b);


/**
 * Funktion = mit Rückgabe
 * @return int
 */

function f_add($x, $y)
{
    $z = $x+$y;
    return $z;
}

$a = 1;
$b = 2;
echo f_add($a, $b);

//Funktionsaufrufe zählen mit Static-Variable innerhalb der Funktion
function multipleRuns()
{
    static $a = 0;
    echo $a;
    $a++;
}


//Standardparameter für Funktionsaufrufe definieren !! Immer am Ende

function writeUni($name, $uni, $zip, $city = "Emden")
{
    echo "$name ist an der $uni, $zip, $city.<br>";
}

echo "<br><br>vollständige Übergabe:<br>";
// Vier Werte werden nun übergeben
writeUni("Bernd", "HS EL", "26723", "Emden");

echo "<br>teilweise Übergabe:<br>";
// Gut, wenn es einen Standardparameter gibt (hier: "Emden")
writeUni("Bernd", "HS EL", "26723");


//REKURSIVER FUNKTIONSAUFRUF

function r_add($x)
{
    echo "x startet mit: $x <br>";

    if ($x === 0) {
        return 0;
    }
    $result = r_add($x - 1) + $x;
    echo "x ist nun $x <br>";
    return $result;
}

echo "<br>";
$total = r_add(5);
echo "<br>Das Gesamtergebnis ist $total";



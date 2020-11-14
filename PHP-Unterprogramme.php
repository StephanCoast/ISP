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

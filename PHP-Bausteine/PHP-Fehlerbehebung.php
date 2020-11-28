<?php

//ohne DEBUGGER herausfinden in welcher Zeile und welcher DATEI der Fehler steckt

function report_error($file, $line, $message)
{
    echo "Fehler in $file in Zeile $line aufgetreten: $message";
}
report_error( __FILE__ , __LINE__ , "Irgendwas funktioniert nicht.");



//EXCEPTION-HANDLING -> TRY/CATCH Block für Funktion wo Fehler auftritt.

function division($numerator, $denominator)

// numerator = Zähler, denominator = Nenner
{
    if ($denominator == 0) {
        throw new Exception("Es kann nicht durch 0 dividiert werden!");
    }
    $result = $numerator/$denominator;
    return $result;
}

try {
    echo division(5, 0);
}

catch (Exception $error) {
    echo "Fehler: ".$error->getMessage();
}
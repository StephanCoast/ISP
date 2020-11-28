<?php
session_start();

echo "Der letzte Reload war am: ";

if (empty($_SESSION["zeit"])) {
    echo "Noch nie!";
} else {
    echo date("d.m.Y H:i:s", $_SESSION["zeit"]) . " Uhr";
}

echo "<br />Warten Sie kurz und drücken Sie dann die F5-Taste!";

$_SESSION["zeit"] = time();



/*

session_start() 	Initialisiert eine Session oder nimmt die aktuelle wieder auf (Funktion gibt immer true zurück)
session_destroy() 	Logout – löscht also alle registrierten Daten
session_name() 	Liefert den Session-Namen
session_id() 	Setzt und liefert die aktuelle Session-ID
session_encode() 	Kodiert die aktuellen Session-Daten als Zeichenkette
session_decode() 	Dekodiert Session-Daten aus der Zeichenkette

*/
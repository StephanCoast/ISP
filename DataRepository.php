<?php


class DataRepository

{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchData() {
        $stmt = $this->pdo->prepare(
            "SELECT datum, nachname, vorname, eventname FROM mitarbeiter ma JOIN hasEvent hE ON hE.userid = ma.id JOIN event ev ON ev.eventid = hE.eventid"
        );
     //   $stmt->bindParam(":start", $start);
     //   $stmt->bindParam(":end", $end);
        $stmt->execute();

        // Ergebnis soll in "Mitarbeiter Model" gefüllt werden
        // Objekt "$mitarbeiter" der Klasse "MitarbeiterModel" wird
        // automatisch erstellt, ohne "$student = new StudentModel()"
        $stmt->setFetchMode(PDO::FETCH_CLASS, "DataModel");

        $data =  $stmt->fetchAll(PDO::FETCH_CLASS, "DataModel");

        /*
        echo 'Das Objekt $student sieht wie folgt aus:<pre>';
        print_r($student);
        echo '</pre>';
        */

        return $data;
    }
}

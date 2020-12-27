<?php


class DataRepository

{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchEventData() {
        $stmt = $this->pdo->prepare(
            "SELECT datum, nachname, vorname, eventname FROM mitarbeiter ma JOIN hasEvent hE ON hE.userid = ma.id JOIN event ev ON ev.eventid = hE.eventid ORDER BY nachname, vorname"
        );
     //   $stmt->bindParam(":start", $start);
     //   $stmt->bindParam(":end", $end);
        $stmt->execute();

        // Ergebnis soll in "EventModel" gefüllt werden
        // Objekt "$data" der Klasse "EventModel" wird
        // automatisch erstellt, ohne "$data = new EventModel()"
        $stmt->setFetchMode(PDO::FETCH_CLASS, "EventModel");

        $data =  $stmt->fetchAll(PDO::FETCH_CLASS, "EventModel");

        /*
        echo 'Das Objekt $data sieht wie folgt aus:<pre>';
        print_r($data);
        echo '</pre>';
        */

        return $data;
    }


    public function fetchLoginData($email) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM mitarbeiter WHERE email = :email"
        );
        $stmt->bindParam(":email", $email);
        //   $stmt->bindParam(":end", $end);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getMitarbeiter() {
        $stmt = $this->pdo->prepare(
            "SELECT nachname, vorname, id FROM mitarbeiter ORDER BY nachname"
        );
        // $stmt->bindParam(":email", $email);
        //   $stmt->bindParam(":end", $end);
        $stmt->execute();

        return $stmt->fetchAll();
    }

}

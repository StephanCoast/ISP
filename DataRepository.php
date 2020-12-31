<?php


class DataRepository

{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchEventData($von, $bis) {
        $stmt = $this->pdo->prepare(
            "SELECT datum, nachname, vorname, eventname FROM mitarbeiter ma 
                    JOIN hasEvent hE ON hE.userid = ma.id 
                    JOIN event ev ON ev.eventid = hE.eventid 
                    WHERE datum BETWEEN :von AND :bis 
                    ORDER BY nachname, vorname"
        );
        $stmt->bindParam(":von", $von);
        $stmt->bindParam(":bis", $bis);
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

    public function deleteEvent($eventid) {

        //aus hasEvent Tabelle löschen (Constraint!)
        $stmt = $this->pdo->prepare(
            "DELETE FROM hasEvent WHERE hasEvent.eventid = :eventid"
        );
        $stmt->bindParam(":eventid", $eventid);
        $stmt->execute();

        // aus Event Tabelle löschen
        $stmt = $this->pdo->prepare(
            "DELETE FROM event WHERE event.eventid = :eventid"
        );
        $stmt->bindParam(":eventid", $eventid);
        $stmt->execute();

    }

    public function addEvent($eventname, $datum, $userid) {

        $statement = $this->pdo->prepare("INSERT INTO event (eventname, datum) VALUES (:eventname, :datum)");
        $result = $statement->execute(array('eventname' => $eventname, 'datum' => $datum));

        if ($result) {
            echo 'Event wurde erfolgreich registriert.';
            // $showPage = false;
        } else
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';



        // Gerade angelegter Eventeintrag hat maximalen Schlüssel durch AutoIncrement
        $statement = $this->pdo->prepare("SELECT eventid FROM event WHERE eventid = ( SELECT MAX(eventid) FROM event )");
        $statement->execute();
        $eventMax = $statement->fetch();
        //  echo '<br><br>' . $eventMax['eventid'];


        // Event Mitarbeiter zuordnen
        $statement = $this->pdo->prepare("INSERT INTO hasEvent (userid, eventid) VALUES (:userid, :eventid)");
        $result = $statement->execute(array('userid' => $userid, 'eventid' => $eventMax['eventid']));

        if ($result) {
            // echo 'Event wurde erfolgreich dem Mitarbeiter zugeordnet (hasEvent).';
            return true;
        } else {
            echo 'Zuordnung des Events zum Mitarbeiter fehlgeschlagen.' .'<br>';
        }

    }

    public function gethasEvent () {

        //PRÜFEN ob Überschneidung mit vorhandenem Event
        $statement = $this->pdo->prepare("SELECT datum, hE.eventid, userid FROM hasEvent hE
                                        JOIN event ev ON ev.eventid = hE.eventid
                                        ORDER BY datum");
        $statement->execute();
        $hasEvent = $statement->fetchAll();

        /*
        echo 'Das Objekt $data sieht wie folgt aus:<pre>';
        print_r($hasEvent);
        echo '</pre>';
        */

        return $hasEvent;

    }

}

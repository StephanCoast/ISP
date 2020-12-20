<?php

class StudentRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchStudentByMatnr(
        $start,
        $end
    ) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM db_pro WHERE matnr BETWEEN :start AND :end"
        );
        $stmt->bindParam(":start", $start);
        $stmt->bindParam(":end", $end);
        $stmt->execute();

        // Ergebnis soll in "StudentModel" gefüllt werden
        // Objekt "$student" der Klasse "StudentModel" wird
        // automatisch erstellt, ohne "$student = new StudentModel()"
        $stmt->setFetchMode(PDO::FETCH_CLASS, "StudentModel");

        $student =  $stmt->fetchAll(PDO::FETCH_CLASS, "StudentModel");

        /*
        echo 'Das Objekt $student sieht wie folgt aus:<pre>';
        print_r($student);
        echo '</pre>';
        */

        return $student;
    }
}
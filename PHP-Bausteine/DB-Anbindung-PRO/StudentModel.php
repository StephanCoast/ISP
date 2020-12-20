<?php

class StudentModel
{
    // Spalten der Datenbank
    public $id;
    public $name;
    public $matnr;
    public $semester;
    public $course;

    // Zusätzliche Eigenschaften
    public $firstName;

    public function extractFirstName($name)
    {
        // geht bis zum 1. Leerzeichen und speichert dies in $1
        $this->firstName = preg_replace(
            '/^(.+?)\s(.+)$/',
            "$1",
            $name
        );
    }
}
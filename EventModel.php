<?php

class EventModel
{
    // Spalten der gejointen Datenbank: datum, nachname, vorname, eventname
    public $datum;
    public $nachname;
    public $vorname;
    public $eventname;


    /*
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
    */
}
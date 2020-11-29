<?php


class Event
{
    // Eigenschaften der Klasse festlegen

    private $eventName;
    private $datum;


    public function __construct($eventName, $datum)
    {

        $this->setEventName($eventName);
        $this->setDatum($datum);

    }

    /**
     * @return mixed
     */
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * @param mixed $datum
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;
    }


    /**
     * @return mixed
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @param mixed $eventName
     */
    public function setEventName($eventName)
    {
        $this->eventName = $eventName;
    }

}








